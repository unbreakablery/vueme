@extends('layouts.app_splash')

@section('content')
<splash-top></splash-top>
<section class="thirdSectionHeading">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="thirdSectionHeadingContainer">
                    <h2>Respectfully is a favorite guilty pleasure for our users. Provide interactive live action and intimate private shows as one of the sexiest models from around the globe. It’s no secret, Respectfully fans can’t wait to see its models.</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="fourColSection">
    <div class="container text-center">
        <div class="row">
            <div class="col">
                <h3 class="m-5">How It Works</h3>
                <div class="fourColContainer">

                    <div class="fourColItem">
                        <p><b>Step 1</b></p>
                        <div class="iconContainer">
                            <img src="{{ env('APP_URL') }}/images/icons/1115.svg" alt="Sign up" class="img-fluid">
                        </div>
                        <p>Apply</p>
                    </div>
                    <div class="fourColItem">
                        <p><b>Step 2</b></p>
                        <div class="iconContainer">
                            <img src="{{ env('APP_URL') }}/images/icons/1116.svg" alt="Browse" class="img-fluid">
                        </div>
                        <p>Verify your account & create a profile</p>
                    </div>
                    <div class="fourColItem">
                        <p><b>Step 3</b></p>
                        <div class="iconContainer">
                            <img src="{{ env('APP_URL') }}/images/icons/1117.svg" alt="Discover" class="img-fluid">
                        </div>
                        <p>Start Live streaming or attracting clients via private sessions</p>
                    </div>
                    <div class="fourColItem">
                        <p><b>Step 4</b></p>
                        <div class="iconContainer">
                            <img src="{{ env('APP_URL') }}/images/icons/1118.svg" alt="Advice" class="img-fluid">
                        </div>
                        <p>Get Paid</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="thirdSection">
    <div class="container-fluid why_join p-0">
        <div class="container  pt-5 pb-5">
            <div class="row mt-lg-5 py-lg-5">
                <div class="col-12 mb-5 mt-5 text-center">
                    <h3 class="">Why Join</h3>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-4 col-sm-12 mb-5 mt-5 d-flex px-5">
                        <v-card style="border-radius: 8px!important;">
                            <div class="p-3 m-0 head text-center" size="auto" tile two-line>
                                <v-list-item-title class="headline mb-2">
                                    <img src="{{ env('APP_URL') }}/images/icons/1119.svg"/>
                                </v-list-item-title>
                                <v-list-item-title v-if="$vuetify.breakpoint.mdAndUp"> <p class="p-card-text">Monetize<br>Interactions</p></v-list-item-title>
                                <v-card-text >Clients pay to interact via live-streaming, private sessions, monthly subscriptions, tipping, or a-la-carte purchasing.</v-card-text>
                            </div>
                        </v-card>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-5 mt-5 d-flex px-5">
                        <v-card style="border-radius: 8px!important;">
                            <div class="p-3 m-0 head text-center" size="auto" tile two-line>
                                <v-list-item-title class="headline mb-2">
                                    <img src="{{ env('APP_URL') }}/images/icons/1120.svg"/>
                                </v-list-item-title>
                                <v-list-item-title v-if="$vuetify.breakpoint.mdAndUp"> <p class="p-card-text">Client Base<br>Growth</p></v-list-item-title>
                                <v-card-text >Get discovered automatically through live search and category filters.</v-card-text>
                            </div>
                        </v-card>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-5 mt-5 d-flex px-5">
                        <v-card style="border-radius: 8px!important;">
                            <div class="p-3 m-0 head text-center" size="auto" tile two-line>
                                <v-list-item-title class="headline mb-2">
                                    <img src="{{ env('APP_URL') }}/images/icons/1121.svg"/>
                                </v-list-item-title>
                                <v-list-item-title v-if="$vuetify.breakpoint.mdAndUp"> <p class="p-card-text">Completely<br>Customizable</p></v-list-item-title>
                                <v-card-text >Set your pricing for any aspect of your content from subscription costs, replay purchases and private sessions. </v-card-text>
                            </div>
                        </v-card>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-5 mt-5 d-flex px-5">
                        <v-card style="border-radius: 8px!important;">
                            <div class="p-3 m-0 head text-center" size="auto" tile two-line>
                                <v-list-item-title class="headline mb-2">
                                    <img src="{{ env('APP_URL') }}/images/icons/1122.svg"/>
                                </v-list-item-title>
                                <v-list-item-title v-if="$vuetify.breakpoint.mdAndUp"> <p class="p-card-text">Marketing<br>Managed</p></v-list-item-title>
                                <v-card-text >We handle the advertising to drive potential new clients to your page.</v-card-text>
                            </div>
                        </v-card>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-5 mt-5 d-flex px-5">
                        <v-card style="border-radius: 8px!important;">
                            <div class="p-3 m-0 head text-center" size="auto" tile two-line>
                                <v-list-item-title class="headline mb-2">
                                    <img src="{{ env('APP_URL') }}/images/icons/1123.svg"/>
                                </v-list-item-title>
                                <v-list-item-title v-if="$vuetify.breakpoint.mdAndUp"> <p class="p-card-text">Logistics<br>Handeled</p></v-list-item-title>
                                <v-card-text >We manage payment processing, customer support and website maintenance.</v-card-text>
                            </div>
                        </v-card>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




<div class="container-fluid the_platform text-center">
    <div class="container  pt-5">
        <div class="row mt-5 pt-5">
            <div class="col-12 mb-5 mt-5">
                <h3 class="">The Platform</h3>
                <p>Simple and easy to-Use</p>
                <p><img src="{{ env('APP_URL') }}/images/icons/4283.png" class="img-fluid" /></p>
            </div>


        </div>
    </div>
</div>

<splash-section-6></splash-section-6>


@endsection
