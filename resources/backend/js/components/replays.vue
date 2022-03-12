<template>
  <div class="fan-replays">
    <form class="form-dashboard" @submit="updateUserServices">
         
         <!-- v-if="users.length == 0"  -->
        <div 
          class="user-card py-3" style="background-color: #f4f4f4; padding: 40px 40px !important; color: #c7c7c7;">
            <img  src="/images/icons/play icon.svg" style="opacity: 0.5; display:inline-block; width:20px; height:21px" /> &nbsp; <span>Currently Empty</span>
        </div>

      <!-- use this for match with design with data -->
      <!-- <div id="form-panel" class="white m-0" v-if="users.length>0" >
        <v-list-item-group  color="primary" active-class="primary--text">

         


          <div class="user-card py-3" v-for="(user, i) in users" :key="i" :href="user.href"
            :target="user.target" >
            <div>
              <img :src="user.src"/>
            </div>
            <div class="user-btn">
              <div id="follow-font">
                <h2 id="name">{{user.name}}</h2>
                <div class="d-flex">
                  <div class="Date">
                      <img :src="user.src1" alt="" style="fill:grey">
                  </div>
                  <h6 id="Date-n">{{user.date}}</h6>
                  <h6 id="Date-m">{{user.min}}</h6>
                </div>
              </div>
              <div class="btn-set" style="float: right" >
                <v-btn id="watch-btn"  outlined color="#9759FF" rounded><span class="text">Watch</span></v-btn>
              </div>
            </div>
          </div>
        </v-list-item-group>
      </div> -->
      
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      users: [
      {
        src: "/images/icons/messaging-about.png",
        name:"Sydney Goodman",
        src1:"/images/icons/calendar_icon.svg",
        date:"05/05",
        min:"16 minutes",
        // href: "/dashboard/",
        target: "_self",
      },
      {
        src: "/images/icons/messaging-about.png",
        name:"Sydney Goodman",
        src1:"/images/icons/calendar_icon.svg",
        date:"05/05",
        min:"16 minutes",
        // href: "/dashboard/services",
        target: "_self",
      },
      {
        src: "/images/icons/messaging-about.png",
        name:"Sydney Goodman",
        src1:"/images/icons/calendar_icon.svg",
        date:"05/05",
        min:"16 minutes",
        // href: "/dashboard/reviews",
        target: "_self",
      },
      {
        src: "/images/icons/messaging-about.png",
        name:"Sydney Goodman",
        src1:"/images/icons/calendar_icon.svg",
        date:"05/05",
        min:"16 minutes",
        // href: "/dashboard/cosmic-rewards",
        target: "_self",
      },
      {
        src: "/images/icons/messaging-about.png",
        name:"Sydney Goodman",
        src1:"/images/icons/calendar_icon.svg",
        date:"05/05",
        min:"16 minutes",
        // href: "/dashboard/payout",
        target: "_self",
      },
    ],
      free_chat: true,
      savingUserServices: false,
      usSaved: false,
      services: [],
      user_services: [],
      user_service: {},
      browserSupported: [],
      user_id: 0,
      errors: {
        user_services: [],
      },
      message: "",
    };
  },

  methods: {
    rate_suffix(id) {
      if (id == 2) {
        return "per message";
      } else {
        return "per minute";
      }
    },
    /**
     * Prepare the component.
     */
    getServices() {
      axios
        .get("/api/v1/user/services")
        .then((response) => {
          this.services = response.data.success.services;
          this.user_services = response.data.success.user_services;
          this.user_id = response.data.success.user_id;
          this.free_chat = response.data.success.free_chat;
          this.browserSupported = response.data.success.browserSupported;

          if (this.user_services.length == 0) {
            this.services.forEach((the_s) => {
              this.user_services.push({
                service_id: the_s.id,
                active: false,
                rate: 0,
                min_duration: 0,
              });
            });
          }

          for (var index_us in this.user_services) {
            var the_s = this.user_services[index_us];

            this.user_service[the_s.service_id] = the_s;
          }
        })
        .catch(function (error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            //location.reload();
          }
        });
    },
    updateUserServices(e) {
      e.preventDefault();

      this.savingUserServices = true;

      for (var index_us in this.user_services) {
        var the_s = this.user_services[index_us];

        if (!the_s.active && the_s.rate == "") {
          the_s.rate = 0;
        }

        if (!the_s.active && the_s.min_duration == "") {
          the_s.min_duration = 0;
        }
      }

      axios
        .post("/api/v1/user/services/save", {
          user_id: this.user_id,
          user_services: this.user_services,
          free_chat: this.free_chat,
        })
        .then((response) => {
          setTimeout(() => {
            this.savingUserServices = false;
            this.usSaved = true;

            setTimeout(() => {
              this.usSaved = false;
            }, 2000);
          }, 1000);

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
  },
  computed: {
    minutes() {
      let minutes = [];

      for (let i = 0, j = 5; i < 14; i++) {
        if (j < 60) {
          minutes.push({ text: j + " min", value: j });
          j += j < 20 ? 5 : 10;
        } else {
          if (j == 60) minutes.push({ text: "1 hr", value: j });
          else if (j < 120)
            minutes.push({ text: "1:" + (j - 60) + " hr", value: j });
          else minutes.push({ text: "2 hr", value: j });
          j += 10;
        }
      }
      return minutes;
    },
  },
  mounted() {
    this.getServices();

    if (
      location.pathname == "/dashboard/services" ||
      location.pathname == "/dashboard/services/"
    ) {
      document.querySelectorAll("#sidebar-call-text-video").forEach((ele) => {
        ele.style.display = "none";
      });

      document.querySelectorAll("#online-dropdown").forEach((ele) => {
        ele.style.display = "none";
      });
    }
  },
};
</script>

</style>
