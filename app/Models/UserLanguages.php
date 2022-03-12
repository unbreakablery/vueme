<?php

namespace App\Models;

use App\Services\WhiteLabel;
use Illuminate\Database\Eloquent\Model;

class UserLanguages extends Model
{
	protected $table = 'user_languages';


	protected $casts = [
		'user_id' => 'int',
		'languages_id' => 'int',
	];

    protected $fillable = [
        'user_id',
        'languages_id',
    ];


	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

	public function languages()
	{
		return $this->belongsTo(\App\Models\Languages::class);
	}


	public function languageName()
	{
		return $this->hasOne(\App\Models\Languages::class,'id');
	}

	
}
