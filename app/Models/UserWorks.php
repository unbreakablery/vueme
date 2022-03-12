<?php

namespace App\Models;

use App\Services\WhiteLabel;
use Illuminate\Database\Eloquent\Model;

class UserWorks extends Model
{
	protected $table = 'user_works';



	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

}
