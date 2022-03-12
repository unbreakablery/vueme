<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   
    
    <meta charset="utf-8">
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="theme-color" content="#9759FF">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <script  src="{{ asset('backend/js/app.js') }}?id=110520201320" defer></script>

    <!-- Web Manifest -->
    <link rel="manifest" href="{{ env('APP_URL') }}/manifest.json">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('backend/css/app.css') }}?id=110520201320">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}?id=110520201320">
    <link rel="stylesheet" href="{{ asset('css/custom-dashboard.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/app.css') }}?id=110520201320">
    <link rel="stylesheet"  href="{{ asset('css/main-styles.css') }}?id=110520201320">
    <link rel="stylesheet" href="{{ asset('frontend/css/landing.css') }}?id=110520201320">
    <!--Start of Tawk.to Script-->
    
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

    <script rel="preload" as="script" src="https://static.opentok.com/v2/js/opentok.min.js" defer></script>
    
</head>

<body class="body-dashboard">
    
    <div id="app">
        <div id="modalVideoCall" style="position: fixed; z-index: 200000000000;"></div>
        <v-app light class="app_dashboard" v-resize="onResize" @if(Route::currentRouteName() == "dashboard_menu") style="background-color: rgb(235, 244, 253)  !important" @endif>
            <div class="container--fluid p-0">
            
                @if(Auth::user()->role_id == 1)
                    <s-header-2 :user="{{json_encode(Auth::user())}}"></s-header-2>
                @else
                    <s-header-1 :user="{{json_encode(Auth::user())}}"></s-header-1>
                @endif

                <c-message></c-message>
                
                @if(Auth::user()->role_id == 1)
                <header-space-2></header-space-2> 
                @else
                <header-space></header-space> 
                @endif
                <!-- <nav class="navbar" id="mobile-nav-2">
                    <mobile-navbar :user="{{json_encode(Auth::user())}}"></mobile-navbar>
                </nav> -->
                <!-- Collapsible content -->

                <div class='linear-layout-wrapper'>
                    {{-- <div id="dashboard-layout" class="container p-0"> --}}
                    <div id="dashboard-layout" class="container p-0" style="margin: 0px !important; max-width: 100%; min-height: 800px;">
                    @if(Auth::user()->role_id == 1)
                        <div id="sidebar_model">

                            <div id="sidebar-scroll-away" class="pb-12 model-sidebar-scroll">
                                <dashboard-sidebar-menu style="width: 268px;" :link="{{json_encode($link)}}" :user="{{json_encode(Auth::user())}}"></dashboard-sidebar-menu>
                            </div>
                        </div>
                    @else
                    <div id="sidebar">

                        <div id="sidebar-scroll-away" class="pb-10" style="position: relative;">
                            <dashboard-sidebar-menu style="width: 268px;" :link="{{json_encode($link)}}" :user="{{json_encode(Auth::user())}}"></dashboard-sidebar-menu>
                        </div>
                    </div>
                    @endif
                        <div class="d-inline-block mw-100 w-100 bg-color-grey">

                            <div class="d-flex p-0">
                                {{-- <div class="d-flex container p-0"> --}}
                                <div id="main" class="pb-0 pt-0 pl-0 "  >
                                        @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(Route::currentRouteName() !== "dashboard_notifications" && Route::currentRouteName() !== "dashboard_menu")
                    <!-- <v-footer class="fan-footer p-0">
                        <p-footer :user="{{json_encode(Auth::user())}}"></p-footer>
                    </v-footer> -->
                    <div class="container--fluid p-0">
                        <p-footer :guest="{{json_encode(\Illuminate\Support\Facades\Auth::guest())}}" :home="{{json_encode($home ?? null)}}"></p-footer>
                    </div>
                    @endif
        </v-app>
    </div>

</body>

</html>