<template>
  <v-container class="p-0 m-0">
    <v-row class="py-0 mb-0 pb-0 mb-0 mt-3" no-gutters>
      <v-col :sm="6">
        <p class="h2Title pt-2" style="font-size: 14px !important">Earnings</p>
      </v-col>
      <v-col :sm="6" class="text-right">
        <v-container class="p-0 m-0">
          <v-row v-if="user.role_id == 1" style="float: right;">
            <p class="pt-1">
              <span style="color: #2CC05F; font-weight: 600; font-size: 12px;" v-if="status">Online</span>
              <span
                style="color: #999999; font-weight: 600; font-size: 12px;"
                v-if="!status"
              >Offline</span>
            </p>
            <v-switch
              class="mt-0 mb-0 pt-0 pb-0 ml-4 service_switch"
              color="#49C874"
              flat
              inset
              :dense="true"
              :ripple="false"
              v-model="status"
              @change="postUserOnlineStatus(status)"
            ></v-switch>
          </v-row>
        </v-container>
      </v-col>
    </v-row>
    <v-row class="py-0 mb-3" no-gutters>
      <v-col :sm="6">
        <v-card class="mb-0" min-height="80px">
          <v-card-title class="p-0 pl-4 mb-2 pt-2 textList" style="color: #C7C7C7" primary-title>
            <div>Earned this Week</div>
          </v-card-title>
          <v-card-title
            class="p-0 pl-4 mt-1 mb-0 textList"
            style="line-height: 2px;color: #1F1E34  !important; font-weight: 600; font-size: 13px !important "
          >
            <div>${{ current_balance | numFormat("0,0.00") }}</div>
          </v-card-title>
        </v-card>
      </v-col>
      <v-col :sm="6">
        <v-card class="mb-0" min-height="80px">
          <v-card-title class="p-0 pl-4 mb-2 pt-2 textList" style="color: #C7C7C7" primary-title>
            <div>Earned All-Time</div>
          </v-card-title>
          <v-card-title
            class="p-0 pl-4 mt-1 mb-0 textList"
            style="line-height: 2px;color: #1F1E34  !important; font-weight: 600; font-size: 13px !important "
          >
            <div>${{ total_earning | numFormat("0,0.00") }}</div>
          </v-card-title>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
  <!-- <v-card min-height="90px" class="mb-3">
            <v-layout row>
            <v-flex xs8>
                 <v-card-title class="pl-7 pt-2 d-block" primary-title>
            <div class=" text_header_data">Reviews</div>
            <div class="number_reviews">{{reviews}}</div>
                 </v-card-title>
            </v-flex>
            <v-flex xs4>
                 <v-card-title class="pt-2 pr-2 number_data">
            <v-rating style="bottom: 15px;"
                                   
                                    v-model="reviews_rating"
                                    background-color="yellow darken-2"
                                    color="yellow darken-2"
                                    readonly
                                    dense
                                    half-increments                            
                                    
           ></v-rating>
                 </v-card-title>
            
            </v-flex>
            </v-layout>
  </v-card>-->

  <!-- <v-card min-height="90px" class="mb-3">
            <v-layout row>
            <v-flex xs7>
                 <v-card-title class="pl-7 pt-2 text_header_data" primary-title>
            <div>Profile Views</div>
                 </v-card-title>
            </v-flex>
            <v-flex xs4>
                 <v-card-title class="pl-7 pt-2 number_data">
            <div>{{profile_views}}</div>
                 </v-card-title>
            
            </v-flex>
            </v-layout>
  </v-card>-->
</template>

<script>
import { EventBus } from "../../event-bus.js";
export default {
  props: ["user"],
  data() {
    return {
      reviews: 0,
      status: false,
      total_earning: 0,
      profile_views: 0,
      reviews_rating: 0.0,
      current_balance: 0.0,
    };
  },
  mounted() {
    if (
      this.$vuetify.breakpoint.name === "xs" ||
      this.$vuetify.breakpoint.name === "sm"
    ) {
      this.f_data_header();
    }
  },
  methods: {
    postUserOnlineStatus(status) {
      axios
        .post("/api/v1/user/set_contact_status", { online: status })
        .then((response) => {
          console.log(
            `this is mobile status from DB: ${response.data.success.data.online}`
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
      EventBus.$emit("changed-event", this.status);
    },
    f_data_header() {
      axios
        .get("/api/v1/user/hdata")
        .then((response) => {
          if (response.status === 200) {
            this.current_balance = response.data.success.current_balance;
            this.total_earning = response.data.success.t_earning;
            this.reviews = response.data.success.reviews;
            this.profile_views = response.data.success.p_views;
            this.reviews_rating = response.data.success.reviews_rating;
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
  },
  created() {
    this.status = this.user.online;
  },
};
</script>

<style lang="scss" scoped>
.number_data {
  position: absolute;
  right: 10px;
  bottom: 16px;
  font-size: 28px;
  font-weight: bold;
}
.text_header_data {
  font-weight: 600;
  color: #bebec2 !important;
}
.number_reviews {
  font-size: 20px;
  font-weight: bold;
}
</style>
