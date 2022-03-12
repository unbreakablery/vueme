@extends('layouts.phone_verification')

@section('content')
    <add-verify-phone :notice="{{json_encode($notice)}}" :phone="{{json_encode($phone)}}" :user="{{json_encode($user)}}"  :country_all="{{json_encode($country_all)}}"></add-verify-phone>
@endsection
