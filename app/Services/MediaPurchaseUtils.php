<?php namespace App\Services;

use App\Models\media_purchase;
use App\media_purchase_item;
use App\Models\media_purchase_item_pending;
use App\media_purchase_report;
use App\Models\media_user_playlist;
use App\star_chat_log;
use Illuminate\Support\Facades\Auth;
use DB;
use Exception;
use Intervention\Image\ImageManagerStatic as Image;
use Log;
use Storage;


class MediaPurchaseUtils extends MediaBase {

    public static $type = 'media_purchase';

    public static $ext_allowed = [
        'image' => ['jpg', 'jpeg', 'png', 'gif', 'bmp'],
        'video' => ['mp4', 'wmv', 'mpeg', 'mpg', 'mov', 'avi', 'flv', 'f4v'],
        'audio' => ['wav', 'aiff', 'aif', 'aifc', 'flac', 'm4a', 'caf', 'mp3', 'aac', 'wma', 'ogg'],
        'pdf' => ['pdf'],
        'compressed' => ['zip', 'rar', 'gz', 'tgz', '7z', 'sit', 'sitx']
    ];

    //blur
    //convert britney.jpg -blur 0x30 blurred.jpg

    public static function upload($input){

        if (empty($input['file']) && empty($input['tmp_file']) && empty($input['s3_file']) && empty($input['mp3_file']) && empty($input['preview_file'])) {
            throw new Exception('missing file');
        }

        $tmp_dir = self::tmp_dir();

        try
        {
	        //uploaded file
	        if ( !empty($input['file']))
	        {

		        $mime = $input['file']->getClientMimeType();

		        if (empty($mime) || !self::mime_to_ext($mime))
		        {
			        $mime = self::file_mime($input['file']);
		        }

	        }

	        //file located on disk
	        elseif ( !empty($input['tmp_file']))
	        {

                $tmp_file = $tmp_dir . '/tmpfile';
		        copy($input['tmp_file'] ,$tmp_file);
		        $mime = self::file_mime($tmp_file);

            } //file located on disk and converted mp3
            elseif ( !empty($input['mp3_file']))
            {

                $tmp_file = $tmp_dir . '/tmpfile.mp3';
                copy($input['mp3_file'] ,$tmp_file);
                $mime = 'audio/mpeg';

            }
            elseif ( !empty($input['preview_file']))
            {

                $tmp_file = $tmp_dir . '/preview-tmpfile.mp3';
                copy($input['preview_file'] ,$tmp_file);
                $mime = 'audio/mpeg';

            }
	        //file located on S3
	        else
	        {
		        $tmp_file = $tmp_dir . '/s3tmpfile';
		        file_put_contents($tmp_file ,Storage::disk('media_purchase')->get($input['s3_file']));
		        $mime = self::file_mime($tmp_file);
	        }

	        if ( !empty($input['mime']))
	        {
		        $mime = $input['mime'];
	        }


            $ext = self::mime_to_ext($mime);
            $type = self::mime_to_type($mime);


//            $ext_allowed = array_merge(static::$ext_allowed['image'], static::$ext_allowed['video'], static::$ext_allowed['audio'], static::$ext_allowed['pdf']);
//
//            if (!in_array($ext, $ext_allowed)) {
//                log::debug('File was not an acceptable format: ' . $mime . ' - ' . $ext . ' allowed: ' . implode(', ', $ext_allowed));
//                throw new Exception('Unacceptable file format. Formats allowed: ' . implode(', ', $ext_allowed));
//            }

            // Check allowed file types
            if( !in_array($ext, static::$ext_allowed[strtolower($type)]) ) {
                throw new Exception('Unacceptable file format. '.ucfirst($type).' formats allowed: ' . implode(', ', static::$ext_allowed[strtolower($type)]));
            }

            if (strpos($mime, 'image') !== false || in_array($ext, static::$ext_allowed['image'])) {
                $type = 'IMAGE';
                if ($ext == 'jpeg') {
                    $ext = 'jpg';
                }
            } elseif (strpos($mime, 'audio') !== false || in_array($ext, static::$ext_allowed['audio'])) {
                $type = 'AUDIO';
            } elseif (strpos($mime, 'pdf') !== false || in_array($ext, static::$ext_allowed['pdf'])) {
                $type = 'PDF';
            } elseif (in_array($ext, static::$ext_allowed) || MediaBase::compression_mime_check($mime)) {
                $type = 'COMPRESSED';
            }
            else {
                $type = 'VIDEO';
                $ext = 'mp4';
            }

//            log::debug("In MediaPurchaseUtils::upload 000 with \$type, \$ext $type, $ext");

            $filename = md5(mt_rand() . microtime()) . '.' . $ext;
	        $file     = $tmp_dir . '/' . $filename;


	        if ( !empty($input['file']))
	        {

		        if ( !$input['file']->move($tmp_dir ,$filename))
		        {
                    Log::warning('MediaPurchaseUtils - an error ocurred moving the uploaded file: ' . print_r($input['file'] ,true) . ' -> ' . $tmp_dir . ' / ' . $filename);
                    throw new Exception('An error occurred');
		        }
	        } else
	        {
		        if ( !rename($tmp_file ,$file))
		        {
                    Log::warning('MediaPurchaseUtils - an error ocurred moving the local file: ' . $tmp_file . ' -> ' . $file);
			        throw new Exception('An error occurred');
		        }
	        }


	        WebUtils::chmod($file ,self::$PERMISSION['file']);

            $in = [
		        'media_purchase_id' => $input['media_purchase']->id ,
		        'type'              => $type ,
		        'name'              => !empty($input['file_name']) ? $input['file_name'] : '' ,
		        'mime'              => $mime ,
		        'status'            => 'PROCESSING' ,
	        ];


            if ( !empty($input['created_at']))
	        {
		        $in['created_at'] = $input['created_at'];
	        }

//	         log::debug("In MediaPurchaseUtils::upload 001 calling  media_purchase_item_pending::create with "
//	         . print_r($in,true));


	        $item_pending = media_purchase_item_pending::create($in);

	        $item_pending->filename = $item_pending->id . '-' . $filename;
	        $item_pending->save();

	        $in = [
		        'key'         => Auth::user()->id.'/'.$item_pending->filename ,
		        'source_file' => $file ,
		        'expires'     => self::EXPIRES,
	        ];


//	        log::debug("In MediaPurchaseUtils::upload 001 calling \WhiteLabel::s3upload with 'media_purchase' and " . print_r($in,true));




	        WhiteLabel::s3upload('media_purchase' ,$in);

	        $item_pending->get();

	        // If this is a BULLETIN IMAGE or AUDIO -- process it right now.
	        if ($input['media_purchase']->department == "BULLETINS" && $type == 'IMAGE' || $type == 'AUDIO'
            || $type == 'COMPRESSED')
	        {
	            $process_input['media_purchase_item_pending'] = $item_pending;

	            if (!empty($input['file']) && $type == 'AUDIO') {
	                $process_input['audio_preview'] = true;
                }
		        self::process($process_input);
		        self::approve(['media_purchase_item_pending' => $item_pending]);
	        }

        } catch (Exception $e) {
            self::rrmdir($tmp_dir);
            //Log::notice("MediaPurchaseUtils::upload()\n".print_r($e,1));
            throw $e;
        }

        self::rrmdir($tmp_dir);
    }

