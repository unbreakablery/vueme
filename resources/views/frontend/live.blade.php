@extends('layouts.stream')
@section('metas')
@parent
<meta name="description" content="{{$profile_bio}}">



@endsection
@section('title', $profile_name . ' | ')
@section('content')

<live-stream :user="{{\Illuminate\Support\Facades\Auth::user()}}" :token="{{json_encode($token)}}" :token_rtm="{{json_encode($token_rtm)}}" :model="{{json_encode($model)}}" :channel="{{json_encode($channel)}}"/>

@endsection


