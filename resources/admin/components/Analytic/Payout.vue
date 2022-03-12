<template>
  <div>
    <v-card-title class="pt-0">
      <v-row class="d-flex justify-start">
        <v-col col="12">
          Models payout
          <!-- <v-btn color="purple" class="text-white" @click="printChart">Export</v-btn> -->
        </v-col>
      </v-row>
      <v-row class="d-flex justify-md-end">
        <v-col cols="12" md="5" style="max-width:220px">
          <v-select v-model="month" :items="months" label="Year Total" clearable>
          </v-select>
        </v-col>
        <v-col cols="12" md="3" style="max-width:220px">
          <v-select v-model="year" :items="years" label="Year">
          </v-select>
        </v-col>
        <v-col class="d-flex" style="max-width: 30px">
          <v-btn icon style="margin-top: 15px" @click="reset">
            <v-icon>mdi-autorenew</v-icon>
          </v-btn>
        </v-col>
      </v-row>
    </v-card-title>
    <v-row>
      <v-col col="12">
        <div v-if="month" class="d-flex justify-center mb-3">
          <div>
            <div class="font-weight-bold">{{month | month}} {{year}}</div>
            <div>Total  {{monthTotal.cont1 | money}}</div>
          </div>
        </div>
        <div v-else class="d-flex justify-center mb-3">
          <div>
            <div class="font-weight-bold">{{'Year ' + year }}</div>
            <div>Total {{yearTotal.cont1 | money}}</div>
          </div>
        </div>
        <AnalyticBar v-if="datacollection" :chart-data="datacollection" money="true" :tool-tip="toolTip" />
      </v-col>
    </v-row>
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
  computed: {
    ...mapGetters({
      items: "analytic/payouts"
    })
  },
  watch: {
    month(val) {
      
        this.$store
          .dispatch(this.store + "/payouts", { year: this.year, month: val })
          .then(() => {
            let payouts = [],
              item = null,
              labels = [];
            for (
              let i = 1;
              i <= moment(`${this.year}-${this.month}`, "YYYY-M").daysInMonth();
              i++
            ) {
              labels.push(i);
              item = this.items.payouts.filter(item => item.interval == i);
              if (item.length) {
                payouts.push(item[0].total);
                this.monthTotal.cont1 = this.monthTotal.cont1 + item[0].total;
              } else payouts.push(0);
            }
            this.datacollection = {
              labels: !val ? this.months.map(item => item.text) : labels,
              datasets: [
                {
                  label: "Payout",
                  backgroundColor: "#f87979",
                  data: payouts
                }
              ]
            };
          });
          
    },
    year(val) {
      this.month = null;

      this.$store.dispatch(this.store + "/payouts", { year: val }).then(() => {
        let payouts = [],
          item = null;
        for (let i = 1; i < 13; i++) {
          item = this.items.payouts.filter(item => item.interval == i);
          if (item.length) {
            payouts.push(item[0].total);
            this.yearTotal.cont1 = this.yearTotal.cont1 + item[0].total;
          } else payouts.push(0);
        }
        this.datacollection = {
          labels: this.months.map(item => item.text),
          datasets: [
            {
              label: "Payout",
              backgroundColor: "#f87979",
              data: payouts
            }
          ]
        };
      });
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
            return label + new Intl.NumberFormat([],{style: 'currency', currency: 'USD'}).format( Math.round(tooltipItem.yLabel * 100) / 100 );
          }
        }
      }
    };
  },
};
</script>
