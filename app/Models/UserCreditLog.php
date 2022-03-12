<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:03 +0000.
 */

namespace App\Models;

use App\Services\WhiteLabel;
use Illuminate\Database\Eloquent\Model;
use DB;
/**
 * Class UserCreditLog
 * 
 * @property int $id
 * @property int $user_id
 * @property int $model_id
 * @property int $site_id
 * @property int $credits
 * @property string $action
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * 
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class UserCreditLog extends Model
{

    public static function boot()
    {
        parent::boot();

      

        static::created(function($model){

           if($model->psychic_id){
                DB::update('update user_profile A
                INNER JOIN (
                SELECT psychic_id,COUNT(distinct user_id) cou 
                FROM user_credit_log 
                where psychic_id = '.$model->psychic_id.'
                GROUP BY user_credit_log.psychic_id) as B
                ON B.psychic_id = A.user_id 
                SET A.t_clients = B.cou
                WHERE A.user_id = '.$model->psychic_id.';');
           }
            //$total_clients = $model->psychic->psychic_credit_logs::
            //$model->psychic->user_profile->t_clients = $total_clients;
        });


    }

    
	protected $table = 'user_credit_log';

	protected $casts = [
		'user_id' => 'int',
		'psychic_id' => 'int',
		'site_id' => 'int',
        'user_1_1_chat_request_id' => 'int',
		'credits' => 'decimal:2',
        'duration' => 'decimal:2',
        'refunded' => 'boolean',
	];


    protected $fillable = [
        'user_id',
        'psychic_id',
        'credits',
        'action',
        'credits_old',
        'service_id',
        'user_1_1_chat_request_id',
        'duration',
        'promo_code',
        'promo_id',
        'appointment_id'
    ];
  
    public function psychic()
    {
        return $this->belongsTo(\App\Models\User::class,'psychic_id');
    }

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class,'user_id');
    }

    public function user_1_1_chat_request()
    {
        return $this->belongsTo(\App\Models\user_1_1_chat_request::class, 'user_1_1_chat_request_id');
    }
    
    public static function dollars_to_credits($dollars,$date = '0000-00-00 00:00:00') {
        if ($date > '0000-00-00 00:00:00')
        {
            return $dollars / self::credit_to_dollar_on_date($date);
        }
        return $dollars / WhiteLabel::config('accounting')->credit_to_dollar;

    }

    public static function credit_to_dollar_on_date($date){
        $credit_to_dollar = WhiteLabel::config('accounting')->credit_to_dollar;
        foreach (WhiteLabel::config('accounting')->credit_to_dollar_history as $credit_to_dollar_array){
            if ($date>$credit_to_dollar_array['begin_date']){
                $credit_to_dollar = $credit_to_dollar_array['credit_to_dollar'];
            }
        }
        return $credit_to_dollar;

    }
  
}
