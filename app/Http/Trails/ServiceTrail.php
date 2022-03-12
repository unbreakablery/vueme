<?php
namespace App\Http\Trails;

use App\Models\chat;
use App\Models\User;
use App\Models\UserService;
use App\Services\WhiteLabel;
use App\Models\UserCreditLog;
use Illuminate\Support\Facades\DB;
use App\Models\user_1_1_chat_request;

trait ServiceTrail
{
    public function serviceRate()
    {
        $query1 = user_1_1_chat_request::select(DB::raw('round(sum(user_1_1_chat_request.rate), 2) as total'), DB::raw('round(sum(user_1_1_chat_request.rate), 2) as `rate`'))
            ->join('user', 'user.id', '=', 'user_1_1_chat_request.model_id')
            ->where('user.fraud', 0)->where('user.test_user', 0)->where('user.email_validated', 1)
            ->where('user_1_1_chat_request.state', 'COMPLETE'); //->groupBy('user_1_1_chat_request.model_id');

        $query = clone $query1;
        $call_rate_avg = $query->where('user_1_1_chat_request.service_id', 1)->get();

        $call_rate_avg = $call_rate_avg->count() == 0 ? 0 : \round($call_rate_avg->sum('total') / $call_rate_avg->count(), 2);

        $query = clone $query1;
        $video_rate_avg = $query->where('user_1_1_chat_request.service_id', 3)->get();

        $video_rate_avg = $video_rate_avg->sum('rate') == 0 ? 0 : \round($video_rate_avg->sum('total') / $video_rate_avg->count(), 2);

        $query1 = user_1_1_chat_request::select(
            DB::raw('round(sum(user_1_1_chat_request.rate), 2) as total'))
            ->join('user', 'user.id', '=', 'user_1_1_chat_request.model_id')
            ->where('user.fraud', 0)->where('user.test_user', 0)->where('user.email_validated', 1)
            ->where('user_1_1_chat_request.state', 'COMPLETE');

        $query = clone $query1;
        $call_rate_month_avg = $query->addSelect(DB::raw('MONTH(user_1_1_chat_request.created_at) as date'))->where('user_1_1_chat_request.service_id', 1)->groupBy('date')->get();

        $call_rate_month_avg = $call_rate_month_avg->count() == 0 ? 0 : \round(($call_rate_month_avg->sum('total')) / $call_rate_month_avg->count(), 2);

        $query = clone $query1;
        $video_rate_month_avg = $query->addSelect(DB::raw('MONTH(user_1_1_chat_request.created_at) as date'))->where('user_1_1_chat_request.service_id', 3)->groupBy('date')->get();

        $video_rate_month_avg = $video_rate_month_avg->count() == 0 ? 0 : \round(($video_rate_month_avg->sum('total')) / $video_rate_month_avg->count(), 2);

        $query = clone $query1;
        $call_rate_year_avg = $query->addSelect(DB::raw('YEAR(user_1_1_chat_request.created_at) as date'))->where('user_1_1_chat_request.service_id', 1)->groupBy('date')->get();

        $call_rate_year_avg = $call_rate_year_avg->count() == 0 ? 0 : \round(($call_rate_year_avg->sum('total')) / $call_rate_year_avg->count(), 2);

        $query = clone $query1;
        $video_rate_year_avg = $query->addSelect(DB::raw('YEAR(user_1_1_chat_request.created_at) as date'))->where('user_1_1_chat_request.service_id', 3)->groupBy('date')->get();

        $video_rate_year_avg = $video_rate_year_avg->count() == 0 ? 0 : \round(($video_rate_year_avg->sum('total')) / $video_rate_year_avg->count(), 2);

        $query1 = UserCreditLog::select(DB::raw('round(sum(user_credit_log.credits), 2) as `rate`'))
            ->join('user', 'user.id', '=', 'user_credit_log.psychic_id')
            ->where('user.fraud', 0)->where('user.test_user', 0)->where('user.email_validated', 1)->where('user_credit_log.service_id', 2)
            ->where('user_credit_log.action', 'Chat');

            // UserService::select(DB::raw('round(sum(user_service.rate), 2) as `rate`'))
            // ->join('services', 'services.id', '=', 'user_service.service_id')->join('user', 'user.id', '=', 'user_service.user_id')
            // ->where('user.fraud', 0)->where('user.test_user', 0)->where('user.email_validated', 1)->where('user_service.service_id', 2)->where('user_service.active', 1)
            // ->groupBy('user_service.user_id')->get();
        
            $query = clone $query1;
            $chat_rate_avg = $query->get();
            $chat_rate_avg = $chat_rate_avg->count() == 0 ? 0 : \round($chat_rate_avg->sum('rate') / $chat_rate_avg->count(), 2);

            $query = clone $query1;
            $chat_rate_month_avg = $query->addSelect(DB::raw('MONTH(user_credit_log.created_at) as date'))->groupBy('date')->get();
            $chat_rate_month_avg = $chat_rate_month_avg->count() == 0 ? 0 : \round($chat_rate_month_avg->sum('rate') / $chat_rate_month_avg->count(), 2);

            $query = clone $query1;
            $chat_rate_year_avg = $query->addSelect(DB::raw('YEAR(user_credit_log.created_at) as date'))->groupBy('date')->get();
            $chat_rate_year_avg = $chat_rate_year_avg->count() == 0 ? 0 : \round($chat_rate_year_avg->sum('rate') / $chat_rate_year_avg->count(), 2);

        return [
            'avg_rate_call' => $call_rate_avg,
            'avg_rate_video' => $video_rate_avg,
            'chat_rate_avg' => $chat_rate_avg,
            'chat_rate_month_avg' => $chat_rate_month_avg,
            'chat_rate_year_avg' => $chat_rate_year_avg,
            'call_rate_month_avg' => $call_rate_month_avg,
            'video_rate_month_avg' => $video_rate_month_avg,
            'call_rate_year_avg' => $call_rate_year_avg,
            'video_rate_year_avg' => $video_rate_year_avg,
        ];

    }

