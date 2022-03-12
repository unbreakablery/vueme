<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:03 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VerifyUser
 * 
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class VerifyUser extends Model
{
	protected $casts = [
		'user_id' => 'int'
	];

	protected $hidden = [
		'token'
	];

	protected $fillable = [
		'user_id',
		'token'
	];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

}
