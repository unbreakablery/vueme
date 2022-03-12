@extends('layouts.app')

@section('content')
<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

<div class="container text-center mt-5">

    <p 
    style="margin-top:100px; font-family: 'Montserrat', sans-serif; font-weight: 600; color:#949498;" 
    >Nothing to See Here!</p>

    <img src="{{ env('APP_URL') }}/images/site-images/404.png" style="width:78%; margin-top:-7px;"
    class="img-fluid mt-5" alt="Responsive image">

</div>
<a href='/'>
    <v-btn 
    class="container text-center mt-5"
    style="
        margin-top: 65px !important;
        font-size: 12px !important;
        color: #FFF !important;
        background: transparent linear-gradient(180deg, #7272FF 0%, #9759FF 100%) 0% 0% no-repeat padding-box;
        letter-spacing: 0.43px;
        width: 150px;
        height: 35px;
        display: block;
        line-height: 30px !important;
        border-radius: 9px;
    "

        dark>Go Back</v-btn>
</a>

</div>
@endsection