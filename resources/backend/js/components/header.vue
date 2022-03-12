<template>
  <div>
    <div class="landing">
    
      <!-- <header-info :user="user"></header-info> -->
      <header-info :user="user"></header-info>
      
      <!-- Menubar section  -->
      <header class="header">
        
        <div class="container px-4 py-0">
          <div class="row">
            <nav class="navbar navbar-expand-lg ml-0 w-100">
              <a class="navbar-brand mobile-logo"  href="/">Respectfully</a>
              <ul class="navbar-nav">
                <li v-if="guest" class="nav-item signup-btn-box mobile-menu">
                  <a href="javascript:void(0)" @click.prevent="userSignupDialog=true" class="nav-link signup-btn">
                    Sign Up
                  </a>
                </li>
              </ul>
              <li v-if="!guest" class="mobile-menu">
                <div class="d-inline-flex mobile-menu">
                  <!-- <div>
                    <credits v-if="user.role_id===2 && $vuetify.breakpoint.smAndDown" :user="user" style="color:rgb(162, 162, 162) !important"/>
                  </div> -->
                  <toxbox-chat-notifications style="" color="black" size="27px" :user="user"></toxbox-chat-notifications>
                </div>
              </li>
              <a class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
              </a>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                
                <!-- <ul class="navbar-nav w-100 mr-auto">
                  <li v-if="guest" class="nav-item" style="order: 0"><hr></li>
                  <li v-if="!guest" class="nav-item mobile-menu"><a href="/dashboard" :class="['nav-link']"><img src="/images/icons/calendar.svg" /> Appointments</a></li>
                  <li v-if="!guest" class="nav-item mobile-menu"><a href="/dashboard/services" :class="['nav-link']"><img src="/images/icons/services_bar.svg" /> Services</a></li>
                  <li v-if="!guest" class="nav-item mobile-menu"><a href="/dashboard/replays" :class="['nav-link']"><img src="/images/icons/reviews.svg" /> Reviews</a></li>
                  <li v-if="!guest" class="nav-item mobile-menu"><a href="/dashboard/payout" :class="['nav-link']"><img src="/images/icons/moneys.svg" /> Money</a></li>
                  <li v-if="!guest" class="nav-item mobile-menu"><a href="/dashboard/analytics" :class="['nav-link']"><img src="/images/icons/analytic.svg" /> Analytics</a></li>
                  <li v-if="!guest" class="nav-item mobile-menu"><a href="https://respectfully-models.zendesk.com/hc/en-us" :class="['nav-link']"><img src="/images/icons/help.svg" /> Help</a></li>
                  <li v-if="!guest" class="nav-item mobile-menu"><a href="/dashboard/payout" :class="['nav-link']"><img src="/images/icons/moneys.svg" /> Blob</a></li>
                  <li v-if="!guest" class="nav-item mobile-menu"><a href="#" @click.prevent="logout()" style="color:rgb(162, 162, 162) !important" :class="['nav-link']"><img src="/images/icons/logout.svg" /> Logout</a></li>
                  <li v-if="!guest" class="nav-item" style="order: 1"><hr></li>
                  <li class="nav-item how-menu" style="flex-grow: 1;"><a href="/how-it-works" :class="['nav-link', (url == 'how-it-works') ? 'active' : '']">How It Works</a></li>
                  <li class="nav-item search-menu"><h-search/></li>
                  <li v-if="guest" class="nav-item become-menu"><a href="/apply" class="nav-link">Become a Model</a></li>
                  <li v-if="guest" class="nav-item login-menu"><a @click.prevent="loginDialog=true" href="#" class="nav-link">Login</a></li>
                  <li v-if="guest" class="nav-item signup-btn-box desktop-menu"><a href="javascript:void(0)" @click.prevent="userSignupDialog=true" class="nav-link signup-btn">Sign Up</a></li>
                </ul> -->
                <ul class="navbar-nav w-100 mr-auto d-flex justify-end">

                  <li v-if="guest" class="nav-item" style="order: 0"><hr></li>
                  
                  <li v-if="!guest" class="nav-item mobile-menu"><a href="/dashboard/user/profile" :class="['nav-link']"><img src="/images/model-dashboard/edit.svg" /> Edit Profile</a></li>
                  <li v-if="!guest" class="nav-item mobile-menu"><a href="/dashboard/favorites" :class="['nav-link']"><img src="/images/icons/heart icon.svg" /> Following</a></li>
                  <li v-if="!guest" class="nav-item mobile-menu"><a href="/dashboard/user/subscriptions" :class="['nav-link']"><img src="/images/model-dashboard/reviews.svg" /> Subscriptions</a></li>
                  <li v-if="!guest" class="nav-item mobile-menu"><a href="/dashboard/appointments" :class="['nav-link']"><img src="/images/icons/calendar icon.svg" /> Appointments</a></li>
                  <li v-if="!guest" class="nav-item mobile-menu"><a href="/dashboard/transaction" :class="['nav-link']"><img src="/images/model-dashboard/money-icon.svg" /> Transactions</a></li>
                  <li v-if="!guest" class="nav-item mobile-menu"><a href="/dashboard/payment" :class="['nav-link']"><img src="/images/icons/credit card icon.svg" /> Payment Method</a></li>
                  <li v-if="!guest" class="nav-item mobile-menu"><a href="/dashboard/user/replays" :class="['nav-link']"><img src="/images/model-dashboard/play.svg" /> Replays</a></li>
                  
                  <li v-if="!guest" class="nav-item feed-menu "><a href="/myfeed" :class="['nav-link']">My Feed</a></li>
                  <li v-if="!guest" class="nav-item model-menu"><a href="/models" :class="['nav-link']">Models</a></li>
                  <li v-if="!guest" class="nav-item categroy-menu "><a href="/categories" :class="['nav-link']">Categories</a></li>
                  <li v-if="!guest" class="nav-item explore-menu"><a href="/explore" :class="['nav-link']">Explore</a></li>
                  <li v-if="!guest && $vuetify.breakpoint.smAndDown" class="nav-item explore-menu"><a href="#" @click.prevent="logout()" style="color:rgb(162, 162, 162) !important" :class="['nav-link']">Logout</a></li>
                  <li v-if="!$vuetify.breakpoint.smAndDown" class="nav-item how-menu" style="flex-grow: 1;"><a href="/how-it-works" :class="['nav-link']">How It Works</a></li>
                  <li class="nav-item search-menu hidden-md-and-up"><h-search/></li>

                  <div v-if="!guest && $vuetify.breakpoint.smAndDown">
                    <credits v-if="user.role_id===2" :user="user" 
                    style="color:rgb(162, 162, 162) !important;
                            margin-top: 16px;
                            margin-bottom: -10px;
                            padding: 10px 10px 0px 10px;"/>

                    <v-btn
                      class="todo-items-btn"
                      @click="dialog=true"
                    >
                      Add Funds
                    </v-btn>

                    <hr>
                  </div>

                  <li v-if="guest" class="nav-item become-menu"><a href="/apply" class="nav-link">Become a Model</a></li>
                  <li v-if="guest" class="nav-item login-menu"><a @click.prevent="loginDialog=true" href="#" class="nav-link">Login</a></li>
                  <li v-if="guest" class="nav-item signup-btn-box desktop-menu"><a href="javascript:void(0)" @click.prevent="userSignupDialog=true" class="nav-link signup-btn">Sign Up</a></li>
                
                </ul>
                
                
                <ul v-if="user" class="right-menu desktop-menu" style="padding: 0px">
                  <!-- <li class="d-none d-lg-inline-block"><a @click.prevent="signupDialog=true" href="#">Become a Model</a></li> -->
                  <li>
                    <div class="d-inline-flex">
                        <div>
                          <credits v-if="user.role_id===2 && $vuetify.breakpoint.mdAndUp" :user="user" style="color:rgb(162, 162, 162) !important"/>
                        </div>
                        <!-- <div class="mr-2">
                        <text-chat-notifications color="black" size="27px" :user="user"></text-chat-notifications>
                        </div> -->
                        <toxbox-chat-notifications style="" color="black" size="27px" :user="user"></toxbox-chat-notifications>
                        <div v-if="$vuetify.breakpoint.smAndDown">
                          <v-btn v-if="user.role_id===1" text icon color="black" href="/dashboard/menu">
                            <img :src="dash_menu" />
                          </v-btn>

                        <v-btn
                            v-if="user.role_id===2"
                            text
                            icon
                            color="black"
                            href="/dashboard/user/menu"
                        >
                            <i class="fas fa-bars"></i>
                        </v-btn>
                        </div>

                        <v-menu
                          v-model="menu_opened"
                          v-if="!$vuetify.breakpoint.smAndDown"
                          offset-y
                          left
                          content-class="my-menu landing-popup-menu"
                          class="px-2 px-md-3 header-profile"
                        >
                          <template v-slot:activator="{ on }">
                              <a class="px-2 px-md-3" style="height: 24px" v-on="on">
                              <div
                                class="w-profile"
                                style="width: 22px; height: 22px"
                                :style="[ menu_opened ? {'background-image': 'url(/images/icons/profile.png)' } :{ 'background-image': 'url(/images/icons/profile.png)' }]"
                              ></div>
                              </a>
                          </template>
                          <v-card
                              style="border-radius:  5px !important;"
                              :min-width="300"
                              :min-height="user.role_id != 3 ? 150 : '100%'"
                          >
                              <v-list dense class v-if="user.role_id == 1">
                              <v-list-item-group color="primary">
                                  <v-list-item dense class="px-5" href="/dashboard">
                                  <v-list-item-icon>
                                      <img src="/images/icons/calendar.svg" />
                                  </v-list-item-icon>
                                  <v-list-item-content>
                                      <v-list-item-title>Appointments</v-list-item-title>
                                  </v-list-item-content>
                                  </v-list-item>

                                  <v-list-item dense class="px-5" href="/dashboard/services">
                                  <v-list-item-icon>
                                      <img src="/images/icons/services_bar.svg" />
                                  </v-list-item-icon>
                                  <v-list-item-content>
                                      <v-list-item-title>Services</v-list-item-title>
                                  </v-list-item-content>
                                  </v-list-item>

                                  <v-list-item class="px-5" href="/dashboard/replays">
                                  <v-list-item-icon>
                                      <img src="/images/icons/review.svg" />
                                  </v-list-item-icon>
                                  <v-list-item-content>
                                      <v-list-item-title>Reviews</v-list-item-title>
                                  </v-list-item-content>
                                  </v-list-item>
                                  <v-list-item class="px-5" href="/dashboard/payout">
                                  <v-list-item-icon>
                                      <img src="/images/icons/moneys.svg" />
                                  </v-list-item-icon>
                                  <v-list-item-content>
                                      <v-list-item-title>Money</v-list-item-title>
                                  </v-list-item-content>
                                  </v-list-item>
                                  <v-list-item class="px-5" href="/dashboard/analytics">
                                  <v-list-item-icon>
                                      <img src="/images/icons/analytic.svg" />
                                  </v-list-item-icon>
                                  <v-list-item-content>
                                      <v-list-item-title>Analytics</v-list-item-title>
                                  </v-list-item-content>
                                  </v-list-item>

                              <v-list-item class="px-5" href="https://respectfully-models.zendesk.com/hc/en-us"  target="_blank">
                                  <v-list-item-icon>
                                      <img src="/images/icons/help.svg"/>
                                  </v-list-item-icon>
                                  <v-list-item-content>
                                      <v-list-item-title>Help</v-list-item-title>
                                  </v-list-item-content>
                                  </v-list-item>
                                  <v-list-item class="px-5" href="/blog">
                                  <v-list-item-icon>
                                      <img src="/images/icons/blog.svg"/>
                                  </v-list-item-icon>
                                  <v-list-item-content>
                                      <v-list-item-title>Blog</v-list-item-title>
                                  </v-list-item-content>
                                  </v-list-item>
                                  <v-list-item class="px-5" @click.prevent="logout()" dense>
                                  <v-list-item-icon>
                                      <img src="/images/icons/logout.svg" />
                                  </v-list-item-icon>
                                  <v-list-item-content>
                                      <v-list-item-title style="color:#42424d60 !important">Log Out</v-list-item-title>
                                  </v-list-item-content>
                                  </v-list-item>
                              </v-list-item-group>
                              </v-list>
                              <v-list dense class v-else-if="user.role_id == 2">
                              <v-list-item-group color="primary">
                                <v-list-item class="px-5" href="/dashboard/user/profile">
                                  <v-list-item-icon>
                                      <img src="/images/icons/edit icon.svg" />
                                  </v-list-item-icon>
                                  <v-list-item-content>
                                      <v-list-item-title><p>Edit Profile</p></v-list-item-title>
                                  </v-list-item-content>
                                  </v-list-item>
                                  <v-list-item class="px-5" href="/dashboard/favorites">
                                  <v-list-item-icon>
                                      <img src="/images/icons/heart icon.svg" />
                                  </v-list-item-icon>
                                  <v-list-item-content>
                                      <v-list-item-title><p>Following</p></v-list-item-title>
                                  </v-list-item-content>
                                  </v-list-item>
                                  <v-list-item class="px-5" href="/dashboard/user/subscriptions">
                                  <v-list-item-icon>
                                      <img src="/images/model-dashboard/reviews.svg" />
                                  </v-list-item-icon>
                                  <v-list-item-content>
                                      <v-list-item-title><p>Subscriptions</p></v-list-item-title>
                                  </v-list-item-content>
                                  </v-list-item>
                                  <v-list-item class="px-5" href="/dashboard/appointments">
                                  <v-list-item-icon>
                                      <img src="/images/icons/calendar icon.svg" />
                                  </v-list-item-icon>
                                  <v-list-item-content>
                                      <v-list-item-title><p>Appointments</p></v-list-item-title>
                                  </v-list-item-content>
                                  </v-list-item>
                                  <v-list-item class="px-5" href="/dashboard/transaction">
                                  <v-list-item-icon>
                                      <img src="/images/icons/money icon.svg" />
                                  </v-list-item-icon>
                                  <v-list-item-content>
                                      <v-list-item-title><p>Transactions</p></v-list-item-title>
                                  </v-list-item-content>
                                  </v-list-item>
                                  <v-list-item class="px-5" href="/dashboard/payment">
                                  <v-list-item-icon>
                                      <img src="/images/icons/credit card icon.svg" />
                                  </v-list-item-icon>
                                  <v-list-item-content>
                                      <v-list-item-title><p>Payment Method</p></v-list-item-title>
                                  </v-list-item-content>
                                  </v-list-item>

                                  <v-list-item dense class="px-5" href="/dashboard/user/replays">
                                  <v-list-item-icon>
                                      <img src="/images/icons/play icon.svg" />
                                  </v-list-item-icon>
                                  <v-list-item-content>
                                      <v-list-item-title><p>Replays</p></v-list-item-title>
                                  </v-list-item-content>
                                  </v-list-item>
                                  <v-list-item
                                  class="px-5"
                                  @click.prevent="logout()"
                                  dense
                                  >
                                  <v-list-item-icon>
                                      <img src="/images/icons/logout.svg" />
                                  </v-list-item-icon>
                                  <v-list-item-content>
                                      <v-list-item-title><p style="color:#42424d60 !important">Log Out</p></v-list-item-title>
                                  </v-list-item-content>
                                  </v-list-item>
                              </v-list-item-group>
                              </v-list>
                              <v-list dense class v-else-if="user.role_id == 3 || user.role_id == 4 || user.role_id == 7">
                              <v-list-item-group color="primary">
                                  <v-list-item
                                  class="px-5"
                                  link
                                  href="/admin"
                                  dense
                                  style="text-decoration: none"
                                  >
                                  <v-list-item-icon>
                                      <!-- <i class="fas fa-power-off mt-1"></i> -->
                                  </v-list-item-icon>
                                  <v-list-item-content>
                                      <v-list-item-title>Admin dashboard</v-list-item-title>
                                  </v-list-item-content>
                                  </v-list-item>

                                  <v-list-item class="px-5" @click.prevent="logout()" dense>
                                  <v-list-item-icon>
                                      <img src="/images/icons/logout.svg" />
                                  </v-list-item-icon>
                                  <v-list-item-content>
                                      <v-list-item-title style="color:#42424d60!important">Log Out</v-list-item-title>
                                  </v-list-item-content>
                                  </v-list-item>
                              </v-list-item-group>
                              </v-list>
                          </v-card>
                        </v-menu>
                    </div>
                  </li>
                </ul>
              </div>
            </nav>
          </div>
        </div>
      </header>

      <!-- <div v-if="user && $vuetify.breakpoint.smAndDown" style="height:80px !important"></div> -->

      <nav
        class="navbar"
        style="max-height: 60px; height: 60px;"
        v-if="user && $vuetify.breakpoint.smAndDown"
        id="mobile-nav"
      >
        <v-row>
          <v-col v-if="user.role_id===1" :md="4" class="text-center">
            <v-btn text icon color="white" href="/dashboard">
              <img :src="dash_app" width="40px" />
            </v-btn>
          </v-col>
          <v-col v-if="user.role_id===2" :md="4" class="text-center">
            <v-btn text icon color="white" href="/dashboard/appointments">
              <img :src="dash_app" width="40px" />
            </v-btn>
          </v-col>
          <v-col :md="4" class="text-center">
            <text-chat-notifications color="white" :user="user"></text-chat-notifications>
          </v-col>
          <v-col :md="4" class="text-center">
            <toxbox-chat-notifications color="white" :user="user"></toxbox-chat-notifications>
          </v-col>
          <v-col v-if="user.role_id===1" :md="4" class="text-center">
            <v-btn text icon color="white" href="/dashboard/menu">
              <img :src="dash_menu" />
            </v-btn>
          </v-col>
          <v-col v-if="user.role_id===2" :md="4" class="text-center">
            <v-btn text icon color="white" href="/dashboard/user/menu">
              <img :src="dash_menu" />
            </v-btn>
          </v-col>
            <!-- <credits style="display:none" v-if="user.role_id===2" :user="user" class="mt-2" /> -->
        </v-row>
      </nav>

      <!-- Becaomme a model -->
      <v-dialog
        v-if="signupDialog"
        v-model="signupDialog"
        width="375"
        :content-class="(step == 4 || step == 5) ? ' top-modal' : ''"
      >
        <v-card style="background:#fff !important;border-radius:30px!important ">
          <v-card-text class="p-0">
            <div class="row m-0">
              <div class="col-12 text-right mt-6 pr-6">
                <v-icon class="text-right" @click="signupDialog=false">mdi-close</v-icon>
              </div>

              <div class="col-12 px-3">
                <div class="card-body px-0 pt-4">
                  <form method="POST" action class="registration_form">
                    <div v-if="step == 1">
                      <div class="form-row mb-5">
                        <div class="form-row m-0">
                          <div
                          style="font-size:18px;color:#131220;font-weight: 600; text-align: center;"
                          >Are you Ready to Become a Model? Create Your Free Account Now</div>
                        </div>
                      </div>
                      <div class="form-row mb-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-4 pr-0" style="font-size:12px!important;color:#131220!important"
                        >
                          Display Name <span class="text-danger" style="font-size:14px;">*</span>
                            
                        </label>
                        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 mb-5">
                          <v-text-field
                            label=""
                            placeholder="Display Name"
                            v-model="newuser.display_name"
                            hide-details
                            flat
                            height="40"
                            solo
                            class="inputClass1"
                          >
                          </v-text-field>
                            <span class="text-danger" style="font-size:12px;">
                            <span  v-if="errors.display_name">{{ errors.display_name[0] }}</span>
                            </span>
                        </div>
                      </div>
                      <div class="form-row mb-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-4 pr-0" style="font-size:12px!important;color:#131220!important"
                        >
                          Email <span class="text-danger" style="font-size:14px;">*</span>
                        </label>

                        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 mb-5">
                            <v-text-field
                              label=""
                              placeholder="Email"
                              v-model="newuser.email"
                              hide-details
                              flat
                              height="40"
                              solo
                              class="inputClass1"
                            >
                              
                            </v-text-field>
                            <span class="float-right text-danger" style="font-size:12px">
                            <span  v-if="errors.email">{{ errors.email[0] }}</span>
                            </span>
                        </div>
                      </div>
                      <div class="form-row mb-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-4 pr-0" style="font-size:12px!important;color:#131220!important"
                        >
                          Password <span class="text-danger" style="font-size:14px;">*</span>
                        </label>
                        <div class="col-md-12 col-12 col-sm-12 col-lg-12 mb-5">
                          <v-text-field
                            label=""
                            placeholder="Password"
                            v-model="newuser.password"
                            hide-details
                            flat
                            height="40"
                            solo
                            type="password"
                            
                            class="inputClass1"
                          >
                          </v-text-field>
                          <div class="d-flex justify-content-between">
                            <ul style="padding-left: 15px;" class="mb-0">
                              <li 
                                class="required-text"
                                :style="[
                                      newuser.password
                                        ? newuser.password.match(regexSix)
                                          ? { color: '#2CC05F' }
                                          : errors.password
                                          ? { color: '#DB4242' }
                                          : { color: '#97999D' }
                                        : { color: '#97999D' },
                                    ]"
                              >
                                At least 6 characters
                              </li>
                              <li
                              style="margin-top:4px !important;"
                              :style="[
                                      newuser.password
                                        ? newuser.password.match(regexChar)
                                          ? { color: '#2CC05F' }
                                          : errors.password
                                          ? { color: '#DB4242' }
                                          : { color: '#97999D' }
                                        : { color: '#97999D' },
                                    ]"
                               class="required-text">
                                Has a symbol !@#$%^&*
                              </li>
                            </ul>
                            <ul style="padding-left: 15px;" class="mb-0">
                              <li class="required-text"
                                 :style="[
                                      newuser.password
                                        ? newuser.password.match(regexUpper)
                                          ? { color: '#2CC05F' }
                                          : errors.password
                                          ? { color: '#DB4242' }
                                          : { color: '#97999D' }
                                        : { color: '#97999D' },
                                    ]"                              
                              >
                                Has an uppercase letter
                              </li>
                              <li          
                              style="margin-top:4px !important;"                    
                              :style="[
                                      newuser.password
                                        ? newuser.password.match(regexNumber)
                                          ? { color: '#2CC05F' }
                                          : errors.password
                                          ? { color: '#DB4242' }
                                          : { color: '#97999D' }
                                        : { color: '#97999D' },
                                    ]"
                              class="required-text">
                                Has a number
                              </li>
                            </ul>
                          </div>
                          <span class="float-right text-danger"  style="font-size:12px">
                            <span v-if="errors.password">{{ errors.password[0] }}</span>
                          </span>
                        </div>
                      </div>
                      
                      <div class="form-row mb-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-4 pr-0" style="font-size:12px!important;color:#131220!important"
                        >
                          Confirm Password <span class="text-danger" style="font-size:14px;">*</span>
                        </label>
                        <div class="col-md-12 col-12 col-sm-12 col-lg-12 mb-5">
                          <v-text-field
                            label=""
                            placeholder="Confirm Password"
                            v-model="newuser.c_password"
                            hide-details
                            flat
                            height="40"
                            solo
                            type="password"                            
                            class="inputClass1"
                          >
                          </v-text-field>
                          <div class="d-flex justify-content-between">
                            <ul style="padding-left: 15px;" class="mb-0">
                              <li
                              :style="[
                               newuser.c_password
                                ? newuser.c_password.match(regexSix)
                                ? { color: '#2CC05F' }
                                : errors.c_password
                                ? { color: '#DB4242' }
                                : { color: '#97999D' }
                                : { color: '#97999D' },
                              ]"
                              class="required-text">
                                At least 6 characters
                              </li>
                              <li   
                                  style="margin-top:3px !important;"
                                  :style="[
                                      newuser.c_password
                                        ? newuser.c_password.match(regexChar)
                                          ? { color: '#2CC05F' }
                                          : errors.c_password
                                          ? { color: '#DB4242' }
                                          : { color: '#97999D' }
                                        : { color: '#97999D' },
                                    ]"                      
                              class="required-text">
                                Has a symbol !@#$%^&*
                              </li>
                            </ul>
                            <ul style="padding-left: 15px;" class="mb-0">
                              <li
                              :style="[
                                newuser.c_password
                                ? newuser.c_password.match(regexUpper)
                                ? { color: '#2CC05F' }
                                : errors.c_password
                                ? { color: '#DB4242' }
                                : { color: '#97999D' }
                                : { color: '#97999D' },
                               ]"  
                               class="required-text">
                                Has an uppercase letter
                              </li>
                              <li 
                              style="margin-top:3px !important;"
                              :style="[
                               newuser.c_password
                               ? newuser.c_password.match(regexNumber)
                               ? { color: '#2CC05F' }
                               : errors.c_password
                               ? { color: '#DB4242' }
                               : { color: '#97999D' }
                               : { color: '#97999D' },
                              ]"
                              class="required-text">
                                Has a number
                              </li>
                            </ul>
                          </div>
                          <span class="float-right text-danger"  style="font-size:12px">
                            <span   v-if="errors.c_password">{{ errors.c_password[0] }}</span>
                          </span>
                        </div>
                      </div>

                      <div class="form-row mb-3">
                        <div class="col-md-12 col-12 col-sm-12 col-lg-12 mb-0 mt-0">
                          <div class="form-row m-0">
                            <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">
                              <v-checkbox
                                class="float-left age"
                                style="display: inline-block;"
                                v-model="newuser.age"
                                hide-details
                              >
                                
                              </v-checkbox>
                              <label style="width: 88%;font-size: 12px !important;color:#1F1E34 !important;font-weight: 400;line-height:18pt;">
                                You consent to receive SMS messages from Respectfully to provide updates on your account and/or for marketing purposes. You will receive up to 5 promotional messages a month. Reply “STOP” to cancel at any time. Message and data rates apply.
                              </label>
                            </div>
                            <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">
                              <span v-if="errors.age" class="text-danger float-right" style="font-size:12px">{{ errors.age[0] }}</span>
                            </div>
                            <div
                              v-if="errors.spam"
                              class="mt-3 col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0"
                            >
                              <span class="text-danger float-right" style="font-size:12px">{{ errors.spam[0] }}</span>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-row justify-content-center mb-0 mt-0">
                        <v-btn  class="btn-action" 
                          href="javascript:void(0)"
                          :loading="loading"
                          :disabled="loading"
                          @click="step1()"
                        >
                          Join As Model
                        </v-btn>
                      </div>
                      <div class="form-row justify-content-center mb-0 mt-5">

                        <a style="color: #8EbEF8; font-size: 12px !important;color:#1F1E34 !important;font-weight: 400;line-height:18pt;" target="_blank"
                          href="javascript:void(0)"
                        >Already a member?</a>
                        <span class="text-danger" style="margin-left:10px;font-size: 12px !important;font-weight: 400;line-height:18pt;"
                          :loading="loading"
                          :disabled="loading"
                          @click="login()"
                        >Login Here</span>
                      </div>
                    </div> 
                    <div v-if="step == 2">
                      <div class="form-row mb-5 justify-content-center">
                        <div class="form-row m-0">
                          <div
                          style="font-size:18px;color:#131220;font-weight: 600; text-align: center;"
                          >Complete Your Account</div>
                        </div>
                      </div>
                      <div class="form-row mb-0">
                        <label class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-4 pr-0" style="font-size:12px!important;color:#131220!important">
                          Legal Name <span class="text-danger" style="font-size:14px;">*</span>
                        </label>
                        <div class="d-flex col-md-12 col-xs-12 col-sm-12 col-lg-12 mb-5">
                          <div style="padding-right: 10px;">
                            <v-text-field
                            label=""
                            placeholder="First Name"
                            v-model="newuser.name"
                            hide-details
                            flat
                            height="40"
                            solo
                            class="inputClass1"
                            >
                            </v-text-field>
                            <span class="text-danger" style="font-size:12px;">
                              <span  v-if="errors.name">{{ errors.name[0] }}</span>
                            </span>
                          </div>
                          <div style="padding-left: 10px;">
                            <v-text-field
                              label=""
                              placeholder="Last Name"
                              v-model="newuser.last_name"
                              hide-details
                              flat
                              height="40"
                              solo
                              class="inputClass1"
                            >
                            </v-text-field>
                            <span class="text-danger" style="font-size:12px;">
                            <span  v-if="errors.last_name">{{ errors.last_name[0] }}</span>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="form-row mb-0">
                        <label class="col-md-6 col-xs-6 col-sm-6 col-lg-6 control-label pl-4 pr-0" style="font-size:12px!important;color:#131220!important">
                          Country Code <span class="text-danger" style="font-size:14px;">*</span>
                        </label>
                        <label class="col-md-6 col-xs-6 col-sm-6 col-lg-6 control-label pl-4 pr-0" style="font-size:12px!important;color:#131220!important">
                          Mobile <span class="text-danger" style="font-size:14px;">*</span>
                        </label>
                        <div class="row mb-4">
                          <div class="col-md-6" style="padding-right:10px !important;">
                            <v-select
                              v-model="newuser.code"
                              :items="country_all"
                              disabled
                              item-text="country"
                              item-value="id"
                              label="Select"
                              filled
                              background-color="#FFFFFF"
                              class="whiteCheckList"
                              :menu-props="{contentClass: 'checkList-lineGrey'}"
                              dense
                              solo
                              :height="40"
                            >
                            <template
                              slot="selection"
                              slot-scope="data"
                            ><span style="font-size:14px!important;color: rgba(0, 0, 0, 0.87)!important;">{{data.item.code2}} (+ {{data.item.prefix}} )</span></template>
                            <template
                              slot="item"
                              slot-scope="data"
                            >{{data.item.country}} (+ {{data.item.prefix}} )</template>
                            </v-select>
                            <span
                              v-if="errors.code"
                              class="float-left text-danger" style="font-size:12px"
                            >{{ errors.code[0] }}</span>
                          </div>
                          <div class="col-md-6" style="padding-left:10px !important;">
                            <v-text-field
                              label=""
                              placeholder="Mobile"
                              v-model="newuser.number"
                              hide-details
                              flat
                              height="40"
                              solo                            
                              class="inputClass1"
                            >
                            </v-text-field>
                            <span class="float-right text-danger" style="min-height:25px;font-size:12px">
                              <span   v-if="errors.number">{{ errors.number[0] }}</span>
                            </span>
                          </div>
                        </div>
                        <div class="d-flex justify-content-between">
                          <ul style="padding: 0px 15px;" class="mb-0">
                            <li class="required-text-step-2">
                              "Your number will only be used to let you know when a fan is trying to reach you"
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="form-row mt-5">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-4 pr-0" style="font-size:12px!important;color:#131220!important"
                        >
                          I was Referred by <span class="text-danger" style="font-size:14px;"></span>
                        </label>

                        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 mb-5">
                            <v-text-field
                              label=""
                              placeholder="N/A"
                              v-model="newuser.referral"
                              hide-details
                              flat
                              height="40"
                              solo
                              class="inputClass1"
                            >
                              
                            </v-text-field>
                            <span class="float-right text-danger" style="font-size:12px">
                            <span  v-if="errors.referral">{{ errors.referral[0] }}</span>
                            </span>
                        </div>
                      </div>
                      <div class="form-row mb-3">
                        <label class="col-12 control-label mb-0" style="font-size:12px!important;color:#131220!important">
                          Select All That Apply
                        </label>
                        
                        <div
                          class="col-md-6 col-12 col-lg-6 pr-lg-0 checks"
                          :key="index"
                          v-for="(item, index) in this.categories"
                        >
                          <v-checkbox
                          :disabled="newuser.categories.length >2000 && newuser.categories.indexOf(index+1) == -1"
                            v-model="newuser.categories"
                            :label="item.name"
                            :value="item.id"
                            color="primary"
                            dense
                            hide-details
                          ></v-checkbox>
                        </div>
                        <span
                          v-if="errors.categories"
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 float-left text-danger" style="font-size:12px"
                        >{{ errors.categories[0] }}</span>
                      </div>

                      <div class="form-row mb-3">
                        <label class="col-12 control-label mb-0" style="font-size:12px!important;color:#131220!important; margin-bottom: 10px !important;">
                          Identity Verification
                        </label>
                        <div class="d-flex justify-content-between">
                          <ul style="padding: 0px 15px;" class="mb-0">
                            <li class="required-text-step-2">
                              We require you to verify your identity by scanning your Driver’s License and a selfie photo. This is to ensure that any models on our site are at least 18 years old. Don’t worry, your information is secure and will never be shared with anyone.
                            </li>
                          </ul>
                        </div>
                      </div>

                      <div class="form-row mb-3">
                        <label class="col-12 control-label mb-0" style="font-size:12px!important;color:#131220!important; margin-bottom: 10px !important;">
                          Scan License <span class="text-danger" style="font-size:14px;">*</span>
                        </label>
                        <div class="d-flex justify-content-between">
                          <div class="" style="padding: 0px 24px 0px 15px;">
                            <input
                            style="display: none"
                            ref="governmentIssuedInputFile"
                            type="file"
                            @change="setGovernmentIssued"
                            accept="image/*"
                            />
                            <svg v-if="!governmentIssuedFilePath" style="cursor:pointer;" @click="$refs.governmentIssuedInputFile.click()" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="120" height="120" viewBox="0 0 120 120">
                              <defs>
                                <pattern id="pattern" preserveAspectRatio="xMidYMid slice" width="100%" height="100%" viewBox="0 0 834 834">
                                  <image width="834" height="834" xlink:href="data:image/png;base64,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"/>
                                </pattern>
                              </defs>
                              <g id="Group_26000" data-name="Group 26000" transform="translate(-742 -1615)">
                                <g id="Teacher_ID_Empty_State" data-name="Teacher ID, Empty State" transform="translate(742 1615)">
                                  <rect id="VUEME_AVATARS_TEACHER_ID_EMPTY_copy" data-name="VUEME_AVATARS_TEACHER_ID_EMPTY copy" width="120" height="120" rx="6" fill="url(#pattern)"/>
                                </g>
                              </g>
                            </svg>
                            <img
                              v-else
                              :src="governmentIssuedFilePath"
                              alt="diploma"
                              width="120"
                              height="120"
                              style="cursor: pointer"
                              @click="$refs.governmentIssuedInputFile.click()"
                             />
                          </div>
                          <div class="d-flex align-self-center">
                            <a class="btn-upload" 
                              @click="$refs.governmentIssuedInputFile.click()"
                            >
                              Upload
                            </a>
                          </div>
                        </div>
                      </div>

                      <div class="form-row mb-5">
                        <label class="col-12 control-label mb-0" style="font-size:12px!important;color:#131220!important; margin-bottom: 10px !important;">
                          Selfie Photo <span class="text-danger" style="font-size:14px;">*</span>
                        </label>
                        <div class="d-flex justify-content-between">
                          <div class="" style="padding: 0px 24px 0px 15px;">
                           <input
                           style="display: none"
                           ref="faceInputFile"
                           type="file"
                           @change="setFace"
                           accept="image/*"
                           />
                            <svg v-if="!faceFilePath" @click="$refs.faceInputFile.click()" style="cursor:pointer" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="120" height="120" viewBox="0 0 120 120">
                              <defs>
                                <pattern id="pattern" preserveAspectRatio="xMidYMid slice" width="100%" height="100%" viewBox="0 0 200 200">
                                  <image width="200" height="200" xlink:href="data:image/png;base64,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"/>
                                </pattern>
                              </defs>
                              <rect id="selfie" width="120" height="120" rx="6" fill="url(#pattern)"/>
                            </svg>                            
                             <img
                              v-else
                              :src="faceFilePath"
                              alt="diploma"
                              width="120"
                              height="120"
                              style="cursor: pointer"
                              @click="$refs.faceInputFile.click()"
                             />
                          </div>
                          <div class="d-flex align-self-center">
                            <a class="btn-upload" 
                              @click="$refs.faceInputFile.click()"
                            >
                              Upload
                            </a>
                          </div>
                        </div>
                      </div>

                      <div class="form-row justify-content-center mb-0 mt-0">
                        <v-btn  class="btn-action" 
                          :loading="loading"
                          :disabled="loading"
                          @click="step2()"
                        >
                          Save &amp; Begin
                        </v-btn>
                      </div>
                    </div> 
                    <div v-if="step == 3">
                      <div class="form-row mb-5 justify-content-center">
                        <div class="form-row m-0">
                          <div class="mb-3"
                          style="font-size:18px;color:#131220;font-weight: 600; text-align: center;"
                          >Confirm Your Information</div>
                        </div>
                        <div class="d-flex justify-content-between">
                          <ul style="padding: 0px 15px;" class="mb-0">
                            <li class="required-text-step-2">
                              Please confirm the information below matches your driver’s license.
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="form-row mb-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-4 pr-0" style="font-size:12px!important;color:#131220!important"
                        >
                          Driver’s License Number                          
                        </label>
                        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 mb-5">
                          <v-text-field
                              :value="license.documentNumber"
                              readonly
                              hide-details
                              flat
                              height="40"
                              solo
                              class="inputClass2-1"
                            >
                            </v-text-field>
                            <span class="text-danger" style="font-size:12px;">
                            <span  v-if="errors.display_name">{{ errors.display_name[0] }}</span>
                            </span>
                        </div>
                      </div>
                      <div class="form-row mb-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-4 pr-0" style="font-size:12px!important;color:#131220!important"
                        >
                          First Name <span class="text-danger" style="font-size:14px;">*</span>
                        </label>

                        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 mb-5">
                            <v-text-field
                              label=""
                              :value="license.firstName"
                              readonly
                              hide-details
                              flat
                              height="40"
                              solo
                              class="inputClass2-1"
                            >
                              
                            </v-text-field>
                            <span class="float-right text-danger" style="font-size:12px">
                            <span  v-if="errors.email">{{ errors.email[0] }}</span>
                            </span>
                        </div>
                      </div>
                      <div class="form-row mb-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-4 pr-0" style="font-size:12px!important;color:#131220!important"
                        >
                          Last Name <span class="text-danger" style="font-size:14px;">*</span>
                        </label>
                        <div class="col-md-12 col-12 col-sm-12 col-lg-12 mb-5">
                          <v-text-field
                            label=""
                            :value="license.lastName"
                            readonly
                            hide-details
                            flat
                            height="40"
                            solo                                       
                            class="inputClass2-1"
                          >
                          </v-text-field>
                          <span class="float-right text-danger"  style="font-size:12px">
                            <span   v-if="errors.password">{{ errors.password[0] }}</span>
                          </span>
                        </div>
                      </div>
                      <div class="form-row mb-0">
                        <label class="col-md-6 col-xs-6 col-sm-6 col-lg-6 control-label pl-4 pr-0" style="font-size:12px!important;color:#131220!important">
                          Date of Birth
                        </label>
                        <label class="col-md-6 col-xs-6 col-sm-6 col-lg-6 control-label pl-4 pr-0" style="font-size:12px!important;color:#131220!important">
                          Gender
                        </label>
                        <div class="d-flex col-md-12 col-xs-12 col-sm-12 col-lg-12 mb-n1">
                          <div style="padding-right: 10px;">
                            <v-text-field
                              label=""
                              :value="license.dob | dateFormat"
                              hide-details
                              flat
                              height="40"
                              solo                              
                              class="inputClass2-1"
                            >
                            </v-text-field>
                            <span class="float-right text-danger"  style="font-size:12px">
                              <span   v-if="errors.password">{{ errors.password[0] }}</span>
                            </span>
                          </div>
                          <div style="padding-left: 10px;">
                            <v-text-field
                              label=""
                              :value="license.sex == 'F' ? 'Female' : 'Male'"
                              readonly
                              hide-details
                              flat
                              height="40"
                              solo                            
                              class="inputClass2-1"
                            >
                            </v-text-field>
                            <span class="float-right text-danger" style="min-height:25px;font-size:12px">
                              <span   v-if="errors.number">{{ errors.number[0] }}</span>
                            </span>
                          </div>
                        </div>
                      </div>

                      <div class="form-row mb-n1">
                        <label class="col-md-6 col-xs-6 col-sm-6 col-lg-6 control-label pl-4 pr-0" style="font-size:12px!important;color:#131220!important">
                          Valid From
                        </label>
                        <label class="col-md-6 col-xs-6 col-sm-6 col-lg-6 control-label pl-4 pr-0" style="font-size:12px!important;color:#131220!important">
                          Valid To
                        </label>
                        <div class="d-flex col-md-12 col-xs-12 col-sm-12 col-lg-12 mb-0">
                          <div style="padding-right: 10px;">
                            <v-text-field
                              label=""
                              :value="license.issued | dateFormat"
                              readonly
                              hide-details
                              flat
                              height="40"
                              solo                       
                              class="inputClass2-1"
                            >
                            </v-text-field>
                            <span class="float-right text-danger"  style="font-size:12px">
                              <span   v-if="errors.password">{{ errors.password[0] }}</span>
                            </span>
                          </div>
                          <div style="padding-left: 10px;">
                            <v-text-field
                              label=""
                              :value="license.expiry | dateFormat"
                              readonly
                              hide-details
                              flat
                              height="40"
                              solo                            
                              class="inputClass2-1"
                            >
                            </v-text-field>
                            <span class="float-right text-danger" style="min-height:25px;font-size:12px">
                              <span   v-if="errors.number">{{ errors.number[0] }}</span>
                            </span>
                          </div>
                        </div>
                      </div>
                      
                      <div class="form-row mb-0">
                        <label
                          class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-4 pr-0" style="font-size:12px!important;color:#131220!important"
                        >
                          Issued By
                        </label>
                        <div class="col-md-12 col-12 col-sm-12 col-lg-12 mb-8">
                          <v-text-field
                            label=""
                            :value="license.issuerOrg_region_full"
                            readonly
                            hide-details
                            flat
                            height="40"
                            solo                            
                            class="inputClass2-1"
                          >
                          </v-text-field>
                          <span class="float-right text-danger"  style="font-size:12px">
                            <span   v-if="errors.password">{{ errors.password[0] }}</span>
                          </span>
                        </div>
                      </div>
                    <div class="row mt-3" v-if="confirmError">
                    <div class="col-12 text-center">
                    <span class="float-left text-danger" >{{ confirmError }}</span>
                    </div>
                    </div>
                      <div class="form-row justify-content-between px-0 mb-0 mt-2">
                        <div class="col-md-6">
                        <v-btn  class="btn-action-outline" style="padding: 10px;width:100%;"
                          :loading="loading"
                          :disabled="loading"    
                          @click="retry"                      
                        >
                          Retry
                        </v-btn>
                        </div>
                        <div class="col-md-6">
                        <v-btn  class="btn-action" style="padding: 10px;width:100%;"
                          :loading="loadingConfirm"
                          :disabled="loadingConfirm"
                          @click="sendConfirm"
                          >
                          Confirm
                        </v-btn>
                        </div>
                      </div>
                    </div> 
                    <div v-if="step == 4">
                      <div class="form-row mb-5 justify-content-center">
                        <div class="form-row m-0">
                          <div class="mb-3"
                          style="font-size:18px;color:#131220;font-weight: 600; text-align: center;"
                          >Identity Verification Complete</div>
                        </div>
                        <div class="d-flex justify-content-between">
                        <div class="mx-6 text-center">
                          <ul style="padding: 0px 15px;" class="mb-0">
                            <li class="required-text-step-2">
                              You have successfully completed your identity verification. You may now complete the signup process.
                            </li>
                          </ul>
                        </div>
                        </div>
                      </div>
                      <div class="form-row justify-content-center px-4 mb-0 mt-0">
                        <a  class="btn-action" style="padding: 10px 50px;"
                          href="javascript:void(0)"
                          :loading="loading"
                          :disabled="loading"
                          @click="step4()"
                        >
                          Confirm
                        </a>
                      </div>
                    </div>
                    <div v-if="step == 5">
                      <div class="form-row mb-5 justify-content-center">
                        <div class="form-row m-0">
                          <div class="mb-3"
                          style="font-size:18px;color:#131220;font-weight: 600; text-align: center;"
                          >Verify Your Phone Number</div>
                        </div>
                        <div class="d-flex justify-content-center">
                          <ul style="padding: 0px 15px;" class="mb-0 text-center">
                            <li class="required-text-step-2">
                              Enter the Code We Texted You 
                            </li>
                            <li class="required-text-step-2" style="color:#6c757d !important;">
                              Code Sent to: <span style="color: #9759FF;">{{"+1" + newuser.number}}</span>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="d-flex justify-content-center">
                        <div class="col-md-10 col-xs-10 col-sm-10 col-lg-10 mb-5 ">
                          <v-text-field
                              label=""
                              placeholder="Verification Code"
                              v-model="phonecode"
                              hide-details
                              flat
                              height="40"
                              solo
                              class="inputClass1"
                            >
                            </v-text-field>
                            <span class="text-danger" style="font-size:12px;">
                            <span  v-if="errors.display_name">{{ errors.display_name[0] }}</span>
                            </span>
                        </div>
                      </div>
                      <div class="d-flex justify-content-center">
                        <ul style="padding: 0px 15px;" class="mb-4 text-center">
                          <li class="required-text-step-2" style="color:#6c757d !important;">
                            Didn’t receive your code?  <a href="javascript:void(0)" @click="resendCode()"  style="color: #9759FF;">Resend</a>
                          </li>
                        </ul>
                      </div>
                      <div class="form-row justify-content-center px-4 mb-0 mt-0">
                        <v-btn class="btn-action" style="padding: 10px 50px;"
                          :loading="loading"
                          :disabled="loading"
                          @click="verifyCode()"
                        >
                          Submit
                        </v-btn>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </v-card-text>
        </v-card>
      </v-dialog>
      <!-- End Becaomme a model -->

      <v-dialog v-model="userSignupDialog" width="375">
        <v-card style="background:#FFFFFF;border-radius:6px!important ">
          <v-card-text class="p-0">
            <div class="row m-0">
              <div class="col-12 text-right mt-6 pr-6">
                <v-icon class="text-right" @click="userSignupDialog=false">mdi-close</v-icon>
              </div>

              <div class="col-12 px-3">
                <div class="card-body px-0 pt-8">
                  <form method="POST" action class="registration_form">
                    <div class="form-row mb-5 justify-content-center">
                      <div class="form-row m-0">
                        <div
                        style="font-size:18px;color:#131220;font-weight: 600; text-align: center;"
                        >100% Free Sign up</div>
                      </div>
                    </div>
                    <div class="form-row mb-0">
                      <label
                        class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-4 pr-0" style="font-size:12px!important;color:#131220!important"
                      >
                        Email <span class="text-danger" style="font-size:14px;">*</span>
                      </label>

                      <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 mb-5">
                          <v-text-field
                            label=""
                            v-model="newuser1.email"
                            hide-details
                            flat
                            height="40"
                            solo
                            class="inputClass1"
                          >
                            
                          </v-text-field>
                          <span class="float-right text-danger" style="font-size:12px">
                          <span  v-if="errors1.email">{{ errors1.email[0] }}</span>
                          </span>
                      </div>
                    </div>
                    <div class="form-row mb-0">
                      <div class="col-6  mb-lg-0 pr-2">
                        <div class="form-row m-0">
                          <label
                            class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0" style="font-size:12px!important;color:#131220!important"
                          >
                            Country Code <span class="text-danger" style="font-size:14px;">*</span>
                          </label>

                          <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">
                         
                            <v-select
                              v-model="newuser1.code"
                              :items="country_all"
                              item-text="country"
                              item-value="id"
                              label="Select"
                              filled
                              background-color="#FFFFFF"
                              class="whiteCheckList"
                              :menu-props="{contentClass: 'checkList-lineGrey'}"
                              dense
                              solo
                              :height="40"
                            >
                              <template
                                slot="selection"
                                slot-scope="data"
                              ><span style="font-size:14px!important;color: rgba(0, 0, 0, 0.87)!important;">{{data.item.code2}} (+ {{data.item.prefix}} )</span></template>
                              <template
                                slot="item"
                                slot-scope="data"
                              >{{data.item.country}} (+ {{data.item.prefix}} )</template>
                            </v-select>

                            <span
                              v-if="errors1.code"
                              class="float-left text-danger" style="font-size:12px"
                            >{{ errors1.code[0] }}</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-6  mb-lg-0 pl-2">
                        <div class="form-row m-0">
                          <label
                            class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-0 pr-0" style="font-size:12px!important;color:#131220!important"
                          >
                            Mobile <span class="text-danger" style="font-size:14px;">*</span>
                          </label>
                          <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">

                           <v-text-field
                            label=""
                            v-model="newuser1.number"
                            hide-details
                            flat
                            height="40"
                            solo
                            
                            class="inputClass1"
                          >
                          </v-text-field>
                            
                          </div>
                        </div>
                      </div>
                    
                       <div class="col-md-12 col-12 col-sm-12 col-lg-12">
                        <span v-if="!errors1.number" class="float-right pb-2"  style="min-height:25px;color:#43425D;font-size:12px;">
                        </span>
                           <span class="float-right text-danger" style="font-size:12px">
                            <span   v-if="errors1.number">{{ errors1.number[0] }}</span>
                           </span>
                        </div>
                    </div>
                    <div class="form-row mb-0">
                      <label
                        class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-4 pr-0" style="font-size:12px!important;color:#131220!important"
                      >
                        Password <span class="text-danger" style="font-size:14px;">*</span>
                      </label>
                      <div class="col-md-12 col-12 col-sm-12 col-lg-12 mb-5">
                        <v-text-field
                          label=""
                          v-model="newuser1.password"
                          hide-details
                          flat
                          height="40"
                          solo
                          type="password"
                          
                          class="inputClass1"
                        >
                        </v-text-field>
                        <div class="d-flex justify-content-between">
                          <ul style="padding-left: 15px;" class="mb-0">
                            <li :class="['required-text', (p_validate.at_least_6_chars) ? 'text-success' : '', (show_text_danger && !p_validate.at_least_6_chars) ? 'text-danger' : '']">
                              At least 6 characters
                            </li>
                            <li :class="['required-text', (p_validate.has_symbol) ? 'text-success' : '', (show_text_danger && !p_validate.has_symbol) ? 'text-danger' : '']">
                              Has a symbol !@#$%^&*
                            </li>
                          </ul>
                          <ul style="padding-left: 15px;" class="mb-0">
                            <li :class="['required-text', (p_validate.has_uppercase) ? 'text-success' : '', (show_text_danger && !p_validate.has_uppercase) ? 'text-danger' : '']">
                              Has an uppercase letter
                            </li>
                            <li :class="['required-text', (p_validate.has_number) ? 'text-success' : '', (show_text_danger && !p_validate.has_number) ? 'text-danger' : '']">
                              Has a number
                            </li>
                          </ul>
                        </div>
                        <span class="float-right text-danger"  style="font-size:12px">
                          <span   v-if="errors1.password">{{ errors1.password[0] }}</span>
                        </span>
                      </div>
                    </div>
                    
                    <div class="form-row mb-0">
                      <label
                        class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-4 pr-0" style="font-size:12px!important;color:#131220!important"
                      >
                        Confirm Password <span class="text-danger" style="font-size:14px;">*</span>
                      </label>
                      <div class="col-md-12 col-12 col-sm-12 col-lg-12 mb-5">
                        <v-text-field
                          label=""
                          v-model="newuser1.password_confirmation"
                          hide-details
                          flat
                          height="40"
                          solo
                          type="password"
                                                    
                          class="inputClass1"
                        >
                        </v-text-field>
                        <div class="d-flex justify-content-between">
                          <ul style="padding-left: 15px;" class="mb-0">
                            <li :class="['required-text', (c_p_validate.at_least_6_chars) ? 'text-success' : '', (show_text_danger && !c_p_validate.at_least_6_chars) ? 'text-danger' : '']">
                              At least 6 characters
                            </li>
                            <li :class="['required-text', (c_p_validate.has_symbol) ? 'text-success' : '', (show_text_danger && !c_p_validate.has_symbol) ? 'text-danger' : '']">
                              Has a symbol !@#$%^&*
                            </li>
                          </ul>
                          <ul style="padding-left: 15px;" class="mb-0">
                            <li :class="['required-text', (c_p_validate.has_uppercase) ? 'text-success' : '', (show_text_danger && !c_p_validate.has_uppercase) ? 'text-danger' : '']">
                              Has an uppercase letter
                            </li>
                            <li :class="['required-text', (c_p_validate.has_number) ? 'text-success' : '', (show_text_danger && !c_p_validate.has_number) ? 'text-danger' : '']">
                              Has a number
                            </li>
                          </ul>
                        </div>
                        <span class="float-right text-danger"  style="font-size:12px">
                          <span   v-if="errors1.password_confirmation">{{ errors1.password_confirmation[0] }}</span>
                        </span>
                      </div>
                    </div>

                    <div class="form-row mb-3">
                      <div class="col-md-12 col-12 col-sm-12 col-lg-12 mb-0 mt-0">
                        <div class="form-row m-0">
                          <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">
                            <v-checkbox
                              class="float-left age"
                              style="display: inline-block;"
                              v-model="newuser1.age"
                              hide-details
                            >
                              
                            </v-checkbox>
                            <label style="width: 88%;font-size: 12px !important;color:#1F1E34 !important;font-weight: 400;line-height:18pt;">
                              You consent to receive SMS messages from Respectfully to provide updates on your account and/or for marketing purposes. You will receive up to 5 promotional messages a month. Reply “STOP” to cancel at any time. Message and data rates apply.
                            </label>
                          </div>
                          <div class="col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0">
                            <span v-if="errors1.age" class="text-danger float-right" style="font-size:12px">{{ errors1.age[0] }}</span>
                          </div>
                          <div
                            v-if="errors1.spam"
                            class="mt-3 col-md-12 col-12 col-sm-12 col-lg-12 pl-0 pr-0"
                          >
                            <span class="text-danger float-right" style="font-size:12px">{{ errors1.spam[0] }}</span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-row justify-content-center mb-0 mt-0">
                      <a  class="btn-action" 
                        href="javascript:void(0)"
                        :loading="loading"
                        :disabled="loading"
                       @click="getTokenUser()"
                      >
                        Enter Respectfully
                      </a>
                    </div>
                    <div class="form-row justify-content-center mb-0 mt-5" style="border-top: 1px solid rgb(160 160 165);margin: 0px 10px;">

                      <a style="color: #8EbEF8; font-size: 12px !important;color:#1F1E34 !important;font-weight: 500;line-height:18pt; padding-top:10px;" target="_blank"
                        href="javascript:void(0)"
                      >Already a member?</a>
                      <span class="text-danger" style="color: #F77F98 !important;margin-left:10px;font-size: 12px !important;font-weight: 600;line-height:18pt; padding-top:10px;"
                        :loading="loading"
                        :disabled="loading"
                        @click.prevent="userSignupDialog=false;loginDialog=true;"
                      >Login Here</span>
                    </div>

                    <div class="form-row justify-content-center mb-0" >

                      <a style="color: #8EbEF8; font-size: 12px !important;color:#1F1E34 !important;font-weight: 500;line-height:18pt;" target="_blank"
                        href="javascript:void(0)"
                      >Are you model?</a>
                      <span class="text-danger" style="color: #F77F98 !important;margin-left:10px;font-size: 12px !important;font-weight: 600;line-height:18pt;"
                        :loading="loading"
                        :disabled="loading"
                      >Apply Now</span>
                    </div>
                    
                  </form>
                </div>
              </div>
            </div>
          </v-card-text>
        </v-card>
      </v-dialog>

      <v-dialog v-model="messageDialog" width="600">
        <v-card>
          <v-card-text class="p-0">
            <div class="row m-0">
              <div class="col-12 text-right">
                <v-btn icon light @click="messageDialog = false" class="right">
                  <i class="far fa-times-circle fa-2x primary--text"></i>
                </v-btn>
              </div>
              <div class="col-12">
                <div class="text-center p-5">
                  <h1 class="mb-5">
                    THANK YOU
                    <br />FOR SIGNING UP!
                  </h1>
                  <p class="p-4 pt-0 mb-8" v-html="message"></p>
                  <v-btn
                    class
                    rounded
                    color="primary"
                    @click="messageDialog=false;loginDialog=true"
                  >Login Now</v-btn>
                </div>
              </div>
            </div>
          </v-card-text>
        </v-card>
      </v-dialog>
      <v-dialog v-model="loginDialog" width="335">
        <v-card style="background:#FFFFFF;border-radius:6px!important ">
          <v-card-text class="p-0">
            <div class="row m-0">
              <div class="col-12 text-right mt-6 pr-6">
                <v-icon class="text-right" @click="loginDialog=false">mdi-close</v-icon>
              </div>
              <div class="col-12 pt-8">
                <div class="form-row justify-content-center mb-0">
                  <div class="px-2" style="font-size:20px;color:#43425D;font-weight: 600;">
                    Log In
                  </div>
                </div>
                <div class="card-body p-0 p-lg-5 pt-4">
                  <form method="POST" action class="registration_form  pt-0 pb-0">
                    <div class="form-row mb-0">
                      <label
                        class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-4 pr-0" style="font-size:12px!important;color:#131220!important"
                      >
                        Email <span class="text-danger" style="font-size:14px;">*</span>
                          
                      </label>
                      <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 mb-5">
                        <v-text-field
                          label=""
                          v-model="email"
                          hide-details
                          flat
                          height="40"
                          solo
                          class="inputClass1"
                        >
                        </v-text-field>
                          <span class="text-danger" style="font-size:12px;display: flex;justify-content: flex-end;">
                          <span  v-if="errors.display_name">{{ errors.display_name[0] }}</span>
                          </span>
                      </div>
                    </div>
                    <div class="form-row mb-0">
                      <label
                        class="col-md-12 col-xs-12 col-sm-12 col-lg-12 control-label pl-4 pr-0" style="font-size:12px!important;color:#131220!important"
                      >
                        Password <span class="text-danger" style="font-size:14px;">*</span>
                          
                      </label>
                      <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 mb-2">
                        <v-text-field
                          label=""
                          v-model="password"
                          hide-details
                          flat
                          height="40"
                          solo
                          class="inputClass1"
                          type="password"
                        >
                        </v-text-field>
                          <span class="text-danger" style="font-size:12px;display: flex;justify-content: flex-end;">
                          <span   v-if="errors.password">{{ errors.password[0] }}</span>
                          </span>
                          <span v-if="error != ''" class="float-right text-danger" style="font-size:12px">{{ error }}</span>
                      </div>
                    </div>
                    <div class="form-row mb-0 justify-content-center">
                      <div class="col-12 text-right mb-5">
                      <a href="/password/reset" style="font-size:12px;font-weight:600;color:#9759FF">Forgot Password?</a>
                      </div>
                      <a  class="btn-action" 
                        href="javascript:void(0)"
                        :loading="loadingLogin"
                        :disabled="loadingLogin"
                        @click="login()"
                      >
                        Enter Respectfully
                      </a>
                    </div>
                    <div class="form-row justify-content-center mb-0 mt-5" style="border-top: 1px solid rgb(160 160 165);margin: 0px 10px;">

                      <a style="color: #8EbEF8; font-size: 12px !important;color:#1F1E34 !important;font-weight: 500;line-height:18pt; padding-top:10px;" target="_blank"
                        href="javascript:void(0)"
                      >New to Respectfully?</a>
                      <span style="color: #F77F98;margin-left:10px;font-size: 12px !important;font-weight: 600;line-height:18pt;padding-top:10px;"
                        :loading="loading"
                        :disabled="loading"
                        @click.prevent="userSignupDialog=false;loginDialog=true;"
                      >Sign Up Here</span>
                    </div>
                    <div class="form-row justify-content-center mb-10">

                      <a style="color: #8EbEF8; font-size: 12px !important;color:#1F1E34 !important;font-weight: 500;line-height:18pt;" target="_blank"
                        href="javascript:void(0)"
                      >Are you model?</a>
                      <span style="color: #F77F98;margin-left:10px;font-size: 12px !important;font-weight: 600;line-height:18pt;"
                        :loading="loading"
                        :disabled="loading"
                      >Apply Now</span>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </v-card-text>
        </v-card>
      </v-dialog>
      
    </div>

    <v-navigation-drawer
      class="drawer"
      v-model="drawer"
      hide-overlay
      stateless
      fixed
      width="100%"
      style="top:50px;overflow-y:scroll"
    >


      <v-list dense>
      <v-list-item>
      <i
          class="fa fa-times close-button contact-close"
          style="float: right; font-size: 15px; top: 34px; right: 15px; color: #A2A2A2; cursor: pointer;"
          @click="drawer = false"
          aria-hidden="true"
        ></i>
         </v-list-item>
     
        <div class="flex" v-for="(item, index) in items" :key='index'>
        <v-list-item v-if="item.items.length == 0"
          
          :key="item.title"
          link
          @click.stop="openLink(item)"
        >
        

          <v-list-item-content>
            <v-list-item-title class="px-4" v-if="item.title != 'Sign Up'">{{ item.title }}</v-list-item-title>
            <v-btn v-else
                         
                          class="mb-0 btn-block" style="justify-content: start;height:50px!important"
                          
                          color="#8EbEF8"
                          depressed
                          rounded
                          min-width="70"
                          :loading="loading"
                          :disabled="loading"
                          href="/signup"
                        >
                          <span style="color: #ffffff">Sign Up</span>
                        </v-btn>
          </v-list-item-content>
        </v-list-item>
        <v-list-group v-else>
        <template v-slot:activator>
          <v-list-item-content >
            <v-list-item-title class="px-4" v-text="item.title" link></v-list-item-title>
          </v-list-item-content>
        </template>

        <v-list-item 
          v-for="child in item.items[0]"
          :key="child.slug"
        >
          <a v-if="item.title == 'Specialties'"  :href="'/search?category='+child.slug">
          <v-list-item-content class="pl-7">
            <v-list-item-title v-text="child.name"></v-list-item-title>
          </v-list-item-content>
        </a>
        <a v-else-if="item.title == 'Abilities'"  :href="'/search?ability='+child.slug">
          <v-list-item-content class="pl-7">
            <v-list-item-title v-text="child.name"></v-list-item-title>
          </v-list-item-content>
        </a>
        </v-list-item>
        
      </v-list-group>
      </div>
       <div class="my-10 pb-10 px-4"
          
          key="search"
          link
        >
        

          <v-list-item-content>
            <v-list-item-title>
              <div style="color:#C7C7C7; font-size: 25px; font-weight: 600">Search</div>
              <v-divider></v-divider>
              <SearchInput menu="true"/>              
            </v-list-item-title>
          </v-list-item-content>
        </div>   
         </v-list>    
    </v-navigation-drawer>
     <RequestPrivates
      v-if="model"
      :request="requestPrivate"
      :teacher="model"
      :key="requestPrivate"
      :close.sync="requestPrivate"
    />
  </div>
