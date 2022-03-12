<template>
  <div class="model-appointments model-profile-main  dialogTitle">
    <h1 class="title">Livestream</h1>

    <div class="stickyTopCalendar model-sticky-calender mb-4">
      <v-date-picker
        ref="picker"
        v-model="userform.date"
        class="custom-date-picker"
        :min="new Date().toISOString().substr(0, 10)"
        color="primary"
      ></v-date-picker>
    </div>

    
      
      <form @submit="(e) => e.preventDefault()">
        <div class="profileinfo pd-none row" style="padding-left:0 !important; padding-right:0 !important">
          <div class="col-md-6 col-sm-12 col-12 " style="padding-left:0; padding-right:0">
            <h3>Select Time<span >  *</span></h3>
            <v-select
              id="profile_country"
              v-model="userform.time"
              :items="times"
              label=""
              background-color="#fff"
              filled
              dense
              solo
              flat
              hide-details
              item-text="text"
              item-value="value"
              class="checkRigth right-align profile_country"
              :menu-props="{ contentClass: 'checkList-lineBlue' }"
            ></v-select>
             <span
              v-if="errors['time']"
              class="float-left text-danger small"
            >{{ errors['time'][0] }}</span>

          </div>

             <div  class="col-md-6 col-sm-12 col-12 "  style="padding-left:0; padding-right:0">
            <h3>Wishlist (Optional)<span> </span></h3>
            <input
              type="text"
              placeholder="Add a product link to market during your livestream"
              style="background-color: #fff!important;"
              maxlength="150"
              v-model="userform.product_link"
            />
          </div>


        </div>

        <div class="descriptions pd-none col-md-12 col-sm-12 col-12 ">
          <h3>Livestream Description<span> *</span></h3>
          <v-textarea
            id="profile_description"
            v-model="userform.description"
            solo
            :maxlength="400"
            background-color="#fff"
            class="sfInputBackgroundClass"
            filled
            flat
            width="730"
            name="input-7-4"
            hide-details
            label=""
            placeholder="Hi this is my livestream"
          ></v-textarea>
                  <span
              v-if="errors['description']"
              class="float-left text-danger small"
            >{{ errors['description'][0] }}</span>
                
             
        </div>
       
        <div class="subtitle-1 mb-0 pd-none">
          <v-btn
            class="py-5 px-6"
            style="
              min-width: auto !important;
              background: linear-gradient(256deg, #7272ff 0%, #9759ff 100%);
              box-shadow: 0 2px 4px #9759ff4d;
              border-radius: 12px;
              outline: none;
            "
            type="submit"
            color="primary"
            @click="savePrivate()"
            rounded
          >
            <span style="font-size: 12px; letter-spacing: 0.43px"
              >Save Information</span
            >
          </v-btn>
          <span v-if="savingUserSubscription" style="color: #01bf16; font-size: 75%" 
            >Successfully Saved.</span
          >
        </div>
      </form>
    
    
    <!--v-dialog for the new profile fields-->
  </div>
</template>

<style lang="scss">
.model-appointments .model-v-tab .model-sticky-calender .vdpInnerWrap {
  min-height: auto !important;
  padding-bottom: 5px !important;
}

.model-appointments {
  max-width: 620px !important;
}
.model-appointments
  div.row.row-gray-area.marks
  div.textList.pt-0.col-lg-12.col
  span.mr-4 {
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
      textErr: [],
      userform: {
        date: moment().format("YYYY-MM-DD"),
        time: "",
        product_link: "",
        description: ""
      },
      datepicker_menu: false,
      times: [],
      usSaved: false,
      loading: true,
      loadingUpdate: false,
      appointments: [],
      errors: [],
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
      month: null,
      savingUserSubscription:false,
      
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
      space_header: "util/space",
    }),
    datePicker: {
      get() {
        return this.focus;
      },
      set(value) {
        this.showEvent(value);
      },
    },
 
    monthFormatter() {
      return this.$refs.calendar.getFormatter({
        timeZone: "UTC",
        month: "long",
      });
    },
  },
  watch: {
    
  },
  methods: {
    
    timesData(){
         var times = [];
        var iniTime = moment('00:00:00', "hh:mm:ss A");
        var pprivateTime = [];
        

         while (moment(iniTime, "HH:mm") <= moment('24:00:00', "HH:mm")) {
             var time = { 
              text: iniTime.format("hh:mm A "),
              value: iniTime.format("HH:mm"),
            };
            times.push(time);
            iniTime = moment(iniTime, "hh:mm:ss A").add('30', "minutes");
            

         }
         
        for (var i = 0; i < times.length; i++) {
            var item = {
              text: times[i].text,
              value: times[i].value,
            };
            this.times.push(item);
            
          }

    },
        savePrivate() {
      
      this.textErr = [];
      
      
      axios
        .post(`/api/v1/user/private/create`, this.userform)
        .then((response) => {
          setTimeout(() => {
            this.savingUserSubscription = true;
            console.log(response);
            setTimeout(() => {
              this.savingUserSubscription = false;
              window.location.href = '/dashboard';
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
          this.message = "";
        });
    },
  
  
  },
  /**
   * Prepare the component (Vue 2.x).
   */
  mounted() {
      this.timesData();
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
    font-size: 24px !important;
    color: #42424d;
    font-family: "Montserrat", sans-serif !important;
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
          color: #0f0f0f !important;
        }
        .tab-btn {
          width: 50%;
          font-size: 14px;
          color: #0f0f0f !important;
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
      font-size: 20px !important;
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

.custom-date-picker,
.custom-date-picker .v-picker__body {
  width: 100% !important;

}
.dialogTitle .v-picker{
  width: 100%;
  border: 1px #CBCBCD solid;
  border-radius: 3px !important;
  box-shadow: 0px 1px 1px #0000000C !important;
  padding: 10px !important;
}
.dialogTitle .v-picker__title {
  display: none;
}

.dialogTitle .theme--light.v-date-picker-table th{
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


.dialogTitle .theme--light.v-date-picker-header .v-date-picker-header__value:not(.v-date-picker-header__value--disabled) button:not(:hover):not(:focus),
.dialogTitle .v-date-picker-header__value button{ 
  color: #131220 !important;
  font-weight: 600 !important;
}

.v-application .dialogTitle .v-picker .v-btn--rounded{
  width: 100% !important;
  height: 40px !important;
  background: #fff !important;
}
.v-application .dialogTitle .v-date-picker-table__current.primary--text{

  background: #F3F3F3 !important;
    color: #797885 !important;
    border: none;
    font-weight: 600 !important;

    
}
.dialogTitle .v-picker .v-btn--rounded.v-btn--disabled{
  // background: #E6E6E6A3 !important;
  opacity: 0.5 !important;
} 

.dialogTitle .theme--light.v-date-picker-table th{
  background: #9759FF1A !important;
  height: 40px !important;
}

</style>