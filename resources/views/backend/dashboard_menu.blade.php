@extends('layouts.app-dashboard')

@section('content')

<mobile-navbar :user="{{json_encode(Auth::user())}}" />



@endsection