</template>
<script>
import moment from "moment";
import axios from 'axios';
import RequestPrivates from "../../../frontend/js/components/request_private";
export default {
  components: { RequestPrivates },
  props: [
    "user",
    "guest",
    "abilities",
    "specialties",
    // "categories",
    "country_all",
    "redeem",
    "search",
    "tools",
    "styles",
    "url",
  ],

  data: function () {
    return {
      redirect:"/",
      model: {},
      requestPrivate: false,
      formData: null,
      confirm:false,
      governmentIssuedFile: null,
      governmentIssuedFilePath: null,
      faceFile: null,
      faceFilePath: null,
      categories: [],
      step:1,
      show: false,
      show1: false,
      drawer: false,
      menu_opened: false,
      dash_menu: "/images/icons/profile.svg",
      dash_app: "/images/icons/dashboard.svg",
      same_page_login: false,
      loadingLogin: false,
      loading: false,
      loginDialog: false,
      email: "",
      password: "",
      message: "",
      header: "",
      error: "",
      errors: [],
      errors1: [],
      signupDialog: false,
      userSignupDialog: false,
      message: "",
      messageDialog: "",
      phonecode:"",
      newuser: {
        age: false,
        name: "",
        last_name: "",
        number: "",
        email: "",
        display_name: "",
        referral: "",
        categories: [],
        specialties: [],
        tools: [],
        styles: [],
        password: "",
        c_password: "",
        code: 215,
        token: "",
      },
      newuser1: {
        age: false,
        name: "",
        email: "",
        password: "",
        code: 215,
        number: "",
        token: "",
        password_confirmation: "",
      },
      p_validate: {
        at_least_6_chars: false,
        has_symbol: false,
        has_number: false,
        has_uppercase: false
      },
      c_p_validate: {
        at_least_6_chars: false,
        has_symbol: false,
        has_number: false,
        has_uppercase: false
      },
      show_text_danger: false,
      items: [
        { title: "Sign Up", url: "signup", items: [] },
        { title: "Log In", url: "login", items: [] },
        { title: "Specialties", url: "specialties", items: [this.specialties] },
        { title: "Abilities", url: "abilities", items: [this.abilities] },
         { title: "Horoscopes", url: "horoscope", items: [] },
        { title: "About", url: "about", items: [] },
        { title: "Blog", url: "blog", items: [] },
        { title: "Press", url: "press", items: [] },
      ],
      regexSix: /^.{6,}$/,
      regexUpper: /[A-Z]/,
      regexNumber: /[0-9]/,
      regexChar: /[!@#$%^&*]/,
      retryVar: false,
      license: {},
      confirmError: false,
      loadingConfirm: false,
    };
  },
  mounted() {
    EventBus.$on("openrequestPrivate", (data) => {
      console.log('dentro mierda');
      this.requestPrivate = data.requestPrivate;
      this.model = data.model;
    });
    EventBus.$on("open_sign_up", () => (this.signupDialog = true));
    EventBus.$on("open_sign_up_user", () => (this.userSignupDialog = true));
    EventBus.$on("open_login", (data) => {
      this.loginDialog = true;
      this.same_page_login = data.same_page_login;
    });    
  },
  ready() {
    EventBus.$on("open_sign_up", () => (this.signupDialog = true));
    EventBus.$on("open_sign_up_user", () => (this.userSignupDialog = true));
    EventBus.$on("open_login", () => (this.loginDialog = true));    
  },
  created(){
    this.formData = new FormData();
  },
  filters: {
    dateFormat(val) {
      return moment(val).format("MM/DD/YYYY");
    },
  },
  methods: {
     verifyCode() {
      this.loading = true;

      var input = { code: this.phonecode };

      axios
        .post("/api/v1/user/verify/phone/code", input)
        .then((response) => {
          if (response.status === 200) {
            this.redirect ="/explore"
            if (this.redirect) window.location.href = this.redirect;
            else location.reload();
          }
        })
        .catch((error) => {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }

          if (typeof error.response.data === "object") {
            if (error.response.data.errors) {
              this.errors = error.response.data.errors;
              this.error = "";
            }

            if (error.response.data.error) {
              this.error = error.response.data.error.message;
              this.errors = [];
            }
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }

          this.saving = false;
          this.message = "";
        });
    },
    resendCode() {
      axios
        .post("/api/v1/user/resend/phone/code")
        .then((response) => {
          if (response.status === 200) {
            this.loading = false;
          }
        })
        .catch((error) => {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }

          if (typeof error.response.data === "object") {
            if (error.response.data.errors) {
              this.errors = error.response.data.errors;
              this.error = "";
            }

            if (error.response.data.error) {
              this.error = error.response.data.error.message;
              this.errors = [];
            }
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }

          this.saving = false;
          this.message = "";
        });
    },
    setFace(event) {
      this.faceFile = event.target.files[0];
      this.formData.append("faceFile", event.target.files[0]);
      const reader = new FileReader();
      reader.onload = (e) => {
        this.faceFilePath = e.target.result;
      };
      if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
      }
    },
    setGovernmentIssued(event) {
      this.governmentIssuedFile = event.target.files[0];
      this.formData.append("governmentIssuedFile", event.target.files[0]);
      const reader = new FileReader();
      reader.onload = (e) => {
        this.governmentIssuedFilePath = e.target.result;
      };
      if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
      }
    },
    openLink(item) {
      if (item.url == "login") {
        EventBus.$emit("open_login", {});
      } else {
        window.location = "/" + item.url;
      }
    },
    getToken() {
      this.loading = true;
      const self = this;
      grecaptcha.ready(function () {
        grecaptcha
          .execute("6LdkjDkbAAAAAEKr_DU5nNYOQW5GrZpPB8mNvgHd", {
            action: "register",
          })
          .then(function (token) {
            if (token) {
              self.newuser.token = token;
              self.register();
            }
          });
      });
    },

    getTokenUser() {
      this.loading = true;
      const self = this;
      // self.registerUser();
      grecaptcha.ready(function () {
        grecaptcha
          .execute("6LdkjDkbAAAAAEKr_DU5nNYOQW5GrZpPB8mNvgHd", {
            action: "registerUser",
          })
          .then(function (token) {
            if (token) {
              self.newuser1.token = token;
              self.registerUser();
            }
          });
      });
    },

    step1() {
      var input = this.newuser;
      this.loading = true;
      axios
        .post("/register/validate/step1", input)
        .then((res) => {
          if (res.status == 201) {
           this.loading = false;
          this.errors = [];
          this.step++;
          axios
            .post('generic/list', {table: 'category', fields: ['id', 'name']})
            .then(response => {
                this.categories = response.data.data;
              })
          }
         
        })
        .catch((error) => {
          console.log(error);
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
          if (typeof error.response.data === "object") {
            this.errors = error.response.data.errors;
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }
          this.show1 = false;
          this.loading = false;
          this.message =
            "There is something wrong, please check that all form fields are correct.";
        });
    },
    
    step2() {
      this.loading = true;      
      for(const[key, value] of Object.entries(this.newuser)){
        if(key!=='categories')
            this.formData.append(key, value);
        else{
            this.formData.delete('categories');
            this.formData.append('categories', []);
            for(var i=0;i<value.length;i++)
            this.formData.append('categories[]', value[i]);
        }
      }  
      axios
        .post("/register/validate/step2", this.formData)
        .then((res) => {
          console.log(res);
          if (res.data.data) {
            this.license = res.data.data;
            this.retryVar=false;    
            this.step = 3; 
            this.loading=false;
          }
          if (res.status == 201) {
          this.loading = false;
          this.errors = [];
          this.step++;
          }
         
        })
        .catch((error) => {
          console.log(error);
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
          if (typeof error.response.data === "object") {
            this.errors = error.response.data.errors;
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }

          this.loading = false;
          this.message =
            "There is something wrong, please check that all form fields are correct.";
        });
    },

    step3() {
      var input = this.newuser;
      this.loading = true;
      axios
        .post("/register/validate/step3", input)
        .then((res) => {
          if (res.status == 201) {
          this.loading = false;
          this.errors = [];
          this.step++;
          }
         
        })
        .catch((error) => {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
          if (typeof error.response.data === "object") {
            this.errors = error.response.data.errors;
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }

          this.loading = false;
          this.message =
            "There is something wrong, please check that all form fields are correct.";
        });
    },

    step4() {
      var input = this.newuser;
      this.loading = true;
      axios
        .post("/register/validate/step4", input)
        .then((res) => {
          if (res.status == 201) {
          this.loading = false;
          this.errors = [];
          this.step++;
          }
         
        })
        .catch((error) => {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
          if (typeof error.response.data === "object") {
            this.errors = error.response.data.errors;
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }

          this.loading = false;
          this.message =
            "There is something wrong, please check that all form fields are correct.";
        });
    },

    step5() {
      var input = this.newuser;
      this.loading = true;
      axios
        .post("/register/validate/step5", input)
        .then((res) => {
          if (res.status == 201) {
            this.getToken();
          }
        
        })
        .catch((error) => {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
          if (typeof error.response.data === "object") {
            this.errors = error.response.data.errors;
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }

          this.loading = false;
          this.message =
            "There is something wrong, please check that all form fields are correct.";
        });
    },
    retry() {
      this.step=2;
      this.confirm = false;
      this.confirmError = false
      this.$refs.governmentIssuedInputFile.click();
    },
    sendConfirm() {
      this.loadingConfirm = true;
      this.confirmError = false;
      this.formData.append('confirm', true);
      axios
        .post("/register/validate/step2", this.formData)
        .then((res) => {
          this.confirmError = false
          console.log("Result");
          console.log(res.data);
          if (res.data) {
            this.confirm = true;
            this.step4();
          }
          this.loadingConfirm = false;
          this.errors = [];
          this.formData = new FormData();
        }).catch((error) => {
          this.confirmError = error.response.data.error;
        })
        .finally(() => {
          this.loadingConfirm = false;
        });
    },
    register() {
      var input = this.newuser;
      axios
        .post("/register/psychic", input)
        .then((res) => {
          if (res.status == 201) {
            //Created
            // this.message = res.data.success.message;
            // this.signupDialog = false;
            // this.resetUser();
            // this.messageDialog = true;
            
            location.reload();
          }
          this.loading = false;
          this.errors = [];
        })
        .catch((error) => {
          this.newuser.token = "";
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
          if (typeof error.response.data === "object") {
            this.errors = error.response.data.errors;
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }

          this.loading = false;
          this.message =
            "There is something wrong, please check that all form fields are correct.";
        });
    },
    registerUser() {
      const self = this;
      var input = this.newuser1;
      self.show_text_danger = true;
      axios
        .post("/register/user", input)
        .then((res) => {
          if (res.status == 201) {
            //Created
            // this.message = "$10 in <button  class='credit_icon btn-sm' color='withe--text'>c</button> credits have been added to your account.";
            // this.userSignupDialog = false;
            // this.resetUser();
            // this.messageDialog = true;
            // console.log(res)
            location.reload();
          }
          this.loading = false;
          this.errors1 = [];
         
        })
        .catch((error) => {
          this.newuser1.token = "";
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
          if (typeof error.response.data === "object") {
            this.errors1 = error.response.data.errors;
          } else {
            this.errors1 = ["Something went wrong. Please try again."];
          }
           this.show = false;
          this.loading = false;
          this.message =
            "There is something wrong, please check that all form fields are correct.";
        });
    },
    resetUser() {
      this.newuser = {
        name: "",
        last_name: "",
        number: "",
        email: "",
        display_name: "",
        referral: "",
        categories: [],
        password: "",
        c_password: "",
        age: false,
      };

      this.newuser1 = {
        name: "",
        last_name: "",
        email: "",
        password: "",
        c_password: "",
        age: false,
        promo_code: "",
      };
    },
    logout() {
      axios
        .post("/logout")
        .then((response) => {
          if (response.status === 200) {
            window.location = "/";
          }
        })
        .catch((error) => {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
      // this.$refs.logoutform.submit()
    },
    login() {
      this.loadingLogin = true;
      this.error = "";
      var input = { email: this.email, password: this.password };
      axios
        .post("/ajax/login", input)
        .then((res) => {
          if (res.status == 200) {
            //Created

            if (this.same_page_login) {
              location.reload();
            } else {
              if (res.data.success.url) window.location = res.data.success.url;
              else location.reload();
            }
          }
        })
        .catch((error) => {
          this.loadingLogin = false;


          console.log(this.errors);
          this.errors = [];

          if (typeof error.response.data === "object") {
            if (error.response.data.error) {
              this.error = error.response.data.error;
            }

            if (error.response.data.errors) {
              this.errors = error.response.data.errors;
            }
          } else {
            this.errors = ["Something went wrong. Please try again."];
          }

          this.message = "There is something wrong.";
        });
    },
    hasUpperCase(str) {
      return (/[A-Z]/.test(str));
    },
    hasLowerCase(str) {
      return (/[a-z]/.test(str));
    },
    hasNumber(str) {
      return (/[0-9]/.test(str));
    },
    hasSymbol(str) {
      return (/[!@#$%^&*]/.test(str));
    }
  },
};
</script>

<style>

#navbarSupportedContent div.v-list-item__title p
{
  margin-bottom:0px !important;
}
#navbarSupportedContent div.v-list-item__icon{
  margin-right: 20px !important;
}
/*
div.v-menu__content div.v-list div.v-list-item__icon{
  margin-right: 0px !important;
}
div.v-menu__content div.v-list  div.v-list-item__title p{
    margin-bottom:0px !important;
}
*/


.my-menu .v-item-group {
  padding: 30px 20px;
}
.my-menu .v-item-group img {
  width: 20px;
}
.my-menu .v-item-group p {
  margin: 0!important;
  font-size: 14px;
  font-weight: 500;
  color: #131220;
}
.inputClass1 .v-input__slot {
    font-size: 14px !important;
}

.credit_icon {
  background-color: #8ebef8 !important;
  font-size: 11px !important;

  padding: 0 !important;
  min-width: 16px !important;
  height: 16px !important;
  color: white !important;
  border-radius: 100% !important;
}
/* .menubar{
  position: fixed;
  z-index: 10;
  box-shadow: 0px 0px 10px 0px #cecece;
} */


.v-card label,
.v-label:hover,
.v-label {
  font-size: 14px !important;
  color: #656b72 !important;
}

.checks label, .checks .v-label:hover{
    font-size: 12px !important;
}
.logo {
  width: 110px;
}
.v-input__control .v-select__selections,
.checkListGray-line
  .theme--light.v-list-item:not(.v-list-item--active):not(.v-list-item--disabled) {
  color: #8e8d99 !important;
}
.v-text-field.v-text-field--enclosed .v-text-field__details {
  margin: 0px !important;
  display: none;
}

.v-input--selection-controls__ripple {
  display: none;
}
.v-dialog__content--active {
  opacity: 1 !important;
  -webkit-backdrop-filter: blur(10px);
  backdrop-filter: blur(10px);
}

.v-dialog {
  box-shadow:none!important;
}

.v-text-field.v-text-field--solo .v-input__control {
    min-height: 40px!important;
   
}
.credits { color: black !important; }
/* .sign-up  {
color: #fff ;
background-repeat: #fff;
padding: 5px 20px;
font-size: 12px;
letter-spacing: 0.43px;
border-radius: 9px;
border: 2px solid #9759FF;
background:transparent linear-gradient(90deg, #9759FF 0%, #7272FF 100%) 0% 0% no-repeat padding-box; ;

}

.form-check-label { padding-left:10px }
@media screen and (max-width: 600px) {
.btn-follow {
color: #9759FF !important;;
background-repeat: #fff;
padding: 5px 20px;
font-size: 12px;
letter-spacing: 0.43px;
border-radius: 9px;
border: 2px solid #9759FF;
background:transparent  ;

}
.form-check-label { padding-left:5px }
} */

body {
     font-size: 14px;
     font-family: 'Montserrat', sans-serif;
     font-weight:400;
	 font-style: normal;
	 
}
.toxbox-margin {
  margin: 8px 0 0 20px!important;
}
a {
     color: #03a9f4;
     transition: all 0.3s ease-out 0s;
}
a:hover, a:active, a:focus {
     outline: none;
     text-decoration: none;
     transition: all 0.3s ease-out 0s;
}
 h1, h2, h3, h4, h5, h6 {
  
     font-weight: 900;
}
h1 {
  font-size: 4.375rem;	
}
h2 {
    font-size: 2.5rem;
}
h3 {
    font-size: 1.5rem;
}
h4 {
     font-size: 1rem;
}
h5 {
     font-size: 0.875rem;
}
h6 {
     font-size: 0.75rem;
}
.btn
{
	padding:0px;
}
.theme.btn-primary
{
	border:0px;
background: transparent linear-gradient(256deg, #7272FF 0%, #9759FF 100%) 0% 0% no-repeat padding-box;
box-shadow: 0px 2px 4px #9759FF4D;
border-radius: 12px;
width:160px;
height:40px;
line-height:40px;
text-align:center;
font-size:12px;
font-weight:600;
color:#FFFFFF !important;
}
.theme.btn-primary:hover
{
	background: transparent linear-gradient(256deg, #9759FF 0%, #7272FF 100%) 0% 0% no-repeat padding-box;
}
/*
* ----------------------------------------------------------------------------------------
* 2. Header css
* ----------------------------------------------------------------------------------------
*/
.header
{
box-shadow: 0px 3px 6px #00000029;
position: fixed;
left: 0px;
right: 0px;
z-index: 99;
background: #FFF;
padding: 0px 0px !important;
}
.header .navbar-brand
{
	padding-top:9px;
	padding-bottom:9px;
	float:left;
}
.header .navbar-brand
{
	font-family: 'Lobster', cursive;
	font-weight:normal;
	line-height:38px;
	font-size:30px;
	letter-spacing: -0.72px;
  color: #0F0F0F;
  margin-right: 40px
}
.header .navbar
{
	padding:0px;
	margin-left:22px;
	float:left;
	/* padding-top: 10px;
  padding-bottom: 10px; */
}
.header .navbar .navbar-nav
{
	padding:0px;
	margin:0px;
	list-style:none;
}
.header .navbar .navbar-nav .nav-item
{
	display:inline-block;
}
.header .navbar .navbar-nav .nav-item .nav-link
{
	padding:0px;
	font-size:12px;
	letter-spacing: 0px;
  color: #131220;
	margin-right:24px;
	font-family: 'Montserrat', sans-serif;
	font-weight:600;
	letter-spacing: 0px;
	line-height:38px;
}

.header .navbar .navbar-nav .nav-item .nav-link.active,
.header .navbar .navbar-nav .nav-item .nav-link:hover
{
	color:#9759FF;
}
.header .right-menu
{
	padding:0px;
	margin:0px;
	list-style:none;
	padding-top: 12px;
	padding-bottom:12px;
  align-items: center;
}
.header .right-menu li
{
	display:inline-block;
	margin-left:24px;
}
.header .right-menu li a
{
	font-size:14px;
	font-weight:600;
	letter-spacing: 0px;
  color: #131220;
}
.header .right-menu li a:hover
{
	color:#9759FF;
}
.header .right-menu li a i
{
	font-size:18px;
	position: relative;
  top: 2px;
  margin-right: 3px;
}
.signup-btn-box{
  align-self: center;
}
.mobile-menu{
  display: none !important;
}
.header .signup-btn
{
  font-size: 12px !important;
  color: #FFF !important;
  background: transparent linear-gradient(180deg, #7272FF 0%, #9759FF 100%) 0% 0% no-repeat padding-box;
  letter-spacing: 0.43px;
  width: 80px;
  height: 30px;
  text-align: center;
  display: block;
  line-height: 30px !important;
  border-radius: 9px;
  margin: 0px !important;
}
.header .signup-btn:hover
{
	background: transparent linear-gradient(0deg, #7272FF 0%, #9759FF 100%) 0% 0% no-repeat padding-box;
}
.container {
      padding: 0px !important;
}
.header {
  padding: 0px 0px !important;
}
.v-input__icon {
  padding-left: 10px !important;
}
@media (min-width: 1904px){
    .container {
        max-width: 1185px !important;
    }
}
/* Normal desktop :992px. */
@media (min-width: 1280px){
    .container {
        max-width: 1070px;
    }
}
@media (min-width: 992px) and (max-width: 1200px) {
  
	.header .navbar {
    margin-left: 20px;
	}
	.header .navbar .navbar-nav .nav-item .nav-link {
    margin-right: 20px;
	}
	.header .navbar .navbar-nav .nav-item:last-child .nav-link {
    margin-right: 0px;
}
	.header .right-menu li {
    display: inline-block;
    margin-left: 15px;
}
	}

/* Tablet desktop :768px. */
@media (min-width: 768px) and (max-width: 991px) {}

/*  Small mobile :320px. */
@media (min-width: 320px) and (max-width: 767px) {
  .mobile-menu{
    display: block !important;
  }
  .mobile-menu a.nav-link img {
    width: 20px;
    height: 20px;
    margin-right: 10px;
  }
  .desktop-menu {
    display: none !important;
  }
  .mobile-logo {
    flex-grow: 1;
  }
  .mobile-sign {
    display: block !important;
  }
  .header .navbar .navbar-nav .nav-item .nav-link {
    font-size: 14px;
    font-weight: 700;
  }
 
  .search-menu {
    order: 0;
  }
  ul.navbar-nav .nav-item.mobile-menu,
  .login-menu,
  .feed-menu {
    order: 1;
  }
  .model-menu {
    order: 2;
  }
  .categroy-menu {
    order: 3;
  }
  .explore-menu {
    order: 4;
  }
  .how-menu {
    order: 5;
  }
  .become-menu {
    order: 6;
  }
  
	.header .right-menu li.menu-btn-box 
	{
		margin-left:13px;
	}
	.header .right-menu li.menu-btn-box a.menu-btn i
	{
		margin-right:0px;
	}
	.explore-box .image {
     height: 280px;
  }
	 .footer .widget
	 {
		 margin-bottom:30px;
	 }
     .footer .widget .menu ul li {
    margin-bottom: 10px;
    display: inline-block;
    margin-right: 10px;
      }
	    /* .footer .widget .iconlist ul li a.instagram
		{
			background:none;
			color:#131220;
			font-size:19px;
		} */
		.footer .widget .iconlist ul li a.instagram:hover
		{
			color:#9759FF !important;
		}
	}
/* Large Mobile :577px. */
@media only screen and (min-width: 577px) and (max-width: 767px) {}
.text-success {
  color: #2CC05F;
  font-weight: 500;
}
.text-danger{
    color: #FF2727!important;
    font-weight: 500;
}
.inputClass1 .v-input__slot {
  border: 1px solid #13122066;
  border-radius: 4px;
}
.whiteCheckList .v-select__slot {
  border: 1px solid #13122066;
  border-radius: 4px;
}
.inputClass1 input, .inputClass2-1 input {
    padding: 8px !important;
    color: #131220 !important;
}
.whiteCheckList .v-select__selections {
    padding: 8px !important;
    color: #131220 !important;
}
.required-text {
  list-style: disc;
  line-height: 14px;
  font-size: 11px;
  font-weight: 600;
  margin-top: 10px;
}

.required-text-step-2 {
  list-style: none;
  line-height: 17px;
  font-size: 12px;
  font-weight: 500;
  color: #131220 !important;
}

.btn-action {
  color: #fff !important;
  display: inline-block;
  padding: 10px 30px;
  border-radius: 9px;
  font-size: 12px;
  font-weight: 600;
  background: transparent linear-gradient(90deg, #9759FF 0%, #7272FF 100%) 0% 0% no-repeat padding-box; 
}
.btn-action-outline {
  color: #9759FF !important;
  border: 1px solid #9759FF;
  display: inline-block;
  padding: 10px 30px;
  border-radius: 9px;
  font-size: 12px;
  font-weight: 600;
  background: #fff; 
}

.v-input--selection-controls {
  padding: 0px !important;
}
.btn-upload {
  border: 1px solid #9759ff;
  padding: 9px 16px;
  height: 40px;
  font-size: 12px;
  font-weight: 900;
  border-radius: 12px;
}

.inputClass2-1 .v-input__control .v-input__slot{
  background: #CED1D6 !important;
}
.top-modal {
  align-self: flex-start;
}
.bg-white .v-card{
  background: #fff !important;
}
.mdi-checkbox-blank-outline::before {
  position: absolute !important;
}
.mdi-checkbox-marked::before {
  position: absolute !important;
}
.todo-items-btn {
	font-size: 12px !important;
  font-weight: 500 !important;
	text-align: center;
	display: flex;
  align-items: center;
  justify-content: center;
	background-color: rgba(255, 255, 255, 0.1) !important;
	text-align: center;
	border-radius: 9px !important;
	border:2px solid #9759FF;
	line-height: 40px;
	cursor: pointer;
  margin: 0px;
  color: #9759FF !important;
  float: right;
  top: -27px;
  height: 30px !important;
}
button.v-btn {
    font-size: 12px !important;
    font-weight: 600 !important;
    box-shadow: none !important;
    font-family: Montserrat, sans-serif !important;
    text-transform: capitalize !important;
}
  .search-menu {
    order: 0;
  }
</style>
