<?php

/**
 * Created by PhpStorm.
 * User: developer
 * Date: 8/23/2019
 * Time: 11:27 AM
 */

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Services;
use App\Services\ApiUtils;
use App\Models\Appointment;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use App\Services\TwilioUtils;
use Illuminate\Validation\Rule;
use App\Events\VideoPrivateSent;
use App\Mail\ClientReadingBooked;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Events\NotificationsInAppEvent;
use App\Http\Resources\v1\PostResource;
use App\Services\NotificationsInAppUtils;
use App\Http\Resources\v1\PostFrontResource;
use App\Http\Resources\v1\UserChatRequestResource;
use App\Http\Resources\v1\AppointmentUserCalendarResource;
use App\Http\Resources\v1\AppointmentScheduledRequestResource;
use App\Http\Resources\v1\AppointmentCalendarResourceCollection;


class AppointmentController extends Controller
{

    public function __construct(Guard $auth)
    {
        $this->middleware('auth:api');
        $this->auth = $auth;
    }


    protected function filterAppointments(Request $request)
    {
        $q = Appointment::latest()->where('psychic_id', Auth::guard('api')->user()->id)->get();
        $today = date('Y-m-d');


        if ($request->has('status') && !is_null($request->input('status')) && $request->input('status') != 'All') {
            $status = explode(',', $request->input('status'));
            $q = $q->whereIn('status', $status);
        }


        if ($request->has('date_filter') && !is_null($request->input('date_filter'))) {
            //$dayAfter = (new \DateTime('now'))->modify('-' . $request->input('date_filter') . ' months')->format('Y-m-d');
            $today = $request->input('date_filter');
        }

        // $twoDays = date('Y-m-d', strtotime($today . ' + 2 day'));
        // $q = $q->whereBetween('date', [$today, $twoDays]);
            $q = $q->where('date', '=',$today);

        return $q->sortBy('start_hour');
    }

    protected function filterUserAppointments(Request $request)
    {


        $q = Appointment::where('user_id', '=', Auth::guard('api')->user()->id);

        $today = date('Y-m-d');

        if ($request->has('status') && !is_null($request->input('status')) && $request->input('status') != 'All') {
            $status = explode(',', $request->input('status'));
            $q->whereIn('status', $status);
        }

        if ($request->has('date_filter') && !is_null($request->input('date_filter'))) {

            $today = $request->input('date_filter');
        }

        $twoDays = date('Y-m-d', strtotime($today . ' + 2 day'));
        $q->whereBetween('date', [$today, $twoDays]);

        $q->orderBy('start_hour', 'ASC');
        return $q->get();
    }

    public function getAppointmentsMonth(Request $request)
    {
        $date = \explode('-',$request->date);
        $date = Carbon::createFromDate($date[0], $date[1]);
        $user = Auth::guard('api')->user();
        $field = $user->role_id == WhiteLabel::roleId('Model') ? 'psychic_id' : 'user_id';
        $q = Appointment::select('appointment.date', 'appointment.status')->where($field, '=', $user->id)
             ->whereBetween('appointment.date', [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()])->get()->toArray();

        return \json_encode($q);
    }

    public function getAppointments(Request $request)
    {
        
        $appointments = new AppointmentCalendarResourceCollection($this->filterAppointments($request));
         
        return $appointments;
    }

    public function getAppointmentsDay(Request $request)
    {
        $date = \explode('-',$request->date);
        $date = Carbon::createFromDate($date[0], $date[1], $date[2]);
        $model_id = $request->model_id;  
        $field = 'psychic_id';
        $q = Appointment::select('appointment.start_hour', 'appointment.end_hour' )->where($field, '=', $model_id)
             ->whereDate('appointment.date', '=', $date)
             ->where('appointment.status', '!=', 'Cancelled')
             ->where('appointment.status', '!=', 'Completed')
             ->orderBy('appointment.start_hour', 'DESC')
             ->get()->toArray();             
        return \json_encode($q);
    }

    public function getUserAppointments(Request $request)
    {

        $appointments = AppointmentUserCalendarResource::collection($this->filterUserAppointments($request));

        return $appointments;
    }

