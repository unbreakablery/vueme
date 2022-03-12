@extends('layouts.phone_verification')

@section('content')
<change-password :token_user="{{json_encode($token_user)}}" :email_user="{{json_encode($email_user)}}" :notice="{{json_encode($notice)}}" :phone="{{json_encode($phone)}}" :user="{{json_encode($user)}}" :redirect="{{json_encode($redirect)}}"></change-password>
@endsection