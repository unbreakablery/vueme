@extends('layouts.app-dashboard')

@section('content')
<div id="main-padding">
    <h4 class="link_intro">Appointments</h4>
    <h1 class="link_intro_mobile">Appointments</h1>
    <user-appointments :user="{{Auth::user()}}" :categories="{{json_encode($categories)}}" :apid="{{json_encode($apid)}}"></user-appointments>
</div>
@endsection