@extends('layouts.app')
@section('metas')
@parent
<meta name="description" content="{{$meta_description}}">
<link rel="canonical" href="https://www.respectfully.com/{{$meta_link}}">
@endsection
@section('title', $page_title . ' | ')
@section('content')

<specialtie-profile
    :user="{{ json_encode($user) }}"
    {{-- :current-user-appointment-count="{{ $current_user_appointment_count }}" --}}
    {{-- :current-user-timezone="'{{ $current_user_timezone }}'" --}}
    {{-- :timezones="{{json_encode($timezones)}}" --}}
    {{-- :browser="'{{$browser}}'" --}}
    :model="{{json_encode($model)}}"    
/>

@endsection