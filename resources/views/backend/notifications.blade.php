@extends('layouts.app-dashboard')

@section('content')


<notifications :user="{{ json_encode(\Illuminate\Support\Facades\Auth::user())}}"></notifications>


@endsection