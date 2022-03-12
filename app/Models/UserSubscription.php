<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:03 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserPostBought
 *
 * @property int $id
 * @property int $user_id
 * @property int $subscription_id
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @property string $deleted_at
 *
 * @property \App\Models\User $user
 * @property \App\Models\Subscription $subscription
 *
 * @package App\Models
 */
class UserSubscription extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'user_subscription';

    protected $casts = [
        'user_id' => 'int',
        'subscription_id' => 'int'
    ];

    protected $fillable = [
        'user_id',
        'subscription_id'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function subscription()
    {
        return $this->belongsTo(\App\Models\Subscription::class, 'subscription_id');
    }


}
