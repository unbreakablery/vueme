<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Styles extends Model
{
    protected $table = 'styles';
	protected $hidden = ['pivot'];

	protected $fillable = [
		'name', 'color'
	];  

	public function users()
	{
		return $this->belongsToMany(\App\Models\User::class, 'user_styles');					
	}
}
