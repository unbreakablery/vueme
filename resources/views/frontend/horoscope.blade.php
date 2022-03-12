@extends('layouts.app')
@section('metas')
@parent
<link rel="canonical" href="https://www.respectfully.com/horoscope">
<meta name="keywords" content="zodiac, the zodiac">
<meta name="description" content="The zodiac helps us navigate our way through life, love and happiness. Select your zodiac sign for your free weekly horoscope delivered right to your inbox!">
@endsection
@section('title', 'Free Weekly Horoscope Readings On Demand | ')


@section('content')



<div class="homepage">
    <div class="pa-0">
      <v-img
        alt="Home Banner Image"
        style="z-index: 1"
        src="/images/Banner-imgs/horoscopeHub.png"
        aspect-ratio="1"
        class="align-sm-center justify-sm-center home_hero imgHoroscopeHome"
      >
        <div class="justify-center text-center" style="position: absolute;width: 100%;margin-top: -50px;padding: 0 47px;top: 45%;">
          <h1>Horoscope Hub</h1>
          <h3>your source for weekly horoscope readings on demand</h3>
        </div>
      </v-img>
    </div>

    <horoscope_all></horoscope_all>
    
    <v-layout row class="mt-12 front m-0">
    <v-flex style =" background: #F4F4F4">
        <v-container class="p-0">
          <div
            class="align-sm-center text-center-md justify-sm-center home_banner pr-0 pl-0 mr-5 ml-5"
          >
            <h3 class="mb-5">Let the Zodiac Guide You</h3>
            <p
              class="text-center-md"
              style="
                font-size: 14px !important;
                color: #656b72;
                font-weight: 500;
              "
            >
              The world can be a lonely, confusing place - but it doesn’t have to stay that way! Reading your free horoscope from Respectfully™ allows you to gain insight into everything from navigating relationships to understanding your own strengths and weaknesses. Instead of facing the world on your own, let the zodiac star sign guide you to a happier and healthier life.
            </p>
          </div>
        </v-container>
      </v-flex>
    </v-layout>

    <horoscope_abilities></horoscope_abilities>
    

    <v-layout row class="mt-12 front m-0">
      <v-flex style =" background: #F4F4F4">
        <v-container class="p-0">
          <div
            class="align-sm-center text-center-md justify-sm-center home_banner pr-0 pl-0 mr-5 ml-5"
          >
            <h4 class="mb-5">Zodiac Signs Frame Your Future</h4>
            <p
              class="text-center-md"
              style="
                font-size: 14px !important;
                color: #656b72;
                font-weight: 500;
              "
            >
              Feeling as if you need more support in this crazy life? The Respectfully™ top-rated online models can perform a tailored horoscope reading online for your star sign offering insight into your personality and valuable information about your future. You can then use this knowledge to improve your relationships, your career, your finances, and more. Book a reading with any of our models or check out our free horoscopes to get you started on the path you were always meant to be on.
            </p>
          </div>
        </v-container>
      </v-flex>
    </v-layout>


    <horoscope_specialties  :blogs="{{$blogs}}"></horoscope_specialties>



    
    </div>

@endsection