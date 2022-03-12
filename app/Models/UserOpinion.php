<?php

namespace App\Models;

use App\Services\WhiteLabel;
use Illuminate\Database\Eloquent\Model;



class UserOpinion extends Model
{
	protected $table = 'user_opinion';


	protected $casts = [
		'user_id' => 'int',
		'fan_chat_room_id' => 'int',
	];

    protected $fillable = [
        'opinion',
		'fan_chat_room_id',
		'user_id'
    ];


	
	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

	public function fan_chat_room()
	{
		return $this->belongsTo(\App\Models\fan_chat_room::class);
	}


}
