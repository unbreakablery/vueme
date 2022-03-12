<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class UserReferral extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $table = 'user_referral';


    protected $fillable = [
		'user_id',
		'referral_email'
	];


    public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'user_id');
	}

	public function referral($referral_id)
	{

		return UserProfile::where('user_id', $referral_id)->first();

	}


	public function joined($referral_email)
	{

		return User::where('email', $referral_email)->first() ? true : false;

	}

	 
	
}
