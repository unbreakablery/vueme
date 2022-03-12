<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:02 +0000.
 */

namespace App\Models;


use App\Services\WhiteLabel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NotifyInApp
 * 
 * @property int $id
 * @property int $user_id
 * @property string $body
 * @property string $LINK
 * @property string $viewed
 * @property string $category
 * @property int $user_message_log_id
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @property string $deleted_at
 * @property string $avatar
 * 
 * @property \App\Models\User $user
 * @property \App\Models\UserMessageLog $user_message_log
 *
 * @package App\Models
 */
class NotifyInApp extends Model
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'notify_in_app';
    const CATEGORY_CONNECT = "CONNECT";
    const CATEGORY_PROFILE = "PROFILE";
	protected $casts = [
		'user_id' => 'int',
		'user_message_log_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'body',
		'LINK',
		'viewed',
		'category',
		'user_message_log_id',
		'avatar'
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

	public function user_message_log()
	{
		return $this->belongsTo(\App\Models\UserMessageLog::class);
	}
}
