@extends('layouts.app-dashboard')

@section('content')
<div>
    <!-- <p-cosmic-rewards :user="{{Auth::user()}}">
    </p-cosmic-rewards> -->
    <p-referrals :user="{{Auth::user()}}"></p-referrals>
</div>


@endsection