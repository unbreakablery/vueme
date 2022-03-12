<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:02 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
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
class HoroscopeZodiacSigns extends Model
{
	
	protected $table = 'horoscope_zodiac_signs';

	protected $fillable = [
		'name', 'text','about', 'from', 'to', 'start_period', 'end_period'
		, 'glance_1'
		, 'glance_2'
		, 'glance_3'
		, 'glance_4'
		, 'glance_5'
		, 'glance_6'
		, 'glance_7'
		, 'glance_8'
		, 'glance_9'
		, 'glance_10'
		, 'glance_11'
		, 'glance_12'
	];

	protected $hidden = ["created_at", "updated_at"];
	
}
