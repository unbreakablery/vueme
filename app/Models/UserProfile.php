<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:03 +0000.
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class Role
 * 
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $users
 *
 * @package App\Models
 */
class UserProfile extends Model
{
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $table = 'user_profile';

	protected $fillable = [
		'user_id',
		'name',
		'last_name',
		'display_name',
		'profile_link',
		'social_link_one',
		'social_link_two',
		'description',
        'timezone',
        'gender',
        'city',
        'state',
        'license_checked'
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'user_id');
	}

    public function getHaedshotPathAttribute($value)
    {
        if ($value) {
            return Storage::disk('assets')->url('user-profile/'. $this->user_id .'/'. $value);
        }
        else {
            return Storage::disk('assets')->url('images/AVATAR_DEFAULT.png');
        }
    }

    public function getCoverPathAttribute($value)
    {
        if ($value) {
            return Storage::disk('assets')->url('user-profile/'. $this->user_id .'/'. $value);
        }
        else {
            return Storage::disk('assets')->url('images/Cover.png'); ;
        }
    }


    public function getIntroVideoPathAttribute($value)
    {
        if ($value) {
            return Storage::disk('assets')->url('user-profile/'. $this->user_id .'/'. $value);
        }
        else {
            return '';
        }
    }

    public function getIntroAudioPathAttribute($value)
    {
        if ($value) {
            return Storage::disk('assets')->url('user-profile/'. $this->user_id .'/'. $value);
        }
        else {
            return '';
        }
    }

    public function getIntroVideoThumbnailAttribute($value)
    {
        if ($value) {
            return Storage::disk('assets')->url('user-profile/'. $this->user_id .'/'. $value);
        }
        else {
            return '';
        }
    }


	public function getHeadshotUrl() {

		if ($this->haedshot_path) {
			return Storage::disk('assets')->url('user-profile/'. $this->user_id .'/'. $this->haedshot_path);
		}
		else {
			return '/images/dashboard/default_profile.jpg';
		}

	}

	public function getFullBodyUrl() {

		if ($this->full_body_path) {
			return Storage::disk('assets')->url('user-profile/'. $this->user_id .'/'. $this->full_body_path);
		}
		else {
			return '/images/dashboard/default_body.png';
		}
	}

    public function getFullName()
    {
       return $this->name." ".$this->last_name;
    }

    protected static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            $user = $model->user()->get()->first();
            $completeFields = 0;
            if($model->getOriginal('haedshot_path'))
                $completeFields++;
            if($model->description)
                $completeFields++;
            if($model->intro_video_path)
                $completeFields++;
            if($model->intro_audio_path)
                $completeFields++;
            if($model->city)
                $completeFields++;
            if($model->state)
                $completeFields++;
            if($model->country)
                $completeFields++;
            if($user->serviceActiveCount())
                $completeFields++;
            $user->profile_percent = round(100*$completeFields/8);
            $user->save();
        });
    }
   
}