    public function updateAppointmentStatus(Request $request)
    {

        $this->validate($request, [
            'id' => 'required|integer',
            'status' => ['required', Rule::in(["Confirmed", "Cancelled"])],
        ]);

        $user = Auth::user();
        $id =  $request->input('id');
        $status =  $request->input('status');


        $appointment = $user->appointments()->where('id', '=', $id)->first();

        if (is_null($appointment)) {
            return response()->json(['message' => 'Invalid appointment ID'], 400);
        }

        $toTimezone = $appointment->user->userProfile->timezone;

        $now = new \DateTime();
        $now->setTimezone(new \DateTimeZone($toTimezone));

        if ($now->getTimestamp() > date_timestamp_get(new \DateTime($appointment->start_hour))) {
            $appointment->status = 'Cancelled';
            $appointment->save();

            return response()->json(['message' => 'Appointment was cancelled because it was in the past'], 200);
        }

        $appointment->status = $status;
        $appointment->save();

        if ($appointment->status == 'Confirmed') {
            EmailUtils::send_to_user_when_reading_booked($appointment);
            TwilioUtils::send_sms_appointment_booked($appointment);
            NotificationsInAppUtils::f_to_user_when_psychic_confirm_appointment($appointment, 'user');
        }

        if ($appointment->status == 'Cancelled') {
            //TwilioUtils::send_sms_appointment_cancel($appointment);
            $appointment->canceled_by = $user->id;
            $appointment->save();
            //If appointment is request later
            if (!$appointment->user_1_1_chat_request) {
                $appointment->canceled_by = $user->id;
                $appointment->save();
                NotificationsInAppUtils::f_to_user_when_psychic_canceled_or_expired_appointment($appointment, 'user');
            }
        }
        return response()->json(['message' => 'Appointment was successfully ' . $status], 200);
    }

    public function updateUserAppointmentStatus(Request $request)
    {
       
        $this->validate($request, [
            'id' => 'required|integer',
            'status' => ['required', Rule::in(["Cancelled"])],
        ]);
      
        $user = Auth::user();
        $id =  $request->input('id');
        $status =  $request->input('status');

     
        $appointment = $user->user_appointments()->where('id', '=', $id)->first();
       
        if (is_null($appointment)) {
            return response()->json(['message' => 'Invalid appointment ID'], 400);
        }
       
        $appointment->status = $status;
        $appointment->save();
        if ($appointment->status == 'Cancelled') {
            $appointment->canceled_by = $user->id;
            $appointment->save();
            TwilioUtils::send_sms_to_psychic_appointment_cancel($appointment);
            //If appointment is request later
            if (!$appointment->user_1_1_chat_request) {
            NotificationsInAppUtils::f_to_psychic_when_user_canceled_appointment($appointment, 'psychic');
            }
        }

        return response()->json(['message' => 'Appointment was successfully ' . $status], 200);
    }

    public function editAppointment(Request $request)
    {
        $id =  $request->input('id');
        $user = Auth::user();
        $appointment = $user->appointments()->where('id', '=', $id)->first();

        $psychic_user = $appointment->psychic;

        $psychic_service = $psychic_user->userService()->where('service_id', $appointment->service_id)->first();

        $min_duration = $psychic_service->min_duration;

        //$toTimezone=$appointment->user->userProfile->timezone;
        $toTimezone = $user->userProfile->timezone;

        $now = new \DateTime();
        $now->setTimezone(new \DateTimeZone($toTimezone));

        $this->validate($request, [
            'id' => 'required|integer',
            'category' => 'required|integer',
            'date' => 'required|date',
            'start' => ['required', 'regex:/^(((([0-1][0-9])|(2[0-3])):?[0-5][0-9])|(24:?00))/', 'string'],
            //'end'=> ['required', 'regex:/^(((([0-1][0-9])|(2[0-3])):?[0-5][0-9])|(24:?00))/', 'string'],
            'date_and_time' => ['date', 'after_or_equal:' . $now->format('m/d/Y g:i:s A')],
            'duration' => ['required', 'integer', 'min:' . $min_duration],
            'notes' => 'nullable|string',
        ]);

        $category =  $request->input('category');
        $date =  $request->input('date');
        $start =  $request->input('start');
        $end =  date("H:i", strtotime('+' . $request->get('duration') . ' minutes', strtotime($start)));
        $duration =  $request->input('duration');
        $notes =  $request->input('notes');


        if (is_null($appointment)) {
            return response()->json(['message' => 'Invalid appointment ID'], 400);
        }

        $startDate = new \DateTime($date . " " . $start);
        $endDate = new \DateTime($date . " " . $end);

        $appointment->category_id = $category;
        $appointment->date = $date;
        $appointment->start_hour = $startDate->format('Y-m-d H:i:s');
        $appointment->end_hour = $endDate->format('Y-m-d H:i:s');
        $appointment->duration = $duration;
        $appointment->text = $notes;
        $appointment->save();

        return response()->json(['message' => 'Appointment updated'], 200);
    }

