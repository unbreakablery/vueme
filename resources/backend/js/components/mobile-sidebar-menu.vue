<template>
  <div>
    <ul class="nav nav-pills" id="online-dropdown" style="margin-bottom: -5px;">
      <li class="nav-item" style="font-weight: 500; font-size: 12px; margin-top: 3px;">
        Service
        <i class="fas fa-circle" style="font-size: 8px;"></i> &nbsp;
      </li>
      <li id="user-dropdown" class="nav-item dropdown">
        <a
          data-toggle="dropdown"
          href="#"
          role="button"
          aria-haspopup="true"
          aria-expanded="false"
          class="dropdown-toggle"
        >
          <span style="color: #2CC05F; font-weight: 600; font-size: 12px;">Online</span>
        </a>
        <div
          x-placement="left"
          class="dropdown-menu dropdown-menu-left"
          style="border-color: #E6E9ED;  min-width: auto;"
        >
          <a href="#" class="dropdown-item" style="color: #2CC05F;">Online</a>
          <a href="#" class="dropdown-item" style="color: #999999;">Offline</a>
        </div>
      </li>
    </ul>

    <div
      class="container-fluid"
      style="background-color: rgba(249, 249, 249, .8); padding-top: 12px; padding-bottom: 12px; font-size: 12px; font-weight: 600;"
    >
      <div class="row collapse show collapse-c-switches messaging-row">
        <div class="col-4">
          <i class="fas fa-comments" style="margin-right: 5px;"></i> Chat
        </div>
        <div class="col-4">
          <i class="fas fa-phone fa-flip-horizontal" style="margin-right: 5px;"></i>
          Call
        </div>
        <div class="col-4">
          <i class="fas fa-video" style="margin-right: 5px;"></i> Video
        </div>

        <div class="col-4" style="border: 0px; color: #9390DE; font-size: 12px; margin-top: 5px;">
          <a href data-toggle="collapse" data-target=".collapse-c-switches">+ More</a>
        </div>
      </div>

      <div
        class="collapse collapse-c-switches"
        id="communication-switches"
        style="margin-right: -12px; margin-left: -12px;"
      >
        <div style="background-color: #fff; padding: 12px;">
          <div class="switch-row">
            <i class="fas fa-phone fa-flip-horizontal"></i>
            <span class="word">Call:</span>
            <div class="onoffswitch">
              <input
                type="checkbox"
                name="onoffswitch"
                class="onoffswitch-checkbox"
                id="myonoffswitchm"
                checked
              />
              <label class="onoffswitch-label" for="myonoffswitchm">
                <span class="onoffswitch-inner"></span>
                <span class="onoffswitch-switch"></span>
              </label>
            </div>
          </div>
          <div class="switch-row" style="margin: 15px 0px;">
            <i class="fas fa-comments"></i>
            <span class="word">Text:</span>
            <div class="onoffswitch">
              <input
                type="checkbox"
                name="onoffswitch"
                class="onoffswitch-checkbox"
                id="txtm"
                checked
              />
              <label class="onoffswitch-label" for="txtm">
                <span class="onoffswitch-inner"></span>
                <span class="onoffswitch-switch"></span>
              </label>
            </div>
          </div>
          <div class="switch-row">
            <i class="fas fa-video"></i>
            <span class="word">Video Chat:</span>
            <div class="onoffswitch">
              <input
                type="checkbox"
                name="onoffswitch"
                class="onoffswitch-checkbox"
                id="vcallm"
                checked
              />
              <label class="onoffswitch-label" for="vcallm">
                <span class="onoffswitch-inner"></span>
                <span class="onoffswitch-switch"></span>
              </label>
            </div>
          </div>

          <div class="row">
            <div class="col-4 text-center">
              <a
                href="#"
                data-toggle="collapse"
                data-target=".collapse-c-switches"
                style="color: #9390DE; font-size: 12px; margin-top: 5px;"
              >- Less</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div
      class="container-fluid d-none d-md-block"
      style="background-color: rgba(249, 249, 249, .4); font-size: 12px; font-weight: 600; color: #1F1E34;  padding-top: 12px; padding-bottom: 12px;"
      v-if="concated_user_schedule.length > 0"
    >
      <span
        style="font-family: "Montserrat", sans-serif; font-size: 14.4px; font-weight: 500; color: #1f1e34;"
      >Schedule</span>

      <div class="row" v-for="cs in concated_user_schedule">
        <div class="col-auto mr-auto">{{ cs.days }}</div>
        <div class="col-auto">{{ cs.from | ampmtime }}-{{ cs.till | ampmtime }}</div>
      </div>
    </div>

    <div style="padding-left: 12px; padding-right: 12px;">
      <v-card class="mx-auto" width="300">
        <v-list>
          <v-list-group prepend-icon="account_circle" value="false">
            <template v-slot:activator>
              <v-list-item-title>Media</v-list-item-title>
            </template>

            <v-list-item>
              <v-list-item-title>
                <a href="/dashboard/post/new">New Post</a>
              </v-list-item-title>
            </v-list-item>

            <v-list-item>
              <v-list-item-title>
                <a href="/dashboard/post">Posts</a>
              </v-list-item-title>
            </v-list-item>

            <v-list-item>
              <v-list-item-title>
                <a href="/dashboard/post/drafts">Drafts</a>
              </v-list-item-title>
            </v-list-item>

            <v-list-item>
              <v-list-item-title>
                <a href="/dashboard/media/gallery">Gallery</a>
              </v-list-item-title>
            </v-list-item>

            <v-list-item>
              <v-list-item-title>
                <a href="/dashboard/albums">Albums</a>
              </v-list-item-title>
            </v-list-item>

            <v-list-item>
              <v-list-item-title>
                <a href="/dashboard/subscriptions">Subscription</a>
              </v-list-item-title>
            </v-list-item>
          </v-list-group>
        </v-list>
      </v-card>
      <v-card class="mx-auto" width="300">
        <v-list>
          <v-list-group prepend-icon="account_circle" value="false">
            <template v-slot:activator>
              <v-list-item-title>Connect</v-list-item-title>
            </template>

            <v-list-item>
              <v-list-item-title>
                <a href="/dashboard/services">Settings</a>
              </v-list-item-title>
            </v-list-item>

            <v-list-item>
              <v-list-item-title>Rates</v-list-item-title>
            </v-list-item>
          </v-list-group>
        </v-list>
      </v-card>
      <v-card class="mx-auto" width="300">
        <v-list>
          <v-list-group prepend-icon="account_circle" value="false">
            <template v-slot:activator>
              <v-list-item-title>Money</v-list-item-title>
            </template>

            <v-list-item>
              <v-list-item-title>Earnings</v-list-item-title>
            </v-list-item>

            <v-list-item>
              <v-list-item-title>Breakdown</v-list-item-title>
            </v-list-item>
            <v-list-item>
              <v-list-item-title>Transaction History</v-list-item-title>
            </v-list-item>

            <v-list-item>
              <v-list-item-title>Payout History</v-list-item-title>
            </v-list-item>

            <v-list-item>
              <v-list-item-title>
                <a href="/dashboard/payout">Payout Method</a>
              </v-list-item-title>
            </v-list-item>
          </v-list-group>
        </v-list>
      </v-card>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    switchcall: true,
    switchtext: false,
    switchvideo: false,

    concated_user_schedule: []
  }),

  filters: {
    ampmtime: function(time) {
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
    }
  },

  methods: {
    getUserSchedule() {
      axios
        .get("/api/v1/user/schedule")
        .then(response => {
          this.concated_user_schedule = response.data.success.concated;
        })
        .catch(function(error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
    }
  },

  mounted() {
    this.getUserSchedule();
  }
};
</script>
