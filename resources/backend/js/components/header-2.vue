<template>
  <div style="position: fixed;z-index: 10;width: 100%;" class="model-header">
    
   <header-info :user="user" included='backend'></header-info> 
  <div v-if="user" id="the_top_bar" :class="{'home_header': user && user.role_id == 2}" :style="[ $vuetify.breakpoint.xsOnly && user && user.role_id == 2 ? {'height': '60px !important'}:{}]">
    
    <div  :class="[user && user.role_id == 2 ? 'logo_container' : '']"  :style="{
                      'background-color': user && user.role_id == 2
                        ? 'transparent'
                        : '',
                    }">



      <div v-if="!mobile" class="row row-top-bar m-0">
        <div
          class="col logo_container text-center d-flex align-center justify-center"
          style="max-width: 268.5px!important;height: 80px;" :style="{
                      'background': user && user.role_id == 2
                        ? 'transparent'
                        : '',
                    }"
        >
          <a href="/">
            <img
              alt="respectfully Logo"
              src="/images/site-images/respectfully_white.png"
              class="logo"
              style="margin: 0px;"
            />
          </a>
        </div>

        <div class="col pl-0 pr-0 d-flex" id="stats-row">
          <div id="top-bar" class="row justify-content-between" v-if="user && user.role_id == 1">
            <div class="d-flex">
              <div class="earning">
                <span class="earning-title">This Week</span>
                <span
                  class="earning-amount"
                >${{ current_balance | numFormat("0,0.00") }}</span>
              </div>
              <div style="height: 54px; margin: auto; border-right: 1px solid #D8D8D8;"></div>
              <div class="earning">
                  <span class="earning-title">Total Earnings</span>
                  <span class="earning-amount">${{ total_earning | numFormat("0,0.00") }}</span>
              </div>
            </div>

            <!-- <div class="col-3 px-5">
              <div class="inner">
                <span class="words d-none d-md-block text_header_data">Reviews</span>
                <span class="words d-block d-sm-block d-md-none">Favs</span>

                <span class>
                  <span class="words d-none d-md-inline-block">
                    {{
                    reviews
                    }}
                  </span>
                  <span class="words d-inline-block d-sm-inline-block d-md-none">{{ reviews }}</span>
                  <v-rating
                    class="d-inline-flex hStars"
                    v-model="reviews_rating"
                    background-color="yellow darken-2"
                    color="yellow darken-2"
                    readonly
                    dense
                    half-increments
                    small
                  ></v-rating>
                </span>
              </div>
            </div> -->

            <div class="d-flex align-items-center mr-25">
              <!-- <div>
                <text-chat-notifications color="#9759FF" size="27px" :user="user"></text-chat-notifications>
              </div> -->
              <toxbox-chat-notifications
                color="#9759FF"
                size="27px"
                :user="user"
                header="header2"
              ></toxbox-chat-notifications>
              <v-menu v-model="menu_opened" offset-y left content-class="my-menu">
                <template v-slot:activator="{ on }">
                  <a v-on="on" class="d-flex align-center">
                    <div
                      class="w-profile"
                      style="width: 40px"
                      :style="[
                        menu_opened
                          ? {
                              'background-image':
                                'url(/images/icons/profile-active.svg)',
                            }
                          : {
                              'background-image':
                                'url(/images/icons/w-profile.svg)',
                            },
                      ]"
                    ></div>
                  </a>
                </template>
                <v-card style="border-radius:  5px !important;" :min-width="300" :min-height="150">
                  <v-list dense class>
                      <v-list-item-group color="primary">
                          <v-list-item dense class="px-5" href="/dashboard/profile">
                            <v-list-item-icon>
                                <img src="/images/model-dashboard/edit.svg" />
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title><p>Edit Profile</p></v-list-item-title>
                            </v-list-item-content>
                          </v-list-item>
                          <v-list-item dense class="px-5" :href="'/'+link">
                            <v-list-item-icon>
                                <img src="/images/model-dashboard/eye.svg" />
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title><p>View Profile</p></v-list-item-title>
                            </v-list-item-content>
                          </v-list-item>
                          <v-list-item dense class="px-5" href="/dashboard/services">
                            <v-list-item-icon>
                                <img src="/images/model-dashboard/money.svg" />
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title><p>Pricing</p></v-list-item-title>
                            </v-list-item-content>
                          </v-list-item>
                          <v-list-item dense class="px-5" href="/dashboard">
                          <v-list-item-icon>
                              <img src="/images/icons/calendar.svg" />
                          </v-list-item-icon>
                          <v-list-item-content>
                              <v-list-item-title><p>Appointments</p></v-list-item-title>
                          </v-list-item-content>
                          </v-list-item>

                          <v-list-item dense class="px-5" href="/dashboard/replays">
                          <v-list-item-icon>
                              <img src="/images/model-dashboard/play.svg" />
                          </v-list-item-icon>
                          <v-list-item-content>
                              <v-list-item-title><p>Replays</p></v-list-item-title>
                          </v-list-item-content>
                          </v-list-item>

                          
                          <v-list-item class="px-5" href="/dashboard/payout">
                          <v-list-item-icon>
                              <img src="/images/model-dashboard/money-icon.svg" />
                          </v-list-item-icon>
                          <v-list-item-content>
                              <v-list-item-title><p>Money</p></v-list-item-title>
                          </v-list-item-content>
                          </v-list-item>
                          <v-list-item class="px-5" href="/dashboard/subscribers">
                          <v-list-item-icon>
                              <img src="/images/model-dashboard/reviews.svg" />
                          </v-list-item-icon>
                          <v-list-item-content>
                              <v-list-item-title><p>Subscribers</p></v-list-item-title>
                          </v-list-item-content>
                          </v-list-item>
                          <v-list-item class="px-5" href="/dashboard/analytics">
                          <v-list-item-icon>
                              <img src="/images/model-dashboard/analytics.svg" />
                          </v-list-item-icon>
                          <v-list-item-content>
                              <v-list-item-title><p>Analytics</p></v-list-item-title>
                          </v-list-item-content>
                          </v-list-item>

                          <v-list-item class="px-5" href="/dashboard/referrals">
                          <v-list-item-icon>
                              <img src="/images/model-dashboard/referrals.svg"/>
                          </v-list-item-icon>
                          <v-list-item-content>
                              <v-list-item-title><p>Referrals</p></v-list-item-title>
                          </v-list-item-content>
                          </v-list-item>
                          
                          <v-list-item class="px-5" @click.prevent="logout()" dense>
                          <v-list-item-icon>
                              <img src="/images/icons/logout.svg" />
                          </v-list-item-icon>
                          <v-list-item-content>
                              <v-list-item-title style="color:rgb(162, 162, 162) !important"><p style="color:#42424d60 !important">Log Out</p></v-list-item-title>
                          </v-list-item-content>
                          </v-list-item>
                      </v-list-item-group>
                  </v-list>
                </v-card>
              </v-menu>
            </div>
          </div>
          <div
            id="top-bar"
            class="row pr-0"
            style="background-color: transparent; height: 80px;padding-top: 22px; padding-bottom: 18px;"
            v-else-if="user && user.role_id == 2"
          >
            <div class="col-9 px-5"></div>

            <!-- <div class="col-3 pt-2 d-flex "> -->
            <div class="col-3 pr-0 d-flex justify-end">
              <div class="d-flex">
                <credits
                  v-if="user && user.role_id === 2"
                  :user="user"
                  class="mt-2"
                  style="margin-right: 10px !important; "
                />
                <text-chat-notifications color="white" size="25px" :user="user"></text-chat-notifications>
                <toxbox-chat-notifications
                  color="white"
                  size="25px"
                  :user="user"
                  style="margin-left: 10px !important;margin-right: 0px !important;"
                  header="header2"
                ></toxbox-chat-notifications>
              </div>
              <v-menu v-model="menu_opened" offset-y left content-class="my-menu">
                <template v-slot:activator="{ on }">
                  <a
                    v-on="on"
                    :style="{
                      marginRight: $vuetify.breakpoint.mdAndDown
                        ? '89px'
                        : '89px',
                    }"
                    style="margin-left: 10px"
                  >
                    <div
                      class="w-profile"
                      style="width: 40px"
                      :style="[
                        menu_opened
                          ? {
                              'background-image':
                                'url(/images/icons/profile-active.svg)',
                            }
                          : {
                              'background-image':
                                'url(/images/icons/profile.svg)',
                            },
                      ]"
                    ></div>
                  </a>
                </template>
                <v-card style="border-radius:  5px !important;" :min-width="300" :min-height="150">
                  <v-list dense class>
                    <v-list-item-group color="primary">
                      <v-list-item dense class="px-5" href="/dashboard/appointments">
                        <v-list-item-icon>
                          <img src="/images/icons/header-calendar.svg" />
                        </v-list-item-icon>
                        <v-list-item-content>
                          <v-list-item-title>Appointments</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>

                      <v-list-item class="px-5" href="/dashboard/user/replays">
                        <v-list-item-icon>
                          <img src="/images/icons/review.svg" />
                        </v-list-item-icon>
                        <v-list-item-content>
                          <v-list-item-title>Reviews</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>

                      <v-list-item dense class="px-5" href="/dashboard/favorites">
                        <v-list-item-icon>
                          <img src="/images/icons/favorites.svg" />
                        </v-list-item-icon>
                        <v-list-item-content>
                          <v-list-item-title>Favorites</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                      <v-list-item class="px-5" href="/dashboard/transaction">
                        <v-list-item-icon>
                          <img src="/images/icons/moneys.svg" />
                        </v-list-item-icon>
                        <v-list-item-content>
                          <v-list-item-title>Transactions</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                      <v-list-item class="px-5" href="/dashboard/payment">
                        <v-list-item-icon>
                          <img src="/images/icons/payment.svg" />
                        </v-list-item-icon>
                        <v-list-item-content>
                          <v-list-item-title>Payment</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>

                      <v-list-item class="px-5" @click.prevent="logout()" dense>
                        <v-list-item-icon>
                          <img src="/images/icons/logout.svg" />
                        </v-list-item-icon>
                        <v-list-item-content>
                          <v-list-item-title style="color:rgb(162, 162, 162) !important">Log Out</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-list-item-group>
                  </v-list>
                </v-card>
              </v-menu>
            </div>
          </div>
        </div>
      </div>

      <!--Navbar-->
      <nav class="navbar model-mobile-header" style="max-height: 50px; height: 50px; " v-if="mobile" id="mobile-nav">
        <v-row>
          <v-col v-if="user && user.role_id === 1" :md="4" class="text-center">
            <v-btn text icon color="white" href="/dashboard" class="model-mobile-header-icon">
              <img :src="mobile_menu_calendar_img" />
            </v-btn>
            <p :class="['model-mobile-header-text', (mobile_menu_calendar_active == true) ? 'text-grey' : 'text-light-grey']">Calendar</p>
          </v-col>
          <v-col :md="4" class="text-center">
            <v-btn text icon color="white" href="/chat" class="model-mobile-header-icon">
              <img :src="'/images/model-dashboard/header-live.svg'" />
            </v-btn>
            <p class="model-mobile-header-text text-red">Go Live</p>
          </v-col>
          <v-col :md="4" class="text-center">
            <toxbox-chat-notifications-model-mobile style="" color="black" size="30px" :user="user" @active-menu="activeMenu"></toxbox-chat-notifications-model-mobile>
          </v-col>
          <v-col v-if="user && user.role_id === 1" :md="4" class="text-center">
            <v-btn text icon color="white" href="/dashboard/menu" class="model-mobile-header-icon">
              <img :src="mobile_menu_settings_img" />
            </v-btn>
            <p :class="['model-mobile-header-text', (mobile_menu_settings_active == true) ? 'text-grey' : 'text-light-grey']">Settings</p>
          </v-col>
        </v-row>
      </nav>
      <!--/.Navbar-->
    </div>
  </div>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  props: ["user"],
  data: function () {
    return {
      menu_opened: false,
      loading: false,
      errors: [],
      signupDialog: false,
      message: "",
      messageDialog: "",
      reviews: 0,
      total_earning: 0,
      profile_views: 0,
      reviews_rating: 0.0,
      current_balance: 0,
      menu_opened: false,
      mobile_menu_calendar_img: "/images/model-dashboard/header-calendar.svg",
      mobile_menu_calendar_active: false,
      mobile_menu_settings_img: "/images/model-dashboard/header-user.svg",
      mobile_menu_settings_active: false,
      link: null
    };
  },
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
    }),
  },
  created() {
    if (window.location.pathname == "/dashboard") {
      this.mobile_menu_calendar_img = "/images/model-dashboard/calendar-active.svg";
      this.mobile_menu_calendar_active = true;
    } else if (window.location.pathname == "/dashboard/menu") {
      this.mobile_menu_settings_img = "/images/model-dashboard/user-active.svg";
      this.mobile_menu_settings_active = true;
    }
  },
  mounted() {
    if(this.user)
      this.f_data_header();
  },
  ready() {},

  methods: {
    f_data_header() {
      axios
        .get("/api/v1/user/hdata")
        .then((response) => {
          if (response.status === 200) {
            this.total_earning = response.data.success.t_earning;
            this.reviews = response.data.success.reviews;
            this.profile_views = response.data.success.p_views;
            this.current_balance = response.data.success.current_balance;
            this.reviews_rating = response.data.success.reviews_rating;
            this.link = response.data.success.link || null;
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
    activeMenu(data) {
      if (data.notification == false) {
        if (window.location.pathname == "/dashboard") {
          this.mobile_menu_calendar_img = "/images/model-dashboard/calendar-active.svg";
          this.mobile_menu_calendar_active = true;

          this.mobile_menu_settings_img = "/images/model-dashboard/header-user.svg";
          this.mobile_menu_settings_active = false;
        } else if (window.location.pathname == "/dashboard/menu") {
          this.mobile_menu_settings_img = "/images/model-dashboard/user-active.svg";
          this.mobile_menu_settings_active = true;

          this.mobile_menu_calendar_img = "/images/model-dashboard/header-calendar.svg";
          this.mobile_menu_calendar_active = false;
        } else {
          this.mobile_menu_calendar_img = "/images/model-dashboard/header-calendar.svg";
          this.mobile_menu_calendar_active = false;

          this.mobile_menu_settings_img = "/images/model-dashboard/header-user.svg";
          this.mobile_menu_settings_active = false;
        }
      } else {
        this.mobile_menu_calendar_img = "/images/model-dashboard/header-calendar.svg";
        this.mobile_menu_calendar_active = false;

        this.mobile_menu_settings_img = "/images/model-dashboard/header-user.svg";
        this.mobile_menu_settings_active = false;
      }
    }
  },
};
</script>
<style scoped>
.model-mobile-header-icon {
  width: 30px;
  height: 30px;
}
.model-mobile-header-text {
  font-size: 10px;
  font-weight: 600;
  margin: 0;
}
.mobile_chat_notifications {
  position: absolute;
  float: right;
  right: 65px;
  top: 32px;
  display: flex;
}
.text-red {
  color: #E31616;
}
.text-light-grey {
  color: #949498;
}
.text-grey {
  color: #131220;
}
#stats-row [class*="col"] .words {
  color: #4d4f5c !important;
  opacity: 1;
  font-weight: 500 !important;
  letter-spacing: 0.28px;
}
.text_header_data {
  font-weight: 500 !important;
  color: #43425d !important;
  opacity: 0.5 !important;
}

.v-rating.v-rating--dense .yellow--text.text--darken-2 {
  color: #f4c150 !important;
  caret-color: #f4c150 !important;
}
.v-dialog__content--active {
  opacity: 1 !important;
  -webkit-backdrop-filter: blur(10px);
  backdrop-filter: blur(10px);
}
</style>
<style lang="scss">
.model-header {
  box-shadow: 0px 3px 6px #00000029;
  #top-bar {
    padding: 0px;
  }
  .logo {
    width: 176px!important;
    height: 50px;
  }
  #stats-row {
    margin-left: 0px!important;
  }
  .earning {
    width: 160px;
    padding-left: 24px;
    display: flex;
    flex-flow: column;
    justify-content: center;
    .earning-title {
      color: #1F1E34!important;
      font-size: 14px;
      opacity: 0.8!important;
    }
    .earning-amount {
      color: #1F1E34;
      font-size: 20px;
      font-weight: bold;
    }
  }
  #the_top_bar {
    .row-top-bar {
      display: flex!important;
    }
  }
}
@media (max-width: 959.98px) {
  .model-header {
    bottom: 0px;
  }
}
.mr-25 {
  margin-right: 100px;
}
.model-mobile-header {
  background: white!important;
  padding: 0px!important;
}
</style>
<style scoped lang="scss">
.my-menu {
  margin-left: 20px !important;
  margin-top: 0 !important;

  &::before {
    border-bottom: 13px solid #fff !important;
  }

  .v-list-item-group {
    padding: 30px 24px 30px;
    .v-list-item {
      img {
        width: 20px;
      }
      p {
        margin: 0!important;
        font-size: 14px;
        font-weight: 500;
        color: #131220;
      }
    }
  }
}
</style>