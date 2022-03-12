@extends('layouts.app')
@section('metas')
@parent
<link rel="canonical" href="https://www.respectfully.com/get-5-free">
<meta name="description" content="Discover hundreds of top-rated online models and spiritual advisors at Respectfully™. Enjoy personal psychic readings online and get $5 off your first reading!">
@endsection
@section('title', 'Online Models | Top-Rated Online Models at ')
@section('content')

<get-5-free :guest="{{json_encode(\Illuminate\Support\Facades\Auth::guest())}}" :user="{{json_encode(\Illuminate\Support\Facades\Auth::user())}}" />
@endsection