    public function psychicService()
    {
        $avg_session = $avg_video = $avg_chat = $avg_service = 0;

        $query = User::selectRaw('date(user_1_1_chat_request.created_at) as date, count(.user_1_1_chat_request.id) as cant')->join('user_1_1_chat_request', 'user_1_1_chat_request.model_id', '=', 'user.id')->
            where('role_id', WhiteLabel::roleId('Model'))->where('fraud', 0)->where('test_user', 0)->where('email_validated', 1)
            ->where('user_1_1_chat_request.state', 'COMPLETE');

        // $query3 = User::selectRaw('date(user_1_1_chat_request.created_at) as date, count(.user_1_1_chat_request.id) as cant')->join('user_1_1_chat_request', 'user_1_1_chat_request.model_id', '=', 'user.id')->
        //     where('role_id', WhiteLabel::roleId('Model'))->where('fraud', 0)->where('test_user', 0)->where('email_validated', 1)
        //     ->where('user_1_1_chat_request.state', 'COMPLETE');
        // $models = User::where('role_id', WhiteLabel::roleId('Model'))->where('fraud', 0)->where('test_user', 0)->where('email_validated', 1)->count();

        $query2 = clone $query;
        $collection = $query2->groupBy('date')->get();
        $avg_session = $collection->count() == 0 ? 0 : \round($collection->sum(function ($item) { //Average number of total sessions per psychic
            return $item['cant'];
        }) / $collection->count(), 2);

        $query2 = clone $query;
        $collection = $query2->where('service_id', 3)->get();

        $avg_video = $collection->count() == 0 ? 0 : \round($collection->sum(function ($item) { //Average number of video chat sessions completed per Model
            return $item['cant'];
        }) / $collection->count(), 2);

        $query2 = clone $query;
        $collection = $query2->where('service_id', 1)->get();

        $avg_call = $collection->count() == 0 ? 0 : \round($collection->sum(function ($item) { //Average number of call sessions completed per client
            return $item['cant'];
        }) / $collection->count(), 2);

        $collection = chat::selectRaw('date(chat.created_at) as date, count(chat.id) as cant')->join('user', 'user.id', '=', 'chat.receiver_id')->where('user.role_id', WhiteLabel::roleId('Model'))->groupBy('date')->get();

        $avg_chat = $collection->count() == 0 ? 0 : \round($collection->sum(function ($item) {
            return $item['cant'];
        }) / $collection->count(), 2);

        $avg_service = \round(($avg_call + $avg_chat + $avg_video) / 3, 2);

        $collection = User::selectRaw('count(user_1_1_chat_request.id) as cant, user.id')->join('user_1_1_chat_request', 'user_1_1_chat_request.user_id', '=', 'user.id')->
            where('role_id', WhiteLabel::roleId('User'))->where('fraud', 0)->where('test_user', 0)->where('email_validated', 1)
            ->where('user_1_1_chat_request.state', 'COMPLETE')->groupBy('user_1_1_chat_request.user_id')->get()->map(function ($item) {return $item->cant == 1 ? $item->id : null;})->filter(function ($item) {return $item;});

        $collection2 = User::selectRaw('count(chat_in.id) as cant, user.id')->join('chat_in', 'chat_in.user_id', '=', 'user.id')->
            where('role_id', WhiteLabel::roleId('User'))->where('fraud', 0)->where('test_user', 0)->where('email_validated', 1)
            ->groupBy('chat_in.user_id')->get()->map(function ($item) {return $item->cant == 1 ? $item->id : null;})->filter(function ($item) {return $item;});

        $avg_new_session = $collection->diff($collection2)->merge($collection2->diff($collection))->count(); //$collection->count() == 0 ? 0 : \round($collection->map(function ($item) {return $item->cant == 1 ? 1 : 0;})->sum(), 2);

        return [
            'avg_session' => $avg_session,
            'avg_video' => $avg_video,
            'avg_call' => $avg_call,
            'avg_chat' => $avg_chat,
            'avg_service' => $avg_service,
            'avg_new_session_per_psychic' => $avg_new_session,
        ];
    }

