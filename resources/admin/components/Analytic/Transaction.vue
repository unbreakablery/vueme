<template>
  <div>
    <v-card-title class="pt-0">
      <v-row class="d-flex justify-start">
        <v-col col="12">
          Revenue
          <!-- <v-btn color="purple" class="text-white" @click="printChart">Export</v-btn> -->
        </v-col>
      </v-row>
      <v-row class="d-flex justify-md-end">
        <v-col cols="12" md="5" style="max-width:220px">
          <v-select v-model="month" :items="months" label="Year Total" clearable></v-select>
        </v-col>
        <v-col cols="12" md="3" style="max-width:220px">
          <v-select v-model="year" :items="years" label="Year"></v-select>
        </v-col>
      </v-row>
    </v-card-title>

    <v-tabs v-model="tab">
      <v-tab>Gross vs Net</v-tab>
      <v-tab>Gross By Service</v-tab>
      <v-tab>New vs Existing Purchases</v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab" style="background-color: transparent">
      <v-tab-item>
        <v-row class="mb-5 pb-5">
          <v-col col="12">
            <div v-if="month" class="d-flex justify-center mb-3">
              <div>
                <div class="font-weight-bold">{{month | month}} {{year}}</div>
                <div>Gross {{counts.cont1 | money}}</div>
                <div>Net {{counts.cont6 | money}}</div>
              </div>
            </div>
            <div v-else class="d-flex justify-center mb-3">
              <div>
                <div class="font-weight-bold">{{'Year ' + year}}</div>
                <div>Gross {{counts.cont1 | money}}</div>
                <div>Net {{counts.cont6 | money}}</div>
              </div>
            </div>
            <AnalyticBar
              v-if="datacollection"
              :chart-data="datacollection"
              money="true"
              :tool-tip="toolTip"
            />
          </v-col>
        </v-row>
      </v-tab-item>
      <v-tab-item>
        <v-row>
          <v-col col="12">
            <div v-if="month" class="d-flex justify-center mb-3">
              <div>
                <div class="font-weight-bold">{{month | month}} {{year}}</div>
                <div>V-Chat {{cont9 | money}}</div>
                <div>Calling {{cont8 | money}}</div>
                <div>Chat {{cont7 | money}}</div>
              </div>
            </div>
            <div v-else class="d-flex justify-center mb-3">
              <div>
                <div class="font-weight-bold">{{'Year ' + year}}</div>
                <div>V-Chat {{cont9 | money}}</div>
                <div>Calling {{cont8 | money}}</div>
                <div>Chat {{cont7 | money}}</div>
              </div>
            </div>
            <AnalyticBar
              class="pt-5"
              v-if="datacollection3"
              :chart-data="datacollection3"
              money="true"
              :tool-tip="toolTip"
            />
          </v-col>
        </v-row>
      </v-tab-item>
      <v-tab-item>
        <v-row>
          <v-col col="12">
            <div v-if="month" class="d-flex justify-center mb-3">
              <div>
                <div class="font-weight-bold">{{month | month}} {{year}}</div>
                <div>New Clients {{counts.cont4}}, Purchased {{counts.cont2 | money}}</div>
                <div>Existing Clients {{counts.cont5}}, Purchased {{counts.cont3 | money}}</div>
              </div>
            </div>
            <div v-else class="d-flex justify-center mb-3">
              <div>
                <div class="font-weight-bold">{{'Year ' + year}}</div>
                <div>New Clients {{counts.cont4}}, Purchased {{counts.cont2 | money}}</div>
                <div>Existing Clients {{counts.cont5}}, Purchased {{counts.cont3 | money}}</div>
              </div>
            </div>
            <AnalyticBar
              class="pt-5"
              v-if="datacollection2"
              :chart-data="datacollection2"
              :tool-tip="toolTip2"
            />
          </v-col>
        </v-row>
      </v-tab-item>
    </v-tabs-items>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import moment from "moment";

import AnalyticBar from "./VerticalBar";
import VerticalBarMixin from "./VerticalBarMixin";

