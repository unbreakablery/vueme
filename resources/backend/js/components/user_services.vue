<template>
  <div class="pb-4 model-pricing-container">
    <form class="form-dashboard mb-12"  @submit="saveSubscription">
      <div class="row-gray-area p-0">
        <v-row no-gutters>
          <div class="px-lg-0 px-md-0 model-pricing-header">
            <p class="mb-2 model-pricing-title" style="color: #42424D">Pricing</p>
            <p class="mb-5" style="font-size: 14px; color: #131220; font-weight: 500">Set the monthly subscription price fans must pay to access all of your past and current livestreams.</p>
          </div>
        </v-row>
      </div>
      <div class="white py-7 pricing-container card-box-shadow">
        <v-row class="flex-column">
          <div class="ml-6 mr-6 mb-5">
            <div class="d-flex justify-space-between align-center">
              <p class="mt-auto mb-auto" style="font-size: 12px; color: #131220; font-weight: 600">Monthly Subscription</p>
            </div>
          </div>
          <div class="ml-6 mr-6 rate">
            <v-text-field
              class="input-color-none"
              style="padding-left:10px !important;padding-right:10px !important;"
              height="40px"
              solo
              dense
              filled
              hide-details
              flat
              v-model="subscription"
              prefix="$"
              suffix="per month"
              type="number"
              step=".01"
            >
            </v-text-field>
            <span
              v-if="errors2['price']"
              class="float-left text-danger small"
            >{{ errors2['price'][0] }}</span>
          </div>
          <div class="ml-6 mr-6">
            <p class="mt-2" style="font-size: 14px; color: #f77f98">View Subscribers</p>
          </div>
        </v-row>
        <v-row no-gutters class="mt-3">
          <div class="px-lg-0 px-md-0 mr-6 ml-6" cols="12">
            <div class="subtitle-1 mb-0">
              <v-btn class="py-5"
              style="min-width: 90px; 
                background: linear-gradient(256deg, #7272FF 0%, #9759ff 100%);
                box-shadow: 0 2px 4px #9759FF4D!Important;
                border-radius: 12px;
                outline: none;"
                type="submit"
                color="primary"
                :loading="savingUserSubscription"
                :disabled="savingUserSubscription"
                rounded
              >
              <span style="font-size: 12px!important; letter-spacing: 0.43px;">Save</span>
              </v-btn>
              <span style="color: #01BF16; font-size: 75%;" v-if="subsSaved">Successfully Saved.</span>
            </div>
          </div>
        </v-row>
      </div>
    </form>
    <form class="form-dashboard" @submit="updateUserServices">
      <div class="row-gray-area p-0 service-container mb-0">
        <v-row no-gutters>
          <div class="px-lg-0 px-md-0 mr-6 ml-6">
              <p style="font-size: 18px; color: #131220; margin-bottom: 10px;"><strong>Configure Services</strong></p>
              <p class="service-txt mb-5">Determine how much you want to charge for exclusive content</p>
          </div>
        </v-row>
      </div>
      <div class="white py-6 services-container card-box-shadow">
        <v-row  class="flex-column" v-for="(an_s, index) in services" :key="an_s.name" no-gutters>
          <div   :class="{'mt-10':index==1}" class="mr-6 ml-6 mb-6" v-if="index < 2">
            <div class="d-flex justify-space-between align-center">
              <div class="d-flex">
                <img class="mr-2" :src="'/images/icons/'+an_s.icon" />
                <p class="mt-auto mb-auto" style="font-size: 12px; color: #131220; font-weight: 600">{{an_s.name}}</p>
              </div>
              <div class="d-flex" style="justify-content: flex-end">
                <!-- <v-switch
                  class="service_switch switch-pricing"
                  color="#249800"
                  v-model="user_service[ an_s.id ].active"
                  :dense="true"
                  inset
                  :ripple="false"
                ></v-switch> -->
              </div>
            </div>
          </div>
          <div class="rate mr-6 ml-6" v-if="index < 2">
            <div class="d-flex justify-space-between">
              <div style="width: 48%">
                <p class="service-min" style="color: rgb(170, 170, 170); font-size: 14px; margin: 8px 0">Price</p>
                <v-text-field
                  v-model="user_service[ an_s.id ].rate"
                  class="input-color-none"
                  style="padding-left:10px !important;padding-right:10px !important;"
                  height="40px"
                  solo
                  dense
                  filled
                  hide-details
                  :disabled="an_s.id == 2 && free_chat"
                  flat
                  prefix="$"
                  suffix="per minute"
                  type="number"
                  step=".01"
                >
                </v-text-field>
                <span
              v-if="errors['user_services.'+index+'.rate']"
              class="float-left text-danger small"
            >{{ errors['user_services.'+index+'.rate'][0] }}</span>
              </div>
              <div style="width: 48%">
                <p class="service-min" style="color: rgb(170, 170, 170); font-size: 14px; margin: 8px 0">Minutes</p>
                <v-text-field 
                  v-if="an_s.enable_duration"              
                  height="40px"
                  solo
                  dense
                  filled
                  hide-details
                  flat
                  v-model="user_service[ an_s.id ].min_duration"
                  suffix="minutes min."
                  type="number"
                  step=".01"
                  class="input-color-none"
                  style="padding-left:10px !important;padding-right:10px !important;"
                >
                </v-text-field>
                 <span
              v-if="errors['user_services.'+index+'.min_duration'] && an_s.enable_duration"
              class="float-left text-danger small"
            >{{ errors['user_services.'+index+'.min_duration'][0] }}</span>
              </div>
             
              
            </div>
          </div>
        </v-row>
        <v-row no-gutters class="mt-5 mb-1">
          <div class="px-lg-0 px-md-0 ml-6 mr-6" cols="12">
            <div class="subtitle-1 mb-0">
              <v-btn class="py-5"
              style="min-width: 90px; 
                background: linear-gradient(256deg, #7272FF 0%, #9759ff 100%);
                box-shadow: 0 2px 4px #9759FF4D!Important;
                border-radius: 12px;
                outline: none"
                type="submit"
                color="primary"
                :loading="savingUserServices"
                :disabled="savingUserServices"
                rounded
              >
              <span style="font-size: 12px; letter-spacing: 0.43px;">Save</span>
              </v-btn>
              <span style="color: #01BF16; font-size: 75%;" v-if="usSaved">Successfully Saved.</span>
            </div>
          </div>
        </v-row>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      free_chat: true,
      savingUserServices: false,
      savingUserSubscription: false,
      usSaved: false,
      subsSaved: false,
      services: [],
      subscription: 0,
      user_services: [],
      user_service: {},
      browserSupported: [],
      user_id: 0,
      errors: {
        user_services: [],
      },
      errors2: {},
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
    getSubscription() {
      axios
        .get("/api/v1/user/suscription")
        .then((response) => {
          if(response.data.success.data)
          this.subscription = response.data.success.data;
        })
        .catch(function (error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
          }
        });
    },
    saveSubscription(e){
      e.preventDefault();
      this.savingUserSubscription = true;
      axios
        .post("/api/v1/user/suscription/save", {price: this.subscription})
        .then((response) => {
           setTimeout(() => {
            this.savingUserSubscription = false;
            this.subsSaved = true;
            this.errors2= {};
            setTimeout(() => {
              this.subsSaved = false;
            }, 2000);
          }, 1000);             
        })
        .catch((error) => {
          this.savingUserSubscription = false;
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
          if (typeof error.response.data === "object") {
            this.errors2 = error.response.data.errors;
          } else {
            this.errors2 = ["Something went wrong. Please try again."];
          }
          this.savingUserSubscription = false;
          this.message = "";
        });
    },
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
  mounted() {
    this.getServices();
    this.getSubscription();
  },
};
</script>
<style lang="scss" scoped>