    public function clientService()
    {
        $avg_session = $avg_video = $avg_chat = 0;

        $query = User::selectRaw('date(user_1_1_chat_request.created_at) as date, count(.user_1_1_chat_request.id) as cant')->join('user_1_1_chat_request', 'user_1_1_chat_request.user_id', '=', 'user.id')->
            where('role_id', WhiteLabel::roleId('User'))->where('fraud', 0)->where('test_user', 0)->where('email_validated', 1)
            ->where('user_1_1_chat_request.state', 'COMPLETE');

        // $query3 = User::selectRaw('date(user_1_1_chat_request.created_at) as date, count(.user_1_1_chat_request.id) as cant')->join('user_1_1_chat_request', 'user_1_1_chat_request.user_id', '=', 'user.id')->
        //     where('role_id', WhiteLabel::roleId('User'))->where('fraud', 0)->where('test_user', 0)->where('email_validated', 1)
        //     ->where('user_1_1_chat_request.state', 'COMPLETE');
        // $clients = User::where('role_id', WhiteLabel::roleId('User'))->where('fraud', 0)->where('test_user', 0)->where('email_validated', 1)->count();

        $query2 = clone $query;
        $collection = $query2->groupBy('date')->get();
        $avg_session = $collection->count() == 0 ? 0 : \round($collection->sum(function ($item) { //Average number of total sessions per psychic
            return $item['cant'];
        }) / $collection->count(), 2);

        $query2 = clone $query;
        $collection = $query2->where('service_id', 3)->get();

        $avg_video = $collection->count() == 0 ? 0 : \round($collection->sum(function ($item) { //Average number of video chat sessions completed per client
            return $item['cant'];
        }) / $collection->count(), 2);

        $query2 = clone $query;
        $collection = $query2->where('service_id', 1)->get();

        $avg_call = $collection->count() == 0 ? 0 : \round($collection->sum(function ($item) { //Average number of call sessions completed per client
            return $item['cant'];
        }) / $collection->count(), 2);

        $collection = chat::selectRaw('date(chat.created_at) as date, count(chat.id) as cant')->join('user', 'user.id', '=', 'chat.user_id')->where('user.role_id', WhiteLabel::roleId('User'))->groupBy('date')->get();

        $avg_chat = $collection->count() == 0 ? 0 : \round($collection->sum(function ($item) {
            return $item['cant'];
        }) / $collection->count(), 2);

        // $collection = User::selectRaw('count(user_1_1_chat_request.id) as cant, user_1_1_chat_request.user_id')->join('user_1_1_chat_request', 'user_1_1_chat_request.user_id', '=', 'user.id')->
        //     where('role_id', WhiteLabel::roleId('User'))->where('fraud', 0)->where('test_user', 0)->where('email_validated', 1)
        //     ->where('user_1_1_chat_request.state', 'COMPLETE')->groupBy('user_1_1_chat_request.user_id')->get();

        // $avg_new_session = $collection->map(function ($item) {
        //     return $item->cant == 1 ? 1 : 0;})->sum();

        return [
            'avg_session' => $avg_session,
            'avg_video' => $avg_video,
            'avg_call' => $avg_call,
            'avg_chat' => $avg_chat,
            // 'avg_new_session' => $avg_new_session,
        ];
    }
}
