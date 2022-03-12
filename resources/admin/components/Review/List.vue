<template>
  <div>
    <v-card-title>
      <div>
        <v-row>
          <v-col>
        <v-select
          v-model="filter"
          :items="['All', 'Approved', 'Removed', 'Pending']"
          label="Filter"
          item-text="name"
          item-value="slug"
        ></v-select></v-col>
          <v-col class="px-0 ml-5">
        <v-text-field
          style="max-width: 400px"
          v-model="search"
          prepend-icon="mdi-magnify"
          clearable
          clear-icon="mdi-close "
          label="Search"
          single-line
        ></v-text-field>
        </v-col>
        <v-col>
        <v-select style="max-width: 150px"
          v-model="searchOn"
          :items="['Model', 'Client']"
          label="Search by"
        ></v-select>
        </v-col>
        </v-row>
      </div>
    </v-card-title>

    <div id="scrollTarget" style="width: 100%; overflow-x: scroll">
      <div v-bind:style="{height: '1px', width: tableWidth}"></div>
    </div>
    <v-data-table :key="renderTable"
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
      <template v-slot:item="{item}" style="width: 50px">
        <tr>
          <td>{{item.created_at | formatDate}}</td>
          <td>
            <a v-bind:href="'/' + item.psychic_link">{{item.psychic_display_name}}</a>
          </td>
          <td>
            <a v-bind:href="'/' + item.user_link">{{item.user_display_name}}</a>
          </td>
          <td>
            <v-rating
              class="d-inline starBtn"
              :value="parseFloat(item.rating)"
              color="amber"
              dense
              half-increments
              readonly
              size="17"
              
            ></v-rating>
          </td>
          <td>{{item.title}}</td>
          <td v-html="item.text"></td>
          <td v-if="role == 1 || !role">
            <v-switch
             :disabled="item.status == 'Removed'"
              v-model="item.status"
              @change="approving(item)"
              class="d-inline-block"
              :loading="item.loading"
              false-value="Pending"
              true-value="Posted"
            ></v-switch>
          </td>
          <td style="max-width: 30px">
            <v-checkbox
              v-model="item.status"
              @change="approving(item)"
              false-value
              true-value="Removed"
            ></v-checkbox>
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
      role: 1,
      store: "review",
      options: {},
      sort: false,
      sortDesc: false,
      tableWidth: 0,
      loadingPayment: true,
      paymentData: {},
      renderTable: true,
      filter: 'All',
      search: null,
      onSearch: false,
      searchOn: 'Model'
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
    approving(item) {
      item.loading = "purple";
      this.$store.dispatch(this.store + "/update", [item].map(item => { 
        let query = this.getQueryParam();
        query.id = item.id; 
        query.status = item.status;
        return query })[0]).then(() => {
        item.loading = false;
        this.renderTable = !this.renderTable;
      });
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
      let param = {
        filter: this.filter,
        sort: this.sort,
        sortDesc: this.sortDesc,
        search: this.search,
      };
      if(this.search)
       param.searchOn = this.searchOn;

       return param;
    },
  },
  filters: {
    formatDate(date) {
      return moment(date).format("MM/DD/YYYY");
    }
  },
  computed: {
    ...mapGetters({
      page: "review/page",
      perPage: "review/per_page",
      paginate: "review/items",
      loading: "review/loading",
      user: "review/view"
    }),
    header: function() {
      return [
        { text: "Created", align: "left", value: "create_at" },
        { text: "Model", align: "left", value: "psychic", sortable: false },
        { text: "Client", align: "left", value: "user", sortable: false },
        { text: "rating", align: "left", value: "rating", sortable: false },
        { text: "title", align: "left", value: "title", sortable: false },
        { text: "text", align: "left", value: "text", sortable: false },
        { text: "Publish", align: "left", value: "status", sortable: false },
        { text: "Disapproved", align: "left", value: "status", sortable: false }
      ];
    }
  },
  watch: {
    filter() {
      this.$store.dispatch(this.store + "/page", 1);
      this.$store.dispatch(this.store + "/getItems", this.getQueryParam());
    },
    searchOn() {
      if(!this.search) return;
      this.$store.dispatch(this.store + "/page", 1);
      this.$store.dispatch(this.store + "/getItems", this.getQueryParam());
    },
    search(val) {
      if (!val) {
        this.onSearch = false;
        this.$store.dispatch(this.store + "/page", 1);
        this.$store.dispatch(this.store + "/getItems", this.getQueryParam());
        return;
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
    loading(val) {
      this.$store.dispatch("util/setLoading", val);
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
          this.$store
            .dispatch(this.store + "/getItems", this.getQueryParam());
      },
      deep: true
    }
  },
  created() {
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

<style>
th {
  white-space: nowrap;
}
</style>
