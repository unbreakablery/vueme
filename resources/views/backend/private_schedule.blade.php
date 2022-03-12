@extends('layouts.app-dashboard')

@section('content')

<private-schedule :user="{{json_encode(Auth::user())}}" :categories=" {{json_encode($categories)}}" />

@endsection