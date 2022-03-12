<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:03 +0000.
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class Role
 * 
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $users
 *
 * @package App\Models
 */
class HoroscopeInfo extends Model
{
	

	protected $table = 'horoscope_info';

	protected $fillable = [
		
		'content',
		
	];

	public function horoscope_zodiac_signs()
	{
		return $this->belongsTo(\App\Models\HoroscopeZodiacSigns::class, 'horoscope_zodiac_signs_id');
	}


	public function match1()
	{
		return $this->belongsTo(\App\Models\HoroscopeZodiacSigns::class, 'match_id1');
	}

	public function match2()
	{
		return $this->belongsTo(\App\Models\HoroscopeZodiacSigns::class, 'match_id2');
	}
	public function match3()
	{
		return $this->belongsTo(\App\Models\HoroscopeZodiacSigns::class, 'match_id3');
	}


	

   
}
