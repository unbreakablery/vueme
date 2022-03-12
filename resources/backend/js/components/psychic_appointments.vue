<template>
  <div class="model-appointments">
    <h1 class="title">Appointments</h1>
    <v-tabs  flat hide-slider class="model-v-tab">
      <div class="toggle_btn">
        <v-tab active-class="active-tab" light  exact-active-class="custom-tab" class="tab-btn">
          Livestream
        </v-tab>
        <v-tab active-class="active-tab" light  exact-active-class="custom-tab" class="tab-btn">
          Privates
        </v-tab>
      </div>
      <v-tab-item class="tab-item">
        <v-col
          class="pl-0 pr-0"
        >
          <div
            class="stickyTopCalendar model-sticky-calender"
          >
            <date-pick
              v-model="datePicker"
              :hasInputElement="false"
              :weekdays="['M', 'T', 'W', 'T', 'F', 'S', 'S']"
              :startWeekOnSunday="true"
              class="model-date-picker"
            ></date-pick>
          </div>
          <div class="tab-content">
            <v-row class="ml-0 mr-0" style="display: block;">
              <span >
                <div
                  v-for="appointment in livestreams"
                  :key="appointment.id"
                >
                  <v-card
                    flat
                  >
                    <v-row class="pt-6 pb-7 mb-5 v-badge-list card-border align-items-center" no-gutters>
                      <v-col :sm="3" cols="4" class="pl-5 pr-0 pr-0">
                        <v-avatar size="75">
                          <v-img
                            :src="appointment.user.profile.profile_headshot_url"
                          ></v-img>
                        </v-avatar>
                      </v-col>

                      <v-col :sm="8" class="px-0" cols="8">
                        <v-row>
                          <v-col :sm="7" cols="12">
                            <div class="h2Title">
                              <p class="mb-1">{{ appointment.user.profile.name }}</p>
                              <p class="mb-1" :style="{ color: appointment.color }">
                                {{ appointment.status }}: 
                                {{ (appointment.status == 'Completed' || appointment.status == 'Cancelled') ? 'Happening Now' : 'Not Happened' }}
                              </p>
                            </div>
                            <div class="textList subList">
                              {{ appointment.start | formatDate("MMMM D") }},
                              {{ appointment.start | formatDate("h:mm a") }}
                            </div>
                          </v-col>
                          <v-col :sm="5">
                            <v-btn
                              v-if="appointment.status == 'Pending' || appointment.status == 'Confirmed'"
                              class="ma-2 appo-btn"
                              outlined
                              :color="'#e53935'"
                              @click="updateAppointmentStatus(appointment,'Cancelled')"
                            >
                              Cancel
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
            class="ml-0 mr-0 mb-5 pb-5 pt-5 d-item-none"
            style="margin: 30px 0px; padding-bottom: 20px !important; text-align:center"
          >
            <v-col
              :lg="12"
              class="textList pt-0"
              v-if="!$vuetify.breakpoint.xsOnly"
            >
              <span class="mr-4 ml-4 col-3">
                <v-avatar
                  class="mr-1 ml-lg-0 ml-0 mb-1"
                  color="#f9a825"
                  size="10"
                >
                  <span class="white--text headline"></span>
                </v-avatar>
                <span>Pending</span>
              </span>

              <span class="mr-4 ml-4 col-3">
                <v-avatar
                  class="mr-1 ml-lg-0 ml-1 mb-1"
                  color="#00c853"
                  size="10"
                >
                  <span class="white--text headline"></span>
                </v-avatar>
                <span>Confirmed</span>
              </span>

              <span class="mr-4 ml-4 col-3">
                <v-avatar
                  class="mr-1 ml-lg-0 ml-1 mb-1"
                  color="#4899FA"
                  size="10"
                >
                  <span class="white--text headline"></span>
                </v-avatar>
                <span>Completed</span>
              </span>

              <span class="mr-4 ml-4 col-3">
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
            class="stickyTopCalendar model-sticky-calender"
          >
            <date-pick
              v-model="datePicker"
              :hasInputElement="false"
              :weekdays="['M', 'T', 'W', 'T', 'F', 'S', 'S']"
              :startWeekOnSunday="true"
              class="model-date-picker"
            ></date-pick>
          </div>
          <div class="tab-content stream-responsive">
            <v-row class="ml-0 mr-0" style="display: block">
              <span >

                <div
                  v-for="appointment in privates"
                  :key="appointment.id"
                >
                  <v-card
                    flat
                    :style="{ borderLeft: '5px solid ' + status_color(appointment.status) }"
                    class="rounded-card privateCards"
                    
                  >
                    <v-row
                      class="mb-5 v-badge-list card-border align-items-center"
                      style="padding: 25px 10px;"
                      no-gutters
                    >
                      <!-- <v-col :sm="3" cols="4" class="pl-0 pr-0 pr-0" :style="mobile ? '':'max-width: 75px;'">
                        <v-avatar size="75">
                          <v-img
                            :src="appointment.user.profile.profile_headshot_url"
                          ></v-img>
                        </v-avatar>
                      </v-col> -->

                      <v-col class="px-0"
                      >
                        <v-row>
                          <v-col :sm="7" cols="12" class="pl-0">
                             <v-avatar size="75" style="float: left; margin-right:10px">
                                <v-img
                                  :src="appointment.user.profile.profile_headshot_url"
                                ></v-img>
                              </v-avatar>
                            <div class="h2Title">
                              <p class="preTitle">
                                {{ appointment.status }}: 
                                {{ (appointment.status == 'Completed' || appointment.status == 'Cancelled') ? 'Happening Now' : 'Not Happened' }}
                              </p>
                              <p class="nameTitle">{{ appointment.user.profile.name }}</p>
                              
                            </div>
                            <div class="dateTitle">
                              {{ appointment.start | formatDate("MMM D") }},
                              {{ appointment.start | formatDate("h:mm a") }}
                            </div>
                          </v-col>
                          <v-col :sm="5">
                            <v-btn
                                class="ma-2 appo-btn m-0"
                                :style="mobile ? '': 'position: absolute; bottom: 0px;right: 0px; margin: 0px !important'"
                                outlined
                                color=#e31616
                                v-if="appointment.status == 'Pending' || appointment.status == 'Confirmed'"
                                @click="updateAppointmentStatus(appointment,'Cancelled')"
                              >
                                Cancel
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
    <!--v-dialog for the new profile fields-->

  </div>
