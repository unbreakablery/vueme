<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialties extends Model
{
	protected $table = 'specialties';
	protected $hidden = ['pivot'];

	protected $fillable = [
		'name', 'color'
	];  

	public function users()
	{
		return $this->belongsToMany(\App\Models\User::class, 'user_specialties');					
	}

}