export default {
  mixins: [VerticalBarMixin],
  components: {
    AnalyticBar
  },
  data() {
    return {
      users: [],
      tab: 0,
      cont6: 0,
      cont7: 0,
      cont8: 0,
      cont9: 0,
      datacollection3: null
    };
  },
  computed: {
    ...mapGetters({
      items: "analytic/transactions"
    })
  },
  methods: {
    // getData() {
    //   if (this.tab == 0) this.transactions();
    //   else if (this.tab == 1) this.status();
    // },
    transactions() {
      this.counts.cont1 = this.counts.cont2 = this.counts.cont3 = this.counts.cont4 = this.counts.cont5 = this.counts.cont6 =
      this.counts.cont7 = this.counts.cont8 = this.counts.cont9 = 0;
      this.users = [];

      const interval = this.month
        ? { year: this.year, month: this.month }
        : { year: this.year };

      this.$store.dispatch(this.store + "/transactions", interval).then(() => {

        let transactions = [],
          buyOnTime = [],
          buyMoreThanOne = [],
          revenue = [],
          chat = [],
          call = [],
          video = [],
          item = null,
          item2 = null,
          labels = [],
          loop = this.month
            ? moment(`${this.year}-${this.month}`, "YYYY-M").daysInMonth()
            : 12;
        for (let i = 1; i <= loop; i++) {
          labels.push(i);
          item = this.items.transactions.filter(item => item.interval == i);
          if (item.length) {
            transactions.push(item[0].credit);
            revenue.push(item[0].credit / 5);
            this.users.push(item[0].total);
            this.counts.cont1 = this.counts.cont1 + item[0].credit;
            this.counts.cont6 = this.counts.cont6 + revenue[i - 1];
          } else {
            transactions.push(0);
            revenue.push(0);
            this.users.push(0);
          }

          item = this.items.buyOnTime.filter(item => item.interval == i);
          if (item.length) {
            buyOnTime.push(item[0].total);
            this.users.push({ buyOnTime: item[0].credit });
            this.counts.cont2 = this.counts.cont2 + item[0].credit;
            this.counts.cont4 = this.counts.cont4 + item[0].total;
          } else {
            buyOnTime.push(0);
            this.users.push({});
          }

          item = this.items.buyMoreThanOne.filter(item => item.interval == i);
          if (item.length) {
            buyMoreThanOne.push(item[0].total);
            this.users[i - 1] = { buyMoreThanOne: item[0].credit };
            this.counts.cont3 = this.counts.cont3 + item[0].credit;
            this.counts.cont5 = this.counts.cont5 + item[0].total;
          } else {
            buyMoreThanOne.push(0);
          }

          item = this.items.chat.filter(item => item.interval == i);
          item2 = this.items.chat_refund.filter(item => item.interval == i);
          if (item.length) {
            let credit = item2.length ? (item[0].credit - item2[0].credit) : item[0].credit
            chat.push(credit);
            this.cont7 = this.cont7 + credit;
          } else {
            chat.push(0);
          }

          item = this.items.call.filter(item => item.interval == i);
          item2 = this.items.call_refund.filter(item => item.interval == i);
          if (item.length) {
            let credit = item2.length ? (item[0].credit - item2[0].credit) : item[0].credit
            call.push(credit);
            this.cont8 = this.cont8 + credit;
          } else {
            call.push(0);
          }

          item = this.items.video.filter(item => item.interval == i);
          item2 = this.items.video_refund.filter(item => item.interval == i);
          if (item.length) {
            let credit = item2.length ? (item[0].credit - item2[0].credit) : item[0].credit
            video.push(credit);
            this.cont9 = this.cont9 + credit;
          } else {
            video.push(0);
          }
        }
        this.datacollection = {
          labels: this.month ? labels : this.months.map(item => item.text),
          datasets: [
            {
              label: "Gross",
              backgroundColor: "#f87979",
              data: transactions
            },
            {
              label: "Net",
              backgroundColor: "#664577",
              data: revenue
            }
          ]
        };

        this.datacollection2 = {
          labels: this.month ? labels : this.months.map(item => item.text),
          datasets: [
            {
              label: "New Clients",
              backgroundColor: "#f87979",
              data: buyOnTime
            },
            {
              label: "Existing Clients",
              backgroundColor: "#664577",
              data: buyMoreThanOne
            }
          ]
        };

        this.datacollection3 = {
          labels: this.month ? labels : this.months.map(item => item.text),
          datasets: [
            {
              label: "V-Chat",
              backgroundColor: "#f87979",
              data: video
            },
            {
              label: "Calling",
              backgroundColor: "#664577",
              data: call
            },
            {
              label: "Chat",
              backgroundColor: "#B5E4E4",
              data: chat
            }
          ]
        };
      });
    }
  },
  watch: {
    month(val) {
      this.transactions();
    },
    year(val) {
      if (this.month) this.month = null;
      else this.transactions();
    }
  },
  mounted() {
    const $this = this;
    this.toolTip = {
      tooltips: {
        callbacks: {
          label: function(tooltipItem, data) {
            var label = data.datasets[tooltipItem.datasetIndex].label || "";

            if (label) {
              label += ": ";
            }
            label += new Intl.NumberFormat([],{style: 'currency', currency: 'USD'}).format(
                Math.round(tooltipItem.yLabel * 100) / 100
              );
            return label;
          }
        }
      }
    };
    this.toolTip2 = {
      tooltips: {
        callbacks: {
          label: function(tooltipItem, data) {
            
            var label = data.datasets[tooltipItem.datasetIndex].label || "";

            if (label) {
              label += ": ";
            }
            label += tooltipItem.yLabel;
            if (
              tooltipItem.datasetIndex &&
              $this.users[tooltipItem.index].buyMoreThanOne
            )
              label += `; Purchased: ${
                Intl.NumberFormat([],{style: 'currency', currency: 'USD'}).format(
                Math.round($this.users[tooltipItem.index].buyMoreThanOne * 100) / 100
              )
              }`;
            else if ($this.users[tooltipItem.index].buyOnTime)
              label += `; Purchased: ${new Intl.NumberFormat([],{style: 'currency', currency: 'USD'}).format(
                $this.users[tooltipItem.index].buyOnTime
              )}`;
            return label;
          }
        }
      }
    };
  },
  filters: {
    month(val) {
      return moment(val, "M").format("MMMM");
    }
  }
};
</script>
