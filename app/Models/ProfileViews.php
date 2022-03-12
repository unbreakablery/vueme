<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
 * @package App\Models
 */
class ProfileViews extends Model
{
	
	protected $table = 'profile_views';

	protected $casts = [
		
	];

	protected $dates = [
		
	];

	protected $fillable = [
		
	];

	public function psychic()
	{
		return $this->belongsTo(\App\Models\User::class);
    }
   

	
}
