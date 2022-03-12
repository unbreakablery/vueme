@extends('layouts.app-dashboard')

@section('content')

<div>
    <!-- <p-cosmic-rewards :user="{{Auth::user()}}">
    </p-cosmic-rewards> -->
    <p-subscribers :user="{{Auth::user()}}"></p-subscribers>
</div>

@endsection