    public static function upload_playlist($input){

//     	Log::notice("In upload_playlist with \n\n	".print_r($input['playlist_data'],true));

        if (empty($input['media_purchase']) || empty($input['show']) || empty($input['playlist_data']) || empty($input['thumb_data'])) {
            throw new Exception('missing input');
        }


        $tmp_dir = self::tmp_dir();

       try {
            $thumb_file = $tmp_dir . '/thumb.jpg';

            file_put_contents($thumb_file, $input['thumb_data']);

            $cmd = '/usr/bin/convert \'' . $thumb_file . '[0]\' ' . $thumb_file . ' 2>&1';
            exec($cmd, $output, $return_var);

            if ($return_var && !file_exists($thumb_file)) {
                throw new Exception('make thumb fail: ' . $cmd . ' - ' . print_r($output, true) . ' - ' . $return_var);
            }

            \WebUtils::chmod($thumb_file, self::$PERMISSION['file']);

//	       Log::notice("In upload_playlist with thumbfile= \n\n	".print_r($thumb_file,true));


	       // Get stats on mp4 file

	       // Create temp file
	       $tmp_file = $tmp_dir.'/'.$input['playlist_data']['file_name'];

	       // Open source and destination as streams
	       $dest = fopen($tmp_file, 'w');
	       $fs = Storage::disk($input['playlist_data']['config_name'])->getDriver();
	       $source = $fs->readStream($input['playlist_data']['file_path']);


	       // Copy stream to stream.
	       while (!feof($source)) {
		       fwrite($dest, fread($source, 16777216));
	       }
	       fclose($source);
	       fclose($dest);

            \WebUtils::chmod($tmp_file, self::$PERMISSION['file']);

            $duration = round(self::media_info($tmp_file)['duration'],0);

            if ($duration < 1 ) throw new Exception("Empty video.");

            $in = [
                'media_purchase_id' => $input['media_purchase']->id,
                'type' => 'VOD',
                'playlist' => $input['playlist_data']['playlist'],
                'mime' => 'video/mp4',
                'status' => 'PENDING',
                'created_at' => $input['show']->ended_at,
                'duration' => $duration
            ];

//     	Log::notice("In upload_playlist with in \n\n	".print_r($in,true));

            $item = media_purchase_item::create($in);

            $item->thumb_filename = $item->id . '-' . md5(mt_rand().microtime()) . '.jpg';
            $item->save();

            self::_upload_thumbs($item, $thumb_file, $tmp_dir);

            $input['show']->associate_media_item($item);

            $logs = star_chat_log::where('started_at', '>=', ''.$input['show']->started_at)
                ->where('ended_at', '<=', ''.$input['show']->ended_at)
                ->where('star_id', '=', $input['show']->star_id)
                ->get();

            if ($logs && $logs->count()) {
                foreach ($logs as $log) {
                    $log->media_purchase_item_id = $item->id;
                    $log->save();
                }
            }
        } catch (Exception $e) {
        	Log::notice('Error in upload_playlist '.print_r($e->getMessage(),true));
            self::rrmdir($tmp_dir);
            throw $e;
        }
// 		   	Log::notice("returning fom upload_playlist");

        self::rrmdir($tmp_dir);
    }

