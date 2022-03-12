<?php

namespace App\Http\Resources\v1;

use App\Models\PromoBuyCredit;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCreditLogsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       $impact = 'negative'; 
       $image ='';      
       $name = '-------';
       if($this->psychic){
           $name = $this->psychic->userProfile->display_name ? $this->psychic->userProfile->display_name : $this->psychic->userProfile->name;
           $image = $this->psychic->userProfile->haedshot_path;
        }
        $icon = '';
        $symbol = '$';
        //S_REFUND
        if($this->action == 'BUY_CREDIT' || $this->action =='REFUND' || $this->action == 'Credited'){
           $impact = 'positive';
           if($this->service_id == 2){
               $this->action = "Chat Refunded";
           }else if($this->service_id == 1){
               $this->action = "Failed Call";
           }else if($this->service_id == 3){
               $this->action = "Failed V-Chat";
           }
           else if($this->action != 'Credited'){
                $this->action = "Purchased";
           }
          
           $icon = 'mdi-coin';
           $symbol = '$';           
        }
        
        if($this->action == 'ACCOUNT_REFUND'){
            $impact = 'positive';
            $this->action = "Card Refund";
            $icon = 'mdi-coin';
        }
        
        
       //Video Chat Calling Chat
        if($this->service_id === 1){
            $icon = 'mdi-phone';
        }
        elseif($this->service_id == 2){
            $icon = 'mdi-message';
        }
        elseif($this->service_id == 3){
            $icon = 'mdi-video';
        }

        $promoAmount = 0;        
        if($this->promo_id){
            $promo = PromoBuyCredit::find($this->promo_id);
            $promoAmount = $this->promo_amount ? $this->promo_amount : $promo->credits[0]['extra'];
        }
        
        return [
            'id' => $this->id,
            'psychic_name' => isset($this->display_name) ? $this->display_name : $name,
            'psychic_image' => $image,
            'service' => $this->action ?? 'Free Message',
            'duration' => $this->duration,
            'amount'=> $this->credits,
            'impact' => $impact,
            'created' => $this->created_at,
            'icon' => $icon,
            'symbol' => $symbol,
            'refunded' => $this->refunded,
            'promo' => $this->promo,
            'promo_code' => $this->promo_code,
            'promo_amount' => $promoAmount

           
        ];      
    }
}
