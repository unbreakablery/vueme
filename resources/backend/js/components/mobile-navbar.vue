<template>
  <v-container class="m-0 p-0" v-if="$vuetify.breakpoint.smAndDown">
    <ul class="navbar-nav m-0 p-0">
      <li class="nav-item white mr-0">
        <div class="col-12 white">
          <div
            id="profile"
            v-if="user.role_id == 1"
            :key="user.online"
            class="text-center p-3 pb-1"
          >
            <v-badge overlap bottom v-if="status" color="#2CC05F">
              <template v-slot:badge>{{ status.color }}</template>
              <a :href="'/' + user.userProfile.profile_link">
              <v-avatar size="150" style="background-color: rgb(142, 190, 248); border-color: rgb(142, 190, 248);">
                <v-img :alt="user.userProfile.display_name" :src="user.userProfile.haedshot_path"></v-img>
              </v-avatar>
              </a>
            </v-badge>
            <v-badge overlap bottom v-if="!status" color="#C7C7C7">
              <template v-slot:badge>{{ status.color }}</template>
              <a :href="'/' + user.userProfile.profile_link">
              <v-avatar size="150"  style="background-color: rgb(142, 190, 248); border-color: rgb(142, 190, 248);">
                <v-img :alt="user.userProfile.display_name" :src="user.userProfile.haedshot_path"></v-img>
              </v-avatar>
              </a>
            </v-badge>

            <p class="text-center p-2 pb-1 titleUser ">
              
              {{ user.userProfile.display_name  }}
              
              </p>
          </div>
          <div id="profile" v-if="user.role_id == 2" class="text-center">
            <v-avatar size="150" style="background-color: rgb(142, 190, 248); border-color: rgb(142, 190, 248);">
              <v-img :src="user.userProfile.haedshot_path"></v-img>
            </v-avatar>
            <p
              class="text-center titleUser "
            >
            
            {{ user.userProfile.name + ' ' + user.userProfile.last_name}}
            
            
            </p>
          </div>
        </div>

        <div
          id="under-profile"
          class="text-center pb-5 pr-0 pl-0 mr-0 ml-0 row m-0"
          v-if="user.role_id != 1"
        >
          <div class="col-6 col-md-6">
            <a href="/dashboard/profile" class="mMontserrat">
              <i class="far ico-edit"></i> Edit
            </a>
          </div>
          <div class="col-6 col-md-6">
            <a id="view_profile" :href="'/' + user.userProfile.profile_link" class="mMontserrat">
              <i class="far ico-view"></i> View
            </a>
          </div>

          <div id="under-profile" class="text-center pb-5 col-12" v-if="user.role_id == 2">
            <a href="/dashboard/user/profile" class="mMontserrat">
              <i class="far ico-edit"></i> Edit
            </a>
          </div>
        </div>
        <div id="under-profile" class="text-center pb-5 col-" v-else-if="user.role_id == 2">
          <a href="/dashboard/user/profile" class="mMontserrat" style="font-size:14px">
            <i class="far ico-edit"></i> Edit
          </a>
        </div>
      </li>

      <li class="nav-item pl-0 pt-0 white btn-todo-list-wrapper">
        <v-btn
            class="todo-items-btn"
            @click="dialog=true"
          >
          <img src="/images/model-dashboard/todo-list.svg" width="30px" height="30px" />
          To-Do Items
          <span class="ml-4" style="color: #949498;">
            {{completedTodoItems}} / {{totalTodoItems}}
          </span>
        </v-btn>
      </li>

      <li class="nav-item pl-0 pt-0"  color="#EBF4FD">
        <v-list dense v-if="user.role_id == 1" class="mobileMcon" style="height: 100% !important;">
          <v-list-item-group class="mobileSa">
            <v-list-item dense href="/dashboard/profile/1">
              <v-list-item-icon>
                <img src="/images/model-dashboard/edit.svg" width="30px" height="30px" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Edit Profile</v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item dense :href="'/' + user.userProfile.profile_link">
              <v-list-item-icon>
                <img src="/images/model-dashboard/eye.svg" width="30px" height="30px" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">View Profile</v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item dense href="/dashboard/services">
              <v-list-item-icon>
                <img src="/images/icons/services_bar.svg" width="30px" height="30px" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Pricing</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            
            <v-list-item dense href="/dashboard/">
              <v-list-item-icon>
                <img src="/images/model-dashboard/calendar-active.svg" width="30px" height="30px" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Appointments</v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item dense href="/dashboard/replays">
              <v-list-item-icon>
                <img src="/images/model-dashboard/play.svg" width="30px" height="30px" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Replay</v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item dense href="/dashboard/payout">
              <v-list-item-icon>
                <img src="/images/model-dashboard/money-icon.svg" width="30px" height="30px" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Money</v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item dense href="/dashboard/subscribers">
              <v-list-item-icon>
                <img src="/images/model-dashboard/reviews.svg" width="30px" height="30px" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Subscribers</v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item dense href="/dashboard/analytics">
              <v-list-item-icon>
                <img src="/images/model-dashboard/analytics.svg" width="30px" height="30px" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Analytics</v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item dense href="/dashboard/referrals">
              <v-list-item-icon>
                <img src="/images/model-dashboard/referrals.svg" width="30px" height="30px" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Referrals</v-list-item-title>
              </v-list-item-content>
            </v-list-item>                        
            
            <v-list-item
              class="logout"
              @click.prevent="logout()"
              dense
              style="padding-bottom:10px;"
            >
              <v-list-item-icon>
                <img src="/images/icons/logout.svg" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title style="color:#42424d !important">Log Out</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-item-group>
        </v-list>

        <v-list dense class="mobileMcon pt-1 pb-0" v-if="user.role_id == 2" color="#EBF4FD"  style="height: 100% !important;" >
          <v-list-item-group class="mobileSa" style="height: 100%;">

            <v-list-item href="/dashboard/user/replays" :ripple="false" class="mb-0 pt-2" >
              <v-list-item-icon>
                <img src="/images/icons/review.svg" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Reviews</v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item dense href="/dashboard/favorites" class="mb-0" >
              <v-list-item-icon>
                <img src="/images/icons/favorites.svg" width="30px" height="30px" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Favorites</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item href="/dashboard/transaction" class="mb-0" >
              <v-list-item-icon>
                <img src="/images/icons/moneys.svg" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Transactions</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item href="/dashboard/payment" class="mb-0" >
              <v-list-item-icon>
                <img src="/images/icons/payment.svg" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Payment</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
