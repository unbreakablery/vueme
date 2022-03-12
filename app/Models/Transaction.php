<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
   protected $table = 'transaction';

  protected $casts = [
      'billing_id' => 'int',
      'transaction_type_id' => 'int',
       'order_id' => 'int',
  ];

  protected $fillable = [
      'order_id',
      'transaction_type_id',
      'amount',
      'action',
      'result_text',
      'result_code',
      'result_avs',
      'result',
      'result_type',
      'result_cvv',
  ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function payout_logs()
	{
		return $this->hasMany(\App\Models\PayoutLog::class,'transaction_id');
	}
}


