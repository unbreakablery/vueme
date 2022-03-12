<template>
  <div>
    <v-row class="mb-3">
      <v-col class="headline">{{name}}'s payout history</v-col>
    </v-row>

    <v-card flat class="mx-auto">
      <v-card-text class="pa-0" style="height: 50%">
        <v-row>
          <v-col class="col-12 col-sm-4">
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
              background-color="#F0F0F7"
              class="magnifyInput"
            ></v-text-field>
          </v-col>
          <v-col class="col-12 col-md-8">
            <v-row>
              <v-col>
                <div class="text-right">
                  <v-menu offset-y :close-on-content-click="false" v-model="close">
                    <template v-slot:activator="{ on }">
                      <v-btn
                        v-show="!show_data_range"
                        text
                        v-on="on"
                        hint="MM/DD/YYYY format"
                        :style="[ !$vuetify.breakpoint.smAndDown ? {'width': '135px !important'}:{'width': '135px !important','float':'right'}]"
                      >
                        {{range_data}}
                        <v-icon
                          small
                          v-show="range_data ==='Filter by Date'"
                        >mdi-arrow-down-drop-circle-outline</v-icon>
                        <v-icon
                          small
                          v-show="range_data !=='Filter by Date'"
                          @click="f_remove_data"
                        >mdi-close</v-icon>
                      </v-btn>
                    </template>
                    <v-date-picker v-model="dates" range></v-date-picker>
                  </v-menu>
                </div>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
        <v-data-table
          id="information"
          class="col-12"
          :search="search"
          :items="obj_transactions"
          :headers="headers"
          :hide-default-header="mobile"
        >
          <template v-slot:item="{item}">
            <tr :key="item.id" style="height:60px">
              <td class="px-2">${{item.payout | numFormat('0,0.00')}}</td>

              <td
                v-if="item.payout_to_pay > 0"
                class="px-2 text-center"
              >${{ item.payout_to_pay | numFormat('0,0.00')}}</td>
              <td v-else class="px-2 text-center">$--</td>

              <td class="px-2 text-center">{{item.period}}</td>
              <td class="px-2 text-right" :class="[item.status === 'Processed' ?'text-success':'']">
                <v-tooltip top v-if="item.status === 'Processed'">
                  <template v-slot:activator="{ on }">
                    <div style="cursor:pointer" v-on="on">{{item.status}}</div>
                  </template>
                  <span>{{item.paid_day}}</span>
                </v-tooltip>
                <div v-else>{{item.status}}</div>
              </td>
            </tr>
          </template>
        </v-data-table>
        <v-row class="pa-5"></v-row>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";
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
        { text: "Earnings", value: "earnings" },
        { text: "Payout", value: "payout", align: "center" },
        { text: "Pay Period", value: "period", align: "center" },
        { text: "Status", value: "status", align: "right" },
      ],
      dates: [],
      close: false,
      range_data: "Filter by Date",
      show_data_range: false,
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
    obj_transactions() {
      return this.transactions.filter((transaction) => {
        let str =
          transaction.payout +
          " " +
          transaction.payout_to_pay +
          " " +
          transaction.period +
          " " +
          transaction.status;

        if (
          !this.search ||
          str.toLowerCase().indexOf(this.search.toLowerCase()) !== -1
        ) {
          if (this.range_data !== "Filter by Date") {
            let start = new Date(this.dates[0]);
            let end = new Date(this.dates[1]);
            let startDB = new Date(transaction.start_period);
            let endDB = new Date(transaction.end_period);
            if (
              (start <= startDB || start <= endDB) &&
              (end >= endDB || end >= startDB)
            ) {
              return true;
            }
          } else {
            return true;
          }
        }
      });
    },
    ...mapGetters({
      mobile: "util/mobile",
    }),
  },
  props: ["transactions", "name"],

  methods: {
    f_remove_data() {
      this.close = false;
      this.range_data = "Filter by Date";
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

<style>
.icon-close {
  position: absolute;
  top: 0;
  right: 0;
  margin-right: 5px;
  margin-top: 5px;
}

.v-data-footer__pagination {
  margin: 0px 10px 0px 10px;
}
td {
  font-weight: 500;
  font-size: 12px;
}
.v-card label {
  color: #3f3e3f !important;
  font-weight: 500 !important;
}
</style>
