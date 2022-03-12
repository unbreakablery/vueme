@extends('layouts.app')

@section('content')

<signuppage  :country_all="{{json_encode($country_all)}}" />

@endsection