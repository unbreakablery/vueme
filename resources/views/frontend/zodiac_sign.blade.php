@extends('layouts.app')
@section('metas')
@parent
<link rel="canonical" href="https://www.respectfully.com">
<meta name="keywords" content="zodiac, the zodiac">
<meta name="description" content="The zodiac helps us navigate our way through life, love and happiness. Select your zodiac sign for your free weekly horoscope delivered right to your inbox!">
@endsection
@section('title', 'Free Weekly Horoscope Readings On Demand | ')
@section('content')


<zodiac_sign :horoscope="{{$horoscope}}" :weekhoroscope="{{$info}}" :datetoday="{{$datetoday}}" :country_all="{{$country_all}}" />

@endsection