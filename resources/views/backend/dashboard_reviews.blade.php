@extends('layouts.app-dashboard')

@section('content')
<div id="main-padding">
    <h1 class="link_intro subscriptions-title">Subscriptions</h1>
    <h1 class="link_intro_mobile">Subscriptions</h1>
    <reviews  :user="{{Auth::user()}}" :categories="{{json_encode($categories)}}" :apid="{{json_encode($apid)}}"/>
</div>
@endsection
