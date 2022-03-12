<template>
  <div>
    <div class="row">
      <div class="col-12 col-md-4">
        <v-select
          v-model="category"
          :items="categories"
          label="Specialties"
          item-text="name"
          item-value="slug"
          :disabled="role != 1"
          clearable
          clear-icon="mdi-close"
        ></v-select>
      </div>
      <div class="col-12 col-md-4">
        <v-select
          :items="[
              {text: 'Paid', value: 'Paid'},
              {text: 'Pending', value: 'Pending'}]"
          label="Filter by status"
          v-model="status"
          attach
        ></v-select>
      </div>
      <div class="col-12 col-md-4 d-flex justify-end">
        <v-text-field
          style="max-width: 300px"
          v-model="search"
          prepend-icon="mdi-magnify"
          clearable
          clear-icon="mdi-close "
          label="Search"
          single-line
        ></v-text-field>
      </div>
    </div>

    <div id="scrollTarget" style="width: 100%; overflow-x: scroll">
      <div v-bind:style="{height: '1px', width: tableWidth}"></div>
    </div>
    <v-data-table
      id="user-list"
      v-show="paginate.data && !loading"
      :headers="header"
      :items="paginate.data"
      :options.sync="options"
      :server-items-length="paginate.meta.total"
      class="elevation-1"
      :items-per-page="perPage"
      :footer-props="{
       itemsPerPageOptions: [25, 10, 35, 50, 100, -1]
    }"
    >
      <template v-slot:header.current_balance="{ header }">
        {{ header.text }}
        <br />
        <span style="font-size: 11px">({{paginate.meta.pay_period}})</span>
      </template>
      <template v-slot:item="{item}" style="width: 50px">
        <tr>
          <td style="width: 100px">
            <v-avatar v-if="item" size="90">
              <img class="pa-2" v-bind:src="item.photo" alt="John" />
            </v-avatar>
            <div v-else class="pa-2">
              <v-avatar color="grey lighten-2" size="75">
                <v-icon size="50" dark>mdi-account-circle</v-icon>
              </v-avatar>
            </div>
          </td>
          <td>{{item.email}}</td>
          <td>
            <a v-bind:href="'/'+ item.link">{{item.display_name}}</a>
          </td>
          <td>{{item.full_name}}</td>
          <td>
            <v-menu :close-on-content-click="false" :nudge-width="200" max-width="300" offset-x>
              <template v-slot:activator="{ on }">
                <v-btn small color="primary" v-on="on" @click="getPaymentInfo(item,'see_payment_info')">
                  <v-icon size="20">mdi-currency-usd</v-icon>
                </v-btn>
              </template>

              <v-card>
                <v-list>
                  <v-list-item v-if="!loadingPayment && option_clicked == 'see_payment_info'">
                    <v-list-item-content v-if="Object.keys(paymentData).length > 0">
                      <v-list-item-title class="mb-1">
                        <b>Account Name:</b>
                        {{paymentData.account_name}}
                      </v-list-item-title>
                      <v-list-item-title class="mb-1">
                        <b>Account Number:</b>
                        {{paymentData.merchant[0]}}
                        <a
                          @click.stop="copy(paymentData.merchant[0])"
                          class="primary--text ml-2"
                        >copy</a>
                      </v-list-item-title>
                      <v-list-item-title class="mb-1">
                        <b>Routing Number:</b>
                        {{paymentData.merchant[1]}}
                        <a
                          @click.stop="copy(paymentData.merchant[1])"
                          class="primary--text ml-2"
                        >copy</a>
                      </v-list-item-title>
                      <v-list-item-title class="mb-1">
                        <b>Account Type:</b>
                        {{paymentData.account_type}}
                      </v-list-item-title>
                      <v-list-item-title class="mb-1">
                        <b>Country:</b>
                        {{paymentData.country}}
                      </v-list-item-title>
                    </v-list-item-content>

                    <v-list-item-content v-else-if="Object.keys(paymentDataPaypal).length > 0">
                      <v-list-item-title class="mb-1">
                        <b>Paypal Account</b>
                        <a
                          @click.stop="copy(paymentDataPaypal.account)"
                          class="primary--text ml-2"
                        >copy</a>
                      </v-list-item-title>
                      <v-list-item-title class="mb-1">{{paymentDataPaypal.account}}</v-list-item-title>
                    </v-list-item-content>

                    <v-list-item-content v-else>
                      <v-list-item-title>No payment info</v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </v-list>
                <v-skeleton-loader
                  v-if="loadingPayment"
                  type="list-item-three-line"
                  class="mx-auto"
                ></v-skeleton-loader>
              </v-card>
            </v-menu>
          </td>

          <td v-if="role == 1 || !role">
            <v-menu
              :close-on-content-click="false"
              :nudge-width="300"
              max-width="500"
              offset-x
              left
            >
              <template v-slot:activator="{ on }">
                <v-icon
                  v-on="on"
                  @click="getTransactionsPaidInfo(item,'Paid')"
                  medium
                  class="d-inline-block mb-1"
                >mdi-information</v-icon>
              </template>

              <v-card v-if="!loading" max-height="300" width="500">
                <h4 style="padding: 9px 10px;background-color: #e0e0e0;">Transactions Sent</h4>
                <v-simple-table>
                  <template v-slot:default>
                    <thead>
                      <tr style="background-color: #e0e0e0;">
                        <th class="text-left">Status</th>
                        <th class="text-left">Paid Day</th>
                        <th class="text-left">Paid Period</th>
                        <th class="text-left">Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="transaction in transactions_paid" :key="transaction.id">
                        <td>{{ transaction.status }}</td>
                        <td>{{ transaction.paid_day }}</td>
                        <td>{{transaction.start_period}} - {{transaction.end_period}} ({{transaction.count_periods}})</td>
                        <td>
                          ${{ transaction.amount | numFormat('0,0.00') }}
                          <v-menu
                            :close-on-content-click="false"
                            :nudge-width="300"
                            max-width="500"
                            offset-y
                          >
                            <template v-slot:activator="{ on }">
                              <v-icon
                                v-on="on"
                                @click="getPayoutsPaidInfo(transaction,'Paid',item)"
                                medium
                                class="d-inline-block mb-1"
                              >mdi-information</v-icon>
                            </template>

                            <v-card v-if="!loading">
                              <h4
                                style="padding: 9px 10px;background-color: #e0e0e0;"
                              >Payouts Completed</h4>
                              <v-simple-table>
                                <template v-slot:default>
                                  <thead>
                                    <tr style="background-color: #e0e0e0;">
                                      <th class="text-left">Start Period</th>
                                      <th class="text-left">End Period</th>
                                      <th class="text-left">Status</th>
                                      <th class="text-left">Amount</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr v-for="payout in payouts_pending" :key="payout.id">
                                      <td>{{ payout.start_period }}</td>
                                      <td>{{ payout.end_period }}</td>
                                      <td>{{ payout.status }}</td>
                                      <td>${{ payout.payout | numFormat('0,0.00') }}</td>
                                    </tr>
                                    <tr style="background-color: #e0e0e0;">
                                      <td></td>
                                      <td></td>
                                      <td class="text-right" style="font-weight: 800;">Total:</td>
                                      <td
                                        style="font-weight: 800;"
                                      >${{item_total_pending | numFormat('0,0.00')}}</td>
                                    </tr>
                                  </tbody>
                                </template>
                              </v-simple-table>
                              <v-skeleton-loader
                                v-if="loadingPayment"
                                type="list-item-three-line"
                                class="mx-auto"
                              ></v-skeleton-loader>
                            </v-card>
                            <v-skeleton-loader
                              v-if="!payouts_pending || loading"
                              type="table-tbody"
                              class="mx-auto"
                            ></v-skeleton-loader>
                          </v-menu>
                        </td>
                      </tr>
                      <tr style="background-color: #e0e0e0;">
                        <td></td>
                        <td></td>
                        <td class="text-right" style="font-weight: 800;">Total:</td>

                        <td
                          style="font-weight: 800;"
                        >${{transactions_paid_total_amount | numFormat('0,0.00')}}</td>
                      </tr>
                    </tbody>
                  </template>
                </v-simple-table>
                <v-skeleton-loader
                  v-if="loadingPayment"
                  type="list-item-three-line"
                  class="mx-auto"
                ></v-skeleton-loader>
              </v-card>
              <v-skeleton-loader
                v-if="!payouts_pending || loading"
                type="table-tbody"
                class="mx-auto"
              ></v-skeleton-loader>
            </v-menu>
            ${{item.payouts_paid | numFormat('0,0.00')}}
          </td>
          <td class="text-center" v-if="role == 1 || !role">${{item.current_balance}}</td>
          <td v-if="(role == 1 || !role) && status==='Pending'">
            <v-menu
              :close-on-content-click="false"
              :nudge-width="300"
              max-width="500"
              offset-x
              left
            >
              <template v-slot:activator="{ on }">
                <v-icon
                  v-on="on"
                  @click="getPayoutsPendingInfo(item)"
                  medium
                  class="d-inline-block mb-1"
                >mdi-information</v-icon>
              </template>

              <v-card v-if="!loading">
                <v-simple-table>
                  <template v-slot:default>
                    <thead>
                      <tr style="background-color: #e0e0e0;">
                        <th class="text-left">Start Period</th>
                        <th class="text-left">End Period</th>
                        <th class="text-left">Status</th>
                        <th class="text-left">Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="payout_pen in payouts_pending" :key="payout_pen.id">
                        <td>{{ payout_pen.start_period }}</td>
                        <td>{{ payout_pen.end_period }}</td>
                        <td>{{ payout_pen.status }}</td>
                        <td>${{ payout_pen.payout | numFormat('0,0.00') }}</td>
                      </tr>
                      <tr style="background-color: #e0e0e0;">
                        <td></td>
                        <td></td>
                        <td class="text-right" style="font-weight: 800;">Total:</td>
                        <td style="font-weight: 800;">${{item_total_pending | numFormat('0,0.00')}}</td>
                      </tr>
                    </tbody>
                  </template>
                </v-simple-table>
                <v-skeleton-loader
                  v-if="loadingPayment"
                  type="list-item-three-line"
                  class="mx-auto"
                ></v-skeleton-loader>
              </v-card>
              <v-skeleton-loader
                v-if="!payouts_pending || loading"
                type="table-tbody"
                class="mx-auto"
              ></v-skeleton-loader>
            </v-menu>

            <div v-if="item.payouts_pending.total_amount>=75" class="d-inline-block align-center">
              <label style="width: 65px">${{item.payouts_pending.total_amount}}</label>
              <v-btn
                small
                color="primary"
                :loading="loadingPayment && option_clicked =='see_payment_info_to_pay'"
                @click="getPaymentInfo(item,'see_payment_info_to_pay')"
              >Pay</v-btn>
            </div>
            <div v-else class="d-inline-block align-center">
              <label style="width: 65px">Error</label>
            </div>
          </td>
        </tr>
      </template>
    </v-data-table>

    <v-dialog v-model="dialog_confirm_payment" v-if="option_clicked == 'see_payment_info_to_pay'" scrollable max-width="450px">
      <v-card class="px-4 text-center">
       
        <v-card  class="elevation-0 px-5" >
                <v-list>
                  <v-list-item>
                    <v-list-item-content v-if="Object.keys(paymentData).length > 0">
                       <h3 class="my-5 h2 d-inline">
                      Sending payout to Banking Account. Are you sure?       
                      </h3>
                      <v-list-item-title class="mb-1">
                        <b>Account Name:</b>
                        {{paymentData.account_name}}
                      </v-list-item-title>
                      <v-list-item-title class="mb-1">
                        <b>Account Number:</b>
                        {{paymentData.merchant[0]}}                       
                      </v-list-item-title>
                      <v-list-item-title class="mb-1">
                        <b>Routing Number:</b>
                        {{paymentData.merchant[1]}}                       
                      </v-list-item-title>
                      <v-list-item-title class="mb-1">
                        <b>Account Type:</b>
                        {{paymentData.account_type}}
                      </v-list-item-title>
                      <v-list-item-title class="mb-1">
                        <b>Country:</b>
                        {{paymentData.country}}
                      </v-list-item-title>
                    </v-list-item-content>

                    <v-list-item-content v-else-if="Object.keys(paymentDataPaypal).length > 0">
                       <h3 class="my-5 h2 d-inline">
                      Did you already send payout to Paypal account?       
                      </h3>
                      <v-list-item-title class="mb-1">
                        <b>Paypal Account</b>
                        <a
                          @click.stop="copy(paymentDataPaypal.account)"
                          class="primary--text ml-2"
                        >copy</a>
                      </v-list-item-title>
                      <v-list-item-title class="mb-1">{{paymentDataPaypal.account}}</v-list-item-title>
                    </v-list-item-content>

                    <v-list-item-content v-else>
                      <v-list-item-title>No payment info</v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </v-list>
               
              </v-card>  

        <div class="text-center">
          <v-progress-circular v-if="loadingPayment && option_clicked == 'sending_pay'" :size="40" color="purple" indeterminate></v-progress-circular>
        </div>

        <div class="text-center mb-8">
          <v-btn
            type="button"
            color="primary"
            :disabled="loadingPayment || (Object.keys(this.paymentData).length == 0 && Object.keys(this.paymentDataPaypal).length == 0)"
            @click="payoutInit('sending_pay')"
            class="btn btn-primary"
          >OK</v-btn>
          <v-btn
            type="button"
            :disabled="loadingPayment"
            @click="dialog_confirm_payment = false,option_clicked = ''"
            class="btn btn-primary"
          >Cancel</v-btn>
        </div>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import moment from "moment";
