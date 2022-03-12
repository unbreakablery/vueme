@extends('layouts.app-dashboard')

@section('content')
<div id="main-padding">
    <h4 class="link_intro">Edit Profile</h4>
    <h2 class="link_intro_mobile">Edit Profile</h2>
    <div class="container fan-profile container-gray-area p-3">
        <user-profile :countries="{{json_encode($countries)}}"
         :states="{{json_encode($states)}}"
         :timezones="{{json_encode($timezones)}}"
        :country_all="{{json_encode($country_all)}}"></user-profile>
    </div>
</div>
@endsection

