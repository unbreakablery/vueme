<?php namespace App\Services;

use App\Models\UserDevice;
use Illuminate\Support\Facades\Redis;
use Jenssegers\Agent\Agent;

use App\Social\Instagram;

use App\category;
use App\config as app_config;
use App\Models\User;

use Config;
use DateTime;
use DB;
use Exception;
use Log;
use Request;
use Route;

class WebUtils {

    public static function get_env_str() {
        return Config::get('app.env');
    }

    public static function dev(){
        if (Config::get('app.debug') === true || Config::get('app.debug') === 'true') {
            return true;
        }
        return false;
    }

    public static function env_local(){
        return Config::get('app.env') === 'local';
    }

    public static function dev_box() {
        return in_array(Config::get('app.env'), ['local', 'development','qa']);
    }

	public static function cache_clash(){
    	return in_array(Config::get('app.env'),['qa','staging','development','local']);
	}

	public static function auto_validate(){
		return in_array(Config::get('app.env'),['qa','staging','development','local']);
	}

	public static function dev_label($username = '') {
        if (self::cache_clash()) {
            return " [" . Config::get('app.env') . "] - [to: " . $username . "]";
        }
        return '';
    }

	public static function prod_db(){
        return in_array(Config::get('app.env'), ['production', 'admin']);
    }

	public static function dev_db(){
		return in_array(Config::get('app.env'), ['local', 'development', 'staging']);
	}

    public static function stage_db() {
        return in_array(Config::get('app.env'), ['staging']);
    }

	public static function is_qa(){
		return in_array(Config::get('app.env'), ['qa']);
	}

	public static function is_api(){
		return preg_match('#/api/v[0-9.]+(/.*)?$#', !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '');
	}

	public static function debug($out = null) {
        static $log = [];
        if (!\WebUtils::dev()) {
            return;
        }
        if ($out !== null) {
            $log[] = $out;
            return;
        }
        return $log;
    }

    public static function agent() {
        static $agent = null;
        if ($agent) {
            return $agent;
        }
        return $agent = new Agent();
    }

    public static function output_sql(){
        if (!WebUtils::dev()) {
            return;
        }
        static $running = null;
        if ($running) {
            return;
        }
        $running = true;
        DB::listen(function($query) {
            $out = [
                $query->time,
                $query->sql,
            ];
            if (!empty($query->bindings)) {
                $out[] = print_r($query->bindings, true);
            }
            echo implode(' - ', $out) . "\n";
        });
    }

    public static function clean_stars_viewed($arr, &$changed=false) {
        if (empty($arr)) {
            return [];
        }
        $stars_viewed = array();
        foreach ($arr as $star_id => $created_at) {
            if ($created_at < strtotime('2015-01-01')) {
                $changed = true;
                $stars_viewed[$created_at] = time() - mt_rand(60, 60 * 60 * 24 * 7);
            } else {
                $stars_viewed[$star_id] = $created_at;
            }
        }
        //sort by most recently viewed first
        uasort($stars_viewed, function($a, $b) {
            if ($a == $b) {
                return 0;
            }
            return $a < $b ? 1 : -1;
        });
        return $stars_viewed;
    }

    public static function time_to_days_hours($time) {
        if (stripos($time, '-') !== false) {
            $time = strtotime($time);
        }
        $min = 60;
        $hour = $min * 60;
        $day = $hour * 24;
        $year = $day * 365.25;

        $ret = [];
        $sec = abs(time() - $time);
        $days = $sec / $day;
        if (1 <= $days) {
            $days = floor($days);
            $ret[] = $days.' day'.(($days!=1)?'s':'');
            $sec -= $days * $day;
        }
        $hours = $sec / $hour;
        if (1 <= $hours) {
            $hours = floor($hours);
            $ret[] = $hours.' hour'.(($hours!=1)?'s':'');
        }
        if (empty($ret)) {
            return '0 hours';
        }
        if ($time < time()) {
            return implode(', ', $ret).' ago';
        }
        return implode(', ', $ret);
    }

    public static function seconds_to_string($seconds, $round = false) {
        if (!$seconds) {
            return '0';
        }
        $str = [];
        $secs = ['day' => 86400,
                 'hr' => 3600,
                 'min' => 60,
                 'sec' => 1];
        foreach ($secs as $s => $cnt) {
            $amount = floor($seconds / $cnt);
            if ($amount) {
                if ($round) {
                    $amount = round($seconds / $cnt);
                    return $amount . ' ' . $s . ($amount != 1 ? 's' : '');
                }
                $seconds -= $amount * $cnt;
                $str[] = $amount . $s[0];
            }
            if (!$seconds) {
                break;
            }
        }
        return implode(':', $str);
    }

