<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tools extends Model
{
    protected $table = 'tools';
	protected $hidden = ['pivot'];

	protected $fillable = [
		'name', 'color'
	];  

	public function users()
	{
		return $this->belongsToMany(\App\Models\User::class, 'user_tools');					
	}
}
