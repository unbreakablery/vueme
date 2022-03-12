<template>
  <div class="model-credit-logs model-referral-earnings">
    <v-row class="ml-0 mr-0">
      <v-col cols="12" class="px-0">
        <v-container class="mx-0">
          <v-card class="mx-auto credit-log-card" style="box-shadow: 0px 10px 13px #0000001A!important;">
            <v-card-text class="pa-0" style="height: 50%">
              <v-container>
                   <v-row class="mb-3"></v-row>
                <v-row>
                  <v-text-field
                    style="background-color: white;"
                    filled
                    solo
                    dense
                    flat
                    prepend-inner-icon="mdi-magnify"
                    label="Search"
                    v-model="search"
                    clearable
                    class="magnifyInput credit-log-search"
                  ></v-text-field>
                  <v-row>
                    <v-col class="mobile-padding">
                      <template>
                        <div class="text-right btOnly" >
                          <v-menu offset-y :close-on-content-click="false" v-model="close">
                            <template v-slot:activator="{ on }">
                              <v-btn
                                style="width: initial !important;height: 35px !important; background-color: white!important; min-width: 100%;padding: 0px;padding-left: 5px;font-size: 12px !important;"
                                v-show="!show_data_range"
                                
                                
                                v-on="on"
                                text
                                hint="MM/DD/YYYY format"
                                class="history-period"
                              >
                                <label class="mb-0" style="color: #1F1E34!important; letter-spacing: 0;">{{range_data}}</label>
                                <v-icon
                                  small
                                  v-show="range_data ==='Filter by'"
                                >ico-sort-arrows</v-icon>
                                <v-icon
                                  small
                                  
                                  v-show="range_data !=='Filter by'"
                                  @click="f_remove_data"
                                >mdi-close</v-icon>
                              </v-btn>
                            </template>
                            <v-date-picker v-model="dates" range></v-date-picker>
                          </v-menu>
                        </div>
                      </template>
                    </v-col>
                  </v-row>
                </v-row>
                <v-data-table
                  id="information"
                  v-if="referralEarning.length > 0"
                  class="col-12 credit-log-table"
                  :search="search"
                  :items="referralEarning"
                  :headers="headers"
                  :hide-default-header="mobile"
                >
                  <template v-slot:item="{item}">
                    <tr :key="item.id" style="height:60px">
                      <td class="px-0">{{item.name}}</td>

                      <td
                        v-if="item.payout_to_pay > 0"
                        class="px-0"
                      >${{ item.payout_to_pay | numFormat('0,0.00')}}</td>
                      <td v-else class="px-0">$--</td>

                      <td class="px-0">{{item.period}}</td>
                    </tr>
                  </template>
                </v-data-table>                
                 <div class="w-100 view-profile" v-else>
                   <br><br><br>
                 <h4 class="text-center pb-12 recent-streams mt-10">No Referral Earnings Yet!</h4>        
                   <br><br><br><br>
                 </div>
              </v-container>
            </v-card-text>
          </v-card>
        </v-container>
      </v-col>
    </v-row>
  </div>
</template>
                              



<script>
import { mapGetters } from "vuex";
export default {
  data: function () {
    return {
      loading: false,
      search: "",
      flag: true,
      selected_service: "",
      pdf_data: [],
      pdf_data_temp: [],

      headers: [
        { text: "Name", value: "name" },
        { text: "Earning", value: "earning" },
        { text: "Pay Period", value: "period" },
      ],
      dates: [],
      close: false,
      range_data: "Filter by",
      show_data_range: false,
      referralEarning: [
        /*{ name: "Username goes here", payout_to_pay: 120, period: "4/4-4/20" }*/
      ],
    };
  },
  watch: {
    dates: function (newVal, oldVal) {
      if (newVal.length !== 0) {
        if (newVal.length === 2) {
          this.range_data =
            newVal[0].replace("-", "/") + " - " + newVal[1].replace("-", "/");
          this.close = false;
        }
      }
    },
  },
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
    }),
  },

  methods: {
    f_remove_data() {
      this.close = false;
      this.range_data = "Filter by";
      this.dates = [];
    },
    f_fdate(date) {
      var created = new Date(date);
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
  },
};
</script>

<style lang="scss">
.model-referral-earnings {
  .mobile-padding {
    @media(max-width: 500px) {
      padding-left: 5px!important;
      padding-right: 5px!important;
    }
  }
  .credit-log-search {
    max-width: 235px!important;
    @media(max-width: 500px) {
      max-width: 198px!important;
    }
  }
  .v-text-field.v-text-field--solo .v-input__append-inner, .v-text-field.v-text-field--solo .v-input__prepend-inner {
    margin-left: 10px;
  }
  .container {
    padding: 20px 0;
  }
  .v-data-table__wrapper {
    min-height: 300px;
    th {
      padding: 0!important;
      span {
        font-size: 16px;
        color: #949498;
        font-weight: 600;
      }
    }
  }
  .magnifyInput.v-text-field--filled.v-input--dense.v-text-field--single-line .v-label {
    padding-top: 0px!important;
    line-height: 20px!important;
    color: #CBCBCD!important;
  }
  .credit-log-card {
    padding-left: 16px;
    padding-right: 16px;
  }
  @media (max-width: 500px) {
    .v-data-footer {
      justify-content: space-between;
      padding-left: 0px;
      padding-right: 0px;
      .v-data-footer__select {
        margin-left: 0px;
        margin-right: 0px;
        .v-select {
          margin: 0px;
        }
      }
      .v-data-footer__pagination {
        margin: 0px;
      }
    }
  }
}
</style>
