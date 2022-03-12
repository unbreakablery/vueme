@extends('layouts.phone_verification')

@section('content')
<verify-phone :notice="{{json_encode($notice)}}" :phone="{{json_encode($phone)}}" :user="{{json_encode($user)}}" :redirect="{{json_encode($redirect)}}"></verify-phone>
@endsection