    public static function seconds_to_time($seconds) {
        if (!$seconds) {
            return '0';
        }
        $minutes = floor($seconds / 60);
        $seconds -= $minutes * 60;
        if ($seconds < 10) {
            $seconds = '0' . $seconds;
        }
        if ($minutes) {
            return $minutes . ':' . $seconds;
        }
        return $seconds . 's';
    }

    public static function twilio_phone_number($number, $country_code) {
        if (!in_array($country_code, array('US'))) {
            return $number;
        }
        if ($country_code == 'US') {
            if (strlen($number) != 12) {
                return $number;
            }
            return substr($number, 1, 1).' ('.substr($number, 2, 3).') '.substr($number, 5, 3).'-'.substr($number, 8, 4);
        }
        return $number;
    }

    /**
     * @param $number
     * @param bool $hide
     * @return string|string[]|null
     */
    public static function format_phone_number($number, $hide = false) {

        $number = preg_replace('/[^0-9+]+/', '', $number);

        if (strlen($number) < 10) {
            return $number;
        }

        // If the number is 10 digits, it's a US number and needs a +1 prefix
        // If it's 11 digits, it's a US number starting with 1
        // If it's 12 digits, it's a US number with a +1 prefix
        // If it's 13, it's an international number
        switch(strlen($number)) {
            case 10:
                $number = '+1'.$number;
                break;
            case 11:
                $number = '+'.$number;
                break;
            case 12:
                // In the nonexistant case where a non-US number doesn't start with a `+`
                if(substr($number,0,1) != '+') {
                    $number = '+'.$number;
                }
                break;
        }
        if( $hide ) {
            $number = str_pad('', strlen($number)-4, '*').substr($number, -4);
        }
        $number = substr($number,0, strlen($number)-10).' ('.substr($number, -10, 3).') '.substr($number, -7, 3).'-'.substr($number, -4);
        return $number;
    }

    public static function headers_download($input) {
        if (empty($input['mime'])) {
            throw new Exception('missing mime');
        }
        $file = strtolower(\WhiteLabel::site_name()).'_file';
        if (!empty($input['file'])) {
            $file = $input['file'];
        }
        header("Content-type: {$input['mime']}");
        header("Content-Disposition: attachment; filename={$file}");
        header("Pragma: no-cache");
        header("Expires: 0");
    }

    public static function profile_image($star) {
        return self::media($star, 'PROFILE');
    }

    public static function media($star, $type, $obj = false) {

	    if (!array_key_exists('media', $star->getRelations())) {
            $star->load(['media' => function($query) use ($type) {
                $query->where('type', '=', $type);
            }]);
        }
        if (empty($star->media) || !count($star->media)) {
            if ($obj) {
                return null;
            }
            return '';
        }
        foreach ($star->media as $media) {
            if ($media->type != $type) {
                continue;
            }
            if ($obj) {
                return $media;
            }
            return $media->url;
        }
        if ($obj) {
            return null;
        }
        return '';
    }

    public static function number_short($n){
        if (empty($n)) {
            return 0;
        }
        if ($n < 1000) {
            return $n;
        }
        $d = $n < 1000000 ? 1000 : 1000000;
        $f = round($n/$d, 1);
        return number_format($f, $f - intval($f) ? 1 : 0, '.', '') . ($d == 1000 ? 'k' : 'M');
    }

    public static function him_her($gender) {
        if ($gender == 'MAN') {
            return 'him';
        }
        return 'her';
    }

    public static function his_her($gender) {
        if ($gender == 'MAN') {
            return 'his';
        }
        return 'her';
    }