    public function editUserAppointment(Request $request)
    {
        $id =  $request->input('id');
        $user = Auth::user();
        $appointment = $user->user_appointments()->where('id', '=', $id)->where('status', '=', 'Pending')->first();
        $old_appointment = clone ($appointment);
        $psychic_user = $appointment->psychic;

        $psychic_service = $psychic_user->userService()->where('service_id', $appointment->service_id)->first();

        $min_duration = $psychic_service->min_duration;

        $toTimezone = $user->userProfile->timezone;

        $now = new \DateTime();
        $now->setTimezone(new \DateTimeZone($toTimezone));

        $this->validate($request, [
            'id' => 'required|integer',
            'category' => 'required|integer',
            'date' => 'required|date',
            'start' => ['required', 'regex:/^(((([0-1][0-9])|(2[0-3])):?[0-5][0-9])|(24:?00))/', 'string'],
            //'end'=> ['required', 'regex:/^(((([0-1][0-9])|(2[0-3])):?[0-5][0-9])|(24:?00))/', 'string'],
            'date_and_time' => ['date', 'after_or_equal:' . $now->format('m/d/Y g:i:s A')],
            'duration' => ['required', 'integer', 'min:' . $min_duration],
        ]);

        $category =  $request->input('category');
        $date =  $request->input('date');
        $start =  $request->input('start');
        $end =  date("H:i", strtotime('+' . $request->get('duration') . ' minutes', strtotime($start)));
        $duration =  $request->input('duration');

        if (is_null($appointment)) {
            return response()->json(['message' => 'Invalid appointment ID'], 400);
        }

        $startDate = new \DateTime($date . " " . $start);
        $endDate = new \DateTime($date . " " . $end);

        $appointment->category_id = $category;
        $appointment->date = $date;
        $appointment->start_hour = $startDate->format('Y-m-d H:i:s');
        $appointment->end_hour = $endDate->format('Y-m-d H:i:s');
        $appointment->duration = $duration;
        $appointment->save();

        EmailUtils::send_to_psychic_when_user_reschedules_service($appointment, $old_appointment);
        TwilioUtils::send_sms_to_psychic_appointment_rescheduled($appointment);
        return response()->json(['message' => 'Appointment updated'], 200);
    }

