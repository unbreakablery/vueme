<template>
  <div class="px-0 model-money-container">
    <div class="mb-4">
      <form class="form-dashboard sfFormProfile">
          <v-row class="mb-3 ml-0 mr-0">
            <div class="px-lg-0 px-md-0 ml-0 mr-0 money-header">
              <h1 class="mb-2 money-tab-header">Money</h1>
            </div>
          </v-row>
        <div class="row sfHeaderProfile m-0 money-card">
            <v-card
              class="sfHeadersPayout money-v-card"
            >
                <div class="sfHeaderTitle card-title">Current Balance</div>
                <div
                  :style="[
                    payout_details.current_balance < 0
                      ? { color: '#ff5a7f' }
                      : {}, 
                  ]"
                  class="sfHeaderBalance card-balance"
                >
                  ${{ payout_details.current_balance | numFormat("0,0.00") }}
                </div>
                <div class="pay-period">Pay Period</div>
                <div class="sfHeaderPeriod pay-date"  style="min-height:14px">
                  {{ payout_details.pay_period_short }}
                </div>
                <div class="card-earning">
                  *Earnings after fees
                </div>
            </v-card>

            <v-card
              class="sfHeadersPayout money-v-card"
            >
              <div>
                <div class="sfHeaderTitle card-title">Upcoming Payment</div>
                <div class="sfHeaderBalance card-balance">
                  ${{
                    payout_details.upcoming_payment_amount | numFormat("0,0.00")
                  }}
                </div>
                <div class="pay-period">Pay Period</div>
                <div class="sfHeaderPeriod pay-date" style="min-height:14px">
                  {{ payout_details.upcoming_payment_day_short }}
                </div>
                <div class="card-earning">
                  *Earnings after fees
                </div>
              </div>
            </v-card>

            <v-card
              class="sfHeadersPayout money-v-card"
            >
              <div>
                <div class="sfHeaderTitle card-title">All Time Earnings</div>
                <div class="sfHeaderBalance card-balance">
                  ${{ payout_details.all_payment | numFormat("0,0.00") }}
                </div>
                
                <div class="pay-period">Pay Period</div>
                <div class="sfHeaderPeriod pay-date"  style="min-height:14px">
                  Since {{ payout_details.since_short }}
                </div>
                <div class="card-earning">
                  *Earnings after fees
                </div>
              </div>
            </v-card>
        </div>
        <div class="buttonbar edit-buttonbar">
          <button type="button" class="payouts" @click="payoutsShow"><span>Payouts</span></button>
          <button type="button" class="tax-forms" @click="taxShow"><span>Tax Forms</span></button>
          <button type="button" class="history" @click="historyShow"><span>History</span></button>
        </div>
        <div id="payouts" style="margin-top: 30px !important;">
          <payout-method
            :user="user"
            :countries="countries"
            :cards="cards"></payout-method>
        </div>
        <div id="taxForms">
          <tax-forms />
        </div>
        <div id="history">
          <p-credit_logs class="mt-5" :transactions="transactions" :name="name"></p-credit_logs>
          <p-payout-history :transactions="payout_logs"></p-payout-history>
        </div>  
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      reviews: 0,
      total_earning: 0,
      profile_views: 0,
      reviews_rating: 0.0,
      active_tab: null,
    };
  },
  props: ["payout_details", "user",'countries', 'cards','name','transactions','payout_logs',"states","country_all"],
  mounted() {
    if (
      this.$vuetify.breakpoint.name === "xs" ||
      this.$vuetify.breakpoint.name === "sm"
    ) {
      this.f_data_header();
    }
    document.getElementsByClassName('payouts')[0].style.backgroundColor = '#ceb5fa';
    document.getElementsByClassName('payouts')[0].style.color = '#131120';
    document.getElementById('taxForms').style.display = 'none';
    document.getElementById('history').style.display = 'none';
    document.getElementsByClassName('tax-forms')[0].style.color = '#949498';
    document.getElementsByClassName('history')[0].style.color = '#949498';
  },

  methods: {
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
    payoutsShow() {    
      document.getElementById('payouts').style.display = 'block';
      document.getElementById('taxForms').style.display = 'none';
      document.getElementById('history').style.display = 'none';
      document.getElementsByClassName('payouts')[0].style.backgroundColor = '#ceb5fa';
      document.getElementsByClassName('tax-forms')[0].style.backgroundColor = 'transparent';
      document.getElementsByClassName('history')[0].style.backgroundColor = 'transparent';
      document.getElementsByClassName('payouts')[0].style.color = '#131220';
      document.getElementsByClassName('tax-forms')[0].style.color = '#949498';
      document.getElementsByClassName('history')[0].style.color = '#949498';
    },
    taxShow() {
      document.getElementById('payouts').style.display = 'none';
      document.getElementById('taxForms').style.display = 'block';
      document.getElementById('history').style.display = 'none';
      document.getElementsByClassName('payouts')[0].style.backgroundColor = 'transparent';
      document.getElementsByClassName('tax-forms')[0].style.backgroundColor = '#ceb5fa';
      document.getElementsByClassName('history')[0].style.backgroundColor = 'transparent';
      document.getElementsByClassName('payouts')[0].style.color = '#949498';
      document.getElementsByClassName('tax-forms')[0].style.color = '#131220';
      document.getElementsByClassName('history')[0].style.color = '#949498';
    },
    historyShow() {
      document.getElementById('payouts').style.display = 'none';
      document.getElementById('taxForms').style.display = 'none';
      document.getElementById('history').style.display = 'block';
      document.getElementsByClassName('payouts')[0].style.backgroundColor = 'transparent';
      document.getElementsByClassName('tax-forms')[0].style.backgroundColor = 'transparent';
      document.getElementsByClassName('history')[0].style.backgroundColor = '#ceb5fa';
      document.getElementsByClassName('payouts')[0].style.color = '#949498';
      document.getElementsByClassName('tax-forms')[0].style.color = '#949498';
      document.getElementsByClassName('history')[0].style.color = '#131220';
    },
  },
};
</script>

