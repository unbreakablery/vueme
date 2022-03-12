<?php

namespace App\Services;

use App\Models\Media;
use App\Models\Post;
use FFMpeg;
use App\Models\UserProfile;
use App\Services\ApiUtils;
use App\Services\WebUtils;
use App\Services\WhiteLabel;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use DB;
use Exception;
use Intervention\Image\ImageManagerStatic as Image;
use Storage;
use Log;

class ProfileUploadUtils extends MediaBase
{

    public static function uploadProfilePhoto($input, $photo_type, UserProfile $userProfile)
    {

        if (empty($input[$photo_type])) {
            throw new \Exception('missing file');
        }

        $tmp_dir = self::tmp_dir();
        try {
            //uploaded file
            if (!empty($input[$photo_type])) {
                $mime = $input[$photo_type]->getClientMimeType();

                if (empty($mime) || !self::mime_to_ext($mime)) {
                    $mime = self::file_mime($input[]);
                }
            }
            if (!empty($input['mime'])) {
                $mime = $input['mime'];
            }

            $ext = self::mime_to_ext($mime);
            $type = self::mime_to_type($mime);

            // Check allowed file types

            $ext_allowed = WhiteLabel::setting_enum('ext_allowed');

            if ($type == 'IMAGE') {

                if (strpos($mime, 'image') !== false || in_array($ext, $ext_allowed['image'])) {

                    $type = 'IMAGE';
                    if ($ext == 'jpeg') {
                        $ext = 'jpg';
                    }
                } else {
                    throw new \Exception('Unacceptable file format. ' . ucfirst($type) . ' formats allowed: ' . implode(', ', $ext_allowed['image']));
                }
            } else {
                throw new \Exception('Unacceptable file format. ' . ucfirst($type) . ' formats allowed: ' . implode(', ', $ext_allowed['image']));
            }
            // generate filename as psychic name + profile or cover
            // $filename = md5(mt_rand() . microtime()) . '.' . $ext;
            if ($photo_type == 'headshot') {
                $filename = str_replace(" ", "-", $userProfile->display_name) .uniqid().".".$ext;
            } else {
                $filename = str_replace(" ", "-", $userProfile->display_name) . '-cover.' . $ext;
            }

            $file = $tmp_dir . '/' . $filename;

            $extension_pos = strrpos($filename, '.'); // find position of the last dot, so where the extension starts

            // $orig_filename = substr($filename, 0, $extension_pos) . '-orig' . substr($filename, $extension_pos);
            // $orig_file = $tmp_dir . '/' . $orig_filename;
            if (!empty($input[$photo_type])) {
                if (!$input[$photo_type]->move($tmp_dir, $filename)) {
                    Log::warning('UploadUtils - an error ocurred moving the uploaded file: ' . print_r($input[$photo_type], true) . ' -> ' . $tmp_dir . ' / ' . $filename);
                    throw new \Exception('An error occurred');
                }


                // if (!$input['original_' . $photo_type]->move($tmp_dir, $orig_filename)) {
                //     Log::warning('UploadUtils - an error ocurred moving the uploaded file: ' . print_r($input['original_' . $photo_type], true) . ' -> ' . $tmp_dir . ' / ' . $orig_filename);
                //     throw new \Exception('An error occurred');
                // }
            }

            WebUtils::chmod($file, self::$PERMISSION['file']);
            $res = self::media_info($file);
            //$dimension = ($res['dimension']!='0x0')? $res['dimension']:0;

            $in = [
                'key' => 'user-profile/' . Auth::user()->id . '/' . $filename,
                'source_file' => $file,
                'expires' => self::EXPIRES,
                'content_type' => 'image/jpeg',
                'acl' => 'public-read',
            ];

            WhiteLabel::s3upload('assets', $in);

     
            // WebUtils::chmod($orig_file, self::$PERMISSION['file']);
            // $res = self::media_info($orig_file);
            //$dimension = ($res['dimension']!='0x0')? $res['dimension']:0;

            // $in = [
            //     'key' => 'user-profile/' . Auth::user()->id . '/' . $orig_filename,
            //     'source_file' => $orig_file,
            //     'expires' => self::EXPIRES,
            //     'content_type' => 'image/jpeg',
            //     'acl' => 'public-read',
            // ];

            // WhiteLabel::s3upload('assets', $in);

            if ($photo_type == 'headshot') {
                $userProfile->haedshot_path = $filename;
            } else {
                $userProfile->cover_path = $filename;
            }

            $userProfile->save();

            return $userProfile;
        } catch (\Exception $e) {
            self::rrmdir($tmp_dir);
            throw $e;
        }

        self::rrmdir($tmp_dir);
    }

