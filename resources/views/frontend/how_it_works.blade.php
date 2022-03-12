@extends('layouts.app')
@section('metas')
@parent
<link rel="canonical" href="https://www.vueme.com">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<meta name="description" content="">
@endsection
@section('title', '')
@section('content')

<how-it-works
    :guest="{{json_encode(\Illuminate\Support\Facades\Auth::guest())}}"
    :user="{{json_encode(\Illuminate\Support\Facades\Auth::user())}}"
    :abilities="{{json_encode(\App\Http\Controllers\FrontController::abilities())}}"
    :country_all="{{json_encode(\App\Http\Controllers\FrontController::countries_all())}}"
    redeem="true"
    :styles="{{json_encode(\App\Http\Controllers\FrontController::styles())}}"
    :tools="{{json_encode(\App\Http\Controllers\FrontController::tools())}}"
/>

@endsection