    public function editAppointmentNotes(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            'notes' => 'required'
        ]);

        $appointment = Appointment::find($request->get('id'));

        $appointment->text = $request->get('notes');

        $appointment->save();

        return response()->json(['message' => 'Appointment notes updated'], 200);
    }
    public function createPrivateShow(Request $request)
    {


        // save user profile
        if (!Auth::user()) {
            return $this->response_fail();
        }

        $request->validate([  

            'time' => [
                'required',
                'regex:/^(((([0-1][0-9])|(2[0-3])):?[0-5][0-9])|(24:?00))/',
                'string',
                ],
            'date' => "required|date",
            'description' => 'required',
            
         ]);

         
         $user = Auth::user();
         $psychic_user = User::where('id', Auth::user()->id)->first();
         
         $appointment = $user->user_appointments()->create([

            'psychic_id' => Auth::id(),
            'service_id' => 1,
            'date' => $request->input('date'),
            'start_hour' => $request->input('date').' '.$request->input('time'),
            'text' => $request->input('description'),
            'schedule' => '1',
            

        ]);

        return response()->json(['message' => 'Private created', 'data' => $appointment], 200);

    }
    public function createAppointment(Request $request)
    {


        $this->validate($request, [
            'service_id' => 'required|integer',
            'psychic_id' => 'required|integer'
        ]);

        $user = Auth::user();
        $psychic_user = User::where('id', $request->get('psychic_id'))->first();

        $psychic_service = $psychic_user->userService()->where('service_id', $request->get('service_id'))->first();

        $toTimezone = $user->userProfile->timezone;


        $now = new \DateTime();
        $now->setTimezone(new \DateTimeZone($toTimezone));

        $now_or_later = $request->input('now_or_later');

        if ($now_or_later == "now") {
            $this->validate($request, [
                'date' => 'required|date',
                'start' => [
                    'required',
                    'regex:/^(((([0-1][0-9])|(2[0-3])):?[0-5][0-9])|(24:?00))/',
                    'string',
                ],
            ]);
        } elseif ($now_or_later == "later") {

            $this->validate($request, [
                'date' => 'required|date',
                'start' => [
                    'required',
                    'regex:/^(((([0-1][0-9])|(2[0-3])):?[0-5][0-9])|(24:?00))/',
                    'string',
                ],
                'date_and_time' => ['date', 'after_or_equal:' . $now->format('m/d/Y g:i:s A')],
            ]);
        }


        $rate = $psychic_service->rate;
        $min_duration = 1;

        $full_price = ($request->get('duration', $min_duration )) * ($rate);

        if (!$user->check_credits($full_price, true)) {            
            return response()->json([false, ['message' => 'Not enough credits', 'buyCreditOpcion' => $user->BuyCredits['buyCreditOpcion']]]);
        }

        if ($request->get('timezone')) {

            $uProfile = $user->userProfile()->first();

            $uProfile->timezone = $request->get('timezone');

            $uProfile->save();
        }

        $date =  $request->input('date');
        $start =  $request->input('start');
        $startDate = new \DateTime($date . " " . $start);
        

        $appointment = $user->user_appointments()->create([

            'user_id' => Auth::id(),
            'psychic_id' => $request->input('psychic_id'),
            'service_id' => $request->input('service_id'),
            'date' => $date,
            'start_hour' => $startDate,
            'type' => $now_or_later

        ]);
        $appointment_aux = Appointment::where('id', $appointment->id)->first();

        if ($now_or_later == 'later') {

            $appointment_aux->schedule = 1;
            $appointment_aux->save(); 
            NotificationsInAppUtils::f_to_psychics_when_new_scheduled_appointment($appointment_aux);
            NotificationsInAppUtils::f_to_user_when_create_new_scheduled_appointment_pending($appointment_aux);

        }else{
            
        }

       

        return response()->json(['message' => 'Appointment created', 'data' => $appointment], 200);
    }


    public function requestReview(Request $request)
    {

        $this->validate($request, [
            'id' => 'required|integer',
        ]);

        $user = Auth::user();
        $id   = $request->input('id');

        $appointment = $user->appointments()->where('id', '=', $id)->first();

        if (is_null($appointment)) {
            return response()->json(['message' => 'Invalid appointment ID'], 400);
        }
        if ($appointment->review_requested) {
            return response()->json(['message' => 'Invalid appointment ID'], 400);
        }


        if (!$appointment->token_review) {
            $token = ApiUtils::generate_token(40);
            $appointment->token_review = $token;
        }
        $appointment->review_requested = true;
        $appointment->save();

        EmailUtils::send_to_client_when_request_review($appointment);

        return response()->json(['message' => 'Review requested'], 200);
    }
    public function getAppointment(Request $request)
    {

        $user = Auth::user();

        $appointment = $user->appointments()->where('id', $request->id)->first();
        if (!$appointment) {
            return ApiUtils::response_fail('Not Faound');
        }
        return new AppointmentScheduledRequestResource($appointment);
    }
}