import axios from "axios";
import { objectToGetParameters } from "../../util";


export default {
  data() {
    return {
      category: null,
      role: 1,
      store: "payout",
      options: {},
      search: null,
      onSearch: false,
      sort: false,
      sortDesc: false,
      tableWidth: 0,
      loadingPayment: false,
      paymentData: {},
      paymentDataPaypal: {},
      payouts_pending: [],
      item_total_pending: 0,
      dialog_confirm_payment: false,
      item_selected: {},
      status: "Pending",
      transactions_paid: [],
      transactions_paid_total_amount: 0,
      option_clicked:''
    };
  },
  props: {
    editItem: {
      type: Function,
      required: true
    },
    deleteItem: {
      type: Function,
      required: true
    }
  },
  methods: {
    copy(str) {
      const el = document.createElement("textarea");
      el.value = str;
      document.body.appendChild(el);
      el.select();
      document.execCommand("copy");
      document.body.removeChild(el);
    },
    completePayout(payout) {
      alert(payout);
    },
    
    payoutInit(option) {
      //item.sending = 'purple';

      if(Object.keys(this.paymentData).length > 0 || Object.keys(this.paymentDataPaypal).length > 0){

         this.option_clicked = option;
      this.item_selected.sending = true;
      this.loadingPayment = true;
      
      this.$store
        .dispatch(this.store + "/payoutInitEmail", {
          id: this.item_selected.id,
          billing: Object.keys(this.paymentData).length > 0 ? this.paymentData.id : 'PAYPAL' 
        })
        .then(() => {
          this.loadingPayment = false;
          //this.$store.dispatch(this.store + "/page", 1);
          this.$store.dispatch(this.store + "/getItems", this.getQueryParam());
          this.dialog_confirm_payment = false;
          this.item_selected.sending = false;
        });
      }
     
    },
    onScroll(e) {
      document.getElementsByClassName("v-data-table__wrapper")[0].scrollLeft =
        e.currentTarget.scrollLeft;
    },
    onScroll2(e) {
      document.getElementById("scrollTarget").scrollLeft =
        e.currentTarget.scrollLeft;
    },
    getQueryParam() {
      return {
        role: this.role,
        category: this.category,
        search: this.search,
        sort: this.sort,
        sortDesc: this.sortDesc,
        status: this.status
      };
    },
    getPaymentInfo(item,option_c) {

      this.paymentData = {};
      this.paymentDataPaypal = {};
      this.loadingPayment = true;
      this.item_selected = item;
      this.option_clicked = option_c;
     
      axios
        .get("/api/admin/paymentinfo?id=" + item.id)
        .then(response => {
          this.paymentData = {};
          this.paymentDataPaypal = {};
          
         
          if (
            Object.keys(response.data).length > 0 &&
            response.data.type === "DEPOSIT"
          ) {
            this.paymentData = response.data;
          }
          if (
            Object.keys(response.data).length > 0 &&
            response.data.type === "PAYPAL"
          ) {
            this.paymentDataPaypal = response.data;
          }

          this.loadingPayment = false;
          this.dialog_confirm_payment = true;
        })
        .catch(function(error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
    },
    getPayoutsPendingInfo(item) {
      this.payouts_pending = [];
      this.loadingPayment = true;
      axios
        .get("/api/admin/payoutpending?id=" + item.id)
        .then(response => {
          this.payouts_pending = response.data.data;
          this.item_total_pending = item.payouts_pending.total_amount;
          this.loadingPayment = false;
        })
        .catch(function(error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
    },
    getTransactionsPaidInfo(item, status) {
      this.payouts_pending = [];
      this.loadingPayment = true;
      axios
        .get(
          "/api/admin/psychic/transactions?id=" + item.id + "&status=" + status
        )
        .then(response => {
          this.transactions_paid = response.data.data;
          this.transactions_paid_total_amount = 0;

          for (let obj of this.transactions_paid) {
            this.transactions_paid_total_amount += obj.amount;
          }
          this.loadingPayment = false;
        })
        .catch(function(error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
    },
    getPayoutsPaidInfo(item, status, user_selected) {

      this.payouts_pending = [];
      this.loadingPayment = true;
      axios
        .get(
          "/api/admin/psychic/payoutsinfo?transaction=" +
            item.id +
            "&status=" +
            status +
            "&user=" +
            user_selected.id
        )
        .then(response => {
          this.payouts_pending = response.data.data;
          this.item_total_pending = 0;
          for (let obj of this.payouts_pending) {
            this.item_total_pending += obj.payout;
          }

          this.loadingPayment = false;
        })
        .catch(function(error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
        });
    }
  },
  filters: {
    formatDate(date) {
      return moment(date).format("MM/DD/YYYY");
    }
  },
  computed: {
    ...mapGetters({
      page: "payout/page",
      perPage: "payout/per_page",
      paginate: "payout/items",
      loading: "payout/loading",
      categories: "category/items",
      user: "payout/view"
    }),
    header: function() {
      if ((this.role == 1 || !this.role) && this.status === "Pending") {
        return [
          { text: "", align: "left", value: "imagen", sortable: false },
          { text: "Email", align: "left", value: "email" },
          { text: "Username", align: "left", value: "display_name" },
          { text: "Full name", align: "left", value: "full_name" },
          { text: "Payment Info", align: "left" },
          { text: "Paid", align: "left", value: "paid" },
          {
            text: "Current balance",
            align: "center",
            value: "current_balance"
          },
          { text: "Payout Pending", align: "left", value: "earning" }
        ];
      }
      if ((this.role == 1 || !this.role) && this.status === "Paid") {
        return [
          { text: "", align: "left", value: "imagen", sortable: false },
          { text: "Email", align: "left", value: "email" },
          { text: "Username", align: "left", value: "display_name" },
          { text: "Full name", align: "left", value: "full_name" },
          { text: "Payment Info", align: "left" },
          { text: "Paid", align: "left", value: "paid" },
          { text: "Current balance", align: "center", value: "current_balance" }
        ];
      }
      return [
        { text: "Email", align: "left", value: "email" },
        { text: "Username", align: "left", value: "display_name" },
        { text: "", align: "left", value: "imagen", sortable: false },
        { text: "Username", align: "left", value: "display_name" },
        { text: "Full name", align: "left", value: "full_name" },
        { text: "Payment Info", align: "left", value: "checking" }
      ];
    }
  },
  watch: {
    category() {
      this.$store.dispatch(this.store + "/page", 1);
      this.$store.dispatch(this.store + "/getItems", this.getQueryParam());
    },
    status() {
      this.$store.dispatch(this.store + "/page", 1);
      this.$store.dispatch(this.store + "/getItems", this.getQueryParam());
    },

    role() {
      this.category = null;
      this.$store.dispatch(this.store + "/page", 1);
      this.$store.dispatch(this.store + "/getItems", this.getQueryParam());
    },
    loading(val) {
      this.$store.dispatch("util/setLoading", val);
    },

    search(val) {
      if (!val) {
        this.onSearch = false;
        this.$store.dispatch(this.store + "/page", 1);
        this.$store.dispatch(this.store + "/getItems", this.getQueryParam());
      }
      if (!this.onSearch) {
        this.$store.dispatch(this.store + "/page", 1);
        this.onSearch = true;
      }
      if (this.loading) return;

      clearTimeout(this.timeout);

      // Make a new timeout set to go off in 1000ms to wait stop write
      this.timeout = setTimeout(() => {
        if (val.length < 3) {
          return;
        }

        this.$store.dispatch(this.store + "/getItems", this.getQueryParam());
      }, 1000);
    },
    options: {
      handler() {
        let reload = false;

        const { sortBy, sortDesc, page, itemsPerPage } = this.options;

        if (sortBy.length === 1 && sortDesc.length === 1) {
          if (this.sort != sortBy[0] || this.sortDesc != sortDesc[0]) {
            this.sort = sortBy[0];
            this.sortDesc = sortDesc[0];
            reload = true;
            this.$store.dispatch(this.store + "/page", 1);
          }
        } else if (this.sort) {
          this.sort = this.sortDesc = false;
          reload = true;
          this.$store.dispatch(this.store + "/page", 1);
        }

        if (this.page != page) {
          reload = true;
          this.$store.dispatch(this.store + "/page", this.options.page);
        }
        if (this.perPage != itemsPerPage) {
          reload = true;
          this.$store.dispatch(
            this.store + "/perPage",
            itemsPerPage == -1 ? this.paginate.meta.total : itemsPerPage
          );
        }
        if (reload)
          this.$store.dispatch(this.store + "/getItems", this.getQueryParam());
      },
      deep: true
    }
  },
  created() {
    if (!this.categories.length) this.$store.dispatch("category/getItems");

    if (!this.paginate.data || !this.paginate.data.length) {
      this.options = { sortBy: ["earning"], sortDesc: [true] };
    }
  },
  destroyed() {
    document
      .getElementById("scrollTarget")
      .removeEventListener("scroll", this.onScroll);
    document
      .getElementsByClassName("v-data-table__wrapper")[0]
      .removeEventListener("scroll", this.onScroll2);
  },
  mounted() {
    document
      .getElementById("scrollTarget")
      .addEventListener("scroll", this.onScroll);
    document
      .getElementsByClassName("v-data-table__wrapper")[0]
      .addEventListener("scroll", this.onScroll2);
  }
};
</script>

<style scope>
th {
  white-space: nowrap;
}
.v-progress-circular {
  margin-bottom: 10px;
}
</style>
