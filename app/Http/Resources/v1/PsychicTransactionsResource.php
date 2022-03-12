<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class PsychicTransactionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        $first = $this->payout_logs()->orderBy('id')->first();
        $last = $this->payout_logs()->latest('id')->first();  
        $count_periods = $this->payout_logs()->count();    
        $start = date('Y/m/d',strtotime($first->start_period));
        $end = date('Y/m/d',strtotime($last->end_period));

        //$result =  new PsychicPayoutLogsResourceCollection($this->payout_logs); 
        $date = date('Y-m-d',strtotime($this->created_at));
        $status = '';
        if($this->action == 'PAYOUT_PAID'){
            $status = 'Paid';
        }
      
        return [

            'id' => $this->id,            
            'amount' => $this->amount,
            'paid_day' => $date,
            'status' => $status,
            'start_period' => $start,
            'end_period' => $end,
             'count_periods' => $count_periods
            // 'payout_logs'=>$result
           
        ];      
    }
}
