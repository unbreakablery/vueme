<?php

namespace App\Http\Controllers\API;

use App\Billing\gwapi;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\AdminChatMessageResource;
use App\Http\Resources\v1\AdminChatResourceCollection;
use App\Http\Resources\v1\PsychicCreditLogsResourceCollection;
use App\Http\Resources\v1\PsychicPayoutLogsResourceCollection;
use App\Http\Resources\v1\PsychicTransactionsResourceCollection;
use App\Http\Resources\v1\ReviewAdminResourceCollection;
use App\Http\Resources\v1\UserAdminPayoutResource;
use App\Http\Resources\v1\UserAdminPayoutResourceCollection;
use App\Http\Resources\v1\UserAdminResource;
use App\Http\Resources\v1\UserAdminResourceCollection;
use App\Http\Resources\v1\UserAdminTransactionResource;
use App\Http\Resources\v1\UserAdminTransactionResourceCollection;
use App\Http\Resources\v1\UserBasicResourceCollection;
use App\Http\Resources\v1\UserCreditLogsResourceCollection;
use App\Http\Trails\PayoutTrail;
use App\Http\Trails\SearchUser;
use App\Http\Trails\ServiceTrail;
use App\Models\Appointment;
use App\Models\Category;
use App\Models\chat;
use App\Models\chat_in;
use App\Models\Country_all;
use App\Models\File;
use App\Models\PayoutLog;
use App\Models\Review;
use App\Models\Services;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserCreditLog;
use App\Models\UserMobileNum;
use App\Models\UserProfile;
use App\Models\UserService;
use App\Services\ApiUtils;
use App\Services\BillingUtils;
use App\Services\EmailUtils;
use App\Services\PayoutUtils;
use App\Services\TwilioUtils;
use App\Services\WebUtils;
use App\Services\WhiteLabel;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    use SearchUser, PayoutTrail, ServiceTrail;

    public function __construct(Guard $auth)
    {
        $this->middleware('auth:api');
        $this->middleware('admin');
        $this->middleware('verifield');
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @param Request $request
     * @return UserBasicResourceCollection|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function getUsers(Request $request)
    {
        if (!$request->get('page')) {
            if ($id = $request->get('id')) {
                return new UserAdminResource(User::where('id', $id)->first());
            }
        }

        $query = $this->searchUsersWithFilter($request, 'admin');
        if ($id = $request->get('id')) {
            // if ($user = User::find($id)) {
            return new UserAdminResourceCollection(User::where('id', $id)->paginate(1));
            // }

        }

        return ($perPage = $request->get('per_page')) ? new UserAdminResourceCollection($query->paginate($perPage)) : $query->get();
    }

    protected function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user->user_credit_logs()->count() && !$user->transactions()->count()) {
            foreach (['psychic_id' => 'user_category', 'blog_etc_comments', 'blog_etc_posts', 'receiver_id' => 'chat'
                , 'receiver_id' => 'chat_in', 'fan_chat_room', 'model_id' => 'model_chat_room', 'notify_in_app', 'client_id' => 'oauth_access_tokens',
                'client_id' => 'oauth_auth_codes', 'oauth_clients', 'order', 'rate', 'psychic_id' => 'review',
                'transaction', 'model_id' => 'user_1_1_chat_request', 'user_biller_edata', 'user_category',
                'user_credentials', 'psychic_id' => 'user_credit_log', 'user_device', 'psychic_id' => 'user_favorite_psychics',
                'user_languages', 'model_id' => 'user_message_log', 'user_mobile_num', 'user_profile', 'user_schedule', 'user_service',
                'user_specialties', 'user_styles', 'user_tools', 'user_works', 'verify_users'] as $key => $value) {

                if (\is_numeric($key)) {
                    DB::table($value)->where('user_id', $user->id)->delete();
                } else {
                    DB::table($value)->whereRaw("(user_id = {$user->id} OR $key = {$user->id})")->delete();
                }

            }

            foreach (['model_id' => 'model_chat_show', 'client_id' => 'oauth_personal_access_clients',
                'psychic_id' => 'payout_log', 'psychic_id' => 'profile_views', 'psychic_id' => 'review_reply'] as $key => $value) {
                DB::table($value)->whereRaw("($key = {$user->id})")->delete();
            }
        }
        $user->delete();
        return 'deleted';
    }

    protected function getUsersService(Request $request)
    {
        $service = [];

        $service['Model'] = [
            'avg_session' => 0,
            'avg_video' => 0,
            'avg_call' => 0,
            'avg_chat' => 0,
            'avg_service' => 0,
            'avg_rate_call' => 0,
            'avg_rate_video' => 0,
            'avg_new_session_per_psychic' => 0,
            'chat_rate_avg' => 0,
        ];

        $service['User'] = [
            'avg_session' => 0,
            'avg_video' => 0,
            'avg_call' => 0,
            'avg_chat' => 0,
            'avg_new_session' => 0,
        ];

        foreach (['Model', 'User'] as $type) {

            $values = $type == 'Model' ? $this->psychicService() : $this->clientService();

            foreach ($service[$type] as $key => $value) {

                if (isset($values[$key]) && $values[$key]) {

                    $service[$type][$key] = $values[$key];
                }
            }
        }

        $service['rate'] = $this->serviceRate();

        $query = Appointment::select('appointment.created_at as appointmentDate', 'model_chat_room.created_at as responseDate')
            ->join('user_1_1_chat_request', 'user_1_1_chat_request.appointment_id', '=', 'appointment.id')
            ->join('services', 'services.id', '=', 'user_1_1_chat_request.service_id')
            ->join('model_chat_room', 'model_chat_room.id', '=', 'user_1_1_chat_request.model_chat_room_id');

        $service['avg_time'] = [];
        $service['avg_time']['avg_call_now'] = $service['avg_time']['avg_call_later'] = $service['avg_time']['avg_video_later'] = null;

        foreach (['now', 'later'] as $value) {

            $query2 = clone $query;

            $shedule = $value == 'now' ? 0 : 1;

            $result = $query2->where('services.id', 1)->where('appointment.type', $value)->get()->map(function ($item) {
                $date1 = Carbon::createFromFormat('Y-m-d H:i:s', $item->appointmentDate);
                $date2 = Carbon::createFromFormat('Y-m-d H:i:s', $item->responseDate);
                return $date1->diffInSeconds($date2);
            });

            $service['avg_time']["avg_call_$value"] = $result->count() == 0 ? 0 : \round($result->sum() / $result->count(), 0);

            $query2 = clone $query;

            $result = $query2->where('services.id', 3)->where('appointment.type', $value)->get()->map(function ($item) {
                $date1 = Carbon::createFromFormat('Y-m-d H:i:s', $item->appointmentDate);
                $date2 = Carbon::createFromFormat('Y-m-d H:i:s', $item->responseDate);
                return $date1->diffInSeconds($date2);
            });

            $service['avg_time']["avg_video_$value"] = $result->count() == 0 ? 0 : \round($result->sum() / $result->count(), 0);
        }

        $query2 = clone $query;

        $result = $query2->where('services.id', 1)->get()->map(function ($item) {
            $date1 = Carbon::createFromFormat('Y-m-d H:i:s', $item->appointmentDate);
            $date2 = Carbon::createFromFormat('Y-m-d H:i:s', $item->responseDate);
            return $date1->diffInSeconds($date2);
        });
        $service['avg_time']["avg_call"] = $result->count() == 0 ? 0 : \round($result->sum() / $result->count(), 0);

        $query2 = clone $query;

        $result = $query2->where('services.id', 3)->get()->map(function ($item) {
            $date1 = Carbon::createFromFormat('Y-m-d H:i:s', $item->appointmentDate);
            $date2 = Carbon::createFromFormat('Y-m-d H:i:s', $item->responseDate);
            return $date1->diffInSeconds($date2);
        });
        $service['avg_time']["avg_video"] = $result->count() == 0 ? 0 : \round($result->sum() / $result->count(), 0);

        return \json_encode($service);
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @param Request $request
     * @return UserBasicResourceCollection|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function updateUser($id, Request $request)
    {
        $input = $request->all();

        $item = User::find($id);
        $profile = UserProfile::where('user_id', $id)->first();

        $id = $item->id;

        if (isset($input['profile_link']) && UserProfile::where('user_id', '!=', $item->id)->where('user_profile.profile_link', $input['profile_link'])->count()) {
            return json_encode(['profile_link' => $profile->profile_link]);
        }

        if (isset($input['role_id']) && $item->role_id != $input['role_id']) {
            if (WhiteLabel::roleId('Model') == $input['role_id'] && !UserService::where('user_id', $item->id)->count()) {
                for ($i = 1; $i <= 3; $i++) {
                    $userService = new UserService();
                    $userService->user()->associate($item);
                    $userService->service_id = $i;

                    if ($i == 1) {
                        $userService->min_duration = 5;
                        $userService->rate = 2;
                    } elseif ($i == 3) {
                        $userService->min_duration = 5;
                        $userService->rate = 5;
                    }

                    $userService->save();
                }
            }
        }
        if (isset($input['credits']) && $item->credits != $input['credits']) {

            $creditLog = new UserCreditLog();
            $creditLog->user_id = $item->id;
            $creditLog->credits_old = $item->credits;
            $creditLog->credits = abs($item->credits - $input['credits']);
            $creditLog->action = $item->credits < $input['credits'] ? 'Credited' : 'Retracted';
            $creditLog->save();
        }
        $item->update($input);

        if (isset($input['email_validated']) && $input['email_validated'] === false) {

        }
        if (isset($input['categories']) && !isset($input['categories'][0]['id'])) {
            $item->categories()->sync($input['categories']);
        }

        $profile->update($input);

        if (isset($input['phone_numbers']) && $input['phone_numbers']['number']) {

            if (isset($input['phone_numbers']['id'])) {

                $phone = UserMobileNum::find($input['phone_numbers']['id']);
            } else {

                $phone = new UserMobileNum();
                $phone->user_id = $item->id;
            }
            if ($phone->number != $input['phone_numbers']['number']) {

                $phone->number = $input['phone_numbers']['number'];
                $phone->validated = 0;
                $code = rand(1000, 9999);
                $phone->verification_code = $code;
                $phone->active = 0;
                TwilioUtils::send_verification_sms($phone);

            }
            $phone->code2 = $input['phone_numbers']['code2'];
            $phone->save();
        }

        return 'updated';
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @param Request $request
     * @return UserBasicResourceCollection|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function updateCategory($id = null, Request $request)
    {
        $item = $id ? Category::find($id) : new Category();

        if($request->delete){
            $item->delete();
            return 'deleted';
        }
        if ($color = $request->get('color')) {
            $item->color = $color;
        }
        if ($image = $request->get('image')) {
            if ($img = $item->image) {
                $img->delete();
            }

            $image = new File();
            $image->save(['name' => $request->get('name'), 'image' => $request->get('image')]);
            $item->image()->save($image);
            return $image->path;
        }
        if ($name = $request->get('name')) {
            $item->name = $name;
            $item->slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($name));
        }
        if ($description = $request->get('description')) {
            $item->description = $description;
        }
        $item->save();

        return $item->id;
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @param Request $request
     * @return UserBasicResourceCollection|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function updateService($id, Request $request)
    {
        $item = Services::find($id);
        $item->update($request->all());
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @param Request $request
     * @return UserBasicResourceCollection|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function payouts(Request $request)
    {

        $from = 'from_payout';
        $request->request->add(['no_test_user' => true]);

        $query = $this->searchUsersWithFilter($request, $from);
        if ($id = $request->get('id')) {
            return new UserAdminPayoutResource($query->find($id));
        }
        return ($perPage = $request->get('per_page')) ?
        new UserAdminPayoutResourceCollection($query->paginate($perPage)) : $query->get();
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @param Request $request
     * @return UserBasicResourceCollection|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function reviews(Request $request)
    {
        if ($id = $request->get('id')) {
            $review = Review::find($id);
            $input = $request->all();
            unset($input['id']);
            $review->update($input);
        }
        $query = Review::query()->select('review.*');

        if ($sort = $request->get('sort')) {
            if ($sort == 'created_at') {
                $query->orderBy($sort, $request->get('sortDesc') ? 'desc' : 'asc');
            }
        } else {
            $query->orderBy('status', 'desc')
                ->orderBy('created_at', 'desc');
        }
        if ($filter = $request->get('filter')) {
            if ($filter == 'Pending') {
                $query->where('status', 'Pending');
            } else if ($filter == 'Approved') {
                $query->where('status', 'Posted');
            } else if ($filter == 'Removed') {
                $query->where('status', 'Removed');
            }
        }

        if ($search = $request->get('search')) {

            if ($request->get('searchOn') == 'Client') {
                $query->join('user', 'user.id', '=', 'review.user_id')
                    ->join('user_profile', 'user_profile.user_id', '=', 'user.id');
            } else {
                $query->join('user', 'user.id', '=', 'review.psychic_id')
                    ->join('user_profile', 'user_profile.user_id', '=', 'user.id');
            }

            $query->join('user_mobile_num', 'user_mobile_num.user_id', '=', 'user.id');
            $this->searchTerm($query, $search, true);

        }

        return ($perPage = $request->get('per_page')) ? new ReviewAdminResourceCollection($query->paginate($perPage)) : $query->get();
    }

    protected function getPaymentInfo(Request $request)
    {
        $id = $request->input('id');
        $user = User::find($id);

        if ($user->role_id == 1) {
            $data = BillingUtils::get_user_cards_and_info($user->id, 'DEPOSIT');
            if (!count($data) && $user->paypal_account) {
                $data = ['type' => 'PAYPAL', 'account' => $user->paypal_account];
            }

        } elseif ($user->role_id == 2) {
            $data = BillingUtils::get_user_cards_and_info($user->id, 'CREDIT');
        }

        return $data;
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @param Request $request
     * @return UserBasicResourceCollection|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function payoutInitEmail(Request $request, $id)
    {
        $user = User::find($id);

        if ($user) {

            $ip_addr = WebUtils::getUserIp();
            $processor = "ccprocessora";
            $payouts = PayoutUtils::get_payouts_to_pay($user);
            $total_amount = number_format((float) $payouts->sum('payout'), 2);
            $declineTransaction = new Transaction();
            $transaction = new Transaction();

            if ($request->billing !== 'PAYPAL') {

                $billing = $user->biller_edata()->where('billing_id', $request->billing)->first();

                if ($billing) {

                    //make refund (sale) to NMI
                    $gw = new gwapi();
                    $gw->setLogin(BillingUtils::username(), BillingUtils::password());
                    $gw->doDeposit($total_amount, $user->id, $billing->billing_id, $ip_addr, $processor);
                    $code = $gw->responses['response_code'];
                    $responseText = $gw->responses['responsetext'];
                    $actionType = $gw->responses['type'];
                    $avsCode = $gw->responses['avsresponse'];
                    $result = $gw->responses['response'];
                    $result_cvv = $gw->responses['cvvresponse'];
                    $transaction_id = $gw->responses['transactionid'];

                    if ($code == "100") {

                        $transaction->result_text = $responseText;
                        $transaction->result_code = $code;
                        $transaction->result_avs = $avsCode;
                        $transaction->result = $result;
                        $transaction->result_type = $actionType;
                        $transaction->result_cvv = $result_cvv;
                        $transaction->edata_transaction_id = $transaction_id;

                    } else {

                        $declineTransaction->amount = $total_amount;
                        $declineTransaction->action = "PAYOUT_FAIL";
                        $declineTransaction->credits_old = 0;
                        $declineTransaction->result_text = $responseText;
                        $declineTransaction->result_code = $code;
                        $declineTransaction->result_avs = $avsCode;
                        $declineTransaction->result = $result;
                        $declineTransaction->result_type = $actionType;
                        $declineTransaction->result_cvv = $result_cvv;
                        $declineTransaction->edata_transaction_id = $transaction_id;
                        $declineTransaction->sent_to = $request->billing;
                        $user->transactions()->save($declineTransaction);
                        $declineTransaction->save();
                        return ApiUtils::response_fail("Billing Not Found");
                    }

                } else {
                    return ApiUtils::response_fail("Billing Not Found");
                }

            } else {
                if (!$user->paypal_account) {
                    return ApiUtils::response_fail("Paypal Account Not Found");
                }
            }

            $payout_log = $user->psychic_payout_logs()->orderBy('created_at', 'DESC')->get();
            $total_payouts_completed_beforee = PayoutUtils::get_payouts_completed($payout_log)->sum('payout');

            // Create Transaction
            $total_payouts_completed = number_format($this->getAmount($total_payouts_completed_beforee) + $this->getAmount($total_amount), 2);

            $transaction->action = 'PAYOUT_PAID';
            $transaction->amount = $total_amount;
            $transaction->credits_old = $total_payouts_completed_beforee;
            $transaction->sent_to = $request->billing;
            $user->transactions()->save($transaction);
            $transaction->save();

            $start_period = '';
            $end_period = '';
            $pay_day = '';
            $i = 0;
            $payoutsToMod = $payouts->get();
            $lenght = count($payoutsToMod);

            foreach ($payoutsToMod as $item) {

                if ($i == 0) {
                    $end_period = str_replace('-', '/', $item->end_period);
                    $pay_day = str_replace('-', '/', $item->pay_day);
                }
                if ($i == $lenght - 1) {

                    $start_period = str_replace('-', '/', $item->start_period);
                }
                $item->status = 'Paid';
                $item->transaction_id = $transaction->id;
                $item->upcoming = 'COMPLETED';
                $item->save();
                $i++;
            }

            //Prepare to next payout
            $get_payouts_to_pay_next = PayoutUtils::get_payouts_to_pay_next($user, 'asc');
            $total_to_pay_next = $get_payouts_to_pay_next->sum('payout');
            if ($total_to_pay_next > 75) {

                $i = 0;
                $get_payouts_to_pay_nextToMod = $get_payouts_to_pay_next->get();
                $lenght = count($get_payouts_to_pay_nextToMod);
                $sum_payouts = 0;
                foreach ($get_payouts_to_pay_nextToMod as $item) {

                    $sum_payouts = $sum_payouts + $item->payout;
                    $item->upcoming = 'UPCOMING';
                    $item->save();

                    if ($sum_payouts >= 75) {
                        $item->payout_to_pay = $sum_payouts;
                        $item->save();
                        //$sum_payouts = 0;
                        break;
                    }

                    // $i++;
                }
            }

            $payoutDetailsEmail = ['psychic_display_name' => $user->userprofile->display_name,
                'pay_day' => $pay_day,
                'total_payouts_completed' => $total_payouts_completed,
                'total_amount' => $total_amount,
                'start_period' => $start_period,
                'end_period' => $end_period];
            EmailUtils::send_to_psychic_when_payout_is_created($user, $payoutDetailsEmail);

            return json_encode('OK');

        } else {
            return ApiUtils::response_fail("User Not Found");
        }

    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @param Request $request
     * @return UserBasicResourceCollection|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function transactions(Request $request)
    {

        if ($id = $request->get('user')) {
            $user = User::find($id);
            if (WhiteLabel::roleId('Model') == $user->role_id) {
                $payout = $user->psychic_payout_logs()->orderBy('id', 'DESC')->get();
                $pay_out_logs = new PsychicPayoutLogsResourceCollection($payout);
                $credit_logs = $user->psychic_credit_logs()->orderBy('created_at', 'DESC')->get();

                $chatIds = UserCreditLog::where('psychic_id', $id)->where('action', 'Chat')->whereNotNull('chat_id')->get()->map(function ($item) {return $item->chat_id;})->all();

                $chat = chat::selectRaw('chat.*, user_profile.display_name as display_name')->join('user', 'user.id', '=', 'chat.receiver_id')->join('user_profile', 'user_profile.user_id', '=', 'user.id')->where('chat.receiver_id', $id)->whereNotIn('chat.id', $chatIds)->orderBy('chat.created_at', 'DESC')->get();

                return (new PsychicCreditLogsResourceCollection($credit_logs->merge($chat)->sortBy('created_at')->reverse()))
                    ->additional(['meta' => [
                        'psychic' => array_merge(
                            $this->payout($user, true),
                            ['payment_method' => $user->deposit_account || count(
                                BillingUtils::get_user_cards_and_info($user->id, 'DEPOSIT')) || $user->paypal_account]
                        ),
                        'payout' => $pay_out_logs,
                    ]]);
            } else {
                $chatIds = UserCreditLog::where('user_id', $id)->where('action', 'Chat')->whereNotNull('chat_id')->get()->map(function ($item) {return $item->chat_id;})->all();

                $chat = chat::selectRaw('chat.*, user_profile.display_name as display_name')->join('user', 'user.id', '=', 'chat.receiver_id')->join('user_profile', 'user_profile.user_id', '=', 'user.id')->where('chat.user_id', $id)->whereNotIn('chat.id', $chatIds)->orderBy('chat.created_at', 'DESC')->get();

                $credit_logs = $user->user_credit_logs()->orderBy('created_at', 'DESC')->get();

                return (new UserCreditLogsResourceCollection($credit_logs->merge($chat)->sortBy('created_at')->reverse()))
                    ->additional(['meta' => [
                        'psychic' => false,
                    ]]);
            }
        }
        if ($id = $request->get('id')) {
            $query = $this->searchUsersWithFilter($request);
            return new UserAdminTransactionResource($query->find($id));
        }

        $query = Transaction::query()->select('user.email', 'user.id as user_id', 'user_profile.name', 'user_profile.haedshot_path', 'user_profile.profile_link', 'transaction.*')
            ->join('user', 'user.id', '=', 'transaction.user_id')
            ->join('user_profile', 'user_profile.user_id', '=', 'user.id')
            ->where('transaction.amount', '!=', 0)
        // ->where('user.role_id', 2)
            ->where('user.test_user', 0);

        $query->orderBy('transaction.created_at');
        if ($sort = $request->get('sort')) {
            if ($sort == 'name') {
                $query->orderBy('user_profile.name', $request->get('sortDesc') ? 'desc' : 'asc');
            } else if ($sort == 'email') {
                $query->orderBy('user.email', $request->get('sortDesc') ? 'desc' : 'asc');
            } else if ($sort == 'amount') {
                $query->orderBy('transaction.amount', $request->get('sortDesc') ? 'desc' : 'asc');
            }

        }

        if ($request->get('type') == 'failed') {
            $query->where('result_code', '!=', '100');
        } else {
            $query->where('result_code', '=', '100');
        }

        if ($search = $request->get('search')) {
            $query->join('user_mobile_num', 'user_mobile_num.user_id', '=', 'user.id');
            $this->searchTerm($query, $search, true);
        }

        $query->whereRaw("(transaction.action = 'ADD_CARD_AND_BUY_CREDIT' OR transaction.action = 'BUY_CREDIT')");

        return ($perPage = $request->get('per_page')) ? new UserAdminTransactionResourceCollection($query->paginate($perPage)) : $query->get();
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @param Request $request
     * @return UserBasicResourceCollection|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function signUp(Request $request)
    {

        $data = $request->all();
        if (!isset($data['month'])) {
            $date = Carbon::createFromDate($data['year']);
            $models = User::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) as `interval`'))
                ->where('role_id', WhiteLabel::roleId('Model'))->whereBetween('created_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('created_at')
                ->groupBy('interval')->get();
            $users = User::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) as `interval`'))
                ->where('role_id', WhiteLabel::roleId('User'))->whereBetween('created_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('created_at')
                ->groupBy('interval')->get();

            return ['models' => $models, 'users' => $users];

        } else {
            $date = Carbon::createFromDate($data['year'], $data['month']);
            $models = User::select(DB::raw('count(id) as `total`'), DB::raw('DAY(created_at) as `interval`'))
                ->where('role_id', WhiteLabel::roleId('Model'))->whereBetween('created_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->orderBy('created_at')
                ->groupBy('interval')->get();
            $users = User::select(DB::raw('count(id) as `total`'), DB::raw('DAY(created_at) as `interval`'))
                ->where('role_id', WhiteLabel::roleId('User'))->whereBetween('created_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->orderBy('created_at')
                ->groupBy('interval')->get();

            return ['models' => $models, 'users' => $users];
        }
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @param Request $request
     * @return UserBasicResourceCollection|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function userStatus(Request $request)
    {

        $data = $request->all();

        if (!isset($data['month']) && isset($data['year'])) {
            $date = Carbon::createFromDate($data['year']);

            $psychics_inactive = User::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) as `interval`'))->where('role_id', WhiteLabel::roleId('Model'))->where('email_validated', 0)
                ->where('fraud', 0)->where('test_user', 0)->whereBetween('created_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('created_at')->groupBy('interval')->get();

            $psychics_active = User::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) as `interval`'))->where('role_id', WhiteLabel::roleId('Model'))->where('email_validated', 1)
                ->where('fraud', 0)->where('test_user', 0)->whereBetween('created_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('created_at')->groupBy('interval')->get();

            $users_inactive = User::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) as `interval`'))->where('role_id', WhiteLabel::roleId('User'))->where('email_validated', 0)
                ->where('fraud', 0)->where('test_user', 0)->whereBetween('created_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('created_at')->groupBy('interval')->get();

            $users_active = User::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) as `interval`'))->where('role_id', WhiteLabel::roleId('User'))->where('email_validated', 1)
                ->where('fraud', 0)->where('test_user', 0)->whereBetween('created_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('created_at')->groupBy('interval')->get();

            $psychic_hidden = User::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) as `interval`'))->where('role_id', WhiteLabel::roleId('Model'))->where('email_validated', 1)->where('account_status', 'INACTIVE')
                ->where('fraud', 0)->where('test_user', 0)->whereBetween('created_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('created_at')->groupBy('interval')->get();

            $users_hidden = User::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) as `interval`'))->where('role_id', WhiteLabel::roleId('User'))->where('email_validated', 1)->where('account_status', 'INACTIVE')
                ->where('fraud', 0)->where('test_user', 0)->whereBetween('created_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('created_at')->groupBy('interval')->get();

            $test_account = User::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) as `interval`'))
                ->where('test_user', 1)->whereBetween('created_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('created_at')->groupBy('interval')->get();

            $psychics_fraud = User::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) as `interval`'))->where('role_id', WhiteLabel::roleId('Model'))
                ->where('test_user', 1)->whereBetween('created_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('created_at')->groupBy('interval')->get();

            $users_fraud = User::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) as `interval`'))->where('role_id', WhiteLabel::roleId('User'))
                ->where('fraud', 1)->whereBetween('created_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('created_at')->groupBy('interval')->get();

        } else if (isset($data['year'])) {
            $date = Carbon::createFromDate($data['year'], $data['month']);

            $psychics_inactive = User::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) as `interval`'))->where('role_id', WhiteLabel::roleId('Model'))->where('email_validated', 0)
                ->where('fraud', 0)->where('test_user', 0)->whereBetween('created_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->groupBy('interval')->get();

            $psychics_active = User::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) as `interval`'))->where('role_id', WhiteLabel::roleId('Model'))->where('email_validated', 1)
                ->where('fraud', 0)->where('test_user', 0)->whereBetween('created_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->groupBy('interval')->get();

            $users_inactive = User::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) as `interval`'))->where('role_id', WhiteLabel::roleId('User'))->where('email_validated', 0)
                ->where('fraud', 0)->where('test_user', 0)->whereBetween('created_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->groupBy('interval')->get();

            $users_active = User::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) as `interval`'))->where('role_id', WhiteLabel::roleId('User'))->where('email_validated', 1)
                ->where('fraud', 0)->where('test_user', 0)->whereBetween('created_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->groupBy('interval')->get();

            $psychic_hidden = User::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) as `interval`'))->where('role_id', WhiteLabel::roleId('Model'))->where('email_validated', 1)->where('account_status', 'INACTIVE')
                ->where('fraud', 0)->where('test_user', 0)->whereBetween('created_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->groupBy('interval')->get();

            $users_hidden = User::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) as `interval`'))->where('role_id', WhiteLabel::roleId('User'))->where('email_validated', 1)->where('account_status', 'INACTIVE')
                ->where('fraud', 0)->where('test_user', 0)->whereBetween('created_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->groupBy('interval')->get();

            $test_account = User::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) as `interval`'))
                ->where('test_user', 1)->whereBetween('created_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->groupBy('interval')->get();

            $psychics_fraud = User::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) as `interval`'))->where('role_id', WhiteLabel::roleId('Model'))
                ->where('fraud', 1)->whereBetween('created_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->groupBy('interval')->get();

            $users_fraud = User::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) as `interval`'))->where('role_id', WhiteLabel::roleId('User'))
                ->where('fraud', 1)->whereBetween('created_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->groupBy('interval')->get();

        } else {

            $psychics_inactive = User::where('role_id', WhiteLabel::roleId('Model'))->where('email_validated', 0)
                ->where('fraud', 0)->where('test_user', 0)->count();

            $psychics_active = User::where('role_id', WhiteLabel::roleId('Model'))->where('email_validated', 1)
                ->where('fraud', 0)->where('test_user', 0)->count();

            $users_inactive = User::where('role_id', WhiteLabel::roleId('User'))->where('email_validated', 0)
                ->where('fraud', 0)->where('test_user', 0)->count();

            $users_active = User::where('role_id', WhiteLabel::roleId('User'))->where('email_validated', 1)
                ->where('fraud', 0)->where('test_user', 0)->count();

            $psychic_hidden = User::where('role_id', WhiteLabel::roleId('Model'))->where('email_validated', 1)->where('account_status', 'INACTIVE')
                ->where('fraud', 0)->where('test_user', 0)->count();

            $users_hidden = User::where('role_id', WhiteLabel::roleId('User'))->where('email_validated', 1)->where('account_status', 'INACTIVE')
                ->where('fraud', 0)->where('test_user', 0)->count();

            $test_account = User::where('test_user', 1)->count();

            $psychics_fraud = User::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) as `interval`'))->where('role_id', WhiteLabel::roleId('Model'))
                ->where('fraud', 1)->count();

            $users_fraud = User::where('role_id', WhiteLabel::roleId('User'))
                ->where('fraud', 1)->count();

        }

        return ['psychics_inactive' => $psychics_inactive,
            'psychics_active' => $psychics_active
            , 'users_inactive' => $users_inactive,
            'users_active' => $users_active,
            'psychic_hidden' => $psychic_hidden, 'users_hidden' => $users_hidden, 'test_account' => $test_account,
            'psychics_fraud' => $psychics_fraud, 'users_fraud' => $users_fraud];
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @param Request $request
     * @return UserBasicResourceCollection|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function servicesAnalytic(Request $request)
    {

        $data = $request->all();
        if (!isset($data['month'])) {
            $date = Carbon::createFromDate($data['year']);
            return [
                'videos' => UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')
                    ->select(DB::raw('count(user_credit_log.id) as `total`'), DB::raw('MONTH(user_credit_log.created_at) as `interval`'))->where('email_validated', 1)->where('fraud', 0)->where('test_user', 0)->where('user_credit_log.service_id', 3)->where('action', 'Video Chat')->whereBetween('user_credit_log.created_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('user_credit_log.created_at')
                    ->groupBy('interval')->get(),
                'calls' => UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')
                    ->select(DB::raw('count(user_credit_log.id) as `total`'), DB::raw('MONTH(user_credit_log.created_at) as `interval`'))->where('email_validated', 1)->where('fraud', 0)->where('test_user', 0)->where('user_credit_log.service_id', 1)->where('action', 'Call')->whereBetween('user_credit_log.created_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('user_credit_log.created_at')
                    ->groupBy('interval')->get(),
                'messages' => chat_in::join('user', 'user.id', '=', 'chat_in.user_id')
                    ->select(DB::raw('count(chat_in.id) as `total`'), DB::raw('MONTH(chat_in.created_at) as `interval`'))->where('fraud', 0)->where('email_validated', 1)->where('test_user', 0)->whereBetween('chat_in.created_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('chat_in.created_at')
                    ->groupBy('interval')->get(),
            ];

        } else {
            $date = Carbon::createFromDate($data['year'], $data['month']);
            return [
                'videos' => UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')
                    ->select(DB::raw('count(user_credit_log.id) as `total`'), DB::raw('DAY(user_credit_log.created_at) as `interval`'))->where('email_validated', 1)->where('fraud', 0)->where('test_user', 0)->where('user_credit_log.service_id', 3)->where('user_credit_log.action', 'Video Chat')->whereBetween('user_credit_log.created_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->orderBy('user_credit_log.created_at')
                    ->groupBy('interval')->get(),
                'calls' => UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')
                    ->select(DB::raw('count(user_credit_log.id) as `total`'), DB::raw('DAY(user_credit_log.created_at) as `interval`'))->where('email_validated', 1)->where('fraud', 0)->where('test_user', 0)->where('user_credit_log.service_id', 1)->where('user_credit_log.action', 'Call')->whereBetween('user_credit_log.created_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->orderBy('user_credit_log.created_at')
                    ->groupBy('interval')->get(),
                'messages' => chat_in::join('user', 'user.id', '=', 'chat_in.user_id')
                    ->select(DB::raw('count(chat_in.id) as `total`'), DB::raw('DAY(chat_in.created_at) as `interval`'))->where('email_validated', 1)->where('fraud', 0)->where('test_user', 0)->whereBetween('chat_in.created_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->orderBy('chat_in.created_at')
                    ->groupBy('interval')->get(),
            ];
        }
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @param Request $request
     * @return UserBasicResourceCollection|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function payoutAnalytic(Request $request)
    {

        $data = $request->all();
        if (!isset($data['month'])) {
            $date = Carbon::createFromDate($data['year']);
            return [
                'payouts' => PayoutLog::join('user', 'user.id', '=', 'payout_log.psychic_id')
                    ->select(DB::raw('round(sum(payout_log.payout), 2) as `total`'), DB::raw('MONTH(payout_log.created_at) as `interval`'))->where('fraud', 0)->where('test_user', 0)->where('status', 'Paid')->whereBetween('payout_log.created_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('payout_log.created_at')
                    ->groupBy('interval')->get(),
            ];

        } else {
            $date = Carbon::createFromDate($data['year'], $data['month']);
            return [
                'payouts' => PayoutLog::join('user', 'user.id', '=', 'payout_log.psychic_id')
                    ->select(DB::raw('round(sum(payout_log.payout), 2) as `total`'), DB::raw('DAY(payout_log.created_at) as `interval`'))->where('fraud', 0)->where('test_user', 0)->where('status', 'Paid')->whereBetween('payout_log.created_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->orderBy('payout_log.created_at')
                    ->groupBy('interval')->get(),
            ];
        }
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @param Request $request
     * @return UserBasicResourceCollection|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function transactionAnalytic(Request $request)
    {
        $data = $request->all();
        if (!isset($data['month'])) {

            $date = Carbon::createFromDate($data['year']);

            $query = UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')
                ->select(DB::raw('user_credit_log.user_id'))->where('user_credit_log.action', 'BUY_CREDIT')->where('fraud', 0)->where('test_user', 0)->whereBetween('user_credit_log.created_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('user_credit_log.created_at')
                ->get()->map(function ($item) {
                return $item['user_id'];
            })->countBy();

            $buyOnTimeIds = $query->filter(function ($item) {
                return $item == 1;
            })->keys()->all();

            $buyMoreThanOneIds = $query->filter(function ($item) {
                return $item > 1;
            })->keys()->all();

            return [
                'transactions' => UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')
                    ->select(DB::raw('count(user_credit_log.id) as `total`'), DB::raw('round(sum(user_credit_log.credits), 2) as `credit`'), DB::raw('MONTH(user_credit_log.updated_at) as `interval`'))
                    ->where('test_user', 0)->where('user.fraud', 0)->where('user_credit_log.action', 'BUY_CREDIT')->whereBetween('user_credit_log.updated_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('user_credit_log.updated_at')
                    ->groupBy('interval')->get(),
                'buyOnTime' => UserCreditLog::select(DB::raw('round(sum(user_credit_log.credits), 2) as `credit`'), DB::raw('count(id) as `total`'), DB::raw('MONTH(updated_at) as `interval`'))->whereIn('user_id', $buyOnTimeIds)->where('action', 'BUY_CREDIT')->whereBetween('updated_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('updated_at')
                    ->groupBy('interval')->get(),
                'buyMoreThanOne' => UserCreditLog::select(DB::raw('round(sum(user_credit_log.credits), 2) as `credit`'), DB::raw('count(id) as `total`'), DB::raw('MONTH(updated_at) as `interval`'))->whereIn('user_id', $buyMoreThanOneIds)->where('action', 'BUY_CREDIT')->whereBetween('updated_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('updated_at')
                    ->groupBy('interval')->get(),
                'call' => UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')
                    ->select(DB::raw('round(sum(user_credit_log.credits), 2) as `credit`'), DB::raw('MONTH(user_credit_log.updated_at) as `interval`'))
                    ->where('test_user', 0)->where('user.fraud', 0)->where('user_credit_log.service_id', 1)->whereBetween('user_credit_log.updated_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('user_credit_log.updated_at')
                    ->groupBy('interval')->get(),
                'call_refund' => UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')
                    ->select(DB::raw('round(sum(user_credit_log.credits), 2) as `credit`'), DB::raw('MONTH(user_credit_log.updated_at) as `interval`'))
                    ->where('test_user', 0)->where('user.fraud', 0)->where('user_credit_log.service_id', 1)->where('user_credit_log.action', 'REFUND')->whereBetween('user_credit_log.updated_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('user_credit_log.updated_at')
                    ->groupBy('interval')->get(),
                'chat' => UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')
                    ->select(DB::raw('round(sum(user_credit_log.credits), 2) as `credit`'), DB::raw('MONTH(user_credit_log.updated_at) as `interval`'))
                    ->where('test_user', 0)->where('user.fraud', 0)->where('user_credit_log.service_id', 2)->whereBetween('user_credit_log.updated_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('user_credit_log.updated_at')
                    ->groupBy('interval')->get(),
                'chat_refund' => UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')
                    ->select(DB::raw('round(sum(user_credit_log.credits), 2) as `credit`'), DB::raw('MONTH(user_credit_log.updated_at) as `interval`'))
                    ->where('test_user', 0)->where('user.fraud', 0)->where('user_credit_log.service_id', 2)->where('user_credit_log.action', 'REFUND')->whereBetween('user_credit_log.updated_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('user_credit_log.updated_at')
                    ->groupBy('interval')->get(),
                'video' => UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')
                    ->select(DB::raw('round(sum(user_credit_log.credits), 2) as `credit`'), DB::raw('MONTH(user_credit_log.updated_at) as `interval`'))
                    ->where('test_user', 0)->where('user.fraud', 0)->where('user_credit_log.service_id', 3)->whereBetween('user_credit_log.updated_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('user_credit_log.updated_at')
                    ->groupBy('interval')->get(),
                'video_refund' => UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')
                    ->select(DB::raw('round(sum(user_credit_log.credits), 2) as `credit`'), DB::raw('MONTH(user_credit_log.updated_at) as `interval`'))
                    ->where('test_user', 0)->where('user.fraud', 0)->where('user_credit_log.service_id', 3)->where('user_credit_log.action', 'REFUND')->whereBetween('user_credit_log.updated_at', [$date->copy()->startOfYear(), $date->copy()->endOfYear()])->orderBy('user_credit_log.updated_at')
                    ->groupBy('interval')->get(),

            ];

        } else {
            $date = Carbon::createFromDate($data['year'], $data['month']);

            $query = UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')
                ->select(DB::raw('user_credit_log.user_id'))->where('user_credit_log.action', 'BUY_CREDIT')->where('fraud', 0)->where('test_user', 0)->whereBetween('user_credit_log.updated_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->orderBy('user_credit_log.updated_at')
                ->get()->map(function ($item) {
                return $item['user_id'];
            })->countBy();

            $buyOnTimeIds = $query->filter(function ($item) {
                return $item == 1;
            })->keys()->all();

            $buyMoreThanOneIds = $query->filter(function ($item) {
                return $item > 1;
            })->keys()->all();

            return [
                'transactions' => UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')
                    ->select(DB::raw('count(user_credit_log.id) as `total`'), DB::raw('round(sum(user_credit_log.credits), 2) as `credit`'), DB::raw('DAY(user_credit_log.updated_at) as `interval`'))
                    ->where('test_user', 0)->where('user.fraud', 0)->where('user_credit_log.action', 'BUY_CREDIT')->whereBetween('user_credit_log.updated_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->orderBy('user_credit_log.updated_at')
                    ->groupBy('interval')->get(),
                'buyOnTime' => UserCreditLog::select(DB::raw('round(sum(user_credit_log.credits), 2) as `credit`'), DB::raw('count(id) as `total`'), DB::raw('DAY(updated_at) as `interval`'))->whereIn('user_id', $buyOnTimeIds)->where('action', 'BUY_CREDIT')->whereBetween('updated_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->orderBy('updated_at')
                    ->groupBy('interval')->get(),
                'buyMoreThanOne' => UserCreditLog::select(DB::raw('round(sum(user_credit_log.credits), 2) as `credit`'), DB::raw('count(id) as `total`'), DB::raw('DAY(updated_at) as `interval`'))->whereIn('user_id', $buyMoreThanOneIds)->where('action', 'BUY_CREDIT')->whereBetween('updated_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->orderBy('updated_at')
                    ->groupBy('interval')->get(),
                'call' => UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')
                    ->select(DB::raw('round(sum(user_credit_log.credits), 2) as `credit`'), DB::raw('DAY(user_credit_log.updated_at) as `interval`'))
                    ->where('test_user', 0)->where('user.fraud', 0)->where('user_credit_log.service_id', 1)->whereBetween('user_credit_log.updated_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->orderBy('user_credit_log.updated_at')
                    ->groupBy('interval')->get(),
                'chat' => UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')
                    ->select(DB::raw('round(sum(user_credit_log.credits), 2) as `credit`'), DB::raw('DAY(user_credit_log.updated_at) as `interval`'))
                    ->where('test_user', 0)->where('user.fraud', 0)->where('user_credit_log.service_id', 2)->whereBetween('user_credit_log.updated_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->orderBy('user_credit_log.updated_at')
                    ->groupBy('interval')->get(),
                'video' => UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')
                    ->select(DB::raw('round(sum(user_credit_log.credits), 2) as `credit`'), DB::raw('DAY(user_credit_log.updated_at) as `interval`'))
                    ->where('test_user', 0)->where('user.fraud', 0)->where('user_credit_log.service_id', 3)->whereBetween('user_credit_log.updated_at', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->orderBy('user_credit_log.updated_at')
                    ->groupBy('interval')->get(),
            ];
        }
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @param Request $request
     * @return UserBasicResourceCollection|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function chat(Request $request)
    {
        $query = chat_in::select('chat_in.*');

        if ($search = $request->get('search')) {

            $query2 = chat_in::select('chat_in.id')
                ->join('user', 'user.id', '=', 'chat_in.user_id')
                ->join('user_profile', 'user_profile.user_id', '=', 'user.id')
                ->join('user_mobile_num', 'user_mobile_num.user_id', '=', 'user.id');

            $this->searchTerm($query2, $search);

            $ids = $query2->get()->map(function ($i) {
                return $i->id;
            })->all();

            $query3 = chat_in::select('chat_in.id')
                ->join('user', 'user.id', '=', 'chat_in.receiver_id')
                ->join('user_profile', 'user_profile.user_id', '=', 'user.id')
                ->join('user_mobile_num', 'user_mobile_num.user_id', '=', 'user.id');

            $this->searchTerm($query3, $search);

            $ids = array_merge(
                $ids,
                $query3->get()->map(function ($i) {
                    return $i->id;
                })->all()
            );
            $query->whereIn('chat_in.id', $ids);

        }

        return new AdminChatResourceCollection($query->orderBy('created_at', 'DESC')->paginate($request->get('per_page', 10)));
    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @param Request $request
     * @return UserBasicResourceCollection|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function chatMessages($user1, $user2, Request $request)
    {
        if ($firstChat = $request->firstChat) {

            return $firstChat == 1 ? AdminChatMessageResource::collection(chat::with('user')->whereRaw("(user_id = $user1 AND receiver_id = $user2)")->orderBy('created_at', 'ASC')->limit(1)->get())
            : AdminChatMessageResource::collection(chat::with('user')->whereRaw("(user_id = $user2 AND receiver_id = $user1)")->orderBy('created_at', 'ASC')->limit(1)->get());

        }
        return AdminChatMessageResource::collection(chat::with('user')->whereRaw("(user_id = $user1 AND receiver_id = $user2) OR (user_id = $user2 AND receiver_id = $user1)")->orderBy('created_at', 'desc')->paginate($request->get('per_page', 10)));

    }

    protected function getPayoutsPendingInfo(Request $request)
    {

        $user = User::find($request->id);

        if ($user) {
            ApiUtils::response_fail("User Not Found");
        }

        $payout_log = PayoutUtils::get_payouts_to_pay($user);

        return new PsychicPayoutLogsResourceCollection($payout_log->get());
    }
    protected function getTransactionsPaidInfo(Request $request)
    {

        $user = User::find($request->id);
        if (!$user) {
            return ApiUtils::response_fail("User Not Found");
        }
        if ($status = $request->get('status') === 'Paid') {

            $transactions_paid = $user->transactions()
                ->where('action', '=', 'PAYOUT_PAID')
                ->orderBy('created_at', 'DESC')
                ->get();

            return new PsychicTransactionsResourceCollection($transactions_paid);
        }

        return ApiUtils::response_fail("User Not Found");

    }
    protected function getPayoutsPaidInfo(Request $request)
    {

        $user = User::find($request->user);

        if (!$user) {
            return ApiUtils::response_fail("User Not Found");
        }
        if ($status = $request->get('status') === 'Paid') {
            $payout_log = $user->psychic_payout_logs()
                ->where('transaction_id', '=', $request->get('transaction'))
                ->orderBy('created_at', 'DESC');
            $payout_log_to_return = PayoutUtils::get_payouts_completed($payout_log);
            return new PsychicPayoutLogsResourceCollection($payout_log_to_return->get());
        }

        return ApiUtils::response_fail("User Not Found");

    }

    /**
     * @autor Alcides Rodríguez alcidesrh@gmail.com
     * @param Request $request
     * @return UserBasicResourceCollection|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function countries()
    {
        $country_all = Country_all::select('country_all.code2', 'country_all.country as name')
            ->orderBy('country_all.country', 'asc')->get();
        $us_index = $country_all->search(function ($country) {
            return $country->code2 === 'US';
        });
        $us = $country_all->pull($us_index);
        return $country_all->prepend($us);
    }

    protected function retractTransaction($id, Request $request)
    {
        $item = UserCreditLog::find($id);

        if ($item) {
            //S_REFUND
            $credit_log = new UserCreditLog();
            $credit_log->user_id = $item->user_id;
            $credit_log->psychic_id = $item->psychic_id;
            $credit_log->credits = $item->credits;
            $credit_log->service_id = $item->service_id;
            $credit_log->action = "REFUND";
            $credit_log->duration = $item->duration;
            $credit_log->user_1_1_chat_request_id = $item->user_1_1_chat_request_id;
            $credit_log->chat_id = $item->chat_id;
            $credit_log->save();
            $item->refunded = true;
            $item->save();

            $user = $item->user()->first();
            $user->credits += $item->credits;
            $user->save();

        } else {
            return ApiUtils::response_fail("Transaction Not Found");
        }

        return 'retracted';
    }

    protected function refundAccount(Request $request)
    {

        $id = $request->input('id');
        $balance = $request->input('balance');
        $billing_id = $request->input('billing_id');

        $user = User::find($id);

        if ($user) {

            $billing = $user->biller_edata()->where('billing_id', $billing_id)->first();
            $ip_addr = WebUtils::getUserIp();
            $processor = "ccprocessora";

            if ($billing) {

                //make refund (sale) to NMI
                $gw = new gwapi();
                $gw->setLogin(BillingUtils::username(), BillingUtils::password());
                $gw->doDeposit($balance, $user->id, $billing->billing_id, $ip_addr, $processor);
                $code = $gw->responses['response_code'];
                $responseText = $gw->responses['responsetext'];
                $actionType = $gw->responses['type'];
                $avsCode = $gw->responses['avsresponse'];
                $result = $gw->responses['response'];
                $result_cvv = $gw->responses['cvvresponse'];

                if ($code == "100") {
                    $credit_log = new UserCreditLog();
                    $credit_log->user_id = $user->id;
                    $credit_log->credits = $balance;
                    $credit_log->action = "ACCOUNT_REFUND";
                    $credit_log->save();
                    $user->credits = 0;
                    $user->save();
                } else {
                    $declineTransaction = new Transaction();
                    $declineTransaction->amount = $balance;
                    $declineTransaction->action = "ACCOUNT_REFUND";
                    $declineTransaction->credits_old = $user->credits;
                    $declineTransaction->result_text = $responseText;
                    $declineTransaction->result_code = $code;
                    $declineTransaction->result_avs = $avsCode;
                    $declineTransaction->result = $result;
                    $declineTransaction->result_type = $actionType;
                    $declineTransaction->result_cvv = $result_cvv;
                    $user->transactions()->save($declineTransaction);
                    $declineTransaction->save();
                    return ApiUtils::response_fail("Billing Not Found");
                }

            } else {
                return ApiUtils::response_fail("Billing Not Found");
            }

        } else {
            return ApiUtils::response_fail("User Not Found");
        }

        return 'refunded';
    }

    public function ltvAnalytic(Request $request)
    {

        $return = [];

        $date = Carbon::createFromDate($request->get('year', now()->year));

        $query = UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')
            ->where('user_credit_log.action', 'BUY_CREDIT')->where('fraud', 0)->where('test_user', 0)
            ->whereBetween('user_credit_log.created_at', [$date->copy()->startOfYear(), $date->copy()
                    ->endOfYear()]);

        $query2 = clone $query;
        $return['grossRevenue'] = round($query2->sum('user_credit_log.credits'), 2);

        $query2 = clone $query;
        if ($return['totalClient'] = $query2->groupBy('user_credit_log.user_id')->get()->count()) {
            $return['avgCustomerSpent'] = round($return['grossRevenue'] / $return['totalClient'], 2);
        }

        $query2 = clone $query;
        if ($return['transactions'] = $query2->get()->count()) {
            $return['avgTransaction'] = round($return['grossRevenue'] / $return['transactions'], 2);}

        return $return;
    }

}
