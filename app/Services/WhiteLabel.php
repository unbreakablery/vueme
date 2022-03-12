<?php namespace App\Services;


use Aws\CloudFront\CloudFrontClient;
use Aws\CloudWatchLogs\CloudWatchLogsClient;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;
use Aws\Sns\SnsClient;
use Illuminate\Support\Facades\Storage;
use App\Services\WhiteLabel;
use App\Services\WebUtils;
use App\Services\ApiUtils;
use DB;
use Log;
use Config;
use Exception;
//use Illuminate\Support\Facades\Log;
use View;

class WhiteLabel {

	private static $config = [];
	private static $common_config = []; //For configs that are common across sub-sites
	private static $site_config = []; // For configs for sub_sites

	public static function init_view(){
        View::share('layout_file', self::config('general')->site_layout . '.layouts.three');
        View::share('site_name', self::config('general')->site_name);
        View::share('site_description', self::config('general')->site_description);
        View::share('site_domain', self::config('general')->site_domain);
    }

    public static function config($type) {

            if (!isset(self::$config[$type])) {
                $file = self::file_path($type . '.php');

                if (!file_exists($file)) {
                    throw new Exception('missing '.$type.' config');
                }
                self::$config[$type] = (object) include $file;
            }
            return self::$config[$type];
    }

	public static function site_config($type,$site = 'collide')
	{
		if ( !isset(self::$site_config[$site][$type]))
			{
			$file = self::file_path($type.'.php',$site);
			if ( !file_exists($file))
				{
				throw new Exception('missing '.$type.' config');
				}
			self::$site_config[$site][$type] = (object)include $file;
			}

		return self::$site_config[$site][$type];
	}

	public static function common_config($type) {
		if (!isset(self::$common_config[$type])) {
		$file = self::common_file_path($type . '.php');
		if (!file_exists($file)) {
		throw new Exception('missing '.$type.' config');
		}
		self::$common_config[$type] = (object) include $file;
		}
		return self::$common_config[$type];
	}

	public static function chat($param){
        return WhiteLabel::config('chat')->{Config::get('app.env')}[$param];
    }

	public static function file_path($file,$dir = FALSE){
		static $config_dir = NULL;
		if ($dir)
			{
			$config_dir = $dir;
			}
		if ( !$config_dir)
			{
			$config_dir = env('CONFIG_DIR');

			if ( !$config_dir)
				{
				$config_dir = Config::get('app.config_dir');

				if ( !$config_dir)
					{

					throw new Exception('missing CONFIG_DIR');
					}
				}
			}

		return base_path().'/config/whitelabel/'.$config_dir.'/'.$file;
	}
	public static function common_file_path($file) {
		return base_path() . '/config/whitelabel/'. $file;
	}

	public static function site_id() {
        return self::config('general')->site_id;
    }

	/**
	 * Return the site_id based on the HTTP call regardless of what the config was.
	 * @return mixed
	 */
	public static function site_id_from_uri(){
		if (isset($_SERVER['HTTP_HOST'])){
		  $uri = $_SERVER['HTTP_HOST'];
		} else {
		//Log::debug("In Fsite_id_from_uri with no HOST so return".self::site_id());

		return self::site_id();  // Return the configured site id
		}
		//Log::debug("In site_id_from_uri with uri ".$uri);

		$sites = self::common_config('sites');
		//Log::debug("In site_id_from_uri with site list: ".print_r($sites,true));

		foreach ($sites as $site_id => $config_dir)
			{
			if ($config_dir == 'collide') continue;  // 'collide' will match break QA and dev right now.
			//Log::debug("In site_id_from_uri checking: ".$config_dir);

			if (strpos($uri,$config_dir) !== FALSE)
				{
				// Found string
				//Log::debug("In site_id_from_uri found $config_dir so return ".$site_id);

				return $site_id;
				}
			$domain = self::site_config('general',$config_dir)->site_domain;
			//Log::debug("In site_id_from_uri checking: ".$domain);
			if (strpos($uri,$domain) !== FALSE)
				{
				//Log::debug("In site_id_from_uri found $domain so return ".$site_id);

				return $site_id;
				}
			}
		  // If not found, return the one from this environment.
		//Log::debug("In site_id_from_uri default to return".self::site_id());
		return self::site_id();
		}


    public static function site_domain() {
        return self::config('general')->site_domain;
    }

	/**
	 * @return mixed
	 * @throws Exception
	 */
	public static function site_cookie_domain() {
        return self::config('general')->site_cookie_domain;
    }

    public static function site_name() {
        return self::config('general')->site_name;
    }

    public static function site_name_say() {
        return self::config('general')->site_name_say;
    }

