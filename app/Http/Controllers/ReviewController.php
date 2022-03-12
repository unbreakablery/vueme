<?php

namespace App\Http\Controllers;

use App\Http\Resources\v1\AppointmentWriteReviewResource;
use App\Models\Appointment;
use App\Services\ApiUtils;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct(Guard $auth)
    {
        $this->auth = $auth; 
    }

    public function write_review_from_email(Request $request){

         
        $appointment = Appointment::where([
            ['id','=',$request->aid],
            ['token_review','=',$request->token],
            ['reviewed','=',0],            
            ['status', '=', 'Completed']])->first();


          
        if(!$appointment){           
            return redirect()->route('home');
        }
        return view('frontend.review',[
            'appointment' => new AppointmentWriteReviewResource($appointment),
            'link' => ''
            
        ]);  

    }
}
