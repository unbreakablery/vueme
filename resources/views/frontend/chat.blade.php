@extends('layouts.app-dashboard-chat')
@section('content')
<chat :user="{{\Illuminate\Support\Facades\Auth::user()}}"
          users_height="67vh"
          messages_height="61vh"
          :user_to_select={{json_encode($user)}}
    ></chat>
@endsection