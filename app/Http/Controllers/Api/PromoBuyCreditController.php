<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\UserCreditLog;
use App\Models\PromoBuyCredit;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\PromoResource;

class PromoBuyCreditController extends Controller
{
    public function list(){

        $newUsers = $oldUsers = 0;

        foreach (UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')->
        select(DB::raw('count(*) as total, user_credit_log.user_id'))
        ->where('user.fraud', 0)->where('user.test_user', 0)->where('user_credit_log.action', 'BUY_CREDIT')
        ->where('user_credit_log.promo', 5)->groupBy('user_credit_log.user_id')->get() as $key => $value) {
            if($value->total == 1) $newUsers++;
            else $oldUsers++;
        }
        
        return response()->json(['promos' => PromoResource::collection(PromoBuyCredit::all()), 'new' => $newUsers, 'old' => $oldUsers]);
    }

    public function save(Request $request){

        $input = $request->all();

        PromoBuyCredit::updateOrCreate(['id' => $request->id], $request->all());
        
        return response()->json(['promos' => PromoResource::collection(PromoBuyCredit::all())]);
    }

    public function delete($id){

        PromoBuyCredit::find($id)->delete();
        
        return response()->json(['promos' => PromoBuyCredit::all()]);
    }

    
}
