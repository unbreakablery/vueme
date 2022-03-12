@extends('layouts.app')

@section('content')

<specialties :guest="{{json_encode(\Illuminate\Support\Facades\Auth::guest())}}" :user="{{json_encode(\Illuminate\Support\Facades\Auth::user())}}" />

@endsection