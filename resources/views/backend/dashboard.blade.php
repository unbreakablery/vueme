@extends('layouts.app-dashboard')

@section('content')

<psychic-appointments :user="{{json_encode(Auth::user())}}" :categories=" {{json_encode($categories)}}" />

@endsection