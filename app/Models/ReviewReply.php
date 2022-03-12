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
class ReviewReply extends Model
{
	protected $table = 'review_reply';

	protected $casts = [
		'psychic_id' => 'int',
        'review_id' => 'int'
	];




	public function psychic()
	{
		return $this->belongsTo(\App\Models\User::class, 'psychic_id');
	}

    public function review()
    {
        return $this->belongsTo(\App\Models\Review::class, 'review_id');
    }
}
