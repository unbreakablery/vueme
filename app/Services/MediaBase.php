<?php namespace App\Services;

use League\Flysystem\Util\MimeType;

use Exception;
use Log;

use finfo;

class MediaBase {

    public static $type = null;

    public static $PERMISSION = [
        'dir' => 0777,
        'file' => 0666,
    ];

    const IMAGE_QUALITY = 90;

    const EXPIRES = 2592000; //30 days

    public static function download($input) {
        if (empty($input['url'])) {
            throw new Exception('missing url: ' . print_r($input, true));
        }

        $file = @file_get_contents($input['url']);
        if (empty($file) || md5($file) == '7d4df9cc423720b7f1f3d672b89362be') {
            throw new Exception('blank file: ' . print_r($input, true));
        }

        $tmp_file = self::tmp_file('download');
        file_put_contents($tmp_file, $file);
        \WebUtils::chmod($tmp_file, self::$PERMISSION['file']);

        if (!empty($input['mime'])) {
            $mime = $input['mime'];
        } else {
            $mime = self::file_mime($tmp_file);
            if (!$mime) {
                unlink($tmp_file);
                throw new Exception('no mime found:' . $tmp_file . ' - ' . print_r($input, true));
            }
        }

        if (!($file_type = self::mime_to_type($mime))) {
            unlink($tmp_file);
            throw new Exception('no file type:' . $mime . ' - ' . print_r($input, true));
        }

        $ext = self::mime_to_ext($mime);
        if (!$ext) {
            unlink($tmp_file);
            throw new Exception('no ext:' . $mime . ' - ' . print_r($input, true));
        }

        //set extension from mime
        $tmp_file_old = $tmp_file;
        $tmp_file = $tmp_file . '.' . $ext;
        rename($tmp_file_old, $tmp_file);

        return $tmp_file;
    }

    public static function mime_to_ext($mime) {
        $ext = MimeType::getExtensionToMimeTypeMap();
        $ext = array_flip($ext);
        //force common types
        $ext['audio/amr'] = 'amr';
        $ext['audio/mpeg'] = 'mp3';
        $ext['audio/mp3'] = 'mp3';
        $ext['audio/wav'] = 'wav';
        $ext['audio/m4a'] = 'm4a';
        $ext['audio/x-hx-aac-adts'] = 'aac';
        $ext['image/jpeg'] = 'jpg';
        $ext['video/3gpp'] = '3gp';
        $ext['video/x-ms-asf'] = 'wma';
        $ext['video/mp4'] = 'mp4';
        $ext['application/pdf'] = 'pdf';
        $ext['application/zip'] = 'zip';
        $ext['application/x-zip'] = 'zip';
        $ext['application/x-zip-compressed'] = 'zip';
        $ext['application/octet-stream'] = 'rar';
        $ext['application/rar'] = 'rar';
        $ext['application/x-rar'] = 'rar';
        $ext['application/x-rar-compressed'] = 'rar';
        $ext['application/tar+gzip'] = 'tgz';
        $ext['application/gzip'] = 'gz';
        $ext['application/x-gzip'] = 'gz';
        $ext['application/x-gzip-compressed'] = 'gz';
        $ext['application/7z'] = '7z';
        $ext['application/x-7z'] = '7z';
        $ext['application/x-7z-compressed'] = '7z';
        $ext['application/x-sit'] = 'sit';
        $ext['application/x-sitx'] = 'sit';
        $ext['application/x-stuffit'] = 'sit';
        $ext['application/x-stuffitx'] = 'sit';
        if (!empty($ext[$mime])) {
            return $ext[$mime];
        }
        return null;
    }

    public static function ext_to_mime($ext) {
        $arr = MimeType::getExtensionToMimeTypeMap();
        return !empty($arr[$ext]) ? $arr[$ext] : null;
    }

    public static function file_mime($path){
        $finfo = new finfo(FILEINFO_MIME);
        $mime = $finfo->file($path);
        $pos = strpos($mime, ';');
        if ($pos !== false) {
            $mime = substr($mime, 0, $pos);
        }
        return $mime;
    }

    public static function compression_mime_check($mime) {
        $compression_mimes = [
            'application/octet-stream',
            'application/zip',
            'application/x-zip',
            'application/x-zip-compressed',
            'application/rar',
            'application/x-rar',
            'application/x-rar-compressed',
            'application/gzip',
            'application/x-gzip',
            'application/x-gzip-compressed',
            'application/tar+gzip',
            'application/tar',
            'application/x-tar',
            'application/x-tar-compressed',
            'application/x-gzip',
            'application/x-gzip-compressed',
            'application/7z',
            'application/x-7z',
            'application/x-7z-compressed',
            'application/x-sit',
            'application/x-sitx',
            'application/x-stuffit',
            'application/x-stuffitx',
        ];
        $compression_ext = [
            'zip',
            'rar',
            '7z',
            'gzip',
            'sit',
            'stuffit',

        ];
        if (in_array($mime, $compression_mimes) ||
            stripos($mime, 'compressed') !== false) {
            return true;
        }
        foreach ($compression_ext as $ext) {
            if (stripos($mime, $ext) !== false) {
                return true;
            }
        }
        return false;
    }

    public static function mime_to_type($mime){
        if ($mime == 'video/x-ms-asf') {
            return 'AUDIO';
        }
        if ($mime == 'application/pdf') {
            return 'PDF';
        }
        if (self::compression_mime_check($mime)) {
            return 'COMPRESSED';
        }
        if (stripos($mime, 'image/') === 0) {
            return 'IMAGE';
        }
        if (stripos($mime, 'video/') === 0) {
            return 'VIDEO';
        }
        if (stripos($mime, 'audio/') === 0) {
            return 'AUDIO';
        }
        if (stripos($mime, 'pdf/') === 0) {
            return 'PDF';
        }
        return null;
    }

