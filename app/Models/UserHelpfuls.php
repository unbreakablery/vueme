<?php

namespace App\Models;

use App\Services\WhiteLabel;
use Illuminate\Database\Eloquent\Model;



class UserHelpfuls extends Model
{
	protected $table = 'user_helpfuls';


	protected $casts = [
		'user_id' => 'int',
		'review_id' => 'int',
	];

    protected $fillable = [
        'user_id',
        'review_id',
    ];


	
	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

	public function review()
	{
		return $this->belongsTo(\App\Models\Review::class);
	}


}
