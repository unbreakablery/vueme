@extends('layouts.app')

@section('content')

<favorites :user="{{json_encode($user)}}" :guest="{{json_encode($guest)}}"></favorites>
@endsection