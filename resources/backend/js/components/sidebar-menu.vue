<template>
  <div v-if="!$vuetify.breakpoint.smAndDown">
    <div id="profile" v-if="user.role_id == 1" class="text-center model-sidebar">
      <a :href="'/' + user.userProfile.profile_link">
        <v-avatar size="150">
        <v-img
          :alt="display_name_var"
          :src="user.userProfile.haedshot_path"
        ></v-img>
      </v-avatar>
      </a>

      <p class="text-center titleUser">
        {{ display_name_var }}
      </p>
    </div>
    

    <div
      id="profile"
      v-if="user.role_id == 2"
      class="text-center"
    >
      <v-avatar size="150">
        <v-img :src="user.userProfile.haedshot_path"></v-img>
      </v-avatar>
      <p class="text-center titleUser">
        {{ user.userProfile.name + " " + user.userProfile.last_name }}
      </p>

      <!-- <div
        id="under-profile"
        class="text-center"
        v-if="user.role_id == 2"
        style="margin-top: 16px"
      >
        <a href="/dashboard/user/profile"> -->
          <!-- <i class="far ico-edit"></i> Edit -->
          <!-- <img
            src="/images/site-images/pencil.svg"
            width="30"
            height="30"
            style="margin-left: -7px"
          />
          <span style="margin-left: 15px" class="mMontserrat">Edit</span>
        </a>
      </div> -->
    </div>
    <div class="border_bottom"></div>
    <div>
      <div
        id="under-profile"
        class="text-center row m-0"
        v-if="user.role_id == 1"
      >
        <div class="model-live">
          <!-- <a href="#" class="btn btn-live">
          <img src="/images/model-dashboard/live-icon.svg">
          <span @click="golivedialog = true" class="go-live">Go Live</span>
          </a> -->
          <v-dialog
      v-model="golivedialog"
      persistent
      max-width="290"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="#E31616"
          dark
          v-bind="attrs"
          class="btn btn-live go-live"
          v-on="on"
        >
        <img src="/images/model-dashboard/live-icon.svg">
          <span class="go-live">Go Live</span>
        </v-btn>
      </template>
      <v-card>
        <div style="height: 15px"></div>
      <!--Important to preserve correct icon click area and top position -->
      <v-icon large style="position: absolute; right: 10px" @click="golivedialog = false"
        >mdi-close</v-icon
      >
      <div class="pa-5 pt-10">
        <v-container fluid class="dialogTitle">
          <v-row justify="center" align="center" class="text-center d-flex">
            <v-col align="center" justify="center">
              <v-row><h1 style="font-size: 18px;
                              text-align: center;
                              width: 100%;
                              color: #131220;">Livestream Options</h1></v-row>
            </v-col>
          </v-row>
        
        </v-container>
        <v-card-actions style="display: block;text-align: center;">
          <v-spacer></v-spacer>
          <v-btn
          class="py-5 px-6"
          style="
              width: 159px !important;
              background: linear-gradient(256deg, #7272ff 0%, #9759ff 100%);
              box-shadow: 0 2px 4px #9759ff4d  !important;
              border-radius: 12px;
              outline: none;
            "
            type="submit"
            color="primary"
            rounded
            @click="golivedialog = false;createLiveStream();"
          >
          <span style="font-size: 12px; letter-spacing: 0.43px">Stream Now</span>
            
          </v-btn>
          <v-btn
            class="py-5 px-6 mt-2 ml-0"
          style="
              width: 159px !important;
              background: #fff;
              box-shadow: 0 1px 4px #9759ff4d !important;
              border: 1px solid #7272ff ;
              border-radius: 12px;
              outline: none;
            "
            type="submit"
            color="#fff"
            rounded
            @click="golivedialog = false"
            href="/dashboard/private-schedule"
          >
          <span style="font-size: 12px; letter-spacing: 0.43px; 
          color:#7272ff !important;">Schedule Stream</span>
          </v-btn>
        </v-card-actions>
        </div>
      </v-card>
    </v-dialog>


        </div> 
      </div>
      <!-- <div id="under-profile" class="text-center" v-else-if="user.role_id == 2">
        <a href="/dashboard/user/profile">
          <i class="far ico-edit"></i> Edit
        </a>
      </div>-->
    </div>

    <div
      id="sidebar-schedule"
      class="d-none d-md-block"
      v-if="concated_user_schedule.length > 0 && user.role_id == 1"
    >
      <span
        style="
          font-family: Montserrat, sans-serif;
          font-size: 14.4px;
          font-weight: 500;
          color: #1f1e34;
        "
        >Schedule</span
      >

      <div class="row" :v-for="cs in concated_user_schedule">
        <div class="col-auto mr-auto" style="padding-left: 12px !important"  key="index">
          {{ cs.days }}
        </div>
        <div class="col-auto" style="padding-right: 0px !important">
          {{ cs.from | ampmtime }}-{{ cs.till | ampmtime }}
        </div>
      </div>
    </div>

    <v-list dense class="mt-0" v-if="user.role_id == 1">
      <v-list-item-group
        v-model="link"
        color="primary"
        active-class="primary--text"
      >
        <v-list-item
          v-for="(item, i) in items"
          :key="i"
          class="px-6"
          :href="item.href"
          :target="item.target"
        >
          <v-list-item-icon>
            <img :src="item.icon" />
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title
              v-text="item.text"
              class="mMontserrat"
            ></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-item-group>
    </v-list>

    <v-list dense class="mt-3 menu-items" v-else-if="user.role_id == 2">
      <v-list-item-group
        v-model="link"
        color="primary"
        active-class="primary--text"
      >
        <v-list-item
          v-for="(item, i) in items_user"
          :key="i"
          class="px-5"
          :href="item.href"
          :target="item.target"
        >
          <v-list-item-icon>
            <img :src="item.icon" />
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title v-text="item.text"></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-item-group>
    </v-list>
        
  </div>
</template>

<script>
export default {
  props: ["link", "user"],
  data: () => ({
    loading: true,
    status: false,
    switchcall: true,
    switchtxt: false,
    switchvideo: false,
    golivedialog: false,
    display_name_var:"",
    items_user: [
      {
        text: "Edit Profile",
        icon: "/images/icons/edit icon.svg",
        href: "/dashboard/user/profile",
        target: "_self",
      },
      {
        text: "Following",
        icon: "/images/icons/heart icon.svg",
        href: "/dashboard/favorites",
        target: "_self",
      },
      {
        text: "Subscriptions",
        icon: "/images/model-dashboard/reviews.svg",
        href: "/dashboard/user/subscriptions",
        target: "_self",
      },
      {
        text: "Appointments",
        icon: "/images/icons/calendar icon.svg",
        href: "/dashboard/appointments",
        target: "_self",
      },
      {
        text: "Transactions",
        icon: "/images/icons/money icon.svg",
        href: "/dashboard/transaction",
        target: "_self",
      },
      {
        text: "Payment Method",
        icon: "/images/icons/credit card icon.svg",
        href: "/dashboard/payment",
        target: "_self",
      },
      {
        text: "Replays",
        icon: "/images/icons/play icon.svg",
        href: "/dashboard/user/replays",
        target: "_self",
      },
    ],
    concated_user_schedule: [],
  }),
  created() {
    this.display_name_var = this.user.userProfile.display_name;
    this.status = this.user.online;
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
    items(){
     return [
      {
        text: "Edit Profile",
        icon: "/images/model-dashboard/edit.svg",
        href: "/dashboard/profile/1",
        target: "_self",
      },
      {
        text: "View Profile",
        icon: "/images/model-dashboard/eye.svg",
        href: '/' + this.user.userProfile.profile_link,
        target: "_self",
      },
      {
        text: "Pricing",
        icon: "/images/model-dashboard/money.svg",
        href: "/dashboard/services",
        target: "_self",
      },
      {
        text: "Appointments",
        icon: "/images/model-dashboard/calendar-active.svg",
        href: "/dashboard",
        target: "_self",
      },
      {
        text: "Replays",
        icon: "/images/model-dashboard/play.svg",
        href: "/dashboard/replays",
        target: "_self",
      },
      {
        text: "Money",
        icon: "/images/model-dashboard/money-icon.svg",
        href: "/dashboard/payout",
        target: "_self",
      },
      {
        text: "Subscribers",
        icon: "/images/model-dashboard/reviews.svg",
        href: "/dashboard/subscribers",
        target: "_self",
      },
      {
        text: "Analytics",
        icon: "/images/model-dashboard/analytics.svg",
        href: "/dashboard/analytics",
        target: "_self",
      },
      {
        text: "Referrals",
        icon: "/images/model-dashboard/referrals.svg",
        href: "/dashboard/referrals",
        target: "_self",
      },
    ]
    }
  },
    mounted() {
      let that=this;
    this.$root.$on("change_name_display", (data) => {
      console.log(data.name)
      that.update_displayname(data.name)
      
    });

  },

  methods: {
    update_displayname(name){
      this.display_name_var=name;
    },
    getUserSchedule() {
      axios
        .get("/api/v1/user/schedule")
        .then((response) => {
          this.concated_user_schedule = response.data.success.concated;
        })
        .catch(function (error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
    },
    
     createLiveStream(){
        axios
        .post("/api/v1/specialist/channel")
        .then((response) => {
           if(response.data.status){
                   window.location.href = response.data.channel;
           }
           console.log(response);
          
        })
        .catch(function (error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
        
      },

    updateUserServices() {
     
      //console.log('oka!');

      this.savingUserServices = true;

      axios
        .post("/api/v1/user/services/save", {
          user_id: this.user.id,
          user_services: this.user.userService,
        })
        .then((response) => {
          setTimeout(() => {
            this.savingUserServices = false;
            this.usSaved = true;

            setTimeout(() => {
              this.usSaved = false;
            }, 2000);
          }, 1000);

          this.status = response.data.success.user_online;
          this.message = response.data.message;
          this.errors = [];
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

          this.savingUserServices = false;
          this.message = "";
        });
    },

    postUserOnlineStatus(status) {
      axios
        .post("/api/v1/user/set_contact_status", { online: status })
        .then((response) => {
          console.log(
            `this is status from DB: ${response.data.success.data.online}`
          );
          this.user.online = response.data.success.data.online;
        })
        .catch(function (error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
    },
  },
};
</script>
<style>
.menu-items .v-list-item.v-list-item--link.v-list-item--active {
  background-color: #c2a5dd !important;
}
.boxProfile {
  width: 130px !important;
  min-height: 50px !important;
  vertical-align: middle;
  padding: 0px !important;
  padding-top: 13px !important ;
  margin-bottom: 10px !important;
}

.theme--light.v-list-item--active {
  background: #c3a6dd !important;
}
.v-list-item__title {
  color: #1f1e34 !important;
}

.theme--light.v-list-item--active:hover::before,
.theme--light.v-list-item--active::before {
  opacity: 0;
}
/* .v-badge__wrapper .v-badge__badge {
  top: 118px !important;
  left: 118px !important;
} */

#profile {
  padding: 20px 59px 23px !important;
}
.titleUser {
  padding-top: 20px !important;
  margin-bottom: 0px !important;
}
.border_bottom {
  width: 90%;
  border-top: 1px solid #1312201A;
  margin: 0 auto;
}
</style>
<style lang="scss">
.model-sidebar {
  .titleUser {
    padding-top: 10px!important;
    font-size: 16px;
    color: #42424D;
    font-weight: bold;
  }
}
.model-live {
  width: 100%;
  padding: 20px 54px;
}
.btn-live {
  background: #E31616 0% 0% no-repeat padding-box;
  border-radius: 12px;
  width: 100%;
  padding: 7px;
  display: flex;
  flex-flow: row;
  align-items: center;
  justify-content: center;
  .go-live {
    margin-left: 10px;
    font-size: 12px;
    font-weight: bold;
    color: #ffffff;
  }
}
.btn-live:focus {
  box-shadow: 0 0 0 0.2rem rgba(227, 22, 22, .25);
}
</style>