    public static function process($input) {

//     	Log::debug("\n\n"
//     		."In MediaPurchaseUtils::process with input = ".print_r($input,true)
//     		."\n\n"
//    	  		);

	    if (!in_array($input['media_purchase_item_pending']->type, ['IMAGE', 'VIDEO', 'AUDIO', 'PDF', 'COMPRESSED'])) {
            return;
        }

        $tmp_dir = self::tmp_dir();

        try {
            if ($input['media_purchase_item_pending']->type == 'IMAGE') {
                $type = 'IMAGE';
                $ext = self::mime_to_ext($input['media_purchase_item_pending']->mime);
                $new_file = $tmp_file = $tmp_dir . '/new.' . $ext;
            } elseif ($input['media_purchase_item_pending']->type == 'AUDIO') {
                $type = 'AUDIO';
                $ext = self::mime_to_ext($input['media_purchase_item_pending']->mime);
                $new_file = $tmp_file = $tmp_dir . '/new.' . $ext;
                $qt_file = $tmp_dir . '/qt.mp3';
            } elseif ($input['media_purchase_item_pending']->type == 'PDF') {
                $type = 'PDF';
                $ext = self::mime_to_ext($input['media_purchase_item_pending']->mime);
                $new_file = $tmp_file = $tmp_dir . '/new.' . $ext;
            } elseif ($input['media_purchase_item_pending']->type == 'COMPRESSED') {
                $type = 'COMPRESSED';
                $ext = self::mime_to_ext($input['media_purchase_item_pending']->mime);
                $new_file = $tmp_file = $tmp_dir . '/new.' . $ext;
            } else {
                $type = 'VIDEO';
                $tmp_file = $tmp_dir . '/tmp.mp4';
                $qt_file = $tmp_dir . '/qt.mp4';
                $new_file = $tmp_dir . '/new.mp4';
            }

            $thumb_file = $tmp_dir . '/thumb.jpg';

            file_put_contents($tmp_file, Storage::disk('media_purchase')->get($input['media_purchase_item_pending']->unprocessed_uri));
            \WebUtils::chmod($tmp_file, self::$PERMISSION['file']);

            $dimension = '';
            if ($input['media_purchase_item_pending']->type == 'IMAGE') {

                self::exiv_rm($tmp_file, $ext);

                $cmd = '/usr/bin/convert \'' . $tmp_file . '\' ' . $tmp_file . ' 2>&1';
                exec($cmd, $output, $return_var);
                if ($return_var) {
                    throw new Exception('clean image fail: ' . print_r($output, true) . ' - ' . $return_var);
                }

	            $size = getimagesize($tmp_file);
                if (!empty($size)) {
                    $input['media_purchase_item_pending']->dimension = $size[0] . 'x' . $size[1];
                }

                $cmd = '/usr/bin/convert \'' . $tmp_file . '[0]\' ' . $thumb_file . ' 2>&1';
                exec($cmd, $output, $return_var);

                if ($return_var && !file_exists($thumb_file)) {
                    throw new Exception('make thumb fail: ' . $cmd . ' - ' . print_r($output, true) . ' - ' . $return_var);
                }

	            $mime = self::file_mime($new_file);
            }
            elseif ($input['media_purchase_item_pending']->type == 'AUDIO') {


                \WebUtils::chmod($new_file, self::$PERMISSION['file']);

                $res = self::media_info($new_file);

                $input['media_purchase_item_pending']->duration = $res['duration'];
                $input['media_purchase_item_pending']->dimension = $res['dimension'];

                $mime = self::ext_to_mime($ext);

            }
            elseif ($input['media_purchase_item_pending']->type == 'PDF') {

                $cmd = '/usr/bin/convert -density 600 \'' . $tmp_file . '[0]\' ' . $thumb_file;
                exec($cmd, $output, $return_var);

                if ($return_var && !file_exists($thumb_file)) {
                    throw new Exception('make pdf thumb fail: ' . $cmd . ' - ' . print_r($output, true) . ' - ' . $return_var);
                }

                $size = getimagesize($thumb_file);
                if (!empty($size)) {
                    $input['media_purchase_item_pending']->dimension = $size[0] . 'x' . $size[1];
                }

                \WebUtils::chmod($new_file, self::$PERMISSION['file']);

                $mime = self::file_mime($new_file);

            }
            elseif ($input['media_purchase_item_pending']->type == 'COMPRESSED') {

                \WebUtils::chmod($new_file, self::$PERMISSION['file']);
                $mime = self::file_mime($new_file);
            }
            else {

                $res = self::media_info($tmp_file);
                $duration = $res['duration'];

//                 Log::info('MediaPurchaseUtils::upload(): video file info: ' . print_r($res, true));

                //MAKE THUMBNAIL
                $skip = 5;
                if ($duration < $skip) {
                    $skip = $duration - 1;
                }
                if ($skip <= 0) {
                    $skip = '';
                } else {
                    $skip = '-ss ' . $skip;
                }

                $cmd = '/usr/bin/ffmpeg -i ' . $tmp_file . ' -vframes 1 ' . $skip . ' -y ' . $thumb_file . ' 2>&1';
                exec($cmd, $output, $return_var);

                if ($return_var && !file_exists($thumb_file)) {
                    throw new Exception('make thumb fail: ' . $cmd . ' - ' . print_r($output, true) . ' - ' . $return_var);
                }

                // RE-ENCODE VIDEO FILE
                if (file_exists($qt_file)) {
                    unlink($qt_file);
                }

                $cmd = '/usr/bin/ffmpeg -i ' . $tmp_file . ' -codec:v libx264 -profile:v high -preset slow -maxrate 5000k -bufsize 5000k -threads 0 -b:a 128k -y ' . $qt_file . ' 2>&1';
                exec($cmd, $output, $return_var);
                if ($return_var) {
                    throw new Exception('ffmpeg encode failed');
                }

                if (!file_exists($qt_file)) {
                    throw new Exception('ffmpeg encoded file missing');
                }

                unlink($tmp_file);

                $cmd = '/usr/bin/qt-faststart ' . $qt_file . ' ' . $new_file;
                exec($cmd, $output, $return_var);
                if ($return_var) {
                    throw new Exception('qt faststart failed');
                }

                if (!file_exists($new_file)) {
                    rename($qt_file, $new_file);
                } else {
                    unlink($qt_file);
                }

                \WebUtils::chmod($new_file, self::$PERMISSION['file']);

                $res = self::media_info($new_file);

                $input['media_purchase_item_pending']->duration = $res['duration'];
                $input['media_purchase_item_pending']->dimension = $res['dimension'];

                $mime = 'video/mp4';
            }

            if ($input['media_purchase_item_pending']->type != 'COMPRESSED') {
                \WebUtils::chmod($thumb_file, self::$PERMISSION['file']);
            }


            $input['media_purchase_item_pending']->mime = $mime;
            $input['media_purchase_item_pending']->status = 'PENDING';
            $input['media_purchase_item_pending']->save();

            Storage::disk('media_purchase')->delete($input['media_purchase_item_pending']->unprocessed_uri);

            // log::debug("processing audio mime: " . $mime);


            \WhiteLabel::s3upload('media_purchase', [
                'key' => $input['media_purchase_item_pending']->processed_uri,
                'source_file' => $new_file,
                'content_type' => $mime,
                'expires' => self::EXPIRES,
            ]);

            if ($type == 'IMAGE' || $type == 'VIDEO' || $type == 'PDF') {
                self::_upload_thumbs($input['media_purchase_item_pending'], $thumb_file, $tmp_dir);
            }

        } catch (Exception $e) {
            self::rrmdir($tmp_dir);
            throw $e;
        }


        if ($type == 'AUDIO' && $ext != 'mp3') {
            // convert audio file to mp3 and upload

            //Log::debug("converting audio file to mp3");

            if (file_exists($qt_file)) {
                unlink($qt_file);
            }

            $cmd = '/usr/bin/ffmpeg -i ' . $tmp_file . ' ' . $qt_file;
            exec($cmd, $output, $return_var);
            if ($return_var) {
                throw new Exception('audio ffmpeg encode failed');
            }

            if (!file_exists($qt_file)) {
                throw new Exception('audio ffmpeg encoded file missing');
            }

            $media_purchase = media_purchase::find($input['media_purchase_item_pending']->media_purchase_id);
            self::upload([
                'media_purchase' => $media_purchase,
                'mp3_file' => $qt_file,
            ]);
        }

        if (!empty($input['audio_preview']) && $input['audio_preview'] == true) {
            // generate audio preview
            //Log::debug("generating audio file preview as mp3");

            if (file_exists($qt_file)) {
                unlink($qt_file);
            }

            $preview_duration = 30;
            if ($res['duration'] * 0.15 < $preview_duration) {
                $preview_duration = $res['duration'] * 0.15;
            }
            //Log::debug("preview duration: " . $preview_duration);

            $cmd = '/usr/bin/ffmpeg -ss 0 -t '. $preview_duration . ' -i ' . $tmp_file . ' ' . $qt_file;
            exec($cmd, $output, $return_var);
            if ($return_var) {
                throw new Exception('audio preview ffmpeg encode failed');
            }

            if (!file_exists($qt_file)) {
                throw new Exception('audio preview ffmpeg encoded file missing');
            }

            $media_purchase = media_purchase::find($input['media_purchase_item_pending']->media_purchase_id);
            self::upload([
                'media_purchase' => $media_purchase,
                'preview_file' => $qt_file,
            ]);
        }

        self::rrmdir($tmp_dir);

    }