</template>

<style lang="scss">
.model-appointments .model-v-tab .model-sticky-calender .vdpInnerWrap {
    min-height: auto !important;
    padding-bottom: 5px !important;
}
.vdpInnerWrap .vdpTable tbody td{
          padding: 16px 0 !important;
    }
.vdpHeader{
  padding:20px 0px 20px 0px !important;
}
.model-appointments{
  max-width: 620px  !important;
}
.model-appointments div.row.row-gray-area.marks div.textList.pt-0.col-lg-12.col span.mr-4{
  padding: 0 !important;
}
</style>
<script>
import moment from "moment";
import DatePick from "vue-date-pick";
import { mapGetters } from "vuex";
export default {
  props: ["user", "categories"],
  components: { DatePick },
  data() {
    return {
      newProfileDialog:
        this.user.userProfile.updated_at === null ||
        moment(this.user.userProfile.updated_at).isBefore("2020-10-20"),
      tabs: null,
      display: false,
      privates: [],
      livestreams: [],
      today_appointments: [],
      tomorrow_appointments: [],
      after_tomorrow_appointments: [],
      after_tomorrow_day: moment().add(2, "d").format("YYYY-MM-DD"),
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
        .get("/api/v1/psychic/appointments?date_filter=")
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
    
    categorizeAppointmentsbyType() {


      this.livestreams = [];
      this.privates = [];

      

      this.appointments.forEach((app) => {


            if (app.service.id == 1){
              this.livestreams.push(app);
            } 

            if (app.service.id == 2)  {
              console.log('segundo 2 ');
              this.privates.push(app);
            } 
        
      });
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
        .post("/api/v1/psychic/appointment/update/status", input)
        .then((response) => {
          // if (
          //   response.data.message ==
          //   "Appointment was cancelled because it was in the past"
          // ) {
          //   alert("Appointment is in the past so it was cancelled.");
          // }
          if (appointment.request && status == "Cancelled") {
            // appointment was created with a request now
            this.$root.$emit("canceled_or_expired_appointment", {
              id: appointment.request,
            });
          }
          
          this.showEvent(this.focus);

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
    editAppointmentNotes(appointment) {
      this.loadingUpdate = true;
      var input = {
        id: appointment.id,
        notes: appointment.text,
      };
      axios
        .post("/api/v1/psychic/appointment/edit/notes", input)
        .then((response) => {
          this.getAppointments();
          this.message = response.data.message;
          setTimeout(() => {
            this.message = "";
          }, 2000);
          this.selectedEvent = {};
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
          this.loadingUpdate = false;
          this.message = "";
        });
    },
    requestReview(appointment) {
      this.loadingUpdate = true;
      var input = { id: appointment.id };
      axios
        .post("/api/v1/psychic/request/review", input)
        .then((response) => {
          this.loadingUpdate = false;
          appointment.review_requested = true;
          this.$root.$emit("open_dialog_message", {
            message: response.data.message,
            message_title: "",
          });
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
    edit(appointment) {
      this.selectedEvent = appointment;
      this.updateTimes();
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
      //   let hola = this.appointments.filter(app => {
      //     return app.status == "Cancelled";
      //   });
      //   const open = () => {
      //     this.selectedEvent = event;
      //     this.selectedElement = nativeEvent.target;
      //     setTimeout(() => (this.selectedOpen = true), 10);
      //   };
      //   if (this.selectedOpen) {
      //     this.selectedOpen = false;
      //     setTimeout(open, 10);
      //   } else {
      //     open();
      //   }
      //   this.updateTimes();
      //   this.updateTab();
      //   nativeEvent.stopPropagation();\
      //   let tomorrow = moment(this.focus, "YYYY-MM-DD")
      //     .add(1, "d")
      //     .format("YYYY-MM-DD");

      
      this.focus = date;
      axios
        .get(
          `/api/v1/psychic/appointments?status=${this.status}&date_filter=${this.focus}`
        )
        .then((response) => {
          this.appointments = response.data.data; //livestreams
          
          this.categorizeAppointmentsbyType();
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

.h2Title {
  padding-bottom: 4px !important;
}
.textList {
  padding-bottom: 4px !important;
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
</style>
<style lang="scss">
.model-appointments {
  max-width: 1010px;
  padding-left: 40px;
  padding-right: 40px;
  .title {
    font-size: 24px!important;
    color: #42424D;
    font-family: "Montserrat", sans-serif!important;
    margin-top: 48px;
    margin-bottom: 20px;
  }
  .model-v-tab {
    .tab-content {
      padding: 0 10px;
      margin-top: 20px;
      max-width: 628px;
    }
    .appo-btn {
      border-radius: 12px;
      width: 160px;
      height: 40px !important;
    }
    .v-tabs-bar {
      margin-bottom: 20px;
      height: 57px;
      .toggle_btn {
        height: 57px;
        border-radius: 57px;
        .active-tab {
          border-radius: 57px;
          font-size: 14px;
          color: #0F0F0F!important;
        }
        .tab-btn {
          width: 50%;
          font-size: 14px;
          color: #0F0F0F!important;
          text-transform: capitalize;
          font-weight: bold;
          letter-spacing: 1px;
        }
        .tab-btn::before {
          opacity: 0;
        }
        .tab-btn:before {
          border-radius: 57px;
        }
      }
    }
    .model-date-picker {
      max-width: 608px;
    }
    .v-item-group {
      background-color: unset;
    }
    .model-sticky-calender {
      background-color: unset;
      .vdpInnerWrap {
        min-height: 329px;
      }
    }
  }
}
@media (max-width: 500px) {
  .model-appointments {
    padding-left: 20px;
    padding-right: 20px;
    .title {
      font-size: 20px!important;
    }
    .model-v-tab {
      .v-tabs-bar {
        height: 48px;
        .toggle_btn {
          height: 48px;
          width: 258px;
          padding: 3px;
          .tab-btn {
            letter-spacing: 0px;
          }
        }
      }
      .v-slide-group__content {
        flex-flow: column;
        align-items: center;
      }
    }
    .d-item-none {
      display: none;
    }
  }
}


.v-sheet.v-card.rounded-card{
  border-radius:5px !important;
}
.v-sheet.v-card.privateCards .preTitle{

  letter-spacing: 0px;
  color: #131220 !important;
  opacity: 1 !important;
  font-size: 12px !important;
  margin-bottom: 8px !important;
  
}

.v-sheet.v-card.privateCards .nameTitle{
  letter-spacing: 0px;
  color: #131220 !important;
  opacity: 1 !important;
  font-size: 18px !important;
  margin-bottom: 0px !important;
}

.v-sheet.v-card.privateCards .dateTitle{
  letter-spacing: 0px;
  color: #949498 !important;
  opacity: 1 !important;
  font-size: 18px !important;
  margin-bottom: 10px !important;
  font-weight: 600 !important;
}




</style>