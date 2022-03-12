<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFavoritePsychics extends Model
{
    protected $table = 'user_favorite_psychics';

    protected $fillable = [
		'user_id',
		'psychic_id',
	];


}