    public static function instagram_images($star) {
        if (!$star->instagram) {
            return [];
        }
        $FORCE = false;
        $HOURS_BETWEEN = 1;
        $cache_key = 'app:services:webutils:instagram_images('.$star->id.')';
        try {
            $insta_images = \CacheUtils::get($cache_key);
            if ($FORCE) {
                $insta_images = null;
            }
        } catch (Exception $e) {
            $insta_images = null;
        }
        if (empty($insta_images)) {
            $config_key = 'star_instagram_' . $star->id;
            $exist = app_config::key($config_key);
            $exist = !empty($exist)?unserialize($exist):[];
            if ($FORCE
                || empty($exist)
                || !isset($exist['images'])
                || empty($exist['username'])
                || (!empty($exist['username']) && strcasecmp($exist['username'], $star->instagram))
                || empty($exist['time'])
                || $exist['time'] < time() - (60 * 60 * $HOURS_BETWEEN)) {
                $insta_images = self::instagram_scrape($star->instagram);
                if (!empty($insta_images)) {
                    if (!empty($exist['images'])) {
                        $insta_images = array_merge($insta_images, $exist['images']);
                    }
                    $insta_images = array_slice($insta_images, 0, 9);
                    $exist = ['images' => $insta_images,
                              'time' => time(),
                              'username' => $star->instagram];
                } else {
                    Log::warning('Instagram scrape fail: '.print_r($star->toArray(), true));
                    if (empty($exist['images'])) {
                        $exist['images'] = [];
                    }
                    $insta_images = $exist['images'];
                    $exist['time'] = time();
                    $exist['username'] = $star->instagram;
                }
                //tmp code, having separate aws and dev DB messing everything up
                $final = [];
                foreach ($insta_images as $img) {
                    if (is_array($img)) {
                        if (!empty($img['display'])) {
                            $final[] = $img['display'];
                        }
                    } else {
                        $final[] = $img;
                    }
                }
                $exist['images'] = $insta_images = $final;
                /*
                //tmp code until all stars have new format of ['thumb' => '', 'display' => '']
                $final = [];
                foreach ($insta_images as $img) {
                    if (is_array($img)) {
                        $final[] = $img;
                    }
                }
                $exist['images'] = $insta_images = $final;
                */
                app_config::key($config_key, serialize($exist));
            } else {
                $insta_images = $exist['images'];
            }
            \CacheUtils::put($cache_key, $insta_images, 2);
        }
        return $insta_images;
    }

    public static function instagram_scrape($username) {
        $json = @file_get_contents('https://www.instagram.com/'.$username.'/?hl=en');
        $search = '<script type="text/javascript">window._sharedData = ';
        $pos = stripos($json, $search);
        if ($pos === false) {
            return null;
        }
        $json = substr($json, $pos + strlen($search));
        $search = ';</script>';
        $pos = stripos($json, $search);
        if ($pos === false) {
            return null;
        }
        $json = substr($json, 0, $pos);
        $json = trim($json);
        $json = json_decode($json, true);
        if (empty($json['entry_data']['ProfilePage'][0]['user']['media']['nodes'])) {
            return null;
        }
        $insta_images = [];
        foreach ($json['entry_data']['ProfilePage'][0]['user']['media']['nodes'] as $media) {
            if (empty($media['thumbnail_src']) || empty($media['display_src'])) {
                continue;
            }
            $insta_images[] = $media['thumbnail_src'];

            /* disabled until we are on AWS
            $insta_images[] = ['thumb' => $media['thumbnail_src'],
                               'display' => $media['display_src']];
            */
        }
        return $insta_images;
    }

    public static function categories() {
        static $categories = null;
        if ($categories) {
            return $categories;
        }
        $cache_key = 'app:services:webutils:categories';
        try {
            $categories = \CacheUtils::get($cache_key);
        } catch (Exception $e) {
            $categories = [];
        }
        if (empty($categories)) {
            $categories = category::orderBy('name', 'ASC')->get();
            CacheUtils::put($cache_key, $categories);
        }
        return $categories;
    }

    public static function terminate_run($func = null) {
        static $funcs = [];
        if ($func) {
            $funcs[] = $func;
            return;
        }
        return $funcs;
    }

    public static function valid_username($username) {
        if (!empty(\WhiteLabel::config('words')->reserved_partial)) {
            /*
            foreach (\WhiteLabel::config('words')->reserved_partial as $word) {
                if (preg_match('/'.$word.'/i', $username)) {
                    die($word);
                    return false;
                }
            }
            */
            $reserved_regex = implode('|', \WhiteLabel::config('words')->reserved_partial);
            if (preg_match('/'.$reserved_regex.'/i', $username)) {
                return false;
            }
        }
        if (!empty(\WhiteLabel::config('words')->reserved_full)) {
            /*
            foreach (\WhiteLabel::config('words')->reserved_full as $word) {
                if (preg_match('/\b'.$word.'\b/i', $username)) {
                    die($word);
                    return false;
                }
            }
            */
            $reserved_exactregex = implode('\b|\b', \WhiteLabel::config('words')->reserved_full);
            if (preg_match('/\b'.$reserved_exactregex.'\b/i', $username)) {
                return false;
            }
        }
        return true;
    }

