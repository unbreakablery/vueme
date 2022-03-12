<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:03 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserPostLike
 * 
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @property string $deleted_at
 * 
 * @property \App\Models\User $user
 * @property \App\Models\Post $post
 *
 * @package App\Models
 */
class UserPostLike extends Model
{
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $casts = [
		'user_id' => 'int',
		'post_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'post_id'
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

	public function post()
	{
		return $this->belongsTo(\App\Models\Post::class);
	}
}