    // public static function uploadProfilePhoto($input,$photo_type,UserProfile $userProfile){


    //     if (empty($input[$photo_type])) {
    //         throw new \Exception('missing file');
    //     }

    //     $tmp_dir = self::tmp_dir();
    //     try
    //     {
    //         //uploaded file
    //         if ( !empty($input[$photo_type]))
    //         {
    //             $mime = $input[$photo_type]->getClientMimeType();



    //             if (empty($mime) || !self::mime_to_ext($mime))
    //             {
    //                 $mime = self::file_mime($input[]);
    //             }
    //         }
    //         if ( !empty($input['mime']))
    //         {
    //             $mime = $input['mime'];
    //         }

    //         $ext = self::mime_to_ext($mime);
    //         $type = self::mime_to_type($mime);

    //         // Check allowed file types

    //         $ext_allowed = WhiteLabel::setting_enum('ext_allowed');

    //         if($type == 'IMAGE'){

    //             if (strpos($mime, 'image') !== false || in_array($ext, $ext_allowed['image'])) {

    //                 $type = 'IMAGE';
    //                 if ($ext == 'jpeg') {
    //                     $ext = 'jpg';
    //                 }
    //             }
    //             else {
    //                 throw new \Exception('Unacceptable file format. '.ucfirst($type).' formats allowed: ' . implode(', ',$ext_allowed['image']));
    //             }
    //         }
    //         else {
    //             throw new \Exception('Unacceptable file format. '.ucfirst($type).' formats allowed: ' . implode(', ',$ext_allowed['image']));
    //         }

    //         $filename = md5(mt_rand() . microtime()) . '.' . $ext;
    //         $file     = $tmp_dir . '/' . $filename;

    //         if ( !empty($input[$photo_type]))
    //         {
    //             if ( !$input[$photo_type]->move($tmp_dir ,$filename))
    //             {
    //                 Log::warning('UploadUtils - an error ocurred moving the uploaded file: ' . print_r($input[$photo_type] ,true) . ' -> ' . $tmp_dir . ' / ' . $filename);
    //                 throw new \Exception('An error occurred');
    //             }
    //         }

    //         WebUtils::chmod($file ,self::$PERMISSION['file']);
    //         $res = self::media_info($file);
    //         //$dimension = ($res['dimension']!='0x0')? $res['dimension']:0;

    //         $in = [
    //             'key'         => 'user-profile/'.Auth::user()->id.'/'.$filename ,
    //             'source_file' => $file ,
    //             'expires'     => self::EXPIRES,
    //             'content_type' => 'image/jpeg',
    //             'acl' => 'public-read',
    //         ];

    //       WhiteLabel::s3upload('assets' ,$in);


    //           $userProfile->haedshot_path = $filename;


    //         $userProfile->save();

    //         return $userProfile;



    //     } catch (\Exception $e) {
    //         self::rrmdir($tmp_dir);
    //         throw $e;
    //     }

    //     self::rrmdir($tmp_dir);
    // }

    // public static function uploadProfileCover($input,$photo_type,UserProfile $userProfile){


    //     if (empty($input[$photo_type])) {
    //         throw new \Exception('missing file');
    //     }

    //     $tmp_dir = self::tmp_dir();
    //     try
    //     {
    //         //uploaded file
    //         if ( !empty($input[$photo_type]))
    //         {
    //             $mime = $input[$photo_type]->getClientMimeType();



    //             if (empty($mime) || !self::mime_to_ext($mime))
    //             {
    //                 $mime = self::file_mime($input[]);
    //             }
    //         }
    //         if ( !empty($input['mime']))
    //         {
    //             $mime = $input['mime'];
    //         }

    //         $ext = self::mime_to_ext($mime);
    //         $type = self::mime_to_type($mime);

    //         // Check allowed file types

    //         $ext_allowed = WhiteLabel::setting_enum('ext_allowed');

    //         if($type == 'IMAGE'){

    //             if (strpos($mime, 'image') !== false || in_array($ext, $ext_allowed['image'])) {

