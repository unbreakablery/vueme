<template>
  <div>
    <div style="padding: 0px 16px 8px">
      <UsersAnalytic v-if="section == 'users'" :key="section" /> 
      <ServicesAnalytic v-else-if="section == 'services'" :key="section" />
      <TransactionAnalytic v-else-if="section == 'transactions'" :key="section" />
      <LTV v-else-if="section == 'ltv'" :key="section" />
      <PayoutsAnalytic v-else :key="section" />
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import UsersAnalytic from "../components/Analytic/Users";
import ServicesAnalytic from "../components/Analytic/Services";
import PayoutsAnalytic from "../components/Analytic/Payout";
import TransactionAnalytic from "../components/Analytic/Transaction";
import LTV from "../components/Analytic/LTV";

export default {
  data() {
    return {
      section: null
    };
  },
  components: {
    UsersAnalytic,
    ServicesAnalytic,
    PayoutsAnalytic,
    TransactionAnalytic,
    LTV
  },
  watch: {
    "$route.params.section"(val) {
      this.section = val;
    }
  },
  created() {
    this.section = this.$route.params.section;
  }
};
</script>