    public static function site_description() {
        return self::config('general')->site_description;
    }

    public static function site_url($url = '') {
        if (is_string($url) && strlen($url)) {
            if ($url[0] == '/') {
                return self::config('general')->site_url . substr($url, 1);
            }
            return self::config('general')->site_url . $url;
        }
        return self::config('general')->site_url;
    }

    public static function site_url_http($url = '') {
        if (is_string($url) && strlen($url)) {
            if ($url[0] == '/') {
                return self::config('general')->site_url_http . substr($url, 1);
            }
            return self::config('general')->site_url_http . $url;
        }
        return self::config('general')->site_url_http;
    }

    public static function site_url_https($url = '') {
        if (is_string($url) && strlen($url)) {
            if ($url[0] == '/') {
                return self::config('general')->site_url_https . substr($url, 1);
            }
            return self::config('general')->site_url_https . $url;
        }
        return self::config('general')->site_url_https;
    }

    public static function site_url_say() {
        return self::config('general')->site_url_say;
    }

    public static function asset($path) {
        if (strpos($path, '/') !== 0) {
            $path = '/' . $path;
        }
        return self::config('media')->assets['url_cdn'] . $path;
    }

    public static function twitter_handle() {
        return self::config('social')->twitter_handle;
    }

    public static function twitter_oauth($key = null) {
        if ($key) {
            return self::config('social')->twitter_oauth[$key];
        }
        return self::config('social')->twitter_oauth;
    }

    public static function view_path($path) {
        if (self::config('general')->site_layout != 'default') {
            $tmp_path = str_replace('default', str_replace('.', '_', self::config('general')->site_layout), $path);
            //echo base_path() . '/resources/views/' . $tmp_path . '.blade.php';
            if (file_exists(base_path() . '/resources/views/' . $tmp_path . '.blade.php')) {
                return $tmp_path;
            }
        }
        return $path;
    }

    public static function include_path($path) {
        $path = str_replace('.', '/', $path);
        $path = self::view_path($path);
        return str_replace('/', '.', $path);
    }
    public static function s3delete($type, $key) {

        $s3Client = WhiteLabel::s3client($type);

        try
            {
                $result = $s3Client->deleteObject([
                    'Bucket' => WhiteLabel::config('media')->{$type}['bucket'],
                    'Key' => $key,
                ]);

                if ($result['DeleteMarker']) {
                    return true;
                    // echo $keyname . ' was deleted or does not exist.' . PHP_EOL;
                } else {
                    return false;
                    // exit('Error: ' . $keyname . ' was not deleted.' . PHP_EOL);
                }
            } catch (S3Exception $e) {
                return ['error' => $e->getAwsErrorMessage()];
                // exit('Error: ' . $e->getAwsErrorMessage() . PHP_EOL);
            }
    }
    public static function s3client($type) {
        static $clients = [];
        if (empty($clients[$type])) {
            if (empty(self::config('media')->{$type})) {
                throw new Exception('invalid s3 bucket type');
            }
            $clients[$type] = new S3Client([
                'region' => self::config('media')->{$type}['region'],
                'version' => '2006-03-01',
                'credentials' => [
                    'key' => self::config('media')->{$type}['key'],
                    'secret' => self::config('media')->{$type}['secret'],
                ],
            ]);
        }
        return $clients[$type];
    }


