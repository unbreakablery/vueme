<?php
namespace App\Http\Trails;

use App\Models\User;
use App\Services\WhiteLabel;
use App\Services\PayoutUtils;
use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait SearchUser
{
    public function searchUsersWithFilter(Request $request, $from = '')
    {       
        $query = User::query()->select('user.*')       
        ->join('user_profile', 'user_profile.user_id', '=', 'user.id')
        ->join('user_mobile_num', 'user_mobile_num.user_id', '=', 'user.id');

        $status = $request->get('status');
        if($from == 'from_payout' && $status == 'Pending'){
                
            $today = date('Y-m-d');  
            $query->join('payout_log','payout_log.psychic_id','=','user.id');
            $query->groupBy('payout_log.psychic_id')                      
                  ->where('upcoming','=','UPCOMING')
                  ->havingRaw('SUM(payout_log.payout) >= ?',[75])
                  ->whereDate('pay_day','<=',$today);                            
        }
        if($from == 'from_payout' && $status == 'Paid'){
                
            $today = date('Y-m-d');  
            $query->join('payout_log','payout_log.psychic_id','=','user.id');
            $query->groupBy('payout_log.psychic_id')                      
                  ->where([['upcoming','=','COMPLETED'],['status','=','Paid']]);                
                                         
        }             
    

        if ($request->has('no_test_user')) {
            $query->where('test_user', 0);
        }

        if ($rol = $request->get('role')) {
            $query->where('role_id', $rol);
        }

        if ($category = $request->get('category')) {
            $query->whereHas('categories', function ($query) use ($category) {
                return $query->where('slug', $category);
            });
        }
       

        if($sort = $request->get('sort')){
            
            if ($sort == 'created_at' || $sort == 'email' || $sort == 'profile_percent' || $sort == 'featured' || $sort == 'active' || $sort == 'fraud' || $sort == 'account_status' || $sort == 'test_user') {            
                if($sort == 'created_at' || $sort == 'email' || $sort == 'profile_percent')
                $query->orderBy($sort, $request->get('sortDesc') ? 'desc' : 'asc');
                else {
                $query->orderBy($sort, !$request->get('sortDesc') ? 'desc' : 'asc');
                $query->orderBy('created_at', 'desc');
                }

            }
            else{
                if($sort == 'full_name'){
                    $query->orderBy("user_profile.name", $request->get('sortDesc') ? 'desc' : 'asc');
                    $query->orderBy("user_profile.last_name", $request->get('sortDesc') ? 'desc' : 'asc');
                }
                else if($sort == 'location'){
                    $query->orderBy("user_profile.city", $request->get('sortDesc') ? 'desc' : 'asc');
                    $query->orderBy("user_profile.state", $request->get('sortDesc') ? 'desc' : 'asc');
                }
                else if($sort == 'transactions'){
                    $query->addSelect(DB::raw('(SELECT SUM(amount) FROM transaction WHERE transaction.user_id = user.id) as ammount'))                    
                    ->orderBy('ammount', $request->get('sortDesc') ? 'desc' : 'asc');
                        }
                else if($sort == 'earning'){
                    $query->addSelect(DB::raw('(SELECT SUM(payout) FROM payout_log WHERE payout_log.psychic_id = user.id AND 
                     payout_log.status = "Pending") as earning '))
                    ->orderBy('earning', $request->get('sortDesc') ? 'desc' : 'asc');
                        }
                   
                else if($sort == 'paid'){
                    $query->addSelect(DB::raw('(SELECT SUM(payout) FROM payout_log WHERE payout_log.psychic_id = user.id AND 
                     payout_log.status = "Paid") as earning '))
                    
                    ->orderBy('earning', $request->get('sortDesc') ? 'desc' : 'asc');
                        }
                else if($sort == 'device'){
                    $query->addSelect(DB::raw('(SELECT ip FROM user_device WHERE user_device.user_id = user.id LIMIT 1) as ip '))
                    
                    ->orderBy('ip', $request->get('sortDesc') ? 'desc' : 'asc');
                        }        

                        else if($sort == 'current_balance'){
                            $startstrontime = (date('D')=== 'Mon') ? strtotime('now'):strtotime('last monday');
                            $endStronTime = strtotime('next sunday');
                            $first = date('Y-m-d', $startstrontime);
                            $last =  date('Y-m-d', $endStronTime); 
                            $query->addSelect(DB::raw("(SELECT SUM(credits) FROM user_credit_log WHERE user_credit_log.psychic_id = user.id AND DATE(user_credit_log.created_at) >= DATE('$first') AND DATE(user_credit_log.created_at) <= DATE('$last')) as current"))
                    ->orderBy('current', $request->get('sortDesc') ? 'desc' : 'asc');
                                }
                else
                    $query->orderBy("user_profile.$sort", $request->get('sortDesc') ? 'desc' : 'asc');
            }
        }

         if($from == 'admin')
        $query->orderBy("user.created_at", 'desc');
        else$query->orderBy("user.priority", 'desc');

        if($search = $request->get('search')){
            
            $this->searchTerm($query, $search);        
        }

        return $query;
    }

    public function searchTerm(&$query, $search, $noDivice = false){

        $searchTerms = array_filter( explode(" ", $search), function ($value) {
                return !empty($value);
            });

         if(!$noDivice){
            $query2 = clone $query;
            $query2->join('user_device', 'user_device.user_id', '=', 'user.id');
   
            $query2
                   ->where(function ($query2) use ($searchTerms) {
   
                       foreach (['ip'] as $attribute) {
                           foreach ($searchTerms as $searchTerm) {
                               $sql = "LOWER(user_device.{$attribute}) LIKE ?";
                               $searchTerm = mb_strtolower($searchTerm, 'UTF8');
                               $query2->orWhereRaw($sql, ["%{$searchTerm}%"]);
                           }
                       }
                   });
         }

            if(!$noDivice && count($query2->get()->all())) $query = $query2;    

            else{;

            $query
            ->where(function ($query) use ($searchTerms) {

                foreach (['name', 'last_name', 'display_name'] as $attribute) {
                    foreach ($searchTerms as $searchTerm) {
                        $sql = "LOWER(user_profile.{$attribute}) LIKE ?";
                        $searchTerm = mb_strtolower($searchTerm, 'UTF8');
                        $query->orWhereRaw($sql, ["%{$searchTerm}%"]);
                    }
                }
                foreach (['number'] as $attribute) {
                    foreach ($searchTerms as $searchTerm) {
                        $sql = "LOWER(user_mobile_num.{$attribute}) LIKE ?";
                        $searchTerm = mb_strtolower($searchTerm, 'UTF8');
                        $query->orWhereRaw($sql, ["%{$searchTerm}%"]);
                    }
                }

                foreach (['email', 'id'] as $attribute) {
                    foreach ($searchTerms as $searchTerm) {
                        $sql = "LOWER(user.{$attribute}) LIKE ?";
                        $searchTerm = mb_strtolower($searchTerm, 'UTF8');
                        $query->orWhereRaw($sql, ["%{$searchTerm}%"]);
                    }
                }
            });
            }

    }
}