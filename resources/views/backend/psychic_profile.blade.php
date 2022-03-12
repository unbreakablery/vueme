@extends('layouts.app-dashboard')

@section('content')
<div class="container container-gray-area p-0" style="background-color: transparent;">
    <psychic-profile :tab_select="{{json_encode($tab_select)}}" :countries="{{json_encode($countries)}}" :states="{{json_encode($states)}}" :specialties="{{json_encode($specialties)}}" :tools="{{json_encode($tools)}}" :styles="{{json_encode($styles)}}" :languages="{{json_encode($languages)}}" :categories="{{json_encode($categories)}}" :timezones="{{json_encode($timezones)}}" :country_all="{{json_encode($country_all)}}" :todo-list="{{json_encode($todoList)}}"></psychic-profile>
</div>
@endsection