    //                 $type = 'IMAGE';
    //                 if ($ext == 'jpeg') {
    //                     $ext = 'jpg';
    //                 }
    //             }
    //             else {
    //                 throw new \Exception('Unacceptable file format. '.ucfirst($type).' formats allowed: ' . implode(', ',$ext_allowed['image']));
    //             }
    //         }
    //         else {
    //             throw new \Exception('Unacceptable file format. '.ucfirst($type).' formats allowed: ' . implode(', ',$ext_allowed['image']));
    //         }

    //         $filename = md5(mt_rand() . microtime()) . '.' . $ext;
    //         $file     = $tmp_dir . '/' . $filename;

    //         if ( !empty($input[$photo_type]))
    //         {
    //             if ( !$input[$photo_type]->move($tmp_dir ,$filename))
    //             {
    //                 Log::warning('UploadUtils - an error ocurred moving the uploaded file: ' . print_r($input[$photo_type] ,true) . ' -> ' . $tmp_dir . ' / ' . $filename);
    //                 throw new \Exception('An error occurred');
    //             }
    //         }

    //         WebUtils::chmod($file ,self::$PERMISSION['file']);
    //         $res = self::media_info($file);
    //         //$dimension = ($res['dimension']!='0x0')? $res['dimension']:0;

    //         $in = [
    //             'key'         => 'user-profile/'.Auth::user()->id.'/'.$filename ,
    //             'source_file' => $file ,
    //             'expires'     => self::EXPIRES,
    //             'content_type' => 'image/jpeg',
    //             'acl' => 'public-read',
    //         ];

    //         WhiteLabel::s3upload('assets' ,$in);


    //         $userProfile->cover_path = $filename;


    //         $userProfile->save();

    //         return $userProfile;



    //     } catch (\Exception $e) {
    //         self::rrmdir($tmp_dir);
    //         throw $e;
    //     }

    //     self::rrmdir($tmp_dir);
    // }

    public static function uploadProfileVideo($input, $video_type, UserProfile $userProfile)
    {





        if (empty($input[$video_type])) {
            throw new \Exception('missing file');
        }

        $tmp_dir = self::tmp_dir();
        try {

            
            //uploaded file
            if (!empty($input[$video_type])) {
                $mime = $input[$video_type]->getClientMimeType();



                if (empty($mime) || !self::mime_to_ext($mime)) {
                    $mime = self::file_mime($input[]);
                }
            }
            if (!empty($input['mime'])) {
                $mime = $input['mime'];
            }

            $ext = self::mime_to_ext($mime);
            $type = self::mime_to_type($mime);
            /* var_dump($input[$video_type]);
            var_dump($video_type);
            var_dump($mime);
            var_dump($input['mime']);
            var_dump($ext);
            var_dump($type);
            die();*/
            // Check allowed file types

            $ext_allowed = WhiteLabel::setting_enum('ext_allowed');

            if ($type == 'VIDEO') {

                if (strpos($mime, 'video') !== false || in_array($ext, $ext_allowed['video'])) {
                    $type = 'VIDEO';
                } else {
                    throw new \Exception('Unacceptable file format. ' . ucfirst($type) . ' formats allowed: ' . implode(', ', $ext_allowed['video']));
                }
            } else {
                throw new \Exception('Unacceptable file format. ' . ucfirst($type) . ' formats allowed: ' . implode(', ', $ext_allowed['video']));
            }

            $base_name = md5(mt_rand() . microtime());
            $filename = $base_name . '.' . $ext;
            $file     = $tmp_dir . '/' . $filename;



            if (!empty($input[$video_type])) {
                if (!$input[$video_type]->move($tmp_dir, $filename)) {
                    Log::warning('UploadUtils - an error ocurred moving the uploaded file: ' . print_r($input[$video_type], true) . ' -> ' . $tmp_dir . ' / ' . $filename);
                    throw new \Exception('An error occurred');
                }
            }

            WebUtils::chmod($file, self::$PERMISSION['file']);
            // $res = self::media_info($file);
            //$dimension = ($res['dimension']!='0x0')? $res['dimension']:0;

            $thumb_video = $tmp_dir.'/'.$filename;



            try {

                // $timeToSecond  = '1';
                $s3Path = 'user-profile/' . Auth::user()->id . '/' ;
                $skip = '-ss 5' ;


                $execFFmpeg = '/usr/bin/ffmpeg';
                $thumb_file = $tmp_dir . '/'.$base_name.'.jpg';

                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $execFFmpeg = 'ffmpeg';
                }
                $cmd = $execFFmpeg.' -i ' . $thumb_video . ' -vframes 1 ' . $skip . ' -y ' . $thumb_file . ' 2>&1';
                exec($cmd, $output, $return_var);

                if ($return_var && !file_exists($thumb_file)) {
                    throw new Exception('make thumb fail: ' . $cmd . ' - ' . print_r($output, true) . ' - ' . $return_var);
                }
                WebUtils::chmod($thumb_file, self::$PERMISSION['file']);


            $in = [
                'key'         => 'user-profile/' . Auth::user()->id . '/' . $base_name.'.jpg',
                'source_file' => $thumb_file,
                'expires'     => self::EXPIRES,
                'content_type' => 'image/jpeg',
                'acl' => 'public-read',
            ];

            WhiteLabel::s3upload('assets', $in);

                

            } catch (\Exception $e) {
            
                throw $e;
                
            }




            $in = [
                'key'         => 'user-profile/' . Auth::user()->id . '/' . $filename,
                'source_file' => $file,
                'expires'     => self::EXPIRES,
                'content_type' => 'image/jpeg',
                'acl' => 'public-read',
            ];

            WhiteLabel::s3upload('assets', $in);


            $userProfile->intro_video_path = $filename;
            $userProfile->intro_video_thumbnail = $base_name.'.jpg';


            $userProfile->save();


           
            return $userProfile;


           


        } catch (\Exception $e) {
            self::rrmdir($tmp_dir);
            throw $e;
        }

