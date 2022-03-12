<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:03 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 * 
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $status
 * @property string $type
 * @property set $access_type
 * @property int $access_level
 * @property string $comments
 * @property int $comments_level
 * @property int $weight
 * @property int $likes
 * @property \Carbon\Carbon $notify_email_at
 * @property \Carbon\Carbon $notify_sms_at
 * @property \Carbon\Carbon $notify_sns_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property int $views
 * 
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $access_types
 * @property \Illuminate\Database\Eloquent\Collection $post_media
 * @property \Illuminate\Database\Eloquent\Collection $users
 *
 * @package App\Models
 */
class Post extends Model
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'post';

	protected $casts = [
		'user_id' => 'int',
		'access_type' => 'set',
		'access_level' => 'int',
		'comments_level' => 'int',
		'weight' => 'int',
		'likes' => 'int',
		'views' => 'int'
	];

	protected $dates = [
		'notify_email_at',
		'notify_sms_at',
		'notify_sns_at'
	];

	protected $fillable = [
		'user_id',
		'title',
		'status',
		'type',
		'access_type',
		'access_level',
		'comments',
		'comments_level',
		'weight',
		'likes',
		'notify_email_at',
		'notify_sms_at',
		'notify_sns_at',
		'views'
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

	public function access_types()
	{
		return $this->belongsToMany(\App\Models\AccessType::class, 'post_access_type')
					->withPivot('id', 'deleted_at')
					->withTimestamps();
	}

	public function post_media()
	{
		return $this->hasMany(\App\Models\PostMedia::class);
	}

	public function users()
	{
		return $this->belongsToMany(\App\Models\User::class, 'user_post_likes')
					->withPivot('id', 'deleted_at')
					->withTimestamps();
	}
}
