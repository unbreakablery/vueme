<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:03 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserMessageLog
 * 
 * @property int $id
 * @property int $user_id
 * @property int $model_id
 * @property string $name
 * @property string $type
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * 
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $notify_in_apps
 *
 * @package App\Models
 */
class Review extends Model
{
    protected $table = 'review';

    protected $casts = [
        'user_id' => 'int',
        'psychic_id' => 'int',
        'service_id' => 'int'
    ];

    protected $fillable = [
        'title',
        'text',
        'rating',
        'status',
        'helpful',
    ];



    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function psychic()
    {
        return $this->belongsTo(\App\Models\User::class, 'psychic_id');
    }

    public function service()
    {
        return $this->belongsTo(\App\Models\Services::class, 'service_id');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    public function replies()
    {
        return $this->hasMany(\App\Models\ReviewReply::class, 'review_id');
    }


    public function UserHelpfuls()
    {
        return $this->hasMany(\App\Models\UserHelpfuls::class, 'review_id');
    }

    
}