        self::rrmdir($tmp_dir);
    }

    public static function uploadProfileAudio($input, $audio_type, UserProfile $userProfile)
    {


        if (empty($input[$audio_type])) {
            throw new \Exception('missing file');
        }

        $tmp_dir = self::tmp_dir();
        try {


            //uploaded file
            if (!empty($input[$audio_type])) {
                $mime = $input[$audio_type]->getClientMimeType();


                if (empty($mime) || !self::mime_to_ext($mime)) {
                    $mime = self::file_mime($input[]);
                }


                //  dd($mime);
            }
            if (!empty($input['mime'])) {
                $mime = $input['mime'];
            }

            $ext = self::mime_to_ext($mime);
            $type = self::mime_to_type($mime);

            // Check allowed file types

            $ext_allowed = WhiteLabel::setting_enum('ext_allowed');

            if ($type == 'AUDIO') {

                if (strpos($mime, 'audio') !== false || in_array($ext, $ext_allowed['audio'])) {
                    $type = 'AUDIO';
                } else {
                    throw new \Exception('Unacceptable file format. ' . ucfirst($type) . ' formats allowed: ' . implode(', ', $ext_allowed['audio']));
                }
            } else {
                throw new \Exception('Unacceptable file format. ' . ucfirst($type) . ' formats allowed: ' . implode(', ', $ext_allowed['audio']));
            }

            $filename = md5(mt_rand() . microtime()) . '.' . $ext;
            $file     = $tmp_dir . '/' . $filename;

            if (!empty($input[$audio_type])) {
                if (!$input[$audio_type]->move($tmp_dir, $filename)) {
                    Log::warning('UploadUtils - an error ocurred moving the uploaded file: ' . print_r($input[$audio_type], true) . ' -> ' . $tmp_dir . ' / ' . $filename);
                    throw new \Exception('An error occurred');
                }
            }

            WebUtils::chmod($file, self::$PERMISSION['file']);
            $res = self::media_info($file);
            //$dimension = ($res['dimension']!='0x0')? $res['dimension']:0;

            $in = [
                'key'         => 'user-profile/' . Auth::user()->id . '/' . $filename,
                'source_file' => $file,
                'expires'     => self::EXPIRES,
                'content_type' => 'image/jpeg',
                'acl' => 'public-read',
            ];

            WhiteLabel::s3upload('assets', $in);


            $userProfile->intro_audio_path = $filename;


            $userProfile->save();

            return $userProfile;
        } catch (\Exception $e) {
            self::rrmdir($tmp_dir);
            throw $e;
        }

        self::rrmdir($tmp_dir);
    }


   
}
