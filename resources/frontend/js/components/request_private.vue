<template>
  <v-dialog
    :fullscreen="$vuetify.breakpoint.xs"
    content-class="request noHiddenSelect"
    v-if="request && !savingAppointment"
    v-model="request"
    max-width="366px"
    persistent
  >
    <v-card>
      <div style="height: 10px"></div>
      <!--Important to preserve correct icon click area and top position -->
      <v-icon large style="position: absolute; right: 10px" @click="close"
        >mdi-close</v-icon
      >
      <div class="pa-5">
        <v-container fluid class="dialogTitle">
          <v-row justify="center" align="center" class="text-center d-flex">
            <v-col align="center" justify="center">
              <v-row><h1>Schedule Private Show</h1></v-row>
            </v-col>
          </v-row>

          <v-row justify="center" align="center" class="text-center d-flex">
            <v-col cols="12" class="mt-4">
              <h2>Select Day</h2>
              <div class="mt-2 px-0" align="center" justify="center">
                  <v-date-picker
                    ref="picker"
                    v-model="date"
                    :min="new Date().toISOString().substr(0, 10)"
                    class="custom-date-picker"
                    color="primary"
                  ></v-date-picker>
              </div>
            </v-col>
          </v-row>
          <v-row justify="center" align="center" class="text-center d-flex">
            <v-col cols="12" class="mt-4">
              <h3>
                Select Time
              </h3>
              <v-select
                style="font-size: 12px !important"
                class="mt-2 mb-4 selectPrivateShow"
                filled
                dense
                solo
                background-color="#fff"
                v-model="timeSelected"
                :items="privateTime"
                :no-data-text="getEmptyText()"
                attach
                item-text="text"
                item-value="value"
                label="Time"
                @change="privateTimeSelected"
              ></v-select>
            </v-col>
          </v-row>
          <v-row justify="center" align="center" class="text-center d-flex">
            <v-col align="center" justify="center">
              <v-row><h3>Price</h3></v-row>
            </v-col>
          </v-row>
          <v-row justify="center" align="center" class="text-center d-flex ">
            <v-col align="center" justify="center">
              <v-row class="priceMinute" ><span>
                ${{priceService}}
                
                </span> per minute</v-row>
            </v-col>
          </v-row>
          <v-row class="px-5">
              <v-col
                cols="12"
                  class="d-flex mt-3 mt-sm-0 align-center justify-center"
              >
              
                <v-btn
                  :disabled="
                    !date ||
                    !time ||
                    !ampm ||
                    savingAppointment                    
                  "
                  :loading="savingAppointment"
                  @click="completeSchedule()"
                  style="font-weight: 600; color:#FFFFFF !important;"
                  width="160"
                  color="primary"
                  class="white--text mt-3"
                  depressed
                  >Confirm</v-btn
                >
              </v-col>
            </v-row>
        </v-container>
      </div>
    </v-card>
  </v-dialog>
</template>
<script>
import moment, { now } from "moment";
import moment_tz from "moment-timezone";


