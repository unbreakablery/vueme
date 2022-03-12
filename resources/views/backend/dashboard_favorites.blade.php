@extends('layouts.app-dashboard')

@section('content')
<div id="main-padding">
    <h4 class="link_intro" style="margin-top: 10px; margin-bottom: 10px">Following</h4>
    <h1 class="link_intro_mobile">Following</h1>
    <favorites class="py-0 pt-3" :user="{{Auth::user()}}" :categories="{{json_encode($categories)}}" :apid="{{json_encode($apid)}}"/>
</div>
@endsection
