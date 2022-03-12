<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:03 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscription
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $description
 * @property int $price
 * @property set $type
 * @property string $status
 * @property set $duration_period
 * @property \Carbon\Carbon $created_at
 * @property string $deleted_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class Subscription extends Model
{
	// use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'subscription';

	protected $casts = [
		'user_id' => 'int',
		'price' => 'decimal:2',
		'duration_period' => 'int',
	];

	
	protected $fillable = [
		'user_id',
		'name',
		'description',
		'price',
		'type',
		'status',
		'duration_period',
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}
    public function posts()
    {
        return $this->hasMany(\App\Models\Post::class);
    }


    public function userSubscription()
    {
        return $this->belongsToMany(\App\Models\User::class, 'user_subscription');
    }


}
