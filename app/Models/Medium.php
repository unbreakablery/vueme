<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:02 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Medium
 * 
 * @property int $id
 * @property int $user_id
 * @property string $status
 * @property \Carbon\Carbon $pinned_at
 * @property string $for_sale
 * @property \Carbon\Carbon $available_after
 * @property string $type
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $filename
 * @property string $mime
 * @property string $dimension
 * @property int $duration
 * @property bool $error_cnt
 * @property string $preview_file
 * @property string $thumb_filename
 * @property int $thumb_version
 * @property string $playlist
 * @property int $credits_price
 * @property string $sale_type
 * @property string $hashtags
 * @property string $department
 * @property int $likes
 * @property int $views
 * @property \Carbon\Carbon $notify_email_at
 * @property \Carbon\Carbon $notify_sms_at
 * @property \Carbon\Carbon $notify_sns_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $post_media
 *
 * @package App\Models
 */
class Medium extends Model
{
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $casts = [
		'user_id' => 'int',
		'duration' => 'int',
		'error_cnt' => 'bool',
		'thumb_version' => 'int',
		'credits_price' => 'int',
		'likes' => 'int',
		'views' => 'int'
	];

	protected $dates = [
		'pinned_at',
		'available_after',
		'notify_email_at',
		'notify_sms_at',
		'notify_sns_at'
	];

	protected $fillable = [
		'user_id',
		'status',
		'pinned_at',
		'for_sale',
		'available_after',
		'type',
		'name',
		'slug',
		'description',
		'filename',
		'mime',
		'dimension',
		'duration',
		'error_cnt',
		'preview_file',
		'thumb_filename',
		'thumb_version',
		'playlist',
		'credits_price',
		'sale_type',
		'hashtags',
		'department',
		'likes',
		'views',
		'notify_email_at',
		'notify_sms_at',
		'notify_sns_at'
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

	public function post_media()
	{
		return $this->hasMany(\App\Models\PostMedia::class, 'media_id');
	}
}
