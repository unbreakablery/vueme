<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:03 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserMobileNum
 * 
 * @property int $id
 * @property int $user_id
 * @property string $number
 * @property int $validated
 * @property int $active
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * 
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class UserMobileNum extends Model
{
	protected $table = 'user_mobile_num';

	protected $casts = [
		'user_id' => 'int',
		'validated' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'user_id',
		'number',
		'validated',
		'active',
		'code2',
        'prefix'
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}
}
