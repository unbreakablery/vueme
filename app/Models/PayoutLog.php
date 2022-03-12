<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:03 +0000.
 */

namespace App\Models;

use App\Services\WhiteLabel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserCreditLog
 * 
 * @property int $id
 * @property int $psychic_id
 * @property int $amount
 * @property date $start_period
 * @property date $end_period
 * @property string $status
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * 
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class PayoutLog extends Model
{
	protected $table = 'payout_log';

	protected $casts = [
	
	];


    protected $fillable = [
       
    ];
  
    public function psychic()
    {
        return $this->belongsTo(\App\Models\User::class,'psychic_id');
    }
    public function transaction()
    {
        return $this->belongsTo(\App\Models\Transaction::class,'transaction_id');
    }
    

	
  

}
