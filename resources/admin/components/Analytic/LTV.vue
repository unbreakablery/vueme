<template>
  <div>
    <v-card>
      <v-card-title class="subheading font-weight-bold">
        <v-row>
          <v-col>LTV</v-col>
          <v-col class="d-flex justify-end">
            <v-select
              style="max-width: 150px"
              :items="years"
              label="Year"
              v-model="year"
            ></v-select>
          </v-col>
        </v-row>
      </v-card-title>

      <v-divider></v-divider>

      <v-list-item-content dense>
        <v-list-item>
          <v-list-item-content>Paying Clients:</v-list-item-content>
          <v-list-item-content class="align-end">{{
            data.totalClient
          }}</v-list-item-content>
        </v-list-item>

        <v-list-item>
          <v-list-item-content>Number of Transactions:</v-list-item-content>
          <v-list-item-content class="align-end">{{
            data.transactions
          }}</v-list-item-content>
        </v-list-item>


        <v-list-item>
          <v-list-item-content>Gross Revenue:</v-list-item-content>
          <v-list-item-content class="align-end">{{
            data.grossRevenue || 0 | money
          }}</v-list-item-content>
        </v-list-item>

        
        <v-list-item>
          <v-list-item-content>Average Transaction Amount:</v-list-item-content>
          <v-list-item-content class="align-end">{{
            data.avgTransaction || 0 | money
          }}</v-list-item-content>
        </v-list-item>

        <v-list-item>
          <v-list-item-content>Average Customer Spent:</v-list-item-content>
          <v-list-item-content class="align-end">{{
            data.avgCustomerSpent || 0 | money
          }}</v-list-item-content>
        </v-list-item>
      </v-list-item-content>
    </v-card>
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";

export default {
  data() {
    return {
      loading: [],
      year: 2021,
      data: {},
    };
  },
  computed: {
    years() {
      let years = [];
      for (let i = 2019; i < moment().year() + 1; i++) years.push(i);
      return years;
    },
  },
  watch: {
    year: {
      handler: function (val) {
        axios
          .get("/api/admin/analytic/ltv?year=" + val)
          .then((response) => {
            console.log(response);
            this.data = response.data;
          })
          .catch(function (error) {})
          .finally(() => (this.loading = false));
      },
      immediate: true,
    },
  },
};
</script>
