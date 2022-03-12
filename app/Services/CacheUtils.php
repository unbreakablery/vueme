<?php namespace App\Services;

use Illuminate\Support\Facades\Redis;

use Config;
use Exception;
use Log;

class CacheUtils {

    const DEV = false;
    const SHARDED = true;
    const CACHE_LOCK_EXT = "-lock";

    private static function _conn($connection) {
        static $redis = [];

        if (self::SHARDED && in_array($connection, ['read', 'write'])) {
            $connection = 'write';
        }

        if (isset($redis[$connection])) {
            return $redis[$connection];
        }

        return $redis[$connection] = Redis::connection($connection);
    }

    private static function _read($connection = null) {
        if (!$connection || stripos($connection, 'read') === false) {
            $connection = 'read';
        }

        return self::_conn($connection);
    }

    private static function _write($connection = null) {
        if (!$connection || stripos($connection, 'write') === false) {
            $connection = 'write';
        }

        return self::_conn($connection);
    }

    private static function _encode_val($val) {
        //a previous server had mbstring.func_overload which caused predis to break on strlen calcs
        //obviously a bad configuration setting to have but base64 encoding will ensure it's never a problem
        return is_numeric($val) ? $val : base64_encode(serialize($val));
    }

    private static function _decode_val($val) {
        if (!isset($val)) {
            return $val;
        }

        if (is_numeric($val)) {
            return $val;
        }

        return unserialize(base64_decode($val));
    }

    private static function _key($key) {
        $arr = [
            'cacheutils',
            \WhiteLabel::site_id(),
            in_array(Config::get('app.env'), ['production', 'admin']) ? 'production' : 'dev',
            $key,
        ];
        return implode(':', $arr);
    }

    public static function get($key, $master = false, $connection = null) {
        if (self::DEV) {
            echo 'GET:'.$key."\n";
        }

        if ($master) {
            $redis = self::_write($connection);
        } else {
            $redis = self::_read($connection);
        }

        try {
            $val = $redis->get(self::_key($key));
        } catch (Exception $e) {
            Log::error($e);
            $val = null;
        }

        $res = self::_handle_get($val);

        if (!self::SHARDED && $master) {
            //close master so keep connection count low
            //rarely need to hit master multiple times in same request
            $redis->disconnect();
        }

        if (self::DEV && !isset($res)) {
            \WebUtils::output_sql();
        }

        return $res;
    }

    public static function get_master($key) {
        return self::get($key, true);
    }

    public static function get_conn($key, $connection) {
        return self::get($key, false, $connection);
    }

    public static function get_master_conn($key, $connection) {
        return self::get($key, true, $connection);
    }

    private static function _handle_get($val) {
        $val = self::_decode_val($val);

        if ($val !== null) {
            if (array_key_exists('tags', $val) && array_key_exists('val', $val)) {
                if (!empty($val['tags'])) {
                    $tags = self::_tag_vals(array_keys($val['tags']));

                    if ($diff = array_diff_assoc($tags, $val['tags'])) {
                        if (self::DEV) {
                            echo "TAGS DON'T MATCH\n";
                            echo 'EXPECT: ' . print_r($val['tags'], true);
                            echo 'FOUND: ' . print_r($tags, true);
                        }
                        return null;
                    }
                }
                $val = $val['val'];
            }
            return $val;
        }
        return null;
    }

    public static function put($key, $val, $minutes = 0, $tags = [], $connection = null) {
        if (self::DEV) {
            echo 'PUT:'.$key."\n";
        }

        $redis = self::_write($connection);

        $tags = self::_tag_vals($tags);

        $val = [
            'val' => $val,
            'tags' => $tags,
        ];

        $val = self::_encode_val($val);

        if (empty($minutes)) {
            $redis->set(self::_key($key), $val);
            return;
        }

        $minutes = max(1, $minutes);

        $redis->setex(self::_key($key), $minutes * 60, $val);

        if (!self::SHARDED) {
            //close master so keep connection count low
            //rarely need to hit master multiple times in same request
            $redis->disconnect();
        }
    }

    private static function _tag_vals($tags, $update = false){
        if (empty($tags)) {
            return [];
        }

        if (is_string($tags)) {
            $tags = [$tags];
        }

        $res = [];

        foreach ($tags as $tag) {
            if (is_array($tag)) {
                $tag = implode(':', $tag);
            }

            $cache_key_tag = 'cache_tag:' . $tag;

            $result = null;

            if ($update || ($result = self::get_master($cache_key_tag)) === null) {
                $result = microtime() . ' ' . mt_rand(1000, 999999999);
                if (self::DEV) {
                    echo 'PUT TAG: ' . $cache_key_tag . ' - ' . $result . "\n";
                }
                self::put($cache_key_tag, $result, 60 * 24 * 30);
            }

            $res[$tag] = $result;
        }
        return $res;
    }

    public static function delete($key) {
        $redis = self::_write();

        $val = $redis->del(self::_key($key));
    }

    public static function delete_tag(){
        $tags = func_get_args();

        if (empty($tags)) {
            return;
        }
        
        self::_tag_vals($tags, true);
    }

    public static function append($key, $val) {
        $redis = self::_write();

        $val = self::_encode_val($val);

        $redis->rpush(self::_key($key), $val);
    }

    public static function shift($key) {
        $redis = self::_write();

        $val = $redis->lpop(self::_key($key));

        return self::_decode_val($val);
    }

    public static function list($key) {
        $redis = self::_write();

        $len = $redis->llen(self::_key($key));

        $vals = $redis->lrange(self::_key($key), 0, $len - 1);

        foreach ($vals as &$val) {
            $val = self::_decode_val($val);
            unset($val);
        }

        return $vals;
    }

    public static function clear_cache(){
        /* disable for now, some things in redis shouldn't be deleted,
           we need to setup support for different redis dbs */
        return;

        $redis = self::_write();
        $redis->flushdb();
    }

    /*
     * Sets a cache key with '-lock' extension to serve
     * as a single instance guarantee for functions vulnerable to race conditions
     */
    public static function set_lock($key) {

        $key = self::get_cache_lock_key($key);

        // If get() doesn't return a value, no cache lock is active
        // so set the cache lock and return true
        if (!CacheUtils::get($key)) {
            CacheUtils::put($key, 'LOCKED', 1);
            return true;
        }

        // If get() returned a value, the cache lock is set
        // returns false to stop additional process on same cache lock key
        return false;
    }

    public static function unset_lock($key) {

        $key = self::get_cache_lock_key($key);
        return CacheUtils::delete($key);
    }

    public static function get_cache_lock_key($key) {
        return $key . self::CACHE_LOCK_EXT;
    }

}
