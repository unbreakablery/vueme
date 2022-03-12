<template>
  <div>
    <v-card-title class="pt-0">
      <v-row class="d-flex justify-md-end">
        <v-col cols="12" md="5" style="max-width:220px">
          <v-select v-model="month" :items="months" label="Year Total" clearable :disabled="!year"></v-select>
        </v-col>
        <v-col cols="12" md="3" style="max-width:220px">
          <v-select v-model="year" :items="years" label="Year" ></v-select>
        </v-col>
        <v-icon v-show="tab == 0" color="purple" large class="cursor-pointer" @click="downloadExcel">mdi-file-excel</v-icon>
      </v-row>
    </v-card-title>

    <v-tabs v-model="tab">
      <v-tab>Signups</v-tab>
      <v-tab>User Types</v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab" style="background-color: transparent">
      <v-tab-item>
        <v-row>
          <v-col col="12">
            <div v-if="month" class="d-flex justify-center mb-3">
              <div>
                <div class="font-weight-bold">{{month | month}} {{year}}</div>
                <div>Models {{ counts.cont1}}</div>
                <div>Clients {{ counts.cont2}}</div>
              </div>
            </div>
            <div v-else class="d-flex justify-center mb-3">
              <div>
                <div class="font-weight-bold">{{'Year ' + year}}</div>
                <div>Models {{ counts.cont1}}</div>
                <div>Clients {{ counts.cont2}}</div>
              </div>
            </div>
            <AnalyticBar v-if="datacollection" :chart-data="datacollection" />
          </v-col>
        </v-row>
      </v-tab-item>
      <v-tab-item>
        <v-row>
          <v-col col="12">
            <div class="d-flex justify-center mb-3">
              <div>
                <div v-if="month" class="font-weight-bold">{{month | month}} {{year}}</div>
                <div v-else class="font-weight-bold">{{'Year ' + year}}</div>
                <div>Models inactive {{ counts.cont1}}</div>
                <div>Models active {{ counts.cont2}}</div>
                <div>Clients inactive {{ counts.cont3}}</div>
                <div>Clients active {{ counts.cont4}}</div>
                <div>Models hidden {{ cont5 }}</div>
                <div>Clients hidden {{ cont6 }}</div>
                <div>Models fraud {{ cont7 }}</div>
                <div>Clients fraud {{ cont8 }}</div>
                <div>Test accounts {{ cont9 }}</div>
              </div>
            </div>
            <AnalyticBar v-if="datacollection2" :chart-data="datacollection2" :toolTip="toolTip" />
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
      tab: 0,
      cont5: 0,
      cont6: 0,
      cont7: 0,
      cont8: 0,
      cont9: 0
    };
  },
  computed: {
    ...mapGetters({
      items: "analytic/items"
    })
  },
  methods: {
    downloadExcel(date) {
      if (this.month)
        window.open(`/admin/users-cvs?year=${this.year}&month=${this.month}`);
      else
        window.open(`/admin/users-cvs?year=${this.year}`);
    },
    getData() {
      if (this.tab == 0) this.signup();
      else if (this.tab == 1) this.status();
    },
    signup() {
      this.datacollection = false;
      this.counts.cont1 = this.counts.cont2 = 0;

      const interval = this.month
        ? { year: this.year, month: this.month }
        : { year: this.year };

      this.$store.dispatch(this.store + "/getItems", interval).then(() => {
        let psyshics = [],
          users = [],
          item = null,
          labels = [],
          loop = this.month
            ? moment(`${this.year}-${this.month}`, "YYYY-M").daysInMonth()
            : 12;
        for (let i = 1; i <= loop; i++) {
          labels.push(i);

          item = this.items.models.filter(item => item.interval == i);

          if (item.length) {
            psyshics.push(item[0].total);
            this.counts.cont1 = this.counts.cont1 + item[0].total;
          } else psyshics.push(0);

          item = this.items.users.filter(item => item.interval == i);
          if (item.length) {
            users.push(item[0].total);
            this.counts.cont2 = this.counts.cont2 + item[0].total;
          } else users.push(0);
        }
        this.datacollection = {
          labels: this.month ? labels : this.months.map(item => item.text),
          datasets: [
            {
              label: "Models",
              backgroundColor: "#f87979",
              data: psyshics
            },
            {
              label: "Clients",
              backgroundColor: "#664577",
              data: users
            }
          ]
        };
      });
    },
    status() {
      this.datacollection2 = false;
      this.counts.cont1 = this.counts.cont2 = this.counts.cont3 = this.counts.cont4 = this.cont5 = this.cont6 = this.cont7 = this.cont8 = this.cont9 = 0;
      if (!this.year) {
        this.$store.dispatch(this.store + "/getUserStatus").then(() => {
          this.counts.cont1 = this.items.psychics_inactive;
          this.counts.cont2 = this.items.psychics_active;
          this.counts.cont3 = this.items.users_inactive;
          this.counts.cont4 = this.items.users_active;
          this.cont5 = this.items.psychic_hidden;
          this.cont6 = this.items.users_hidden;
          this.cont7 = this.items.psychics_fraud;
          this.cont8 = this.items.users_fraud;
          this.cont9 = this.items.test_account;
          const data = [
            this.items.psychics_inactive,
            this.items.psychics_active,
            this.items.users_inactive,
            this.items.users_active,
            this.items.psychic_hidden,
            this.items.users_hidden,
            this.items.psychics_fraud,
            this.items.users_fraud,
            this.items.test_account
          ];
          this.datacollection2 = {
            labels: [],
            datasets: [
              {
                label: "Models inactive",
                backgroundColor: "#f87979",
                data: [this.items.psychics_inactive]
              },
              {
                label: "Models active",
                backgroundColor: "#664577",
                data: [this.items.psychics_active]
              },
              {
                label: "Clients inactive",
                backgroundColor: "red",
                data: [this.items.users_inactive]
              },
              {
                label: "Clients active",
                backgroundColor: "#3A76D2",
                data: [this.items.users_active]
              },
              {
                label: "Models hidden",
                backgroundColor: "#009688",
                data: [this.items.psychic_hidden]
              },
              {
                label: "Clients hidden",
                backgroundColor: "#004D40",
                data: [this.items.users_hidden]
              },
              {
                label: "Models fraud",
                backgroundColor: "#FF9800",
                data: [this.items.psychics_fraud]
              },
              {
                label: "Clients fraud",
                backgroundColor: "#EF6C00",
                data: [this.items.users_fraud]
              },
              {
                label: "Test accounts",
                backgroundColor: "#4CAF50",
                data: [this.items.test_account]
              }
            ]
          };
        });
        return;
      }

      const interval = this.month
        ? { year: this.year, month: this.month }
        : { year: this.year };

      this.$store.dispatch(this.store + "/getUserStatus", interval).then(() => {
        let psychics_inactive = [],
          psychics_active = [],
          users_active = [],
          users_inactive = [],
          psychic_hidden = [],
          users_hidden = [],
          test_account = [],
          psychics_fraud = [],
          users_fraud = [],
          item = null,
          labels = [],
          loop = this.month
            ? moment(`${this.year}-${this.month}`, "YYYY-M").daysInMonth()
            : 12;
        for (let i = 1; i <= loop; i++) {
          labels.push(i);

          item = this.items.psychics_inactive.filter(
            item => item.interval == i
          );

          if (item.length) {
            psychics_inactive.push(item[0].total);
            this.counts.cont1 = this.counts.cont1 + item[0].total;
          } else psychics_inactive.push(0);

          item = this.items.psychics_active.filter(item => item.interval == i);
          if (item.length) {
            psychics_active.push(item[0].total);
            this.counts.cont2 = this.counts.cont2 + item[0].total;
          } else psychics_active.push(0);

          item = this.items.users_inactive.filter(item => item.interval == i);
          if (item.length) {
            users_inactive.push(item[0].total);
            this.counts.cont3 = this.counts.cont3 + item[0].total;
          } else users_inactive.push(0);

          item = this.items.users_active.filter(item => item.interval == i);
          if (item.length) {
            users_active.push(item[0].total);
            this.counts.cont4 = this.counts.cont4 + item[0].total;
          } else users_active.push(0);

          item = this.items.psychic_hidden.filter(item => item.interval == i);
          if (item.length) {
            psychic_hidden.push(item[0].total);
            this.cont5 = this.cont5 + item[0].total;
          } else psychic_hidden.push(0);

          item = this.items.users_hidden.filter(item => item.interval == i);
          if (item.length) {
            users_hidden.push(item[0].total);
            this.cont6 = this.cont6 + item[0].total;
          } else users_hidden.push(0);

          item = this.items.psychics_fraud.filter(item => item.interval == i);
          if (item.length) {
            psychics_fraud.push(item[0].total);
            this.cont7 = this.cont7 + item[0].total;
          } else psychics_fraud.push(0);

          item = this.items.users_fraud.filter(item => item.interval == i);
          if (item.length) {
            users_fraud.push(item[0].total);
            this.cont8 = this.cont8 + item[0].total;
          } else users_fraud.push(0);

          item = this.items.test_account.filter(item => item.interval == i);
          if (item.length) {
            test_account.push(item[0].total);
            this.cont9 = this.cont9 + item[0].total;
          } else test_account.push(0);
        }

        this.datacollection2 = {
          labels: this.month ? labels : this.months.map(item => item.text),
          datasets: [
            {
              label: "Models inactive",
              backgroundColor: "#f87979",
              data: psychics_inactive
            },
            {
              label: "Models active",
              backgroundColor: "#664577",
              data: psychics_active
            },
            {
              label: "Clients inactive",
              backgroundColor: "#3A76D2",
              data: users_inactive
            },
            {
              label: "Clients active",
              backgroundColor: "#B5E4E4",
              data: users_active
            },
            {
              label: "Models hidden",
              backgroundColor: "#009688",
              data: psychic_hidden
            },
            {
              label: "Clients hidden",
              backgroundColor: "#004D40",
              data: users_hidden
            },
            {
              label: "Models fraud",
              backgroundColor: "#FF9800",
              data: psychics_fraud
            },
            {
              label: "Clients fraud",
              backgroundColor: "#EF6C00",
              data: users_fraud
            },
            {
              label: "Test accounts",
              backgroundColor: "#4CAF50",
              data: test_account
            }
          ]
        };
      });
    }
  },
  watch: {
    menu(val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
    },
    month(val) {
      this.getData();
    },
    year(val) {
      if (this.month) this.month = null;
      else this.getData();
    },
    tab(val) {
      this.getData();
    }
  },
  created(){
    this.toolTip = {
      tooltips: {
        callbacks: {
          title: function(tooltipItem, data) {
            
            return '';
          }
        }
      }
    };
  }
};
</script>
