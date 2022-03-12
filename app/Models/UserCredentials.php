<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:03 +0000.
 */

namespace App\Models;

use App\Services\WhiteLabel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserCredentials
 * 
 * @property int $id
 * @property int $user_id
 * @property int $model_id
 * @property int $site_id
 * @property int $credits
 * @property string $action
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * 
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class UserCredentials extends Model
{
	protected $table = 'user_credentials';



	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

}
