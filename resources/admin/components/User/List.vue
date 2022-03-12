<template>
  <div>
      <v-dialog
        v-if="licenseDialog"
        v-model="licenseDialog"
        width="375"
      >
        <v-card style="background:#fff !important;border-radius:5px!important">
          <v-card-text class="p-0">
            <div class="row m-0">
                          <div class="mt-2" style="font-size:18px;color:#131220;font-weight: 600; text-align: center;width:100%;">
              License Info
            </div>
               <!--<div class="col-12 text-right pr-6">
                <v-icon class="text-right" @click="licenseDialog=false">mdi-close</v-icon>
              </div>-->
               <div class="col-12 px-3">
                <div class="card-body px-0 pt-4" v-if="licenseItem != []">
                    <div v-for="(value,name) in licenseItem" :key="value">{{name}}:{{value}}</div>
                </div>
              </div>
            </div>
          </v-card-text>
        </v-card>
      </v-dialog>
    <v-card-title>
      <div class="d-inline">
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
      <v-radio-group v-model="role" row>
        <v-radio
          class="text-capitalize"
          v-for="role in roles.concat([{id: false, name: 'All'}])"
          :key="role.id"
          :label="role.name == 'user' ? 'Client' : role.name"
          :value="role.id"
        ></v-radio>
      </v-radio-group>
      <v-btn icon :disabled="!role || role == 3" @click="downloadExcel">
        <v-icon color="purple" large class="cursor-pointer">mdi-file-excel</v-icon>
      </v-btn>
      
      <div class="flex-grow-1"></div>
      <v-text-field
        style="max-width: 100px"
        v-model="id"
        prepend-icon="mdi-magnify"
        clearable
        clear-icon="mdi-close "
        label="Id"
        single-line
        hide-details
      ></v-text-field>
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
      must-sort
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
            <span v-if="item.device">{{item.device.ip}}</span>
          </td>
          <td style="white-space: nowrap;">
            <a v-if="role == 1" v-bind:href="'/'+item.profile_link">{{item.display_name}}</a>
            <a v-else-if="role == 2" @click="finance(item)" href="#">{{item.display_name}}</a>
            <a v-else>{{item.display_name}}</a>
            <v-btn v-if="$can('edit', 'all')" icon @click="finance(item)">
              <v-icon color="purple">mdi-finance</v-icon>
            </v-btn>
          </td>
          <td>{{item.id}}</td>
          <td>{{item.full_name}}</td>
          <td>{{item.email}}</td>
          <td>
            {{item.phone_numbers.prefix? '(+'+item.phone_numbers.prefix+')':''}} {{item.phone_numbers.number}}
            <v-btn v-if="!item.phone_numbers.validated" x-small color="warning" @click="validatePhone(item.phone_numbers)">validate</v-btn>
            <!-- <v-btn v-else x-small color="success" @click="validatePhone(item.phone_numbers)">invalidate</v-btn> -->
          </td>
          <td>{{item.created_at | formatDate}}</td>
          <td v-if="role == 2 || !role">
            <div v-if="$can('edit', 'all')" style="white-space: nowrap;">
              <span>{{ item.credit | money}}</span>
              <v-icon color="teal" @click="showEditCredit(item)">mdi-pencil</v-icon>
            </div>
            <span v-else>----</span>
          </td>
          <td>
            <v-progress-circular
              :rotate="360"
              :size="50"
              :width="8"
              :value="item.profile_percent"
              color="purple"
            >{{item.profile_percent}}%</v-progress-circular>
          </td>
          <td style="max-width: 30px">
            <v-checkbox
              v-model="item.featured"
              @change="setFeaturedUser(item)"
              :disabled="!$can('edit', 'all')"
            ></v-checkbox>
          </td>
          <td style="max-width: 30px">
            <v-checkbox
              v-model="item.email_validated"
              @change="setActiveUser(item)"
              :disabled="!$can('edit', 'all')"
            ></v-checkbox>
          </td>
          <td style="max-width: 30px">
            <v-checkbox
              v-model="item.fraud"
              :disabled="!$can('edit', 'all') || item.email_validated == 1"
              @change="setFraudUser(item)"
            ></v-checkbox>
          </td>
          <td style="max-width: 30px">
            <v-checkbox
              v-model="item.account_status"
              @change="setAccountStatus(item)"
              :disabled="!$can('edit', 'all')"
              false-value="ACTIVE"
              true-value="INACTIVE"
            ></v-checkbox>
          </td>
          <td style="max-width: 30px">
            <v-checkbox
              v-model="item.test_user"
              @change="setTestAccount(item)"
              :disabled="!$can('edit', 'all')"
            ></v-checkbox>
          </td>
          <td style="max-width: 30px">
           {{ item.role_id==1 ? item.licence_checked ? "Yes" : "No" : "-"}}
           <v-btn color="teal" @click="licenseItem=item.license_info;licenseDialog=true" v-if="item.licence_checked">View</v-btn>
          </td>
          <td style="max-width: 100px">
            <div class="d-flex">

            <v-icon class="float-right mx-2" color="teal" @click="editItem(item)">mdi-pencil</v-icon>

              <v-icon class="float-right" v-if="item.delete"
             color="red"
             @click="deleteItem(item)">
             mdi-delete</v-icon>
            </div>
          </td>
        </tr>
      </template>
    </v-data-table>

    <v-skeleton-loader v-if="!paginate.data || loading" type="table-tbody" class="mx-auto"></v-skeleton-loader>

    <v-dialog v-model="dialogFinance" fullscreen hide-overlay transition="dialog-bottom-transition">
      <v-card class="pa-5">
        <v-row class="mb-3">
          <v-col cols="12">
            <v-btn icon @click="dialogFinance = false" class="float-right">
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-col>
        </v-row>
        <div v-if="financePsychic">
          <PsychicCreditLogs
            :transactions="transactions"
            :name="financeName"
            :role="financeName"
            :finace-data="financePsychic"
            @retract="onRetract"
            :key="refresh"
          />
          <PsychicPayoutLogs v-if="payouts" :transactions="payouts" :name="financeName" />
        </div>
        <UserCreditLogs
          v-else
          :transactions="transactions"
          :name="financeName"
          :user="selectedUser"
          @refund="onRetract"
          :key="refresh"
        />
      </v-card>
    </v-dialog>

    <v-dialog v-model="editCreditDialog" width="400">
      <v-card style="overflow: hidden">
        <v-btn icon @click="editCreditDialog = false" class="float-right">
          <v-icon>mdi-close</v-icon>
        </v-btn>
        <v-row>
          <v-col cols="12" class="d-flex justify-center">
            <v-text-field
              type="number"
              style="max-width: 100px"
              v-model="credit"
              placeholder="Enter credit"
              hide-details
            ></v-text-field>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" class="d-flex justify-center">
            <v-radio-group v-model="addingCredit" row class="mt-0" hide-details>
              <v-radio label="Adding" :value="true"></v-radio>
              <v-radio label="Removing" v-show="item && parseFloat(item.credit)" :value="false"></v-radio>
            </v-radio-group>
          </v-col>
        </v-row>

        <v-row v-show="addingCredit !== null && newCredit">
          <v-col v-if="item" cols="12" class="d-flex justify-center">Current Credit Balance ${{item.credit}}</v-col>
          <v-col cols="12" class="d-flex justify-center">New Credit Balance ${{newCredit}}</v-col>
        </v-row>

        <v-row v-show="addingCredit !== null && newCredit" class="mb-3">
          <v-col cols="12" class="d-flex justify-center">
            <v-btn small @click="editCreditDialog = false" class="mr-3">Cancel</v-btn>
            <v-btn small color="primary" @click="save()">Confirm</v-btn>
          </v-col>
        </v-row>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import moment from "moment";
