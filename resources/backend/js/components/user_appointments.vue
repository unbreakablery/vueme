<template>
  <div class="fan-appointment">
    <div class="contain mb-0 pb-0 pt-0 pl-0">
      <div class="calendar-responsive">
        <v-tabs flat hide-slider class="fan-appointments">
          <div class="toggle_btn fan-toggle">
            <v-tab active-class="active-tab" light  exact-active-class="custom-tab" class="tab-btn tab-font">
              <h4>Livestream</h4>
            </v-tab>
            <v-tab active-class="active-tab" light  exact-active-class="custom-tab" class="tab-btn tab-font">
              <h4>Privates</h4>
            </v-tab>
          </div>
          <v-tab-item class="tab-item">
            <v-col
              class="pl-0 pr-0"
            >
              <div
                class="stickyTopCalendar"
              >
                <date-pick
                  v-model="datePicker"
                  :hasInputElement="false"
                  :weekdays="['M', 'T', 'W', 'T', 'F', 'S', 'S']"
                  :startWeekOnSunday="true"
                ></date-pick>
              </div>
              <div class="tab-content">
                <v-row class="ml-0 mr-0" style="display: block">
                  <span v-if="focus == today">
                  <!-- <span> -->
                    <div
                      class="mt-10"
                      v-for="appointment in tomorrow_appointments"
                      :key="appointment.id"
                    >
                      <v-card
                        flat
                      >
                        <v-row
                          class="pt-6 pb-7 mb-5 align-items-center v-badge-list card-border"
                          no-gutters
                        >
                          <v-col :sm="2" cols="3" class="pl-5 pr-0 pr-0">
                            <v-avatar size="75" class="fan-avadar">
                              <v-img
                                :src="appointment.user.profile.profile_headshot_url"
                              ></v-img>
                            </v-avatar>
                          </v-col>

                          <v-col :sm="10" class="px-0" cols="9"
                          >
                            <v-row class="fan-join-stream">
                              <v-col :sm="7" cols="12">
                                <div class="h2Title">
                                  {{ appointment.user.profile.name }}
                                  <span style="color: #2CC05F">Happening Now</span>
                                </div>
                                <div class="textList subList pick-days">
                                  <h6>{{ appointment.date | formatDate("MMMM D") }},
                                  {{ appointment.start | formatDate("h:mm a") }}</h6>
                                </div>
                              </v-col>
                              <v-col :sm="5">
                                <v-btn
                                    class="ma-sm-2 appo-btn"
                                    outlined
                                    color=#2CC05F
                                  >
                                    Join Stream
                                </v-btn>
                              </v-col>
                            </v-row>
                          </v-col>
                        </v-row>

                      </v-card>
                      <v-card
                        flat
                      >
                        <v-row
                          class="pt-6 pb-7 mb-5 align-items-center v-badge-list card-border"
                          no-gutters
                        >
                          <v-col :sm="2" cols="3" class="pl-5 pr-0 pr-0">
                            <v-avatar size="75">
                              <v-img
                                :src="appointment.user.profile.profile_headshot_url"
                              ></v-img>
                            </v-avatar>
                          </v-col>

                          <v-col :sm="10" class="px-0" cols="9"
                          >
                            <v-row>
                              <v-col :sm="7" cols="12">
                                <div class="h2Title">
                                  {{ appointment.user.profile.name }}
                                  <span style="color: #2CC05F">Happening Now</span>
                                </div>
                                <div class="textList subList pick-days">
                                  <h6>{{ appointment.date | formatDate("MMMM D") }},
                                  {{ appointment.start | formatDate("h:mm a") }}</h6>
                                </div>
                              </v-col>
                              <v-col :sm="5">
                                <v-btn
                                    class="ma-sm-2 appo-btn"
                                    outlined
                                    color=#2CC05F
                                  >
                                    Join Stream
                                </v-btn>
                              </v-col>
                            </v-row>
                          </v-col>
                        </v-row>

                      </v-card>
                      <v-card
                        flat
                      >
                        <v-row
                          class="pt-6 pb-7 mb-5 align-items-center v-badge-list card-border"
                          no-gutters
                        >
                          <v-col :sm="2" cols="3" class="pl-5 pr-0 pr-0">
                            <v-avatar size="75">
                              <v-img
                                :src="appointment.user.profile.profile_headshot_url"
                              ></v-img>
                            </v-avatar>
                          </v-col>

                          <v-col :sm="10" class="px-0" cols="9"
                          >
                            <v-row>
                              <v-col :sm="7" cols="12">
                                <div class="h2Title">
                                  {{ appointment.user.profile.name }}
                                  <span style="color: #2CC05F">Happening Now</span>
                                </div>
                                <div class="textList subList pick-days">
                                  <h6>{{ appointment.date | formatDate("MMMM D") }},
                                  {{ appointment.start | formatDate("h:mm a") }}</h6>
                                </div>
                              </v-col>
                              <v-col :sm="5">
                                <v-btn
                                    class="ma-sm-2 appo-btn"
                                    outlined
                                    color=#2CC05F
                                  >
                                    Join Stream
                                </v-btn>
                              </v-col>
                            </v-row>
                          </v-col>
                        </v-row>

                      </v-card>
                    </div>
                  </span>
                </v-row>
              </div>
            </v-col>

          </v-tab-item>
          <v-tab-item class="tab-item">
            <div class="row row-gray-area marks">
              <v-row
                class="ml-0 mr-0 mb-5 pb-0"
                style="margin: 30px 0px; padding-bottom: 20px !important; text-align:center"
                :style="[
                  $vuetify.breakpoint.xsOnly
                    ? { 'padding-bottom': '20px !important' }
                    : { 'padding-bottom': '0px !important' },
                ]"
              >
                <v-col
                  :lg="12"
                  class="textList pt-0"
                  style="padding: 0 12px!important"
                  v-if="!$vuetify.breakpoint.xsOnly"
                >
                  <span class="mx-4 col-3">
                    <v-avatar
                      class="mr-1 ml-lg-0 ml-0 mb-1"
                      color="#f9a825"
                      size="10"
                    >
                      <span class="white--text headline"></span>
                    </v-avatar>
                    <span>Pending</span>
                  </span>

                  <span class="mx-4 col-3">
                    <v-avatar
                      class="mr-1 ml-lg-0 ml-1 mb-1"
                      color="#00c853"
                      size="10"
                    >
                      <span class="white--text headline"></span>
                    </v-avatar>
                    <span>Confirmed</span>
                  </span>

                  <span class="mx-4 col-3">
                    <v-avatar
                      class="mr-1 ml-lg-0 ml-1 mb-1"
                      color="#4899FA"
                      size="10"
                    >
                      <span class="white--text headline"></span>
                    </v-avatar>
                    <span>Completed</span>
                  </span>

                  <span class="mx-4 col-3">
                    <v-avatar
                      class="mr-1 ml-lg-0 ml-1 mb-1"
                      color="#F05252"
                      size="10"
                    >
                      <span class="white--text headline"></span>
                    </v-avatar>
                    <span>Cancelled</span>
                  </span>
                </v-col>
              </v-row>
            </div>
            <v-col
            class="pl-0 pr-0"
            >
              <div
                class="stickyTopCalendar"
              >
                <date-pick
                  v-model="datePicker"
                  :hasInputElement="false"
                  :weekdays="['M', 'T', 'W', 'T', 'F', 'S', 'S']"
                  :startWeekOnSunday="true"
                ></date-pick>
              </div>
              <div class="tab-content stream-responsive">
                <v-row class="ml-0 mr-0" style="display: block">
                  <span v-if="focus == today">

                    <div
                      v-for="appointment in tomorrow_appointments"
                      :key="appointment.id"
                    >
                      <v-card
                        class="mt-8"
                        flat
                        :style="{
                          borderLeft: '5px solid ' + status_color(appointment.status),
                        }"
                      >
                        <v-row
                          class="pt-6 pb-7 mb-5 align-items-center v-badge-list card-border"
                          no-gutters
                        >
                          <v-col :sm="2" cols="3" class="pl-5 pr-0 pr-0">
                            <v-avatar size="75">
                              <v-img
                                :src="appointment.user.profile.profile_headshot_url"
                              ></v-img>
                            </v-avatar>
                          </v-col>

                          <v-col :sm="10" class="px-0" cols="9"
                          >
                            <v-row>
                              <v-col :sm="7" cols="12">
                                <div class="h2Title">
                                  {{ appointment.user.profile.name }}
                                  <span style="color: #2CC05F">Happening Now</span>
                                  <span style="font-size: 16px; color: #131220">{{appointment.category.description}}</span>
                                </div>
                                <div class="textList subList stram-days">
                                  {{ appointment.date | formatDate("MMMM D") }},
                                  {{ appointment.start | formatDate("h:mm a") }}
                                </div>
                              </v-col>
                              <v-col :sm="5">
                                <v-btn
                                    class="ma-sm-2 appo-btn"
                                    outlined
                                    color=#e31616
                                  >
                                    Join Stream
                                </v-btn>
                              </v-col>
                            </v-row>
                          </v-col>
                        </v-row>

                      </v-card>
                      <v-card
                        flat
                        :style="{
                          borderLeft: '5px solid ' + status_color(appointment.status),
                        }"
                      >
                        <v-row
                          class="pt-6 pb-7 mb-5 align-items-center v-badge-list card-border"
                          no-gutters
                        >
                          <v-col :sm="2" cols="3" class="pl-5 pr-0 pr-0">
                            <v-avatar size="75">
                              <v-img
                                :src="appointment.user.profile.profile_headshot_url"
                              ></v-img>
                            </v-avatar>
                          </v-col>

                          <v-col :sm="10" class="px-0" cols="9"
                          >
                            <v-row>
                              <v-col :sm="7" cols="12">
                                <div class="h2Title">
                                  {{ appointment.user.profile.name }}
                                  <span style="color: #2CC05F">Happening Now</span>
                                  <span style="font-size: 16px; color: #131220">{{appointment.category.description}}</span>
                                </div>
                                <div class="textList subList">
                                  {{ appointment.date | formatDate("MMMM D") }},
                                  {{ appointment.start | formatDate("h:mm a") }}
                                </div>
                              </v-col>
                              <v-col :sm="5">
                                <v-btn
                                    class="ma-sm-2 appo-btn"
                                    outlined
                                    color=#e31616
                                  >
                                    Join Stream
                                </v-btn>
                              </v-col>
                            </v-row>
                          </v-col>
                        </v-row>

                      </v-card>
                      <v-card
                        flat
                        :style="{
                          borderLeft: '5px solid ' + status_color(appointment.status),
                        }"
                      >
                        <v-row
                          class="pt-6 pb-7 mb-5 align-items-center v-badge-list card-border"
                          no-gutters
                        >
                          <v-col :sm="2" cols="3" class="pl-5 pr-0 pr-0">
                            <v-avatar size="75">
                              <v-img
                                :src="appointment.user.profile.profile_headshot_url"
                              ></v-img>
                            </v-avatar>
                          </v-col>

                          <v-col :sm="10" class="px-0" cols="9"
                          >
                            <v-row>
                              <v-col :sm="7" cols="12">
                                <div class="h2Title">
                                  {{ appointment.user.profile.name }}
                                  <span style="color: #2CC05F">Happening Now</span>
                                  <span style="font-size: 16px; color: #131220">{{appointment.category.description}}</span>
                                </div>
                                <div class="textList subList">
                                  {{ appointment.date | formatDate("MMMM D") }},
                                  {{ appointment.start | formatDate("h:mm a") }}
                                </div>
                              </v-col>
                              <v-col :sm="5">
                                <v-btn
                                    class="ma-sm-2 appo-btn"
                                    outlined
                                    color=#e31616
                                  >
                                    Join Stream
                                </v-btn>
                              </v-col>
                            </v-row>
                          </v-col>
                        </v-row>

                      </v-card>
                    </div>
                  </span>
                </v-row>
              </div>
            </v-col>
          </v-tab-item>
        </v-tabs>
      </div>
    </div>

    <v-dialog
      v-model="messageDialog"
      width="750"
      :fullscreen="$vuetify.breakpoint.xsOnly"
    >
      <v-card>
        <v-card-text class="p-0">
          <div class="row m-0">
            <div class="col-12 text-right">
              <v-btn icon light @click="messageDialog = false" class="right">
                <i class="far fa-times-circle fa-2x pink_icon"></i>
              </v-btn>
            </div>
            <div class="col-12">
              <div class="text-center p-5">
                <h2>{{ message }}</h2>
              </div>
            </div>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<style lang="scss">