</style>
<style lang="scss">
.switch-pricing {
  margin-top: 0px;
  .v-messages {
    min-height: 0px;
  }
  .v-input--selection-controls__input {
    margin-right: 0;
  }
  .v-input--switch__thumb.theme--light {
    color: white!important;
  }
  .v-input--switch__track {
    opacity: 1;
  }
}
.card-box-shadow {
  box-shadow: 0px 10px 13px #0000001A;
  border-radius: 4px;
}
.input-color-none {
  input {
    background-color: transparent!important;
    font-size: 14px !important;
    background-color: transparent!important;
    color: #1F1E34!important;
    border: none !important;
    box-shadow: none !important;
    font-weight: 500;
    padding-left: 0!important;
  }
}
.input-color-none {
  border: 1px solid #CCD1D9!important;
  border-radius: 4px!important;
}
.rate input[type="number"]::-webkit-inner-spin-button {
  display: none;
  -webkit-appearance: none;
}

.v-text-field--filled.v-text-field--single-line.v-input--dense input,
.v-text-field--full-width.v-text-field--single-line.v-input--dense input {
  margin-top: 0px !important;
}
.v-application--is-ltr .v-text-field__suffix {
  padding-right: 10px;
}
.service-txt {
  font-size: 14px;
  color: #131220;
  font-weight: 500;
  margin-bottom: 0 !important;
}
.service-container {
  margin-bottom: 40px;
}
.service-min {
  display: none;
}
.model-pricing-title {
  font-size: 24px;
  font-weight: 500;
}
@media screen and (max-width: 992px) {
  .service-txt {
    display: block;
  }
  .margin-bottom {
    margin-bottom: 20px !important;
  }
  .service-min {
    display: block;
  }
}
.model-pricing-container {
  margin: 40px 0px;
  max-width: 780px;
}
@media (max-width: 991px) {
  .model-pricing-container {
    margin-left: auto;
    margin-right: auto;
  }
}
@media (max-width: 860px) {
  .model-pricing-container {
    margin-left: 40px;
    margin-right: 40px;
  }
}
@media (max-width: 576px) {
  .model-pricing-container {
    margin-left: 2px;
    margin-right: 2px;
  }
  .model-pricing-title {
    font-size: 20px;  
  }
  .model-pricing-header {
    margin-left: 24px;
    margin-right: 24px;
  }
}
.mx-icon {
  margin-left: 10px!important;
  margin-right: 10px!important;
}
</style>
