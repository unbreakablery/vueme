<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:02 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class AccessType
 * 
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $posts
 *
 * @package App\Models
 */
class AccessType extends Model
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'access_type';

	protected $fillable = [
		'name'
	];

	public function posts()
	{
		return $this->belongsToMany(\App\Models\Post::class, 'post_access_type')
					->withPivot('id', 'deleted_at')
					->withTimestamps();
	}
}
