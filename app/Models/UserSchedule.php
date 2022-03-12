<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSchedule extends Model
{
    //
    protected $table = 'user_schedule';

	protected $fillable = [

		'user_id',
		'day',
		'active',
		'from',
		'till'

	];
	
	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

}