<!-- 
            <v-list-item href="/about">
              <v-list-item-icon>
                <img src="/images/icons/about.svg" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">About</v-list-item-title>
              </v-list-item-content>
            </v-list-item> -->


            <v-list-item href="/horoscope" class="mb-0" >
              <v-list-item-icon>
                <img src="/images/icons/horoscope.svg" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Horoscopes</v-list-item-title>
              </v-list-item-content>
            </v-list-item>



            <v-list-item href="https://respectfully.zendesk.com/hc/en-us"  target="_blank" class="mb-0" >
              <v-list-item-icon>
                <img src="/images/icons/help.svg" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Help</v-list-item-title>
              </v-list-item-content>
            </v-list-item>



            <v-list-item href="/blog" class="mb-0" >
              <v-list-item-icon>
                <img src="/images/icons/blog.svg" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title class="mMontserrat">Blog</v-list-item-title>
              </v-list-item-content>
            </v-list-item>



            <v-list-item class="logout" @click.prevent="logout()" >
              <v-list-item-icon>
                <img src="/images/icons/logout.svg" />
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title style="color:rgb(162, 162, 162) !important">Log Out</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-item-group>
        </v-list>
      </li>
    </ul>
    <!-- Links -->
    
    <v-row justify="center">
      <v-dialog
        v-model="dialog"
        fullscreen
        hide-overlay
        transition="dialog-bottom-transition"
      >
        <v-card color="#f9f9f9">
          <v-toolbar
            color="#f9f9f9"
            style="box-shadow: none;"
          >
            <v-toolbar-title></v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
              <v-btn
              icon
              dark
              @click="dialog = false"
              >
                <v-icon>mdi-close</v-icon>
              </v-btn>
            </v-toolbar-items>
          </v-toolbar>
          <v-subheader class="subheader">
            <img src="/images/model-dashboard/todo-list.svg" width="30px" height="30px" />
            To-Do Items
          </v-subheader>
          <v-subheader class="subheader2">
            Complete these steps to go live and start earning $!
          </v-subheader>
          <v-list dense v-if="user.role_id == 1" class="mobileMcon" style="height: 100% !important;background-color: #f9f9f9;">
            <v-list-item-group class="mobileSa">
              <v-list-item dense class="h-48" href="/dashboard/profile/1">
                <v-list-item-content>
                  <v-list-item-title :class="['todo-items-list', (completedProfilePhoto) ? 'todo-item-completed' :  '']">Add a profile photo</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item dense class="h-48" href="/dashboard/profile/1">
                <v-list-item-content>
                  <v-list-item-title :class="['todo-items-list', (completedBio) ? 'todo-item-completed' :  '']">Add a bio</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item dense class="h-48" href="/dashboard/services">
                <v-list-item-content>
                  <v-list-item-title :class="['todo-items-list', (completedSetRate) ? 'todo-item-completed' :  '']">Set your rate</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item dense class="h-48" href="/dashboard/payout">
                <v-list-item-content>
                  <v-list-item-title :class="['todo-items-list', (completedBankAccount) ? 'todo-item-completed' :  '']">Connect a bank account</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item dense class="h-48" href="/dashboard/chat">
                <v-list-item-content>
                  <v-list-item-title :class="['todo-items-list', (completedGoLive) ? 'todo-item-completed' :  '']">Go Live</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-item-group>
          </v-list>
        </v-card>
      </v-dialog>
    </v-row>
  </v-container>
  <!-- <v-container class="m-0 p-0" v-else @="this.window.location.href = '/dashboard/menu'"></v-container> -->
</template>