export default {
  props: {
    request: {
      default: "",
    },
    model: {
      type: Object,
      require: true,
    },
  },
  data() {
    return {
      showCalendar: true,
      model_schedules: null,
      lessonLength: [],
      privateTime: [],
      subjectSelected: null,
      lessonText: "",
      savingAppointment: false,
      requestCompleted: false,
      zone_Abbr: '',
      date: null,
      time: null,
      ampm: null,
      selectedDayAppointments: null,
      durationSelected: 30,
      timeSelected: null,
      buyCreditOption: false,
      timerEnabled: false,
      priceService:0,

      notAvailableMessage: "",
    };
  },
  computed: {
    computedDateFormattedMomentjs() {
      return this.date ? moment(this.date).format("dddd, MMM D") : "";
    },
    schedule() {
      if (this.date || this.time)
        return `Schedule for ${this.computedDateFormattedMomentjs || ""}${
          this.time
            ? this.date
              ? ", " + moment(this.time).format("hh:mm A")
              : moment(this.time).format("hh:mm A")
            : ""
        }`;
      return "";
    },
  },
  //-------------------------------------------------------------------------------------------
  mounted() {
    this.zone_Abbr = moment_tz.tz().zoneAbbr();
    if (this.model.id) {
      this.getUserSchedule();
    }

    console.log('testMaxMaxx',this.model);
    if(this.model.length>0){
      for (var i = 0; i < this.model.services.length; i++) { 
        if(this.model.services[0].service.name == "Scheduled Privates")
        this.priceService = this.model.services[0].rate;
      }
    }

    this.$root.$on("open_confirmed_dialog", (data) => {
      this.$emit("update:close", false);
    });
  },
  //--------------------------------------------------------------------------------------------
  watch: {
    date(val) {
      if (val) {
        this.getUserTodayAppointmens();
        // this.showCalendar = false;
      } else {
        this.privateTime = [];
        this.timeSelected = null;
      }
    },
    durationSelected(val) {
      if (!val) return;
      if (this.date !== null && this.selectedDayAppointments !== null)
        this.getLessonAvailableTimes(this.date);
    },
  },
  //----------------------------------------------------------------------------------------------
  //----------------------------------------------------------------------------------------------
  methods: {
    //----------------------------------------------------------------------------------------------
    timePassedMinuteCheck() {
        this.getLessonAvailableTimes(this.date);
    },
    //----------------------------------------------------------------------------------------------
    repeatEvery(func, interval) {
      var th = this;
      function repeater() {
        th.repeatEvery(func, interval);
        if (th.timerEnabled == true) func();
      }
      var now = new Date();
      var delay = interval - (now % interval);
      if (this.timerEnabled == true) setTimeout(repeater, delay);
    },
    
    //----------------------------------------------------------------------------------------------
    privateTimeSelected(value) {
      this.time = moment(value, "hh:mm A");
      this.ampm = moment(value, "hh:mm A").format("A");
    },
    //----------------------------------------------------------------------------------------------
    getUserTodayAppointmens() {

      this.selectedDayAppointments = null;
      axios
        .get(
          "/api/v1/model/appointments_on_day?model_id=" +
            this.model.id +
            "&date=" +
            this.date
        )
        .then((response) => {
          this.selectedDayAppointments = response.data;
          if (this.durationSelected !== null)
            this.getLessonAvailableTimes(this.date);
        })
        .catch(function (error) {
          console.log(error);
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
    },
    isToday() {
      var today = moment().format("YYYY-MM-DD");
      return moment(today, "YYYY-MM-DD").isSame(
        moment(this.date, "YYYY-MM-DD")
      );
    },
    isPassed(from) {
      moment.tz.setDefault(this.model.timezone_student);
      var now = moment().format("hh:mm:ss A");

      // console.log('  | ---------- now- '+now+'| - from_s - '+from);
      return moment(now, "hh:mm:ss A").isAfter(moment(from, "hh:mm:ss A"));
    },
    isNow(from) {
      var now = moment().format("hh:mm A");
      return moment(now, "hh:mm A").isSame(moment(from, "hh:mm A"));
    },
    momentsOverlap(from1, to1, from2, to2) {
      from1 = moment(from1, "YYYY-MM-DD hh:mm:ss A").format("hh:mm A");
      from1 = moment(from1, "hh:mm A");
      from2 = moment(from2, "hh:mm A").format("hh:mm A");
      from2 = moment(from2, "hh:mm A");
      to1 = moment(to1, "YYYY-MM-DD hh:mm:ss A").format("hh:mm A");
      to1 = moment(to1, "hh:mm A");
      to2 = moment(to2, "hh:mm A").format("hh:mm A");
      to2 = moment(to2, "hh:mm A");
      var overlaps = false;
      if (
        (from1.isSameOrAfter(from2) && from1.isBefore(to2)) ||
        (to1.isAfter(from2) && to1.isBefore(to2)) ||
        (from2.isSameOrAfter(from1) && from2.isBefore(to1)) ||
        (to2.isAfter(from1) && to2.isBefore(to1))
      ) {
        overlaps = true;
      }
      return overlaps;
    },
    hasAppointments(from, to) {
      if (this.selectedDayAppointments.length == false) return false;
      else {
        //   var f = from.format("hh:mm A");
        //    var t = to.format("hh:mm A");
        var has = false;
        for (var i = 0; i < this.selectedDayAppointments.length; i++) {
          /* var tf = moment(
            this.selectedDayAppointments[i].start_hour,
            "hh:mm A"
          );*/
          if (
            this.momentsOverlap(
              this.selectedDayAppointments[i].start_hour,
              this.selectedDayAppointments[i].end_hour,
              from,
              to
            )
          )
            has = true;
        }
        return has;
      }
    },
    
    getEmptyText() {
      return this.date == null
        ? "Select Date First !"
        : this.durationSelected == null
        ? "Select Duration First !"
        : "No hours left on the " + moment(this.date).format("DD");
    },
    getLessonAvailableTimes(date) {


      var schedule = this.getWeekDaySchedule(this.getWeekDay(date));
      console.log('max date'+this.getWeekDay(date));

      //this.privateTime = [];
      this.timeSelected = null;

      if (this.durationSelected !== null && schedule !== false) {
        var pprivateTime = [];

        for (var o = 0; o < schedule.length; o++) {
          var continueCreating = 'true';
          var from = schedule[o].from;
          var max = schedule[o].till;
          max = moment(max, "hh:mm:ss A");
          var iterations = 0;

          var to = from;
          from = moment(from, "hh:mm:ss A");
          
          to = moment(to, "hh:mm:ss A").add(this.durationSelected, "minutes");
          var times = [];

          

          while (moment(to, "HH:mm") <= moment(schedule[o].till, "HH:mm")) {

            var time = { 
              from: from.format("hh:mm A "),
              to: to.format("hh:mm A"),
            };

              times.push(time);

              // console.log(iterations+' line = '+moment(to, "HH:mm")+' to '+moment(schedule[o].till, "HH:mm"));
              
              from = to;
              to = moment(to, "hh:mm:ss A").add( this.durationSelected,"minutes");
          }

          for (var i = 0; i < times.length; i++) {
            var item = {
              text: times[i].from +' '+this.zone_Abbr,
              value: times[i].from,
            };
            // console.log('------ | from '+times[i].from+' till '+times[i].to);
            pprivateTime.push(item);
          }
        }
      }
      if (this.privateTime != pprivateTime) this.privateTime = pprivateTime;
      
    },
    //--------------------------------------------------------------------------------------------
    getWeekDaySchedule(week_day) {
      var schedules = [];
      if (this.model_schedules != null) {
        for (var i = 0; i < this.model_schedules.length; i++) {
          console.log('this.model_schedules[i].day = '+this.model_schedules[i].day+' week_day = '+ week_day);
          if (this.model_schedules[i].day == week_day) {
            console.log(' |----------------- this.model_schedules[i].from ==== '+ this.model_schedules[i].from);
            var schedule = {
              from: this.model_schedules[i].from,
              till: this.model_schedules[i].till,
            };
            schedules.push(schedule);
            
          }
        }
        console.log('schedules',schedules);
        return schedules;
      } else return false;
    },
    //--------------------------------------------------------------------------------------------
    getWeekDay(date) {
      var dt = moment(date, "YYYY-MM-DD hh:mm:ss A");
      return dt.format("dddd");
    },
  //--------------------------------------------------------------------------------------------
    getUserSchedule() {
      axios
        .get("/api/v1/model/schedule?model_id=" + this.model.id)
        .then((response) => {
          this.model_schedules = response.data;
        })
        .catch(function (error) {
          console.log(error);
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
    },

    //------------------------------------------------------------------------------------------
    completeSchedule() {
      this.notAvailableMessage = false;
      let possible_appointment = {};
      possible_appointment.date = moment(this.date).format("YYYY-MM-DD");
      possible_appointment.ampm =
        this.ampm == moment().format(this.ampm.charAt(0));
      possible_appointment.service_id = 2;
      possible_appointment.duration = 30;
      possible_appointment.psychic_id = this.model.id;
      let start = moment(this.time, "hh:mm A");
      possible_appointment.start = moment(start).format("hh:mm A");
      let appointment = Object.assign({}, possible_appointment);
      appointment.date_and_time =
        appointment.date + " " + possible_appointment.start;
      appointment.text = this.lessonText;
      axios
        .post("/api/v1/user/appointment/create", appointment)
        .then((response) => {
          if (response.data.busy) {
            this.savingAppointment = true;
            this.notAvailableMessage = response.data.busy;
            return;
          }
          this.requestCompleted = true;
          this.$root.$emit("update_notifications", true);
          if (response.data[1].buyCreditOpcion) {
            this.buyCreditOption = response.data[1].buyCreditOpcion;
          }
        })
           ["catch"](function (error) {
          console.log(error);
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        })
        .finally((e) => {
          this.savingAppointment = false;
          this.close();
        });
    },
    
    addCredit() {
      this.close();
      EventBus.$emit("open-credits", {});
    },
    close() {
      this.$emit("update:close", false);
    },
  },
};
</script>
<style>
.dialogTitle h1 {
  font-size: 18px;
  letter-spacing: 0px;
  color: #131220;
  opacity: 1;
  line-height: 26px;
  font-weight: 600;
  text-align: center;
  width: 100%;
}

.dialogTitle h2 {
  font-size: 16px;
  letter-spacing: 0px;
  color: #949498;
  opacity: 1;
  line-height: 26px;
  font-weight: 600;
  text-align: center;
  width: 100%;
}

.dialogTitle h3 {
  font-size: 14px;
  letter-spacing: 0px;
  color: #949498;
  opacity: 1;
  line-height: 26px;
  font-weight: 600;
  text-align: center;
  width: 100%;
}

.search-container .active {
  color: #910f24 !important;
  border-bottom: 2px solid #910f24;
}

.search-container
  .filter-select.blueCheckList.v-text-field--filled.v-input--dense.v-text-field--single-line
  .v-label {
  margin-top: 7px;
}

.search-container
  .filter-select
  .v-input__icon.v-input__icon--append
  i::before {
  background: none;
  position: unset;
  content: "\F0140";
  color: #910f24;
}
.dialogTitle .v-picker{
  border: 1px #CBCBCD solid;
  border-radius: 3px !important;
  box-shadow: 0px 1px 1px #0000000C !important;
}

.dialogTitle button:focus{
  outline: none !important;
}
.dialogTitle button.v-btn{
  font-weight: 500 !important;
}

.request .v-picker__title.primary {
  display: none;
}
.request .theme--light.v-date-picker-table th{
    background: #fff !important;
    border-top:1px solid #F3F3F3;
    border-bottom:1px solid #F3F3F3;
}

 .v-application .dialogTitle .v-date-picker-table__current.primary--text {
    background: #F3F3F3;
    color: #797885 !important;
    border: none;
    font-weight: 600 !important;
}

.v-application .dialogTitle .v-btn--active.primary {
    background-color: #F77F9833 !important;
    color: #F77F98 !important;
    border: none;
    font-weight: 600 !important;
}

.dialogTitle .theme--light.v-date-picker-header .v-date-picker-header__value:not(.v-date-picker-header__value--disabled) button:not(:hover):not(:focus),
.dialogTitle .v-date-picker-header__value button{ 
  color: #131220 !important;
  font-weight: 600 !important;
}

.request.v-dialog {
  border-radius: 0px i !important;
}
.request.v-dialog.noHiddenSelect {
  overflow-y: inherit !important;
  overflow-x: inherit !important;
}

.theme--light.v-btn.v-btn--disabled {
  color: rgba(0, 0, 0, 0.26) !important;
}
.theme--light.v-select .v-select__selection--comma {
  color: #151517 !important;
}
.request .v-list-item .v-list-item__title,
.request .theme--light.v-select-list {
  background-color: #f2f2f7;
  color: #151517 !important;
}
.custom-date-picker {
  width: 100%;
}
.user_avatar_mv {
  position: relative;
  backface-visibility: hidden;
  display: inline-block;
  overflow: hidden;
  border-radius: 50%;
  width: 94px;
  height: 94px;
  background-size: cover;
}
.v-textarea textarea {
  padding-left: 12px !important;
  padding-top: 4px !important;
}

.selectPrivateShow{
  box-shadow: 0px 1px 1px #0000000D !important;
  border: 1px solid #CBCBCD !important;
  border-radius: 4px  !important;
  
}

.selectPrivateShow.v-text-field.v-text-field--solo .v-input__control{
  min-height: 28px !important;
}
.selectPrivateShow.v-text-field--filled.v-input--dense.v-text-field--single-line .v-label div, .theme--light.v-select .v-select__selection--comma div, .v-select .v-label, .v-select__selections div {
opacity: 1 !important;
    width: 100%;
    text-align: center !important;
}
.selectPrivateShow .v-input__icon.v-input__icon--append i::before{
    height: 10px !important;
    background-size: 10px  !important;
    width: 10px  !important;
}

.selectPrivateShow .v-input__icon{
  height: 10px !important;
    width: 10px  !important;
    min-width: 10px  !important;
    padding-left: 0px  !important;
    padding-right: 15px !important;
    padding-top: 10px;
}

.priceMinute span{
  letter-spacing: 0px;
color: #131220;
font-size: 12px;
font-weight: 600;
}
.priceMinute{
  letter-spacing: 0px;
      display: block !important;
color: #131220;
font-size: 12px;
text-align: center;
}
</style>