    public static function generate_username($from) {
        for ($i = 0; $i < 100; ++$i) {
            if (strpos($from, '@') !== false) {
                $username = User::generate_username_email($from);
            } else {
                $username = User::generate_username_name($from, 50 <= $i);
            }
            if (User::where('username', '=', $username)->first()) {
                continue;
            }
            return $username;
        }
        return null;
    }

    public static function dollars_to_text($amount) {
        $txt = [];
        $dollars = floor($amount);
        if ($dollars) {
            $txt[] = $dollars . ' dollar' . ($dollars > 1 ? 's' : '');
        }
        $cents = ($amount - $dollars) * 100;
        if ($cents) {
            $txt[] = $cents . ' cent' . ($cents > 1 ? 's' : '');
        }
        return implode(' ', $txt);
    }

    public static function tmp_dir_path(array $paths_sub) {
        $path = storage_path() . '/tmp/' . \WhiteLabel::site_id();
        $path_tmp = $path;
        foreach ($paths_sub as $path_sub) {
            $path_tmp .= '/' . $path_sub;
        }
        $path = $path_tmp;
        return $path;
    }

    public static function tmp_dir(array $paths_sub, $permission = 0777) {
        $path = storage_path() . '/tmp/' . WhiteLabel::site_id();
        $path_tmp = $path;
        foreach ($paths_sub as $path_sub) {
            $path_tmp .= '/' . $path_sub;
            if (!is_dir($path_tmp)) {
                mkdir($path_tmp, $permission, true);
            }
            self::chmod($path_tmp, $permission);
        }
        $path = $path_tmp;
        return $path;
    }

    public static function rrmdir($dir) {
        if (!is_dir($dir)) {
            return self::rrmdir(dirname($dir));
        }
        foreach (glob($dir . '/*') as $file) {
            if (is_dir($file)) {
                self::rrmdir($file);
            } else {
                gc_collect_cycles();
               // array_map('unlink', glob($dir.'/*.*'));
               unlink($file);
            }
        }
        if (!rmdir($dir)) {
            self::rrmdir($dir, false);
        }
    }

    public static function chmod($path, $permission) {
        $old_mask = umask(0);
        @chmod($path, $permission);
        umask($old_mask);
    }

