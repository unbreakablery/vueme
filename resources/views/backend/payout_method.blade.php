@extends('layouts.app-dashboard')
@section('content')



<div class="p-0">
    <p-payout-tab :payout_details="{{json_encode($payout_details)}}"
                  :countries="{{json_encode($countries)}}"
                  :country_all="{{json_encode($country_all)}}"
                  :states="{{json_encode($states)}}"
                  :cards="{{json_encode($methods)}}"
                  :transactions="{{json_encode($transactions)}}"
                  :payout_logs="{{json_encode($payout_logs)}}"
                  :user="{{Auth::user()}}">
    </p-payout-tab>
</div>

@endsection