    public static function set_thumb($input) {
        if (empty($input['file']) || empty($input['media_purchase_item'])) {
            throw new Exception('missing file');
        }

        $tmp_dir = self::tmp_dir();

        try {
            //uploaded file
            $mime = self::file_mime($input['file']);

            if (!empty($input['mime'])) {
                $mime = $input['mime'];
            }

            $ext = self::mime_to_ext($mime);

            if (!in_array($ext, static::$ext_allowed['image'])) {
                throw new Exception('File was not an acceptable image format: '.implode(', ', static::$ext_allowed['image']));
            }

            if ($ext == 'jpeg') {
                $ext = 'jpg';
            }

            $filename = md5(mt_rand().microtime()) . '.jpg';

            $pos = strrpos($filename, '.');
            $thumb_filename = substr($filename, 0, $pos) . '-t.jpg';
            $thumb_file = $tmp_dir . '/' . $thumb_filename;

            if (!$input['file']->move($tmp_dir, $thumb_filename)) {
                throw new Exception('An error occurred');
            }

            \WebUtils::chmod($thumb_file, self::$PERMISSION['file']);

            self::exiv_rm($thumb_file, $ext);

            $cmd = '/usr/bin/convert \'' . $thumb_file . '[0]\' ' . $thumb_file . ' 2>&1';
            exec($cmd, $output, $return_var);
            if ($return_var) {
                throw new Exception('make thumb fail: ' . print_r($output, true) . ' - ' . $return_var);
            }

            \WebUtils::chmod($thumb_file, self::$PERMISSION['file']);

            $input['media_purchase_item']->thumb_filename = $input['media_purchase_item']->id . '-' . $filename;
            $input['media_purchase_item']->save();

            self::_upload_thumbs($input['media_purchase_item'], $thumb_file, $tmp_dir);
        } catch (Exception $e) {
            self::rrmdir($tmp_dir);
            throw $e;
        }

        self::rrmdir($tmp_dir);
    }

