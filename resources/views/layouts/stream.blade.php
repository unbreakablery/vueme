<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   
    @section('metas')
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0">
    <meta name="theme-color" content="#9759FF">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @show
    <title>@yield('title'){{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('frontend/js/app.js') }}?id=110520201321" type="text/javascript" defer></script>
    <!-- Web Manifest -->
    <link rel="manifest" href="{{ env('APP_URL') }}/manifest.json">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/app.css') }}?id=110520201320">
    <link rel="stylesheet"  href="{{ asset('css/custom.css') }}?id=110520201320">
    <link rel="stylesheet"  href="{{ asset('css/main-styles.css') }}?id=110520201320">
    <link rel="stylesheet" href="{{ asset('frontend/css/landing.css') }}?id=110520201320">
    

    <!--Start Service Worker Script-->
    <script type="text/javascript">
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register("{{ asset('/service-worker.js') }}").then(function(registration) {
                    // Registration was successful
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }, function(err) {
                    // registration failed
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }
    </script>
    <!--End of Service Worker Script-->

    <script rel="preload" as="script" src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
    <style>
        @media (min-width: 1280px) {
            .container {
                max-width: 1101px!important;
            }
        }
    </style>
</head>

<body>
   
    <div id="app">

        <v-app light v-resize="onResize">
            <standard-dialog></standard-dialog>
            @if(Route::currentRouteName() === "specialtie.profile")
            <s-header-2 class="d-none d-sm-block" :user="{{json_encode(Auth::user())}}"></s-header-2>
            @endif
            <s-header class="d-none d-sm-block"
                :user="{{ json_encode(\Illuminate\Support\Facades\Auth::user())}}"
                :guest="{{json_encode(\Illuminate\Support\Facades\Auth::guest())}}"
                :categories="{{json_encode(\App\Services\WhiteLabel::config('user')->categories)}}"
                :abilities="{{json_encode(\App\Http\Controllers\FrontController::abilities())}}"
                :specialties="{{json_encode(\App\Http\Controllers\FrontController::specialties())}}"
                :country_all="{{json_encode(\App\Http\Controllers\FrontController::countries_all())}}"
                redeem="true"
                :home="{{json_encode($home ?? null)}}"
                :styles="{{json_encode(\App\Http\Controllers\FrontController::styles())}}"
                :tools="{{json_encode(\App\Http\Controllers\FrontController::tools())}}"
                :url="{{json_encode(Request::path())}}">
            </s-header>
            
            
            <div class="container--fluid p-0 content" style="@if(Route::currentRouteName() === 'specialtie.profile'){{ 'margin-bottom: 50px;' }}@endif">
                @yield('content')
            </div>
            {{-- <div class="container--fluid p-0 content"  v-if="user"
            :style="{marginTop: $vuetify.breakpoint.smAndDown ? '80px' : '80px'}">
                @yield('content')
            </div> --}}
            
            <div class="container--fluid p-0">
                <p-footer
                    :guest="{{json_encode(\Illuminate\Support\Facades\Auth::guest())}}"
                    :home="{{json_encode($home ?? null)}}"
                    :router="{{json_encode(Route::currentRouteName())}}"
                >
                </p-footer>
            </div>
            
        </v-app>

    </div>
    <script rel="preload" as="script" src="https://static.opentok.com/v2/js/opentok.min.js" defer></script>
     @yield('script')
</body>

</html>
