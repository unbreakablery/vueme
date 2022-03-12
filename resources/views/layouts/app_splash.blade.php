<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="theme-color" content="#9759FF">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script rel="preload" as="script" src="{{ asset('frontend/js/app.js') }}" defer></script>

    <!-- Web Manifest -->
    <link rel="manifest" href="{{ env('APP_URL') }}/manifest.json">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet"  href="https://fonts.googleapis.com/css?family=Montserrat:500&display=swap">
    <link rel="stylesheet"  href="https://fonts.googleapis.com/css2?family=Lobster&display=swap">
    <!-- Styles -->
    <link rel="preload" as="style" onload="this.rel = 'stylesheet'" href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css">
    <link rel="preload" as="style" onload="this.rel = 'stylesheet'" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
    <link rel="preload" as="style" onload="this.rel = 'stylesheet'" href="{{ asset('frontend/css/app.css') }}">
    
    <link rel="stylesheet"  href="{{ asset('css/custom.css') }}?id=110520201320">
    <link rel="preload" as="style" onload="this.rel = 'stylesheet'" href="{{ asset('css/custom_splash.css') }}">
    <link rel="preload" as="style" onload="this.rel = 'stylesheet'" href="{{ asset('css/main-styles-splash.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/landing.css') }}?id=110520201320">
    
    <!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/613a184dd326717cb68098c7/1ff5etrl3';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->
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
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MJX4LDW" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="app" v-resize="onResize">

        <v-app light>
            <s-header :user="{{ json_encode(\Illuminate\Support\Facades\Auth::user())}}" :guest="{{json_encode(\Illuminate\Support\Facades\Auth::guest())}}" :categories="{{json_encode(\App\Services\WhiteLabel::config('user')->categories)}}" :abilities="{{json_encode(\App\Http\Controllers\FrontController::abilities())}}" :specialties="{{json_encode(\App\Http\Controllers\FrontController::specialties())}}" :country_all="{{json_encode(\App\Http\Controllers\FrontController::countries_all())}}" redeem="true" :home="{{json_encode($home ?? null)}}" :styles="{{json_encode(\App\Http\Controllers\FrontController::styles())}}" :tools="{{json_encode(\App\Http\Controllers\FrontController::tools())}}"></s-header>
            <div class="container--fluid p-0">
                @yield('content')
            </div>
            <div class="container--fluid p-0">
                <p-footer :guest="{{json_encode(\Illuminate\Support\Facades\Auth::guest())}}"></p-footer>
            </div>
        </v-app>

    </div>

</body>

</html>