    private static function _upload_thumbs($item, $source_file, $tmp_dir) {
        \WhiteLabel::s3upload('media_purchase', [
            'key' => $item->thumb_uri,
            'source_file' => $source_file,
            'content_type' => 'image/jpeg',
            'acl' => 'public-read',
            'expires' => self::EXPIRES,
        ]);

        $size = getimagesize($source_file);

        $thumb_sizes = \WhiteLabel::config('media')->media_purchase['dimension']['V1']['additional'];

        foreach ($thumb_sizes as $thumb_size) {
            $tmp_file = $tmp_dir . '/' . $thumb_size[0] . 'x' . $thumb_size[1] . '.jpg';

            if ($thumb_size[0] == $size[0] && $thumb_size[1] == $size[1]) {
                Image::make($source_file)
                    ->save($tmp_file, self::IMAGE_QUALITY);
            } else {
                $img = Image::make($source_file);
                if ($size[0] < $size[1]) {
                    $img->crop($size[0], $size[0]);
                } else {
                    $img->crop($size[1], $size[1]);
                }
                $img->resize($thumb_size[0], $thumb_size[1]);
                $img->save($tmp_file, self::IMAGE_QUALITY);
            }

            \WhiteLabel::s3upload('media_purchase', [
                'key' => $item->thumb_uri($thumb_size),
                'source_file' => $tmp_file,
                'content_type' => 'image/jpeg',
                'acl' => 'public-read',
                'expires' => self::EXPIRES,
            ]);
        }
    }

