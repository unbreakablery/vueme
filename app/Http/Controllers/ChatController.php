<?php

namespace App\Http\Controllers;

use App\Models\chat_in;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
      /*  $this->middleware('role:2');*/
        $this->middleware('verifield');
        $this->middleware('verifyphone');
    }

    public function index(Request $request)
    {         
       
        $user_logged =Auth::user();
            
        if($request->user && $user_logged->role_id == 2){
            $chat_in = chat_in::firstOrNew(array('user_id' => $user_logged->id,'receiver_id' => $request->user));            
            $chat_in->save();
        }
        if($user_logged->isPsychic()){
            return view('backend.chat',[
                'user' => $request->user,
                'link' => ''
                
            ]);
        }else{            
            return view('frontend.chat',[
                'user' => $request->user,
                'link' => ''
               
            ]);
        }

    }

}
