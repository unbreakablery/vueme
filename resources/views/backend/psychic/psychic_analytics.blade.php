@extends('layouts.app-dashboard')

@section('content')

<p-analytics :user="{{\Illuminate\Support\Facades\Auth::user()}}"></p-analytics>
@endsection