    public static function s3existThumbnail($type, $input) {

        $ext = pathinfo(storage_path($input['source_file']), PATHINFO_EXTENSION);
        $base_url = str_replace('.'.$ext,'.jpg',$input['source_file']);
        $base_name = basename($base_url);
        

        $s3Client = WhiteLabel::s3client($type);

        if (empty(WhiteLabel::config('media')->{$type}['bucket'])) {
            throw new Exception('missing bucket: ' . print_r($input, true));
        }

        $bucket = WhiteLabel::config('media')->{$type}['bucket'];

        //echo $input['key'].$base_name;

        
        
         if(!$s3Client->doesObjectExist($bucket, $input['key'].$base_name)){


            try {

                $skip = '-ss 5' ;
                $paths_sub[] = md5(microtime(true) . '.' . mt_rand());
                
            
                $s3Path = WebUtils::tmp_dir($paths_sub);

                $execFFmpeg = '/usr/bin/ffmpeg';
                $thumb_file = $s3Path .'/'.$base_name;
                
                $thumb_video = $input['source_file'];

                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $execFFmpeg = 'ffmpeg';
                }
                $cmd = $execFFmpeg.' -i ' . $thumb_video . ' -vframes 1 ' . $skip . ' -y ' . $thumb_file . ' 2>&1';
                exec($cmd, $output, $return_var);

                if ($return_var && !file_exists($thumb_file)) {
                    throw new Exception('make thumb fail: ' . $cmd . ' - ' . print_r($output, true) . ' - ' . $return_var);
                }
                WebUtils::chmod($thumb_file, 0666);


            $in = [
                'key'         => $input['key'] . $base_name,
                'source_file' => $thumb_file,
                'expires'     => '2592000',
                'content_type' => 'image/jpeg',
                'acl' => 'public-read',
            ];

            self::s3upload('assets', $in);

            

            } catch (\Exception $e) {
            
                throw $e;
                
            }

         }
         

    }
    public static function s3upload($type, $input) {

       /* if (empty($input['key']) || empty($input['source_file'])) {
            throw new Exception('invalid input: ' . print_r($input, true));
        }*/

        $s3Client = WhiteLabel::s3client($type);

        if (empty(WhiteLabel::config('media')->{$type}['bucket'])) {
            throw new Exception('missing bucket: ' . print_r($input, true));
        }
        
        $bucket = WhiteLabel::config('media')->{$type}['bucket'];
        


        if (filesize($input['source_file']) < 500000000) { //500MB


            $in = [
                'Bucket' => $bucket,
                'Key' => $input['key'],
                'SourceFile' => $input['source_file'],
            ];
            if (!empty($input['acl'])) {
                $in['ACL'] = $input['acl'];
            }
            if (!empty($input['content_type'])) {
                $in['ContentType'] = $input['content_type'];
            }
            if (isset($input['expires'])) {
                $in['CacheControl'] = 'max-age=' . $input['expires'];
            }
            $s3Client->putObject($in);

        } else {
            $in = [
                'bucket' => $bucket,
                'key' => $input['key'],
            ];
            if (!empty($input['acl'])) {
                $in['acl'] = $input['acl'];
            }
            if (!empty($input['content_type'])) {
                $in['ContentType'] = $input['content_type'];
            }
            if (isset($input['expires'])) {
                $in['CacheControl'] = 'max-age=' . $input['expires'];
            }
            $uploader = new MultipartUploader($s3Client, $input['source_file'], $in);
            $uploader->upload();
        }
    }

    public static function cloudfrontclient($type) {
        static $clients = [];
        if (empty($clients[$type])) {
            if (empty(self::config('media')->{$type})) {
                throw new Exception('invalid cloudfront type');
            }
            $clients[$type] = new CloudFrontClient([
                'region' => self::config('media')->{$type}['region'],
                'version' => '2016-01-28',
            ]);
        }
        return $clients[$type];
    }

    public static function cloudwatchlogsclient() {
        static $client = null;
        if (!$client) {
            $client = CloudWatchLogsClient::factory([
                'credentials' => self::config('logs')->credentials,
                'region'  => self::config('logs')->region,
                'version' => '2014-03-28',
            ]);
        }
        return $client;
    }

    public static function snsclient() {
        static $client = null;
        if (!$client) {
            $client = SnsClient::factory([
                'credentials' => self::config('notify')->sns['credentials'],
                'region' => self::config('notify')->sns['region'],
                'version' => '2010-03-31',
            ]);
        }
        return $client;
    }

    public static function setting_enum($key,$key2=null) {
        if($key2){
            return self::config('setting_enum')->{$key}[$key2];
        } else {
            return self::config('setting_enum')->{$key};
        }

    }   
    public static function getUrlMediaChat($chat,$type,$ip=null)
    {
        $key = ($chat->image) ? $chat->image : '';
       
        if($key){         
            $s3_client = Storage::disk($type)->getDriver()->getAdapter()->getClient(); 
            $bucket = self::config('media')->{$type}['bucket'];  
            $command = $s3_client->getCommand(
                'GetObject',
                [
                    'Bucket' => $bucket,
                    'Key'    => $key,
                    'ResponseContentDisposition' => 'attachment;'
                ]
            ); 
            $request = $s3_client->createPresignedRequest($command, '+600 minutes');

            return (string) $request->getUri();
           
        }else{
            return '';
        }      

      
    }  
    public static function getIpAddress()
    {


        if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $_SERVER["REMOTE_ADDR"] = $_SERVER['HTTP_CF_CONNECTING_IP'];
            }elseif (isset($_SERVER['HTTP_X_SUCURI_CLIENTIP'])){
            $_SERVER["REMOTE_ADDR"] = $_SERVER['HTTP_X_SUCURI_CLIENTIP'];
            }
            $ip_addr = $_SERVER['REMOTE_ADDR'];
            return $ip_addr;
    }

    public static function roleId($nameRole) {
        return self::config('user')->{'roles'}[$nameRole];
    }
}
