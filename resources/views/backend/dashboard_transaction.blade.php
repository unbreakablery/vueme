@extends('layouts.app-dashboard')

@section('content')
<div id="main-padding">
    <h1 class="link_intro">Transactions</h1>
    <h1 class="link_intro_mobile">Transactions</h1>
    <credit_logs :transactions="{{json_encode($transactions)}}" :name="{{json_encode($name)}}"> </credit_logs>
    <!-- <credit_logs> </credit_logs> -->
</div>
@endsection
