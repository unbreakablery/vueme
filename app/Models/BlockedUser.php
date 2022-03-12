<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:02 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 * 
 * @property int $id
 * @property int $user_id
 * @property int $model_id
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $users
 *
 * @package App\Models
 */
class BlockedUser extends Model
{
    public $timestamps = false;
	protected $table = 'blocked_users';

	protected $fillable = [
        'user_id',
		'model_id'
	];


}