<?php

namespace App\Models;

use App\Services\WhiteLabel;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserDevice extends Model
{
   protected $table = 'user_device';

   protected $fillable = [
        'user_id',
		'ip',
		'browser',
		'system',
		'device',
        'device_name'
   ];

   protected $hidden = [
       'id',
       'user_id',
       'created_at',
       'updated_at'
   ];

   public function user(){

       return $this->belongsTo(\App\Models\User::class,'user_id');
   }


   
   public function isBrowserSupported(){


    if(strpos($this->system, "Windows") !== false && strpos($this->browser, "Chrome") === false ){
        return ["DOWNLOAD", "If you wish to proceed you must use Chrome.", "Free Chrome Download", "https://www.google.com/chrome/"];
    }else if(strpos($this->system, "iOS") !== false && strpos($this->browser, "Safari") !== false){
        return ["ADVICE", "We strongly recommend using your computer.", "Proceed Anyways", ""];
    }else if(strpos($this->system, "iOS") !== false && strpos($this->browser, "Safari") === false){
        return ["NOT_SUPPORTED", "We strongly recommend using your computer. However if you want to proceed you must use Safari.", "", ""];
    }else if(strpos($this->system, "AndroidOS") !== false && strpos($this->browser, "Chrome") === false){
        return ["DOWNLOAD", "We strongly recommend using your computer. However if you want to proceed you must use Chrome.", "Free Chrome Download", "https://www.google.com/chrome/"];
    }else if(strpos($this->system, "AndroidOS") !== false && strpos($this->browser, "Chrome") !== false){
        return ["ADVICE", "We strongly recommend using your computer.", "Proceed Anyways", ""];
    }else if(strpos($this->system, "OS X") !== false && strpos($this->browser, "Safari") === false){
        return ["NOT_SUPPORTED", "If you wish to proceed you must use Safari.", "", ""];
    }
    return ["SUPPORTED"];

   
   }

   public function isBrowserSupportedSettings(){


    if(strpos($this->system, "Windows") !== false && strpos($this->browser, "Chrome") === false ){
        return ["ADVICE", "For a better video chat & call experience, we recommend using a computer. However, if you wish to proceed you must use Chrome.", "Free Chrome Download", "https://www.google.com/chrome/"];
    }else if(strpos($this->system, "iOS") !== false && strpos($this->browser, "Safari") !== false){
        return ["ADVICE", "For a better video chat & call experience, we recommend using a computer.", "", ""];
    }else if(strpos($this->system, "iOS") !== false && strpos($this->browser, "Safari") === false){
        return ["NOT_SUPPORTED", "For a better video chat & call experience, we recommend using a computer. However, if you wish to proceed you must use Safari.", "", ""];
    }else if(strpos($this->system, "AndroidOS") !== false && strpos($this->browser, "Chrome") === false){
        return ["ADVICE", "For a better video chat & call experience, we recommend using a computer. However, if you wish to proceed you must use Chrome.", "Free Chrome Download", "https://www.google.com/chrome/"];
    }else if(strpos($this->system, "AndroidOS") !== false && strpos($this->browser, "Chrome") !== false){
        return ["ADVICE", "For a better video chat & call experience, we recommend using a computer.", "", ""];
    }else if(strpos($this->system, "OS X") !== false && strpos($this->browser, "Safari") === false){
        return ["NOT_SUPPORTED", "For a better video chat & call experience, we recommend using a computer. However, if you wish to proceed you must use Safari.", "", ""];
    }
    return ["SUPPORTED", "For a better video chat & call experience, we recommend using a computer.", "", ""];

   
   }
}
