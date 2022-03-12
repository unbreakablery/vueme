<template>
  <div>
    <v-card-title>
      <div class="d-inline">
        <v-radio-group v-model="type" row>
          <v-radio label="CC Completed" value="completed"></v-radio>
          <v-radio label="CC Failed" value="failed"></v-radio>
        </v-radio-group>
      </div>
      <div class="flex-grow-1"></div>
      <v-text-field
        style="max-width: 300px"
        v-model="search"
        prepend-icon="mdi-magnify"
        clearable
        clear-icon="mdi-close "
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>

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
            <v-avatar v-if="item.photo" size="90">
              <img class="pa-2" v-bind:src="item.photo" alt="John" />
            </v-avatar>
            <div v-else class="pa-2">
              <v-avatar color="grey lighten-2" size="75">
                <v-icon size="50" dark>mdi-account-circle</v-icon>
              </v-avatar>
            </div>
          </td>
          <td>
            <a v-bind:href="'/'+ item.link">{{item.display_name}}</a>
          </td>
          <td>
            {{item.user_id}}
          </td>
          <td>{{item.email}}</td>          
          <td>{{item.amount | money}}</td>
          <td>
            {{item.date | formatDate}}
          </td>
          <td v-if="type == 'failed'">
            {{item.result_text}}
          </td>
        </tr>
      </template>
    </v-data-table>

    <v-skeleton-loader v-if="!paginate.data || loading" type="table-tbody" class="mx-auto"></v-skeleton-loader>

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
      // user: {},
      // transactions: [],
      // category: null,
      type: 'completed',
      role: 2,
      store: "transaction",
      options: {},
      search: null,
      onSearch: false,
      sort: false,
      sortDesc: false,
      tableWidth: 0,
      loadingTransaction: true,
      paymentData: {},      
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
    // transactionDetail(user) {
    //   this.user = user;
    //   this.loadingTransaction = true;
    //   axios
    //     .get("/api/admin/transaction-detail/" + user.id)
    //     .then(response => {
    //       // console.log(response);
    //       this.transactions = response.data;
    //     })
    //     .catch(function(error) {
    //       console.log(error);
    //     });
    // },
    copy(str) {
      const el = document.createElement("textarea");
      el.value = str;
      document.body.appendChild(el);
      el.select();
      document.execCommand("copy");
      document.body.removeChild(el);
    },
    completePayout(transaction) {
      alert(transaction);
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
        // role: this.role,
        // category: this.category,
        type: this.type,
        search: this.search,
        sort: this.sort,
        sortDesc: this.sortDesc
      };
    }
  },
  filters: {
    formatDate(date) {
      return moment(date).format("MM/DD/YYYY");
    }
  },
  computed: {
    ...mapGetters({
      page: "transaction/page",
      perPage: "transaction/per_page",
      paginate: "transaction/items",
      loading: "transaction/loading",
      // categories: "category/items"
    }),
    header: function(){
      let header = [
        { text: "", align: "left", value: "imagen", sortable: false },
        { text: "Full name", align: "left", value: "name" },
        { text: "Id", align: "left", value: "id" },
        { text: "Email", align: "left", value: "email" },
        { text: "Amount", align: "left", value: "amount" },
        { text: "Date", align: "left", value: "date" },
      ];
      if(this.type == 'failed')
       header.push({ text: "Failed text", align: "left", value: "result_text" });

       return header;
    },
  },
  watch: {
    // dialog(val){
    //   if(!val){
    //     this.user = {},
    //     this.transactions = [];
    //   }
    // },
    // category() {
    //   this.$store.dispatch(this.store + "/page", 1);
    //   this.$store.dispatch(this.store + "/getItems", this.getQueryParam());
    // },
    // role() {
    //   this.category = null;
    //   this.$store.dispatch(this.store + "/page", 1);
    //   this.$store.dispatch(this.store + "/getItems", this.getQueryParam());
    // },
    type() {
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
        // if (val.length < 3) {
        //   return;
        // }

        this.$store.dispatch(this.store + "/getItems", this.getQueryParam());
      }, 2000);
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
     this.$store.dispatch(this.store + "/page", 1);

    if (!this.paginate.data || !this.paginate.data.length) {
      // this.options = { sortBy: ["transactions"], sortDesc: [true] };
      this.$store.dispatch(this.store + "/getItems", this.getQueryParam());
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

<style>
th {
  white-space: nowrap;
}
</style>
