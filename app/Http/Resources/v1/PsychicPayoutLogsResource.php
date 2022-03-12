<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class PsychicPayoutLogsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $start = explode('-',$this->start_period);
        $end = explode('-',$this->end_period);

        $period = $start[1].'/'.$start[2].' - '.$end[1].'/'.$end[2];
        $status_show = $this->status;
        $date_paid = '';
        if($status_show == 'Paid'){
            $status_show = 'Processed';
            if($transaction = $this->transaction()->first())
            $date_paid = date('Y-m-d',strtotime($this->transaction()->first()->created_at));
            else $date_paid = date('Y-m-d');
        }
       
      
        return [

            'id' => $this->id,
            'earnings' => $this->earnings,
            'payout' => $this->payout,
            'period' => $period,           
            'start_period' => $this->start_period,
            'end_period' => $this->end_period,
            'payout_to_pay' => $this->payout_to_pay,
            'paid_day' => $date_paid,
            'status'=> $status_show
           

           
        ];      
    }
}
