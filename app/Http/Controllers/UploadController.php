<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function returnFile($file)
    {
        //This method will look for the file and get it from drive
        $path = storage_path('app/uploads/users/' . $file);
        try {
            $file = \File::get($path);
            $type = \File::mimeType($path);
            $response = \Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        } catch (FileNotFoundException $exception) {
            abort(404);
        }
    }
    public function sexyFile($file)
    {
        /**
         *Make sure the @param $file has a dot
         * Then check if the user has Admin Role. If true serve else
         */
        if (strpos($file, '.') !== false) {
            if (Auth::user()->hasAnyRole(['Admin'])) {
                /** Serve the file for the Admin*/
                return $this->returnFile($file);
            } else {
                /**Logic to check if the request is from file owner**/
                return $this->returnFile($file);
            }
        } else {
//Invalid file name given
            return redirect()->route('home');
        }
    }
}