    public static function validate_date($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    public static function how_it_works_url($url = ''){
        if (!$url) {
            $url = self::current_uri();
        }
        return '/how-it-works?r=' . urlencode($url);
    }

    public static function get_started_url($url = ''){
        if (!$url) {
            $url = self::current_uri();
        }

        return '/signup?r=' . urlencode($url);
    }

    public static function login_url($url = ''){
        if (!$url) {
            $url = self::current_uri();
        }
        return '/login?r=' . urlencode($url);
    }

    public static function onboarding_redirect_url($url = null) {
	    $back_url = '/app';
        if ($url) {
            if (WebUtils::_onboarding_redirect_url($url)) {
                $back_url = $url;
            }
        } else if ($url = self::_onboarding_redirect_url()) {
            $back_url = $url;
        }
	    return $back_url;
    }

    private static function _onboarding_redirect_url($url = null) {
        if ($url) {
            if (self::valid_internal_link($url)) {
                session(['onboarding_redirect_url' => $url]);
                return true;
            }
            return false;
        }
        return session('onboarding_redirect_url');
    }

    public static function valid_internal_link($url) {
        if (!$url) {
            return false;
        }
        if (stripos($url, 'http:') === false
            && stripos($url, '/') === 0
            && substr_count($url, '?') <= 1) {
            return true;
        }
        return false;
    }

    public static function current_uri(){
        return '/' . ltrim(Request::path(), '/');
    }

    public static function onboarding_bg(){
        $bg_image = \WhiteLabel::asset('/images/v1/girl_cp_first.jpg');

        $agent = WebUtils::agent();

        if ($agent->isPhone()) {
            $bg_video = \WhiteLabel::asset('/videos/girl_cp_mobile.mp4');
        } else {
            $bg_video = \WhiteLabel::asset('/videos/girl_cp_desktop.mp4');
        }

        if ($agent->isSafari() && !$agent->isDesktop()) {
            if (preg_match('/OS ([0-9]+)_[0-9_]+ like/i', $_SERVER['HTTP_USER_AGENT'], $matches)) {
                if (!empty($matches[1]) && $matches[1] < 10) {
                    $bg_image = \WhiteLabel::asset('/images/v1/girl_cp_still.jpg');
                    $bg_video = null;
                }
            }
        }

        pushImage($bg_image);

        return [$bg_video, $bg_image];
    }

    public static function how_it_works_bg(){
        $bg_image = WhiteLabel::asset('/images/v1/girl_ts_first.jpg');

        $agent = WebUtils::agent();

        if ($agent->isPhone()) {
            $bg_video = WhiteLabel::asset('/videos/girl_ts_mobile.mp4');
        } else {
            $bg_video = WhiteLabel::asset('/videos/girl_ts_desktop.mp4');
        }

        if ($agent->isSafari() && !$agent->isDesktop()) {
            if (preg_match('/OS ([0-9]+)_[0-9_]+ like/i', $_SERVER['HTTP_USER_AGENT'], $matches)) {
                if (!empty($matches[1]) && $matches[1] < 10) {
                    $bg_image = WhiteLabel::asset('/images/v1/girl_ts_still.jpg');
                    $bg_video = null;
                }
            }
        }

        pushImage($bg_image);

        return [$bg_video, $bg_image];
    }


    public static function seoUrl($string)
    {
        if ($string != null) {
            $string = WebUtils::removeAccents($string);
            //Lower case everything
            $string = strtolower($string);
            //Make alphanumeric (removes all other characters)
            $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
            //Clean up multiple dashes or whitespaces
            $string = preg_replace("/[\s-]+/", " ", $string);
            //Convert whitespaces and underscore to dash
            $string = preg_replace("/[\s_]/", "-", $string);
        }
        return $string;
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function removeAccents($string)
    {
        if (!preg_match('/[\x80-\xff]/', $string)) {
            return $string;
        }
        $chars = array(
            // Decompositions for Latin-1 Supplement
            chr(195) . chr(128) => 'A', chr(195) . chr(129) => 'A',
            chr(195) . chr(130) => 'A', chr(195) . chr(131) => 'A',
            chr(195) . chr(132) => 'A', chr(195) . chr(133) => 'A',
            chr(195) . chr(135) => 'C', chr(195) . chr(136) => 'E',
            chr(195) . chr(137) => 'E', chr(195) . chr(138) => 'E',
            chr(195) . chr(139) => 'E', chr(195) . chr(140) => 'I',
            chr(195) . chr(141) => 'I', chr(195) . chr(142) => 'I',
            chr(195) . chr(143) => 'I', chr(195) . chr(145) => 'N',
            chr(195) . chr(146) => 'O', chr(195) . chr(147) => 'O',
            chr(195) . chr(148) => 'O', chr(195) . chr(149) => 'O',
            chr(195) . chr(150) => 'O', chr(195) . chr(153) => 'U',
            chr(195) . chr(154) => 'U', chr(195) . chr(155) => 'U',
            chr(195) . chr(156) => 'U', chr(195) . chr(157) => 'Y',
            chr(195) . chr(159) => 's', chr(195) . chr(160) => 'a',
            chr(195) . chr(161) => 'a', chr(195) . chr(162) => 'a',
            chr(195) . chr(163) => 'a', chr(195) . chr(164) => 'a',
            chr(195) . chr(165) => 'a', chr(195) . chr(167) => 'c',
            chr(195) . chr(168) => 'e', chr(195) . chr(169) => 'e',
            chr(195) . chr(170) => 'e', chr(195) . chr(171) => 'e',
            chr(195) . chr(172) => 'i', chr(195) . chr(173) => 'i',
            chr(195) . chr(174) => 'i', chr(195) . chr(175) => 'i',
            chr(195) . chr(177) => 'n', chr(195) . chr(178) => 'o',
            chr(195) . chr(179) => 'o', chr(195) . chr(180) => 'o',
            chr(195) . chr(181) => 'o', chr(195) . chr(182) => 'o',
            chr(195) . chr(182) => 'o', chr(195) . chr(185) => 'u',
            chr(195) . chr(186) => 'u', chr(195) . chr(187) => 'u',
            chr(195) . chr(188) => 'u', chr(195) . chr(189) => 'y',
            chr(195) . chr(191) => 'y',
            // Decompositions for Latin Extended-A
            chr(196) . chr(128) => 'A', chr(196) . chr(129) => 'a',
            chr(196) . chr(130) => 'A', chr(196) . chr(131) => 'a',
            chr(196) . chr(132) => 'A', chr(196) . chr(133) => 'a',
            chr(196) . chr(134) => 'C', chr(196) . chr(135) => 'c',
            chr(196) . chr(136) => 'C', chr(196) . chr(137) => 'c',
            chr(196) . chr(138) => 'C', chr(196) . chr(139) => 'c',
            chr(196) . chr(140) => 'C', chr(196) . chr(141) => 'c',
            chr(196) . chr(142) => 'D', chr(196) . chr(143) => 'd',
            chr(196) . chr(144) => 'D', chr(196) . chr(145) => 'd',
            chr(196) . chr(146) => 'E', chr(196) . chr(147) => 'e',
            chr(196) . chr(148) => 'E', chr(196) . chr(149) => 'e',
            chr(196) . chr(150) => 'E', chr(196) . chr(151) => 'e',
            chr(196) . chr(152) => 'E', chr(196) . chr(153) => 'e',
            chr(196) . chr(154) => 'E', chr(196) . chr(155) => 'e',
            chr(196) . chr(156) => 'G', chr(196) . chr(157) => 'g',
            chr(196) . chr(158) => 'G', chr(196) . chr(159) => 'g',
            chr(196) . chr(160) => 'G', chr(196) . chr(161) => 'g',
            chr(196) . chr(162) => 'G', chr(196) . chr(163) => 'g',
            chr(196) . chr(164) => 'H', chr(196) . chr(165) => 'h',
            chr(196) . chr(166) => 'H', chr(196) . chr(167) => 'h',
            chr(196) . chr(168) => 'I', chr(196) . chr(169) => 'i',
            chr(196) . chr(170) => 'I', chr(196) . chr(171) => 'i',
            chr(196) . chr(172) => 'I', chr(196) . chr(173) => 'i',
            chr(196) . chr(174) => 'I', chr(196) . chr(175) => 'i',
            chr(196) . chr(176) => 'I', chr(196) . chr(177) => 'i',
            chr(196) . chr(178) => 'IJ', chr(196) . chr(179) => 'ij',
            chr(196) . chr(180) => 'J', chr(196) . chr(181) => 'j',
            chr(196) . chr(182) => 'K', chr(196) . chr(183) => 'k',
            chr(196) . chr(184) => 'k', chr(196) . chr(185) => 'L',
            chr(196) . chr(186) => 'l', chr(196) . chr(187) => 'L',
            chr(196) . chr(188) => 'l', chr(196) . chr(189) => 'L',
            chr(196) . chr(190) => 'l', chr(196) . chr(191) => 'L',
            chr(197) . chr(128) => 'l', chr(197) . chr(129) => 'L',
            chr(197) . chr(130) => 'l', chr(197) . chr(131) => 'N',
            chr(197) . chr(132) => 'n', chr(197) . chr(133) => 'N',
            chr(197) . chr(134) => 'n', chr(197) . chr(135) => 'N',
            chr(197) . chr(136) => 'n', chr(197) . chr(137) => 'N',
            chr(197) . chr(138) => 'n', chr(197) . chr(139) => 'N',
            chr(197) . chr(140) => 'O', chr(197) . chr(141) => 'o',
            chr(197) . chr(142) => 'O', chr(197) . chr(143) => 'o',
            chr(197) . chr(144) => 'O', chr(197) . chr(145) => 'o',
            chr(197) . chr(146) => 'OE', chr(197) . chr(147) => 'oe',
            chr(197) . chr(148) => 'R', chr(197) . chr(149) => 'r',
            chr(197) . chr(150) => 'R', chr(197) . chr(151) => 'r',
            chr(197) . chr(152) => 'R', chr(197) . chr(153) => 'r',
            chr(197) . chr(154) => 'S', chr(197) . chr(155) => 's',
            chr(197) . chr(156) => 'S', chr(197) . chr(157) => 's',
            chr(197) . chr(158) => 'S', chr(197) . chr(159) => 's',
            chr(197) . chr(160) => 'S', chr(197) . chr(161) => 's',
            chr(197) . chr(162) => 'T', chr(197) . chr(163) => 't',
            chr(197) . chr(164) => 'T', chr(197) . chr(165) => 't',
            chr(197) . chr(166) => 'T', chr(197) . chr(167) => 't',
            chr(197) . chr(168) => 'U', chr(197) . chr(169) => 'u',
            chr(197) . chr(170) => 'U', chr(197) . chr(171) => 'u',
            chr(197) . chr(172) => 'U', chr(197) . chr(173) => 'u',
            chr(197) . chr(174) => 'U', chr(197) . chr(175) => 'u',
            chr(197) . chr(176) => 'U', chr(197) . chr(177) => 'u',
            chr(197) . chr(178) => 'U', chr(197) . chr(179) => 'u',
            chr(197) . chr(180) => 'W', chr(197) . chr(181) => 'w',
            chr(197) . chr(182) => 'Y', chr(197) . chr(183) => 'y',
            chr(197) . chr(184) => 'Y', chr(197) . chr(185) => 'Z',
            chr(197) . chr(186) => 'z', chr(197) . chr(187) => 'Z',
            chr(197) . chr(188) => 'z', chr(197) . chr(189) => 'Z',
            chr(197) . chr(190) => 'z', chr(197) . chr(191) => 's'
        );
        $string = strtr($string, $chars);
        return $string;
    }

    public  static function verifyRecaptcha(\Illuminate\Http\Request $request){
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $remoteip = self::getUserIp();


        $recaptcha = file_get_contents($url . '?secret=' . env('RECAPTCHA_SECRET_KEY') . '&response=' . $request->input('token'));
        $recaptcha = json_decode($recaptcha);



        if ($recaptcha->success != true) {
            return false;
        }

        if ($recaptcha->score >= 0.5) {
            //Validation was successful, add your form submission logic here
            return true;
        } else {
            return false;
        }
    }


    public static function verifyIp(\Illuminate\Http\Request $request){
        $ip = self::getUserIp();

        $xmle = self::readXml("ip_whitelist.xml");

        foreach($xmle as $item) {
            if($item == $ip) {
                return true;
            }
        }

        $dbip = UserDevice::where('ip', $ip)->first();
        if($dbip){
            return false;
        }

        return true;

    }


    public static function getUserIp(){
        if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $_SERVER["REMOTE_ADDR"] = $_SERVER['HTTP_CF_CONNECTING_IP'];
        }elseif (isset($_SERVER['HTTP_X_SUCURI_CLIENTIP'])){
            $_SERVER["REMOTE_ADDR"] = $_SERVER['HTTP_X_SUCURI_CLIENTIP'];
        }

        return $_SERVER["REMOTE_ADDR"];
    }

    public static function readXml($url){
        try {
            //$xmlContent = file_get_contents("blocked_domains.xml");
            $xmlContent = file_get_contents($url);
        } catch (\Exception $e) {
            echo  $e->getMessage();
            return null;
        }

        $xml = simplexml_load_string($xmlContent);
        return $xml;
    }

    public static function verifyPhone($phones){
        $xmle = self::readXml("phone_whitelist.xml");
        foreach($phones as $phone) {
        foreach($xmle as $item) {
            if($item == $phone->number) {
                return true;
            }
           }
          }
        return false;
    }

    public static function verifyEmail($email)
    {
        //return true;
        $xmle = self::readXml("email_whitelist.xml");

        foreach($xmle as $item) {
            if($item == $email) {
                return true;
            }
        }


        $domain  = explode('@', $email);
        $domain = $domain[1];
        $apikey = env('ZEROBOUNCE_API_KEY');
        // use curl to make the request
        $url = 'https://api.zerobounce.net/v2/validate?api_key='.$apikey.'&email='.urlencode($email).'&ip_address=';

        $ch = curl_init($url);
        //PHP 5.5.19 and higher has support for TLS 1.2
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_TIMEOUT, 150);
        $response = curl_exec($ch);
        curl_close($ch);

        //decode the json response
        $json = json_decode($response, true);
        
        

        if($json['status'] == "invalid" || $json['status'] == "abuse" || $json['status'] == "unknown" || $json['status'] == "spamtrap"){
            return false;
        }



        if($domain != "gmail.com"){
            $xml = self::readXml("blocked_domains.xml");

            foreach($xml as $item) {
                if($item == $domain) {
                    return false;
                }
            }
        }

        return true;

    }

}
