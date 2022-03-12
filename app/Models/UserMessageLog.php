<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:03 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserMessageLog
 * 
 * @property int $id
 * @property int $user_id
 * @property int $model_id
 * @property string $name
 * @property string $type
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * 
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $notify_in_apps
 *
 * @package App\Models
 */
class UserMessageLog extends Model
{
	protected $table = 'user_message_log';

	protected $casts = [
		'user_id' => 'int',
		'model_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'model_id',
		'name',
		'type'
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

	public function notify_in_apps()
	{
		return $this->hasMany(\App\Models\NotifyInApp::class);
	}
}
