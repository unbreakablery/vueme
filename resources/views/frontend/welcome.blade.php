@extends('layouts.app_splash')

@section('content')
    <splash-top></splash-top>
    <div class="container-fluid home_ad text-center">
        <div class="container  p-5">
            <div class="row">
                <div class="col-12 p-lg-5">
                    <h3 class="white--text">At home, on your mobile or anywhere in the world – Sexy1on1 works wherever you do. Start making real money and turn your side hustle into game-changing income.</h3>

                </div>

            </div>
        </div>
    </div>
    <div class="container-fluid how_it_works text-center">
        <div class="container  pt-5">
            <div class="row my-5 py-5">
                <div class="col-12 mb-5 mt-5">
                    <h2 class="">HOW IT WORKS</h2>

                </div>
                <div class="col-lg-4 col-12">
                    <p class="py-5">Step 1</p>
                    <img src="{{ env('APP_URL') }}/images/icons/Group_890.png">
                    <p class="p-5">Sign Up Now</p>
                </div>
                <div class="col-lg-4 col-12">
                    <p class="py-5">Step 2</p>
                    <img src="{{ env('APP_URL') }}/images/icons/Group_4228.png">
                    <p class="p-5">Interact with fans safely and securely via Talk, Text and Video Chat</p>
                </div>
                <div class="col-lg-4 col-12">
                    <p class="py-5">Step 3</p>
                    <img src="{{ env('APP_URL') }}/images/icons/Group_4229.png">
                    <p class="p-5">Get Paid</p>
                </div>

            </div>
        </div>
    </div>

    <div class="container-fluid why_join p-0">
        <div class="container  pt-5 pb-5">
            <div class="row mt-5 py-5">
                <div class="col-12 mb-5 mt-5 text-center">
                    <h2 class="">WHY JOIN</h2>

                </div>

                <div class="col-12 mb-5 mt-5">
                   <v-card>
                       <v-list-item>
                           <div class="p-3 m-0 head text-center"
                                   size="auto"
                                   tile
                                   two-line
                           >
                               <v-list-item-title
                                       class="headline mb-2"

                               ><img src="{{ env('APP_URL') }}/images/icons/Path_1092.png"/></v-list-item-title>

                               <v-list-item-title v-if="$vuetify.breakpoint.mdAndUp"> <p>Interact & <br>Get Paid</p></v-list-item-title>


                           </div>
                           <v-card-text class="pl-lg-5 p-3">Every interaction with fans = money in your pocket. After a quick and easy sign-up, fans can browse your profile and you can start earning.</v-card-text>


                       </v-list-item>

                   </v-card>
                </div>
                <div class="col-12 mb-5 mt-5">
                    <v-card>
                        <v-list-item>
                            <div class="p-3 m-0 head text-center"
                                 size="auto"
                                 tile
                                 two-line
                            >
                                <v-list-item-title
                                        class="headline mb-2"

                                ><img src="{{ env('APP_URL') }}/images/icons/Group_949.png"/></v-list-item-title>

                                <v-list-item-title v-if="$vuetify.breakpoint.mdAndUp"> <p>Total <br>Flexibility</p></v-list-item-title>


                            </div>
                            <v-card-text class="pl-lg-5 p-3">Log on where and when it works for you. Period. No minimum hours or set schedule to keep you tied down.</v-card-text>


                        </v-list-item>

                    </v-card>
                </div>
                <div class="col-12 mb-5 mt-5">
                    <v-card>
                        <v-list-item>
                            <div class="p-3 m-0 head text-center"
                                 size="auto"
                                 tile
                                 two-line
                            >
                                <v-list-item-title
                                        class="headline mb-2"

                                ><img src="{{ env('APP_URL') }}/images/icons/Group-1.png"/></v-list-item-title>

                                <v-list-item-title v-if="$vuetify.breakpoint.mdAndUp"> <p>Get Discovered<br> Easier</p></v-list-item-title>


                            </div>
                            <v-card-text class="pl-lg-5 p-3">The marketing and advertising is on us. We’re constantly sending all new admirers to the site every day - that means new, international fans for you and unlimited opportunities to earn.</v-card-text>


                        </v-list-item>

                    </v-card>
                </div>
                <div class="col-12 mb-5 mt-5">
                    <v-card>
                        <v-list-item>
                            <div class="p-3 m-0 head text-center"
                                 size="auto"
                                 tile
                                 two-line
                            >
                                <v-list-item-title
                                        class="headline mb-2"

                                ><img src="{{ env('APP_URL') }}/images/icons/Group_951.png"/></v-list-item-title>

                                <v-list-item-title v-if="$vuetify.breakpoint.mdAndUp"> <p>Your Profile,<br> Your Rules</p></v-list-item-title>


                            </div>
                            <v-card-text class="pl-lg-5 p-3">Our models have the freedom to choose how they want to interact with admirers. Talk, text, or video chat – plus the option to include a custom subscription fee so you can start earning without doing a thing.</v-card-text>


                        </v-list-item>

                    </v-card>
                </div>
                <div class="col-12 mb-5 mt-5">
                    <v-card>
                        <v-list-item>
                            <div class="p-3 m-0 head text-center"
                                 size="auto"
                                 tile
                                 two-line
                            >
                                <v-list-item-title
                                        class="headline mb-2"

                                ><img src="{{ env('APP_URL') }}/images/icons/Group_931.png"/></v-list-item-title>

                                <v-list-item-title v-if="$vuetify.breakpoint.mdAndUp"> <p>Easy to Use<br> Platform</p></v-list-item-title>


                            </div>
                            <v-card-text class="pl-lg-5 p-3">It’s all here. We handle your marketing, manage payment processing, customer support and website maintenance so you can focus on what’s most important – getting paid.</v-card-text>


                        </v-list-item>

                    </v-card>
                </div>
                <div class="col-12 mb-5 mt-5">
                    <v-card>
                        <v-list-item>
                            <div class="p-3 m-0 head text-center"
                                 size="auto"
                                 tile
                                 two-line
                            >
                                <v-list-item-title
                                        class="headline mb-2"

                                ><img src="{{ env('APP_URL') }}/images/icons/Group_954.png"/></v-list-item-title>

                                <v-list-item-title v-if="$vuetify.breakpoint.mdAndUp"> <p>Income<br> Boost</p></v-list-item-title>


                            </div>
                            <v-card-text class="pl-lg-5 p-3">Our clear and easy fee structure puts you in the driver’s seat of your earning potential. Start counting that extra income, boost your side hustle, or completely change your life.</v-card-text>


                        </v-list-item>

                    </v-card>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid the_platform text-center">
        <div class="container  pt-5">
            <div class="row mt-5 pt-5">
                <div class="col-12 mb-5 mt-5">
                    <h2 class="">THE PLATFORM</h2>
                    <p>Simple and Easy-To-Use</p>
                    <p><img src="{{ env('APP_URL') }}/images/Group-4230.png" class="img-fluid" /></p>
                </div>


            </div>
        </div>
    </div>
<splash-section-6></splash-section-6>
@endsection