	public static function approve($input) {

        $fields = [
			'media_purchase_id' => true,
			'type' => true,
			'playlist' => true,
			'name' => true,
			'description' => true,
			'mime' => true,
			'dimension' => true,
			'duration' => true,
		];

		$in = array_intersect_key($input['media_purchase_item_pending']->toArray(), $fields);

		$pos = strrpos($input['media_purchase_item_pending']->filename, '.');
		if ($pos === false) {
			throw new Exception('invalid Filename - missing extension');
		}
		$ext = substr($input['media_purchase_item_pending']->filename, $pos + 1);

		$media_purchase_item = media_purchase_item::create($in);
		if ($media_purchase_item->type != 'VOD') {
			$media_purchase_item->filename = $media_purchase_item->id . '-' . md5(mt_rand().microtime()) . '.' . $ext;

			if ($media_purchase_item->type != 'COMPRESSED') {
                $media_purchase_item->thumb_filename = $media_purchase_item->filename;
            }

			Storage::disk('media_purchase')->rename($input['media_purchase_item_pending']->processed_uri, $media_purchase_item->download_uri);
		} else {
			$media_purchase_item->thumb_filename = $media_purchase_item->id . '-' . md5(mt_rand().microtime()) . '.jpg';
		}

		$media_purchase_item->save();


        // Do not process thumb sizes for compressed files
        if ($media_purchase_item->type != 'COMPRESSED') {
            $thumb_sizes = \WhiteLabel::config('media')->media_purchase['dimension']['V1']['additional'];
            try {
                Storage::disk('media_purchase')->rename($input['media_purchase_item_pending']->thumb_uri, $media_purchase_item->thumb_uri);
            } catch (Exception $e) {
                //Log::warning($e);
            }

            foreach ($thumb_sizes as $thumb_size) {
                try {
                    Storage::disk('media_purchase')->rename($input['media_purchase_item_pending']->thumb_uri($thumb_size), $media_purchase_item->thumb_uri($thumb_size));
                } catch (Exception $e) {
                    //Log::warning($e);
                }
            }
        }

		$input['media_purchase_item_pending']->delete();

		return $media_purchase_item;
	}
	public static function update_reported($input) {

		$media_purchase_item = $input['media_purchase_item'];
		$media_purchase = $input['media_purchase'];

		$action = $input['action'];

		switch ($action){
			case 'delete':
				media_purchase_report::mark_deleted($media_purchase->id);
				$media_purchase->delete();
				break;
			case 'approve':
			default:
				media_purchase_report::mark_approved($media_purchase->id);
				$media_purchase->restore();
				$media_purchase_item->restore();

		}

		return $media_purchase_item;
	}

}
