<?php

namespace App\Models;

use App\Services\WhiteLabel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class chat_in extends Model
{
    protected $table = 'chat_in';

    protected $fillable = ['user_id','receiver_id'];
    public function user(){

        return $this->belongsTo(User::class);
    }

    public function receiver(){

        return $this->belongsTo(User::class, 'receiver_id');
    }
   
}
