<template>
  <div>
    <v-card-title class="pt-0">
      <v-row class="d-flex justify-start">
        <v-col col="12">
          Services
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
            <div>V-Chat {{monthTotal.cont1}}</div>
            <div>Calling {{monthTotal.cont2}}</div>
            <div>Chat {{monthTotal.cont3}}</div>
          </div>
        </div>
        <div v-else class="d-flex justify-center mb-3">
          <div>
            <div class="font-weight-bold">{{'Year ' + year}}</div>
            <div>V-Chat {{yearTotal.cont1}}</div>
            <div>Calling {{yearTotal.cont2}}</div>
            <div>Chat {{yearTotal.cont3}}</div>
          </div>
        </div>
        <AnalyticBar v-if="datacollection" :chart-data="datacollection" />
      </v-col>
    </v-row>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import moment from "moment";
import { objectToGetParameters } from "../../util";

import AnalyticBar from "./VerticalBar";
import VerticalBarMixin from "./VerticalBarMixin";

export default {
  mixins: [VerticalBarMixin],
  components: {
    AnalyticBar
  },
  computed: {
    ...mapGetters({
      services: "analytic/services"
    })
  },
  watch: {
    month(val) {
      this.monthTotal.cont2 = this.monthTotal.cont1 = this.monthTotal.cont3 = 0;
      // if (!val) return;
      this.$store
        .dispatch(this.store + "/services", { year: this.year, month: val })
        .then(() => {
          let videos = [],
            calls = [],
            messages = [],
            item = null,
            labels = [];

          for (
            let i = 1;
            i <= moment(`${this.year}-${this.month}`, "YYYY-M").daysInMonth();
            i++
          ) {
            labels.push(i);

            item = this.services.videos.filter(item => item.interval == i);
            if (item.length) {
              videos.push(item[0].total);
              this.monthTotal.cont1 = this.monthTotal.cont1 + item[0].total;
            } else videos.push(0);

            item = this.services.calls.filter(item => item.interval == i);
            if (item.length) {
              calls.push(item[0].total);
              this.monthTotal.cont2 = this.monthTotal.cont2 + item[0].total;
            } else calls.push(0);

            item = this.services.messages.filter(item => item.interval == i);
            if (item.length) {
              messages.push(item[0].total);
              this.monthTotal.cont3 = this.monthTotal.cont3 + item[0].total;
            } else messages.push(0);
          }
          this.datacollection = {
            labels: !val ? this.months.map(item => item.text) : labels,
            datasets: [
              {
                label: "V-Chat",
                backgroundColor: "#f87979",
                data: videos
              },
              {
                label: "Calling",
                backgroundColor: "#664577",
                data: calls
              },
              {
                label: "Chat",
                backgroundColor: "#B5E4E4",
                data: messages
              }
            ]
          };
        });
      // }
    },
    year(val) {
      this.month = null;

      this.yearTotal.cont2 = this.yearTotal.cont1 = this.yearTotal.cont3 = 0;

      this.$store.dispatch(this.store + "/services", { year: val }).then(() => {
        let videos = [],
          calls = [],
          messages = [],
          item = null;
        for (let i = 1; i < 13; i++) {
          item = this.services.videos.filter(item => item.interval == i);
          if (item.length) {
            videos.push(item[0].total);
            this.yearTotal.cont1 = this.yearTotal.cont1 + item[0].total;
          } else videos.push(0);

          item = this.services.calls.filter(item => item.interval == i);
          if (item.length) {
            calls.push(item[0].total);
            this.yearTotal.cont2 = this.yearTotal.cont2 + item[0].total;
          } else calls.push(0);

          item = this.services.messages.filter(item => item.interval == i);
          if (item.length) {
            messages.push(item[0].total);
            this.yearTotal.cont3 = this.yearTotal.cont3 + item[0].total;
          } else messages.push(0);
        }

        this.datacollection = {
          labels: this.months.map(item => item.text),
          datasets: [
            {
              label: "V-Chat",
              backgroundColor: "#f87979",
              data: videos
            },
            {
              label: "Calling",
              backgroundColor: "#664577",
              data: calls
            },
            {
              label: "Chat",
              backgroundColor: "#B5E4E4",
              data: messages
            }
          ]
        };
      });
    },
    loading(val) {
      this.$store.dispatch("util/setLoading", val);
    }
  }
};
</script>
