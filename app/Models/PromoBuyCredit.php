<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:02 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
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
class PromoBuyCredit extends Model
{
    protected $table = 'promo_buy_credit';

    protected $hidden = ["created_at", "updated_at"];

    protected $fillable = [
       'code', 'credits', 'active'
    ];
    
    protected $casts = [
        'credits' => 'array'
    ];
}