.stickyTopCalendar{
    min-height: auto !important;
    height:auto !important;
}
    .fan-appointment .vdpOuterWrap .vdpTable tbody td{
          padding: 16px 0 !important;
    }
.vdpHeader{
  padding:20px 0px 20px 0px !important;
}
.fan-appointment{
  max-width: 530px  !important;
}
.fan-appointment div.row.row-gray-area.marks div div span.mx-4{
  padding: 0 !important;
}

</style>
<script>
import moment from "moment";
import DatePick from "vue-date-pick";
import { mapGetters } from "vuex";
export default {
  props: ["user", "categories", "apid"],
  components: { DatePick },
  data() {
    return {
      new_review: {
        psychic: "",
        service: "",
        category: "",
        rating: 0,
        headline: "",
        text: "",
        appointment: "",
      },
      today_appointments: [],
      tomorrow_appointments: [],
      after_tomorrow_appointments: [],
      display: false,
      // today_appointments: [{
      //   category: {color: "#7171FF", description: "Astrologer", id: 3, image: {ext: "png", fileable_type: "App\\Models\\Category", id: 3, name: "Astrologer", path: "astrologer.svg", size: null}, name: "Astrology", online: 63, path: "/images/icons/abilities/astrology.svg", models: 115, slug: "astrology", url: "http://local.vueme.com/abilities/astrology", users_count: 115},
      //   color: "#f9a825",
      //   date: "2021-05-14",
      //   details: "",
      //   duration: 5,
      //   end: "2021-05-19 13:05:00",
      //   id: 2147,
      //   name: "Cosmic Arts vgugfui Cosmic Arts vgugfui",
      //   price: "7.50",
      //   service: {id: 1, name: "Call", icon: "call_gray.svg", enable_duration: 1},
      //   start: "2021-05-14 13:00:00",
      //   status: "Pending",
      //   text: null,
      //   user: {profile: {name: "Jessica", profile_headshot_url: "images/model-dashboard/user1.png"}}}],
      // tomorrow_appointments: [{
      //   category: {color: "#7171FF", description: "Astrologer", id: 3, image: {ext: "png", fileable_type: "App\\Models\\Category", id: 3, name: "Astrologer", path: "astrologer.svg", size: null}, name: "Astrology", online: 63, path: "/images/icons/abilities/astrology.svg", models: 115, slug: "astrology", url: "http://local.vueme.com/abilities/astrology", users_count: 115},
      //   color: "#f9a825",
      //   date: "2021-05-14",
      //   details: "",
      //   duration: 5,
      //   end: "2021-05-14 13:05:00",
      //   id: 2147,
      //   name: "Cosmic Arts vgugfui Cosmic Arts vgugfui",
      //   price: "7.50",
      //   service: {id: 1, name: "Call", icon: "call_gray.svg", enable_duration: 1},
      //   start: "2021-08-20 13:00:00",
      //   status: "Pending",
      //   text: null,
      //   user: {profile: {name: "Jessica", profile_headshot_url: "https://vueme-assets-dev.s3.amazonaws.com/user-profile/419/Jessica-profile.jpg"}}}],
      // after_tomorrow_appointments: [{
      //   category: {color: "#7171FF", description: "Astrologer", id: 3, image: {ext: "png", fileable_type: "App\\Models\\Category", id: 3, name: "Astrologer", path: "astrologer.svg", size: null}, name: "Astrology", online: 63, path: "/images/icons/abilities/astrology.svg", models: 115, slug: "astrology", url: "http://local.vueme.com/abilities/astrology", users_count: 115},
      //   color: "#f9a825",
      //   date: "2021-05-14",
      //   details: "",
      //   duration: 5,
      //   end: "2021-08-21 13:05:00",
      //   id: 2147,
      //   name: "Cosmic Arts vgugfui Cosmic Arts vgugfui",
      //   price: "7.50",
      //   service: {id: 1, name: "Call", icon: "call_gray.svg", enable_duration: 1},
      //   start: "2021-05-14 13:00:00",
      //   status: "Pending",
      //   text: null,
      //   user: {profile: {name: "Jessica", profile_headshot_url: "https://vueme-assets-dev.s3.amazonaws.com/user-profile/419/Jessica-profile.jpg"}}}],
        after_tomorrow_day: moment().add(2, "d").format("YYYY-MM-DD"),
        updatingReview: false,
        review_dialog: false,
        tabs: null,
        upcoming_appointments: [],
        pending_appointments: [],
        completed_appointments: [],
        cancelled_appointments: [],
        messageDialog: false,
        mask: "##:## SS",
        datepicker_menu: false,
        start_hour_menu: false,
        end_hour_menu: false,
        savingUserServices: false,
        usSaved: false,
        loading: true,
        loadingUpdate: false,
        appointments: [],
        errors: [],
        date_filter_list: [
          { name: "Last 3 months", key: 3 },
          { name: "Last 6 months", key: 6 },
          { name: "Last 9 months", key: 9 },
          { name: "Last year", key: 12 },
        ],
        appointment_list: [
          { name: "Show all", key: "All" },
          { name: "Pending", key: "Pending" },
          { name: "Confirmed", key: "Confirmed" },
          { name: "Completed", key: "Completed" },
          { name: "Cancelled", key: "Cancelled" },
        ],
        status: ["All"],
        date_filter: 6,
        message: "",
        today: moment().format("YYYY-MM-DD"),
        focus: moment().format("YYYY-MM-DD"),
        type: "month",
        typeToLabel: {
          month: "Month",
          week: "Week",
          day: "Day",
          "4day": "4 Days",
        },
        start: null,
        end: null,
        selectedEvent: {},
        selectedElement: null,
        selectedOpen: false,
        start_time: "",
        end_time: "",
        steppedtime: [
          { label: "5 mins", value: 5 },
          { label: "10 mins", value: 10 },
          { label: "15 mins", value: 15 },
          { label: "20 mins", value: 20 },
          { label: "25 mins", value: 25 },
          { label: "30 mins", value: 30 },
          { label: "35 mins", value: 35 },
          { label: "40 mins", value: 40 },
          { label: "45 mins", value: 45 },
          { label: "50 mins", value: 50 },
          { label: "1 hour", value: 60 },
      ],
      month: null,
      appoimentsMonth: null,
    };
  },
  filters: {
    formatDate(date, format = "MM/DD/YYYY") {
      return moment(date).format(format);
    },
    ftime: function (time) {
      let hour = new Date(time * 1000 * 60).toISOString().substr(11, 2);
      let init = 14;
      let end = 5;
      if (time > 60) {
        init = 11;
        end = 8;
      }
      return new Date(time * 1000 * 60).toISOString().substr(init, end);
    },
  },
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
      space_header: "util/space"
    }),
    datePicker: {
      get() {
        return this.focus;
      },
      set(value) {
        this.showEvent(value);
      },
    },
    title() {
      const { start, end } = this;
      if (!start || !end) {
        return "";
      }
      const startMonth = this.monthFormatter(start);
      const endMonth = this.monthFormatter(end);
      const suffixMonth = startMonth === endMonth ? "" : endMonth;
      const startYear = start.year;
      const endYear = end.year;
      const suffixYear = startYear === endYear ? "" : endYear;
      const startDay = start.day + this.nth(start.day);
      const endDay = end.day + this.nth(end.day);
      switch (this.type) {
        case "month":
          return `${startMonth} ${startYear}`;
        case "week":
        case "4day":
          return `${startMonth} ${startDay} ${startYear} - ${suffixMonth} ${endDay} ${suffixYear}`;
        case "day":
          return `${startMonth} ${startDay} ${startYear}`;
      }
      return "";
    },
    monthFormatter() {
      return this.$refs.calendar.getFormatter({
        timeZone: "UTC",
        month: "long",
      });
    },
  },
  watch: {
    month(val) {
      axios
        .get("/api/v1/user/appointments-month?date=" + val)
        .then((response) => {
          this.appoimentsMonth = response.data;
        });
    },
  },
  methods: {
    // newDayFormat(day) {
    //   const daysOfWeek = ["S", "M", "T", "W", "T", "F", "S"];
    //   let i = day.weekday;
    //   return daysOfWeek[i];
    // },
    appoimentsCheck(date) {
      let appoiments = [];
      this.appoimentsMonth.forEach((i) => {
        if (i.date == date) {
          if (i.status == "Pending" && !appoiments.includes("#F3A726"))
            appoiments.push("#F3A726");
          else if (i.status == "Completed" && !appoiments.includes("#4A99FA"))
            appoiments.push("#4A99FA");
          else if (i.status == "Confirmed" && !appoiments.includes("#4AC853"))
            appoiments.push("#4AC853");
          else if (i.status == "Cancelled" && !appoiments.includes("#E53935"))
            appoiments.push("#E53935");
        }
      });
      return appoiments;
    },
    getTimeRequested(appointment) {
      var ms = moment(appointment.end).diff(moment(appointment.start));
      var d = moment.duration(ms);
      var s = Math.floor(d.asHours()) + moment.utc(ms).format(":mm:ss");
      return s;
    },
    /**
     * Prepare the component.
     */
    getAppointments() {
      axios
        .get("/api/v1/psychic/appointments?status=&date_filter=")
        .then((response) => {
          this.appointments = response.data.data;
          this.categorizeAppointmentsbyDate();
          this.categorizeAppointments();
          this.loading = false;
          this.loadingUpdate = false;
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
    categorizeAppointments() {
      this.upcoming_appointments = [];
      this.pending_appointments = [];
      this.completed_appointments = [];
      this.cancelled_appointments = [];
      for (var i = 0; i < this.appointments.length; i++) {
        if (this.appointments[i].status == "Confirmed") {
          this.upcoming_appointments.push(this.appointments[i]);
        } else if (this.appointments[i].status == "Pending") {
          this.pending_appointments.push(this.appointments[i]);
        } else if (this.appointments[i].status == "Completed") {
          this.completed_appointments.push(this.appointments[i]);
        } else if (this.appointments[i].status == "Cancelled") {
          this.cancelled_appointments.push(this.appointments[i]);
        }
      }
    },
    categorizeAppointmentsbyDate() {
      let tomorrow = moment(this.focus, "YYYY-MM-DD")
        .add(1, "d")
        .format("YYYY-MM-DD");
      // let afterTomorrow = moment(this.focus, "YYYY-MM-DD")
      //   .add(2, "d")
      //   .format("YYYY-MM-DD");
      this.after_tomorrow_day = moment(this.focus, "YYYY-MM-DD")
        .add(2, "d")
        .format("MMMM DD");
      // this.today_appointments = [];
      // this.tomorrow_appointments = [];
      // //console(this.tomorrow_appointments);
      // this.after_tomorrow_appointments = [];
      // this.appointments.forEach((app) => {
      //   if (app.date == this.focus) {
      //     this.today_appointments.push(app);
      //   } else if (app.date == tomorrow) {
      //     this.tomorrow_appointments.push(app);
      //   } else {
      //     this.after_tomorrow_appointments.push(app);
      //   }
      // });
    },
    filterAppointments() {
      if (
        (this.status.length > 1) &
        this.status.includes("All") &
        (this.status[0] != "All")
      ) {
        this.status = ["All"];
        this.showEvent(this.focus);
      } else if ((this.status.length > 1) & (this.status[0] == "All")) {
        this.status.shift();
        this.showEvent(this.focus);
      } else if (this.status.length === 4) {
        this.status = ["All"];
        this.showEvent(this.focus);
      } else {
        this.showEvent(this.focus);
      }
    },
    updateAppointmentStatus(appointment, status) {
      this.loadingUpdate = true;
      var input = { id: appointment.id, status: status };
      axios
        .post("/api/v1/user/appointment/update/status", input)
        .then((response) => {
          this.getAppointments();
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
    editAppointment(appointment) {
      this.loadingUpdate = true;
      var input = {
        id: appointment.id,
        category: appointment.category.id,
        date: appointment.date,
        start: this.start_time,
        end: this.end_time,
        duration: appointment.duration,
        date_and_time: appointment.date + " " + this.start_time,
        notes: appointment.text,
      };

      axios
        .post("/api/v1/user/appointment/edit/data", input)
        .then((response) => {
          this.getAppointments();
          this.loadingUpdate = false;
          this.message = response.data.message;
          setTimeout(() => {
            this.message = "";
          }, 2000);
          this.selectedEvent = {};
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

          this.loadingUpdate = false;
          this.message = "";
        });
    },
    submitReview() {
      this.setNewReview();
      this.updatingReview = true;

      axios
        .post("/api/v1/user/review/create", this.new_review)
        .then((response) => {
          this.updatingReview = false;
          this.message = response.data.message;
          this.selectedEvent.reviewed = true;
          this.selectedEvent = {};
          this.review_dialog = false;
          this.messageDialog = true;
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

          this.updatingReview = false;
          this.message = "";
        });
    },
    setNewReview() {
      this.new_review.psychic = this.selectedEvent.psychic.id;
      this.new_review.service = this.selectedEvent.service.id;
      this.new_review.category = this.selectedEvent.category.id;
      this.new_review.appointment = this.selectedEvent.id;
    },
    edit(appointment) {
      this.selectedEvent = appointment;
      this.updateTimes();
    },
    newReview(appointment) {
      this.selectedEvent = appointment;
      this.updateTimes();
      this.review_dialog = true;
    },
    status_color(status) {
      var color = "";
      if (status == "Pending") {
        color = "#FFAC3B";
      } else if (status == "Confirmed") {
        color = "#2CC05F";
      } else if (status == "Cancelled") {
        color = "#E85D4E";
      } else if (status == "Completed") {
        color = "#4899FA";
      }
      return color;
    },
    duration(x, y) {
      x = new moment(x);
      y = new moment(y);
      var duration = moment.duration(x.diff(y));

      return duration.asMinutes() + " min";
    },
    viewDay({ date }) {
      this.focus = date;
      this.type = "day";
    },
    getEventColor(event) {
      return event.color;
    },
    setToday() {
      this.focus = this.today;
    },
    prev() {
      this.$refs.calendar.prev();
    },
    next() {
      this.$refs.calendar.next();
    },
    showEvent(date) {
      // const open = () => {
      //   this.selectedEvent = event;
      //   this.selectedElement = nativeEvent.target;
      //   setTimeout(() => (this.selectedOpen = true), 10);
      // };

      // if (this.selectedOpen) {
      //   this.selectedOpen = false;
      //   setTimeout(open, 10);
      // } else {
      //   open();
      // }
      // this.updateTimes();
      // this.updateTab();
      // nativeEvent.stopPropagation();
      this.focus = date;

      axios
        .get(
          `/api/v1/user/appointments?status=${this.status}&date_filter=${this.focus}`
        )
        .then((response) => {
          this.appointments = response.data.data;
          this.categorizeAppointmentsbyDate();
          this.categorizeAppointments();
          this.loading = false;
          this.loadingUpdate = false;
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
    updateTab() {
      if (this.selectedEvent.status == "Pending") {
        this.tabs = "mobile-tabs-5-2";
      } else if (this.selectedEvent.status == "Confirmed") {
        this.tabs = "mobile-tabs-5-1";
      } else if (this.selectedEvent.status == "Cancelled") {
        this.tabs = "mobile-tabs-5-4";
      } else if (this.selectedEvent.status == "Completed") {
        this.tabs = "mobile-tabs-5-3";
      }
    },
    updateTimes() {
      this.errors = [];
      this.start_time = moment(this.selectedEvent.start).format("HH:mm");
      this.end_time = moment(this.selectedEvent.end).format("HH:mm");
    },
    updateRange({ start, end }) {
      // You could load events from an outside source (like database) now that we have the start and end dates on the calendar
      this.start = start;
      this.end = end;
    },
    nth(d) {
      return d > 3 && d < 21
        ? "th"
        : ["th", "st", "nd", "rd", "th", "th", "th", "th", "th", "th"][d % 10];
    },
    validateApid() {
      if (this.apid) {
        for (let i = 0; i < this.completed_appointments.length; i++) {
          const element = this.completed_appointments[i];

          if (element.id == this.apid && element.reviewed == 0) {
            this.newReview(element);
          }
        }
      }
    },
  },
  /**
   * Prepare the component (Vue 2.x).
   */
  mounted() {
    this.showEvent(this.today);
    // this.$refs.calendar.checkChange();
    this.$root.$on("update_appointments", (data) => {
      this.showEvent(this.focus);
    });
  },
};
</script>

<style>
/* .row{
  margin-left: 0px !important;
} */
.vdpCellContent {
  position: relative;
}
/* .vdpCellContent:after{
  content: "";
  height: 10px;
  width: 10px;
  background-color: #31af5c;
  border-radius: 50%;
  display: block;
  bottom: -6px;
  right: 7px;
  position: absolute;
} */
.h2Title {
  padding-bottom: 4px !important;
  font-size: 12px!important;
  color: #131220!important;
}
.textList {
  padding-bottom: 4px !important;
  color: #949498!important;
  font-size: 11px!important;
}
.v-menu__content [role="listbox"] .v-list-item {
  color: #8e8d99 !important;
}
.v-menu__content [role="listbox"] .v-list-item__title {
  font-size: 12px !important;
}
.vdpArrow {
  font-size: 13px;
  width: 5em;
  text-indent: -999em;
  overflow: hidden;
  position: absolute;
  top: 10px;
  bottom: 2.5em;
  text-align: left;
}
.vdpPeriodControl button {
  padding-right: 0px !important;
  margin-right: 0px !important;
  padding-left: 1px !important;
}
.v-select-list .v-list-item__title {
  color: #8e8d99 !important;
}
.v-date-picker-table__events div {
  width: 4px;
  height: 4px;
}
.v-application .v-picker .v-btn--rounded.accent--text {
  background-color: #c2d1f7 !important;
  border: 0px !important;
  color: #1f1e34 !important;
}
.v-application .v-picker .v-btn--rounded.accent {
  background-color: #cc9fd9 !important;
  border: 0px !important;
  color: #1f1e34 !important;
}
.v-application .v-picker .v-btn--rounded {
  background-color: #ebf4fd !important;
  border: 0px !important;
  color: #1f1e34 !important;
}
.servList {
  margin-bottom: 0px !important;
}
.textList {
  padding-bottom: 0px !important;
}
/* Hide scrollbar for Chrome, Safari and Opera */
#scroll-target::-webkit-scrollbar {
  display: none;
}
/* Hide scrollbar for IE, Edge and Firefox */
#scroll-target {
  -ms-overflow-style: none; /* IE and Edge */
  scrollbar-width: none; /* Firefox */
}
/* #sidebar{
  position: fixed;
  z-index: 1;
  min-height: 80vh;
}
.v-footer{
  z-index: 2;
} */

.newProfileDataVCard {
  background-size: cover;
  background-repeat: no-repeat;
  position: relative;
  background-position: center;
  background-image: url("/images/back_dialog.jpg");
}
.newProfileDataVCTitle {
  color: #43425d;
  font-size: 16px !important;
  font-weight: 600 !important;
  padding-top: 55px !important;
  padding-bottom: 20px !important;
  line-height: 22px !important;
}
.newProfileDataVCText1,
.newProfileDataVCText2 {
  color: #656b72 !important;
  font-size: 14px !important;
  font-weight: normal !important;
  letter-spacing: 0px !important;
  line-height: 23px !important;
}
.newProfileDataVCText1 {
  padding-left: 50px !important;
  padding-right: 50px !important;
}
.newProfileDataVCText2 {
  padding-left: 40px !important;
  padding-right: 40px !important;
  padding-bottom: 42px !important;
}
.newProfileDataVBtn {
  font-weight: normal !important;
  height: 38px !important;
  width: 130px;
}
.toggle_btn {
  display: flex;
  justify-content: space-between;
  width: 343px;
  height: 47px;
  background-color: #E7E6E8;
  border-radius: 24px;
  padding: 7px;
}
.active-tab {
  background-color: #fff;
  color: #131220!important;
  font-size: 12px;
  width: 50%;
  border: none;
}
.custom-tab {
  box-shadow: 0;
}
.calendar-responsive .v-slide-group {
  width: fit-content;
}
.calendar-responsive .v-tabs:not(.v-tabs--vertical):not(.v-tabs--right) > .v-slide-group--is-overflowing.v-tabs-bar--is-mobile:not(.v-slide-group--has-affixes) .v-slide-group__prev {
  display: none;
}
.calendar-responsive .v-tabs:not(.v-tabs--vertical):not(.v-tabs--right) > .v-slide-group--is-overflowing.v-tabs-bar--is-mobile:not(.v-slide-group--has-affixes) .v-slide-group__next {
  display: none;
}

</style>
<style lang="scss">
.fan-appointments {
  .v-window {
    background-color: unset;
  }
  .fan-toggle {
    .tab-btn {
      width: 50%;
    }
    .tab-btn::before {
      border-radius: 47px;
    }
  }
}
.tab-font h4 {
  font-size: 12px;
  font-weight: 600;
  color: #131220;
  letter-spacing: 0;
  margin-bottom: 0;
  text-transform: capitalize;
}
.stram-days {
  font-size: 11px;
  font-weight: 600;
}
.appo-btn {
  letter-spacing: 0;
}
.pick-days h6 {
  font-size: 11px;
  font-weight: 600;
  color: #949498;
  margin: 0;
  line-height: 11px;
}
</style>
