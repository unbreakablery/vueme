<?php namespace App\Services;

use App\Models\BlockedUser;
use Exception;
/*use Laravel\Passport\Bridge\User;*/
use Illuminate\Support\Facades\Config;
use Log;
use Response;
use App\Models\User;
use App\Services\WhiteLabel;

class ApiUtils {
	
	/**
	 * Function for successful response.
	 *
	 * @param null $data Data to be returned in response.
	 * @param int $code Response code fo response, default 200
	 * @param array $some_headers An array of headers to set or reset, default is []
	 * @return mixed
	 */

	//New---------------------------------
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




	//Old----------------------------------
	public static function response_success($data = null,$code = 200,$some_headers = []) {    	
        return Response::json(['success'=>$data], $code);
     }
	
	public static function response_success_json($data = null,$code = 200,$some_headers = []) {
		$headers = array_merge(ApiUtils::headers(),$some_headers);
		$response = Response::json($data, $code);
		if (empty($headers)) return $response;
		return $response->withHeaders($headers);
	}
	
	
	public static function response_fail_mobile_num($error,$message, $code = 422) {
        return Response::json(['message'=>$message,'errors' => $error], $code);
    }
	public static function response_fail($error = 'Unknown Error', $code = 400) {
        return Response::json(['error' => $error, 'data' => null], $code);
    }

    public static function response_fail_data($error = 'Unknown Error', $data = null, $code = 400) {
        return Response::json(['error' => $error, 'data' => $data], $code);
    }

    public static function response_login() {
        return self::response_fail('Please Login', 401);
    }

    public static function response_invalid_account_type() {
        return self::response_fail('Invalid Account Type', 403);
    }

    public static function time($time) {
        if (empty($time)) {
            return null;
        }
        if (is_object($time)) {
            return $time->timestamp;
        }
        if (is_numeric($time)) {
            return $time;
        }
        if ($time == '0000-00-00 00:00:00') {
            return null;
        }
        return strtotime($time);
    }
    
	public static function headers(){
		if (WebUtils::dev_box()){


			return WhiteLabel::config('api_headers')->development;
		} else {

			return WhiteLabel::config('api_headers')->production;
		}
	
	}
	
	public static function upload($input){
        if (empty($input['file'])) {
            throw new Exception('missing file');
        }

        $tmp_dir = self::tmp_dir();

        try {
            //uploaded file
            $filename = md5(mt_rand().microtime()) . '.txt';
            $file = $tmp_dir . '/' . $filename;

			if (!$input['file']->move($tmp_dir, $filename)) {
				Log::warning('An error occurred in uploading speed test file: ' . print_r($input['file'], true) . ' -> ' . $tmp_dir . ' / ' . $filename);
				throw new Exception('Could not upload file ');
			}

        } catch (Exception $e) {
            self::rrmdir($tmp_dir);
            throw $e;
        }

        self::rrmdir($tmp_dir);
    }
    
    public static function tmp_dir() {
        $paths_sub[] = md5(microtime(true) . '.' . mt_rand());
        return \WebUtils::tmp_dir($paths_sub);
    }

    public static function tmp_file($dir = ''){
        $file = '';
        if (!empty($dir)) {
            $file = self::tmp_dir($dir) . '/';
        }
        return $file . md5(microtime(true) . '.' . mt_rand());
    }

    public static function rrmdir($dir, $try_again=true){
        \WebUtils::rrmdir($dir);
    }
    public static function prod_db(){

        return in_array(Config::get('app.env'), ['production', 'admin']);
    }
    public static function url(){
        return (Config::get('app.url')) != '' ? Config::get('app.url') : 'https://respectfully.com';
            
    }
    public static function generate_token($strength = 16) {

        $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        
        //$token_exit()

     
        return $random_string;
    }
     public static function is_user_blocked_by_model($model_id, $user_id)
     {
        $is_blocked = BlockedUser::where('model_id','=', $model_id)->where('user_id','=', $user_id)->first();
        return $is_blocked !==null ? true : false;
     }
}