import { objectToGetParameters } from "../../util";
import axios from "axios";
import PsychicCreditLogs from "../Transaction/PsychicCreditLogs";
import UserCreditLogs from "../Transaction/UserCreditLogs";
import PsychicPayoutLogs from "../Payout/PayoutHistory";

export default {
  components: {
    PsychicCreditLogs,
    UserCreditLogs,
    PsychicPayoutLogs
  },
  data() {
    return {
      licenseDialog:false,
      licenseItem:[],
      countryCode: [],
      category: null,
      role: 1,
      store: "user",
      options: { sortBy: ["created_at"], sortDesc: [true] },
      search: null,
      onSearch: false,
      sort: false,
      sortDesc: false,
      tableWidth: 0,
      id: null,
      dialogFinance: false,
      transactions: [],
      payouts: [],
      financePsychic: false,
      financeName: false,
      selectedUser: {},
      item: null,
      editCreditDialog: null,
      credit: null,
      addingCredit: null,
      newCredit: null,
      loadingCredit: null,
      refresh: false
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
    validatePhone(phone){
      const message = `Are you sure you want ${phone.validated ? 'invalidate' : 'validate'} the phone number?`;
      if (confirm(message)) {
        axios.post('/api/v1/user/verify/phone/validate/'+phone.id)
          .then(response => {    
            phone.validated = !phone.validated;
            alert('The user can now login into the system.')
            });
      }
    },
    showEditCredit(item) {
      this.item = Object.assign({}, item);
    
     if(parseFloat(item.credit) == 0)
        this.addingCredit = true;

      this.editCreditDialog = true;
    },
    onRetract() {
      this.finance(this.selectedUser);
    },
    finance(user) {
      this.transactions = [];
      this.payouts = [];
      this.financeName = null;
      axios
        .get("/api/admin/transaction?user=" + user.id)
        .then(response => {
          this.refresh = !this.refresh;
          this.financeName =
            user.role_id == 2 ? user.full_name : user.display_name;
          this.transactions = response.data.data;
          this.financePsychic = response.data.meta.psychic;
          if (this.financePsychic && response.data.meta.payout) {
            this.payouts = response.data.meta.payout;
          }
          this.selectedUser = user;
          this.dialogFinance = true;
          
        })
        .catch(function(error) {
          if (
            error.response &&
            (error.response.status === 401 || error.response.status === 419)
          ) {
            location.reload();
          }
          console.log(error);
        });
    },
    savePhone(phone) {
      this.$store.dispatch(
        "user/update",
        {
          phone: phone.id,
          code2: phone.code2,
          number: phone.number,
          noLoading: true
        },
        false
      );
    },
    validNumbers(event) {
      return !(
        (event.keyCode < 48 ||
          (event.keyCode > 57 && event.keyCode < 96) ||
          event.keyCode > 105) &&
        event.keyCode != 8 &&
        event.keyCode != 46 &&
        event.keyCode != 37 &&
        event.keyCode != 39 &&
        event.keyCode != 13
      )
        ? true
        : false;
    },
    save() {
      this.loadingCredit = true;
      this.$store
        .dispatch(
          "user/update",
          {
            id: this.item.id,
            credits: parseFloat(this.newCredit),
            noLoading: true
          },
          false
        )
        .then(() => {
          let item = this.paginate.data.filter(i => i.id == this.item.id)[0];
          item.credit = this.newCredit;
          this.editCreditDialog = false;
          this.loadingCredit = false;
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
    downloadExcel() {
      window.open(
        "/admin/users-cvs?" + objectToGetParameters(this.getQueryParam())
      );
    },
    getQueryParam() {
      return {
        role: this.role,
        category: this.category,
        search: this.search,
        sort: this.sort,
        sortDesc: this.sortDesc,
        id: this.id
      };
    },
    setFeaturedUser(item) {
      this.$store.dispatch(this.store + "/update", {
        id: item.id,
        featured: item.featured,
        noLoading: true
      });
    },
    setActiveUser(item) {
      if (item.email_validated && item.fraud) item.fraud = 0;
      this.$store.dispatch(this.store + "/update", {
        id: item.id,
        email_validated: item.email_validated,
        fraud: 0,
        noLoading: true
      });
    },
    setFraudUser(item) {
      this.$store.dispatch(this.store + "/update", {
        id: item.id,
        fraud: item.fraud,
        noLoading: true
      });
    },
    setAccountStatus(item) {
      this.$store.dispatch(this.store + "/update", {
        id: item.id,
        account_status: item.account_status,
        noLoading: true
      });
    },
    setTestAccount(item) {
      this.$store.dispatch(this.store + "/update", {
        id: item.id,
        test_user: item.test_user,
        noLoading: true
      });
    },
    updateScroll() {
      let elmnt = document.getElementsByTagName("table");
      this.tableWidth = elmnt[0].offsetWidth + "px";
      
      this.removeScroll();
      this.setScroll();
    },
    setScroll() {
      document
        .getElementById("scrollTarget")
        .addEventListener("scroll", this.onScroll);
      document
        .getElementsByClassName("v-data-table__wrapper")[0]
        .addEventListener("scroll", this.onScroll2);
    },
    removeScroll() {
      document
        .getElementById("scrollTarget")
        .removeEventListener("scroll", this.onScroll);
      document
        .getElementsByClassName("v-data-table__wrapper")[0]
        .removeEventListener("scroll", this.onScroll2);
    }
  },
  filters: {
    formatDate(date) {
      return moment(date).format("MM/DD/YYYY");
    }
  },
  computed: {
    ...mapGetters({
      page: "user/page",
      perPage: "user/per_page",
      roles: "user/roles",
      paginate: "user/items",
      loading: "user/loading",
      categories: "category/items",
      user: "user/view"
    }),

    header: function() {
      if (this.role == 2 || !this.role) {
        return [
          { text: "", align: "left", value: "imagen", sortable: false },
          { text: "Ip", align: "left", value: "device" },
          { text: "Username", align: "left", value: "display_name" },
          { text: "Id", align: "left", value: "id" },
          { text: "Full name", align: "left", value: "full_name" },
          { text: "Email", align: "left", value: "email" },
          {
            text: "Phone",
            align: "left",
            value: "phone_numbers",
            sortable: false
          },

          { text: "Signup", align: "left", value: "created_at" },
          { text: "Credit", align: "left", value: "credits" },
          {
            text: "Profile",
            align: "left",
            value: "profile_percent",
            width: 30
          },
          { text: "Featured", align: "left", value: "featured", width: 30 },
          { text: "Active", align: "left", value: "active", width: 30 },
          { text: "Fraud", align: "left", value: "fraud", width: 30 },
          { text: "Hide", align: "left", value: "account_status", width: 30 },
          { text: "Test user", align: "left", value: "test_user", width: 30 },
          { text: "License checked", align: "left", value: "licence_checked", width: 30 },
          { value: "aux" }
        ];
      }
      return [
        { text: "", align: "left", value: "imagen", sortable: false },
        { text: "Ip", align: "left", value: "device" },
        { text: "Username", align: "left", value: "display_name" },
        { text: "Id", align: "left", value: "id" },
        { text: "Full name", align: "left", value: "full_name" },
        { text: "Email", align: "left", value: "email" },
        {
          text: "Phone",
          align: "left",
          value: "phone_numbers",
          sortable: false
        },
        { text: "Signup", align: "left", value: "created_at" },
        { text: "Profile", align: "left", value: "profile_percent" },
        { text: "Featured", align: "left", value: "featured" },
        { text: "Active", align: "left", value: "active" },
        { text: "Fraud", align: "left", value: "fraud", width: 30 },
        { text: "Hide", align: "left", value: "account_status", width: 30 },
        { text: "Test user", align: "left", value: "test_user", width: 30 },
        { text: "License checked", align: "left", value: "licence_checked", width: 30 },
        { value: "aux" }
      ];
    }
  },

  watch: {
    licenseItem(val){
      console.log(val);
      console.log('licenseItem');
    },
    paginate(val){
      console.log(val);
      console.log('users');
    },
    editCreditDialog(val) {
      if (!val)
        this.item = this.credit = this.addingCredit = this.newCredit = null;
    },
    credit(val) {
      if (this.addingCredit !== null) {
        if (this.addingCredit) {
          this.newCredit =
            parseFloat(this.item.credit) + parseFloat(this.credit);
        } else {
          this.newCredit =
            parseFloat(this.credit) > parseFloat(this.item.credit)
              ? 0
              : parseFloat(this.item.credit) - parseFloat(this.credit);
        }
      }
    },
    addingCredit(val) {
      if (val === null) return;
      if (val) {
        this.newCredit = parseFloat(this.item.credit) + parseFloat(this.credit);
      } else {
        this.newCredit =
          parseFloat(this.credit) > parseFloat(this.item.credit)
            ? 0
            : parseFloat(this.item.credit) - parseFloat(this.credit);
      }
    },

    category() {
      this.$store.dispatch(this.store + "/page", 1);
      this.$store
        .dispatch(this.store + "/getItems", this.getQueryParam())
        .then(() => {
          this.updateScroll();
        });
    },
    role() {
      this.category = null;
      this.$store.dispatch(this.store + "/page", 1);
      this.$store
        .dispatch(this.store + "/getItems", this.getQueryParam())
        .then(() => {
          this.updateScroll();
        });
    },
    loading(val) {
      this.$store.dispatch("util/setLoading", val);
    },
    id(val) {
      if (!val) {
        this.onSearch = false;
        this.$store.dispatch(this.store + "/page", 1);
        this.$store.dispatch(this.store + "/getItems", this.getQueryParam()).then(() => {
          this.updateScroll();
        })
      }

      if (!this.onSearch) {
        this.$store.dispatch(this.store + "/page", 1);
        this.onSearch = true;
      }
      if (this.loading) return;

      clearTimeout(this.timeout);

      // Make a new timeout set to go off in 1000ms to wait stop write
      this.timeout = setTimeout(() => {
        this.$store.dispatch(this.store + "/getItems", this.getQueryParam()).then(() => {
          this.updateScroll();
        })
      }, 1000);
    },
    search(val) {
      if (!val) {
        this.onSearch = false;
        this.$store.dispatch(this.store + "/page", 1);
        this.$store.dispatch(this.store + "/getItems", this.getQueryParam()).then(() => {
          this.updateScroll();
        })
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
            .dispatch(this.store + "/getItems", this.getQueryParam())
            .then(() => {
              this.updateScroll();
            });
      },
      deep: true
    }
  },
  created() {
    axios
      .get("/api/admin/country-code")
      .then(response => {
        this.countryCode = response.data;
      })
      .catch(function(error) {
        if (
          error.response &&
          (error.response.status === 401 || error.response.status === 419)
        ) {
          location.reload();
        }
      });
    if (!this.categories.length) this.$store.dispatch("category/getItems");

    if (!this.roles.length) this.$store.dispatch(this.store + "/getRoles");
  },
  destroyed() {
    this.removeScroll();
  }
};
</script>

<style>
th {
  white-space: nowrap;
}
.v-data-table td,
.v-data-table th {
  padding: 0 8px !important;
}
</style>