<style lang="scss">
.v-data-table__empty-wrapper{
  text-align: left !important;
}
.model-money-container {
  .buttonbar {
    background-color: #F0F0F7;
  }
  @media (max-width: 500px) {
    .buttonbar {
      max-width: 220px;
    }
  }
  .edit-buttonbar {
    margin-top: 30px;
  }
  .money-tab-header {
    margin-bottom: 0;
    font-size: 24px!important;
    color: #42424D;
    font-weight: 500;
    @media (max-width: 500px) {
      font-size: 20px;
    }
  }
  max-width: 895px;
  margin: 48px 38px;
  .money-card {
    background-color: transparent;
    box-shadow: none;
    padding: 0px;
    justify-content: space-between;
  }
  .money-v-card.v-sheet {
    padding: 0px!important;
    box-shadow: 0px 10px 13px #0000001a!important;
  }
  .money-v-card {
    width: 240px;
    max-width: 240px;
    max-height: none;
    border-radius: 0px!important;
    .card-title {
      font-size: 18px;
      color: #131220;
      opacity: 1;
      text-align: center;
      margin-top: 22px;
      margin-bottom: 22px;
    }
    .card-balance {
      color: #1F1E34;
      font-size: 20px;
      text-align: center;
      margin-bottom: 15px;
    }
    .pay-period {
      text-align: center;
      font-size: 16px;
      color: #949498;
      margin-bottom: 6px;
      font-weight: 600;
    }
    .pay-date {
      font-size: 12px;
      color: #1F1E34;
      text-align: center;
      opacity: 1;
      margin-bottom: 11px;
    }
    .card-earning {
      background-color: #FFEAEF;
      color: #131220;
      font-size: 12px;
      text-align: center;
      padding: 9px;
      font-weight: bold;
    }
  }
}
@media (max-width: 769px) {
  .model-money-container {
    margin-left: 0px;
    margin-right: 0px;
    .money-v-card {
      width: 100%;
      min-width: 100%;
      margin-bottom: 16px;
    }
    .money-card, .money-header {
      padding-left: 24px;
      padding-right: 24px;
    }
  }
}
</style>

<style>
.sfHeaderProfile {
  background: #f4f4f4;
  box-shadow: 0px 3px 6px #0000000d;
  opacity: 1;
  padding: 20px;
}
.sfHeadersPayout {
  max-width: 135px;
  max-height: 97px;
  box-shadow: 0px 3px 6px #0000000d !important;
  border-radius: 10px !important;
}
.sfHeadersPayout.v-card {
  padding: 10px 5px 5px 10px !important;
}

.sfHeaderBalance {
  font-size: 14px;
  text-align: left;
  font-weight: 600 !important;
  color: #43425d;
  opacity: 1;
  letter-spacing: 0.28px;
  line-height: 17px;
}

.sfHeaderTitle {
  font-size: 10px;
  line-height: 13px;
  letter-spacing: 0px;
  opacity: 0.5;
  font-weight: 600;
  color: #43425d;
  text-align: left;
  margin-bottom: 5px;
  margin-top: 5px;
}
.sfHeaderPeriod {
  font-size: 10px;
  text-align: left;
  opacity: 0.5;
  line-height: 13px;
  letter-spacing: 0px;
  font-weight: 500;
  color: #43425d;
}
.sfHeaderIco {
  text-align: right;
}
</style>