    public static function rrmdir($dir, $try_again=true){
        $required = WebUtils::tmp_dir([static::$type]);
        if (stripos($dir, $required) !== 0) {
            throw new Exception('invalid directory (not in storage_path):' . $dir . ' -- ' . $required);
        }
        WebUtils::rrmdir($dir);
    }

    public static function tmp_dir($name = '') {
        $paths_sub = [static::$type];
        if (!empty($name)) {
            $paths_sub[] = $name;
        }
        $paths_sub[] = md5(microtime(true) . '.' . mt_rand());
        return WebUtils::tmp_dir($paths_sub, self::$PERMISSION['dir']);
    }

    public static function tmp_file($dir = ''){
        $file = '';
        if (!empty($dir)) {
            $file = self::tmp_dir($dir) . '/';
        }
        return $file . md5(microtime(true) . '.' . mt_rand());
    }

    public static function media_info($file) {
        $output = [];

        $cmd = '/usr/bin/ffmpeg -i ' . $file . ' -vstats 2>&1';
        exec($cmd, $output);
        $output = empty($output) ? [] : $output;
        $output = implode("\n", $output);

        $res = [];
        
        $reg = "/Duration: ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}).([0-9]{1,2})/";
        $hours = $mins = $secs = $ms = 0;
        if (preg_match($reg, $output, $regs)) {
            $hours = !empty($regs[1]) ? $regs[1] : 0;
            $mins = !empty($regs[2]) ? $regs[2] : 0;
            $secs = !empty($regs[3]) ? $regs[3] : 0;
            $ms = !empty($regs[4]) ? $regs[4] : 0;
        }
        $res['duration'] = ($hours * 60 * 60) + ($mins * 60) + $secs + ($ms / 100);
        if (!$res['duration']) {
            Log::notice('MediaBase::media_info - no duration - ' . print_r($output, true));
        }

        $reg = "/Video: ([^,]*), ([^,]*), ([0-9]{1,4})x([0-9]{1,4})/";
        $width = $height = 0;
        if (preg_match($reg, $output, $regs)) {
            $codec = $regs[1] ? $regs[1] : null;
            $width = $regs[3] ? $regs[3] : null;
            $height = $regs[4] ? $regs[4] : null;
        }
        $res['dimension'] = $width . 'x' . $height;

        return $res;
    }

    public static function exiv_rm($source_file, $ext) {
        if (in_array($ext, ['gif', 'bmp'])) {
            return;
        }

        // If we find exif orientation data in the source file, run convert with -auto-orient
        // to apply the orientation exif data to the raw jpg source
        if (self::has_orientation($source_file)) {

           self::auto_orient($source_file);
        }
        $cmd = '/usr/bin/exiv2 rm ' . $source_file . ' 2>&1';
        exec($cmd, $output, $return_var);
        if ($return_var) {
            throw new Exception('exiv image fail: ' . $cmd . ' - ' . print_r($output, true) . ' - ' . $return_var);
        }
    }

    // Returns one of the Imagick orientation constants
    // https://www.php.net/manual/en/imagick.constants.php#imagick.constants.orientation
    public static function has_orientation($source_file) {
        $image = new \Imagick($source_file);
        return $image->getImageOrientation();
    }

    public static function jpeg_optimize($source_file, $ext) {
        if (!in_array($ext, ['jpg', 'jpeg'])) {
            return;
        }
        
        $cmd = '/usr/bin/jpegtran -copy none -optimize -outfile ' . $source_file . ' ' . $source_file . ' 2>&1';
        exec($cmd, $output, $return_var);
        if ($return_var) {
            throw new Exception('jpegtran image fail: ' . $cmd . ' - ' . print_r($output, true) . ' - ' . $return_var);
        }
    }

    public static function png_optimize($source_file, $ext) {
        if (!in_array($ext, ['png'])) {
            return;
        }
        
        $cmd = '/usr/bin/optipng -o7 ' . $source_file . ' 2>&1';
        exec($cmd, $output, $return_var);
        if ($return_var) {
            throw new Exception('optipng image fail: ' . $cmd . ' - ' . print_r($output, true) . ' - ' . $return_var);
        }
    }

    public static function auto_orient($source_file) {
        $image = new \Imagick($source_file);
        $orientation = $image->getImageOrientation();

        // Verbose but necessary...
        switch ($orientation) {
            case \Imagick::ORIENTATION_TOPLEFT:
                break;
            case \Imagick::ORIENTATION_TOPRIGHT:
                $image->flopImage();
                break;
            case \Imagick::ORIENTATION_BOTTOMRIGHT:
                $image->rotateImage("#000", 180);
                break;
            case \Imagick::ORIENTATION_BOTTOMLEFT:
                $image->flopImage();
                $image->rotateImage("#000", 180);
                break;
            case \Imagick::ORIENTATION_LEFTTOP:
                $image->flopImage();
                $image->rotateImage("#000", -90);
                break;
            case \Imagick::ORIENTATION_RIGHTTOP:
                $image->rotateImage("#000", 90);
                break;
            case \Imagick::ORIENTATION_RIGHTBOTTOM:
                $image->flopImage();
                $image->rotateImage("#000", 90);
                break;
            case \Imagick::ORIENTATION_LEFTBOTTOM:
                $image->rotateImage("#000", -90);
                break;
        }

        $image->writeImage($source_file);
    }

}
