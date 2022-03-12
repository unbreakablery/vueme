@extends('layouts.app')

@section('content')

<specialtie :guest="{{json_encode(\Illuminate\Support\Facades\Auth::guest())}}" :slug="{{json_encode($slug)}}" :user="{{json_encode(\Illuminate\Support\Facades\Auth::user())}}"/>

@endsection