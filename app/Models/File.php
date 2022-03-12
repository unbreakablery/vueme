<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Services\WhiteLabel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = [
        'name', 'ext', 'path', 'size', 'remote3'
    ];
    protected $hidden = ["created_at", "updated_at", "fileable_id", "fileable_id_type"];

    public function fileable()
    {
        return $this->morphTo();
    }

    public function save(array $data = []){

        if(!empty($data)){

            $pathinfo = pathinfo($data['name']);
            $base64img = $data['image'];
            if ($pathinfo['extension'] == 'png' || $pathinfo['extension'] == 'gif') {
                $img = str_replace('data:image/png;base64,', '', $base64img);
            } else {
                $img = str_replace('data:image/jpeg;base64,', '', $base64img);
            }
            $base64_decode = base64_decode(str_replace(' ', '+', $img));
            $fileName = date_timestamp_get(new \DateTime()).'.'.$pathinfo['extension'];
            try {
                Storage::disk('files')->put($fileName, $base64_decode);
                $this->name = strtolower(preg_replace('/[^A-Za-z0-9]+/', "-", $pathinfo['filename']));
                $this->ext = $pathinfo['extension'];
                $this->path = $fileName;
            } catch (\Exception $exception) {

            }
        }
        return parent::save();
    }

    public function setData(UploadedFile $file, $save = true)
    {

        $this->name = $file->getClientOriginalName();
        $this->ext = $file->extension();
        if($save)
         $this->path = $file->store('/', ['disk' => 'files']);
        $this->size = $file->getSize();
        return $this;
    }

    public function saveRemote(UploadedFile $file, $path = null){

        if(!$path)
            $path = 'user-profile/' . Auth::user()->id . '/' . Str::random(40).'.'.$file->extension();
        $this->path = $path;

        $in = [
            'key' => $path,
            'source_file' => $file->getPathname(),
            'expires' => 2592000,
            'content_type' => 'image/'.$file->extension(),
            'acl' => 'public-read',
        ];

        WhiteLabel::s3upload('assets', $in);

        $this->setData($file, false);

        $this->remote = true;

        return $this->save();
    }

    public function getPathAttribute(){
        return $this->remote ? Storage::disk('assets')->url($this->getOriginal('path')) : $this->getOriginal('path');
       }

    public function delete(array $data = [])
    {

        if ($path = $this->getOriginal('path')) {
            if($this->remote){
                WhiteLabel::s3delete('assets', $path);
            }
            else{
                try {
                    Storage::disk('files')->delete($path);
                } catch (\Exception $exception) {

                }
            }
        }
        return parent::delete();
    }

}