<script>
// import { EventBus } from "../event-bus.js";
import { mapGetters } from "vuex";
export default {
  props: ["user"],
  // watch: {
  //   user(newUser) {
  //     this.status = newUser.online;
  //   },
  // },
  data() {
    return {
      status: this.user.online,
      dialog: false,
      totalTodoItems: 5,
      completedTodoItems: 0,
      completedProfilePhoto: false,
      completedBio: false,
      completedSetRate: false,
      completedBankAccount: false,
      completedGoLive: false
    };
  },
  filters: {
    ampmtime: function (time) {
      if (typeof time == "string") {
        time = time.split(":"); // convert to array

        // fetch
        var hours = Number(time[0]);
        var minutes = Number(time[1]);

        if (typeof time[2] != "undefined") {
          var seconds = Number(time[2]);
        } else {
          var seconds = 0;
        }

        // calculate
        var timeValue;

        if (hours > 0 && hours <= 12) {
          timeValue = "" + hours;
        } else if (hours > 12) {
          timeValue = "" + (hours - 12);
        } else if (hours == 0) {
          timeValue = "12";
        }

        timeValue += minutes < 10 ? ":0" + minutes : ":" + minutes; // get minutes
        //timeValue += (seconds < 10) ? ":0" + seconds : ":" + seconds;  // get seconds
        timeValue += hours >= 12 ? " P.M." : " A.M."; // get AM/PM

        return timeValue;
      }
    },
  },
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
    }),
  },
  created() {
    // EventBus.$on("changed-event", (status) => {
    //   this.status = status;
    // });
    
    // Dynamically calculates completed todo items
    this.completedTodoItems = 0;
    if (this.user.userProfile.haedshot_path != null && 
        this.user.userProfile.haedshot_path != undefined &&
        this.user.userProfile.haedshot_path != '') {
          var pArr = this.user.userProfile.haedshot_path.split('/');
          var image = pArr[pArr.length - 1];
          if (image != null && image != '' && image != 'AVATAR_DEFAULT.png'){
            this.completedTodoItems++;
            this.completedProfilePhoto = true;
          }
    }
    if (this.user.userProfile.description != null && 
        this.user.userProfile.description != undefined &&
        this.user.userProfile.description != '') {
          this.completedTodoItems++;
          this.completedBio = true;
    }
    var flag1 = false;
    var flag2 = false;
    if (this.user.userService != null && 
        this.user.userService != undefined &&
        this.user.userService != []) {
          if (this.user.userService[0].service_id == 1 &&
              this.user.userService[0].active == 1 &&
              this.user.userService[0].rate == "2.00" &&
              this.user.userService[1].service_id == 2 &&
              this.user.userService[1].active == 1 &&
              this.user.userService[1].rate == "2.00") {
                flag1 = true;
              }
    }
    if (this.user.subscriptions != null && 
        this.user.subscriptions != undefined &&
        this.user.subscriptions != []) {
          this.user.subscriptions.every(s => {
            if (s.name == "Subscription" && s.status == 1 && (s.price == '0.00' || s.price == null)) {
              flag2 = true;
              return false;
            }
          });
    }
    if (!(flag1 && flag2)) {
      this.completedTodoItems++;
      this.completedSetRate = true;
    }

    if (this.user.deposit_account == 1) {
          this.completedTodoItems++;
          this.completedBankAccount = true;
    }
    
    if (!this.mobile) {
      window.location.href = "/dashboard";
    }
  },
  methods: {
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
  },
};
</script>
<style>
#navbarSupportedContent1 {
  background: #ebf4fd;
}
#navbarSupportedContent1 .navbar-nav {
  display: block;
  padding-left: 0px !important;
  padding-right: 0px !important;
}
.v-application a {
  color: rgba(0, 0, 0, 0.87) !important;
}
</style>
<style scoped>
.v-list-item .v-list-item__content .todo-item-completed {
  color: #949498 !important;
}
.subheader {
  font-size: 28px;
  font-weight: 700;
  color: #0f0f0f;
  background-color: #f9f9f9;
  margin-top: 24px;
}
.subheader2 {
  font-size: 14px;
  font-weight: 400;
  color: #949498;
  background-color: #f9f9f9;
  padding: 0 24px;
}
.todo-items-list {
  color: #9759ff !important;
  font-size: 16px !important;
  font-weight: 700 !important;
}
.btn-todo-list-wrapper {
  display: contents;
}
.todo-items-btn {
	font-size: 14px;
  font-weight: 600;
	text-align: center;
  letter-spacing: 0px;
	display: flex;
  align-items: center;
  justify-content: center;
	background-color: rgba(151, 89, 255, 0.1) !important;
	height: 40px !important;
	text-align: center;
	border-radius: 6px;
	border:2px solid #9759FF;
	line-height: 40px;
	cursor: pointer;
  margin: 0 24px;
  color: #0F0F0F !important;
  font-weight: 700 !important;
}
.todo-items-btn .v-list-item__title {
  color: #0F0F0F !important;
  font-weight: 700;
}
.mobileSa a, .mobileSa .logout {
  height: 40px !important;
  margin: 0 !important;
}
.mobileSa a.h-48{
  height: 48px !important;
}
.mMontserrat, .mMontserrat.v-list-item__title {
  color: #131220 !important;
}
</style>