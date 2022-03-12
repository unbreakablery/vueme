@extends('layouts.app')

@if ($seo_ability != null)
@section('metas')
@parent
<meta name="description" content="{{$seo_ability->meta_desc_tag}}">
@endsection
@section('title', $seo_ability->title_tag)
@else
@section('metas')
@parent
<meta name="description" content="Get the answers you need with a personal online psychic reading from a top-rated psychic advisor at Respectfully™. As a bonus, get $5 off your first reading!">
@endsection
@section('title', 'Online Model Reading | Model Advisor | ')
@endif

@section('content')

<search :guest="{{json_encode(\Illuminate\Support\Facades\Auth::guest())}}" :user="{{json_encode(\Illuminate\Support\Facades\Auth::user())}}" :terms="{{json_encode($terms)}}" :abilities="{{json_encode($abilities)}}"/>
@endsection