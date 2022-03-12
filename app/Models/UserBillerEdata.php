<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBillerEdata extends Model
{
    protected $table = 'user_biller_edata';
    protected $casts = [
        'user_id' => 'int',
        'test_mode' => 'bool',
    ];

    protected $fillable = [
        'user_id',
        'billing_id',
        'last_four',
        'type',
        'test_mode',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }


}
