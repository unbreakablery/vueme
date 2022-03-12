<template>
  <v-container class="px-0">
    <v-row>
      <v-col class="col-12 col-sm-4">
        <v-card class="mb-3 text-center pt-5">
          <div>
            <div class="text-success">Current Balance</div>
            <div
              style="font-size:25px"
              :style="[
                payout_details.current_balance < 0 ? { color: '#ff5a7f' } : {},
              ]"
              class="font-weight-bold py-1"
            >
              ${{ payout_details.current_balance | numFormat("0,0.00") }}
            </div>
            <div class="body-2 grey--text">Pay Period:</div>
            <div class="body-2 grey--text">{{ payout_details.pay_period }}</div>
            <div class="body-2 py-2 mt-2 earnings_after_fees" style="">
              Earnings after fees
            </div>
          </div>
        </v-card>
      </v-col>

      <v-col class="col-12 col-sm-4">
        <v-card class="mb-3 text-center pt-5">
          <div>
            <div class="text-primary">Upcoming Payment</div>
            <div style="font-size:25px" class="font-weight-bold py-1">
              ${{
                payout_details.upcoming_payment_amount | numFormat("0,0.00")
              }}
            </div>
            <div class="body-2 grey--text">Process date:</div>
            <div class="body-2 grey--text">
              {{ payout_details.upcoming_payment_day }}
            </div>
            <div class="body-2 py-2 mt-2 earnings_after_fees" style="">
              Earnings after fees
            </div>
          </div>
        </v-card>
      </v-col>

      <v-col class="col-12 col-sm-4">
        <v-card class="mb-3 text-center pt-5">
          <div>
            <div class="blue--text">All Time Earnings</div>
            <div style="font-size:25px" class="font-weight-bold py-1">
              ${{ payout_details.all_payment | numFormat("0,0.00") }}
            </div>
            <div class="body-2 grey--text">Since Joining:</div>
            <div class="body-2 grey--text">{{ f_fdate(user.created_at) }}</div>
            <div class="body-2 py-2 mt-2 earnings_after_fees" style="">
              Earnings after fees
            </div>
          </div>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      reviews: 0,
      total_earning: 0,
      profile_views: 0,
      reviews_rating: 0.0,
    };
  },
  props: ["payout_details", "user"],
  mounted() {
    if (
      this.$vuetify.breakpoint.name === "xs" ||
      this.$vuetify.breakpoint.name === "sm"
    ) {
      this.f_data_header();
    }
  },
  methods: {
    f_fdate(date) {
      if (
        navigator.userAgent.indexOf("Safari") != -1 &&
        navigator.userAgent.indexOf("Chrome") == -1
      )
        var created = new Date(date.replace(/\s/, "T"));
      else var created = new Date(date);

      return (
        (created.getMonth() > 8
          ? created.getMonth() + 1
          : "0" + (created.getMonth() + 1)) +
        "/" +
        (created.getDate() > 9 ? created.getDate() : "0" + created.getDate()) +
        "/" +
        created.getFullYear()
      );
    },

    f_data_header() {
      axios
        .get("/api/v1/user/hdata")
        .then((response) => {
          if (response.status === 200) {
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
.earnings_after_fees {
  background-color: #ebf4fd;
  color: #656b72 !important;
  font-size: 12px !important;
}
</style>
