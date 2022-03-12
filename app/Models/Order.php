<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';


    public function user(){
        return $this->belongsTo(User::class);
    }
}