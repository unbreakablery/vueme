<template>
  <div class="pa-5">
    <v-row class="mb-3">
      <v-col class="headline">{{name}} Transaction History</v-col>
      <v-col>
        <v-btn
          color="primary"
          v-if="user.credit > 0 && transactionsList.filter(item => item.service == 'ACCOUNT_REFUND').length == 0"
          @click="confirmRefund(user)"
        >Refund Balance</v-btn>
      </v-col>
    </v-row>
    <v-card flat class="mx-auto">
      <v-card-text class="pa-0" style="height: 50%">
        <v-row>
          <v-col class="col-12 col-sm-6">
            <v-text-field
              style="background-color: white;"
              filled
              solo
              dense
              flat
              prepend-inner-icon="mdi-magnify"
              label="Search"
              v-model="search"
              clearable
            ></v-text-field>
          </v-col>
          <v-col class="col-12 col-md-6">
            <v-row>
              <v-col>
                <v-select
                  clearable
                  :items="['Calling', 'Chat', 'Video Chat','Purchased','Chat Refunded']"
                  label="Filter by"
                  v-model="selected_service"
                  multiple
                  attach
                  chips
                  dense
                ></v-select>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
        <v-data-table
          id="information"
          :items-per-page="10"
          class="col-12"
          :items="obj_transactions"
          :hide-default-header="mobile"
        >
          <template v-slot:header>
            <thead>
              <tr>
                <th class="px-2" colspan="1">Model</th>
                <th class="px-2" colspan="1">Date</th>
                <th class="px-2" colspan="1">Service</th>
                <th class="px-2" colspan="1">Time</th>
                <th class="px-2" colspan="1">Amount</th>
              </tr>
            </thead>
          </template>

          <template v-slot:item="{item}">
            <tr>
              <td class="px-2" v-if="!mobile || item.psychic_name==='-------'">{{item.psychic_name}}</td>
              <td class="px-2" v-else>
                <img class="img" :title="item.psychic_name" :src="item.psychic_image" />
              </td>
              <td class="px-2">{{item.created | fdate}}</td>
              <td class="px-2">
                <!-- <v-icon>{{item.icon}}</v-icon>

                <div v-if="!mobile" class="d-inline">{{item.service}}</div>-->

                <v-icon v-if="item.service==='Video Chat'" color="black">mdi-video</v-icon>
                <v-icon v-if="item.service==='Call'" color="black">mdi-phone</v-icon>
                <v-icon v-if="item.service==='Chat'" color="black" >mdi-message</v-icon>
                <div v-if="!mobile" class="d-inline" color="black">{{item.service}}</div>
              </td>
              <td class="px-2">{{item.duration | ftime}}</td>
              <!-- <td class="px-2">${{item.amount | numFormat('0,0.00')}}</td> -->
              <td
                class="px-2"
                :style="[item.impact === 'negative' ? {color:'red'} : {color:'green'}]"
              >{{item.impact == 'negative' ? '-' : ''}}${{item.amount | numFormat('0,0.00')}}</td>
            </tr>
          </template>
        </v-data-table>
        <v-row>
          <v-col class="d-flex justify-end">
            <v-btn
              @click="f_generate_cvs"
              outlined
              color="#898585"
              :loading="loading"
              small
            >Download CSV</v-btn>

            <v-btn
              class="ml-3"
              @click="f_generate_pdf"
              outlined
              color="#898585"
              :loading="loading"
              small
            >Download PDF</v-btn>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
    <v-dialog v-if="user.billing.length > 0" v-model="dialogRefund" scrollable max-width="450px">
      <v-card class="px-4">
        <v-subheader class style="position: absolute; right: 0;">
          <v-icon
            class="d-block text-right"
            style="position: absolute;right: 15px;z-index: 9;"
            @click="dialogRefund=false"
          >mdi-close</v-icon>
        </v-subheader>
        <div class="message my-10">
          <h4>Confirm Balance Refund</h4>
        </div>
        <div class="mb-8">
          <div class="mb-2">Client ID: {{this.user.id }}</div>
          <div class="mb-2">Email: {{this.user.email }}</div>
          <div class="mb-2 mt-8">
            <v-select
              v-model="payment_method"
              :items="this.user.billing"
              label="Payment Method"
              item-value="billing_id"
              outlined
            >
              <template slot="selection" slot-scope="data">
                <!-- // HTML that describe how select should render selected items -->
                XXXXXXXXXXXX{{data.item.last_four}}
              </template>
              <template slot="item" slot-scope="data">
                <!-- // HTML that describe how select should render items when the select is open -->
                XXXXXXXXXXXX{{data.item.last_four}}
              </template>
            </v-select>
          </div>
          <div class="mb-2 mt-3">
            <v-text-field
              disabled
              label="Balance"
              :rules="[rules.required, rules.numeric]"
              prepend-inner-icon="mdi-currency-usd"
              outlined
              v-model="user.credit"
            ></v-text-field>
          </div>
        </div>
        <div class="text-center mb-4">
          <v-btn
            type="button"
            color="primary"
            :loading="loading"
            @click="makeRefund()"
          >Refund ${{user.credit}}</v-btn>
        </div>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialogSuccess" scrollable max-width="450px">
      <v-card class="px-4">
        <v-subheader class style="position: absolute; right: 0;">
          <v-icon
            class="d-block text-right"
            style="position: absolute;right: 15px;z-index: 9;"
            @click="dialogSuccess=false"
          >mdi-close</v-icon>
        </v-subheader>
        <div class="message my-10">
          <h4>Balance Successfully Refunded</h4>
        </div>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";
import axios from "axios";
import { ExportToCsv } from "export-to-csv";
import moment from "moment";
export default {
  data: function() {
    return {
      loading: false,
      payment_method: "",
      search: "",
      dialogRefund: false,
      dialogSuccess: false,
      flag: true,
      selected_service: "",
      pdf_data: [],
      pdf_data_temp: [],
      transactionsList: [],

      headers: [
        { text: "Model", value: "psychic_name" },
        { text: "Date", value: "created" },
        { text: "Service", value: "service" },
        { text: "Time", value: "duration" },
        { text: "Amount", value: "amount" }
      ],
      rules: {
        required: value => !!value || "Required.",
        numeric: value => {
          const pattern = /^[1-9]\d*(\.\d+)?$/;
          return pattern.test(value) || "Invalid value.";
        }
      }
    };
  },
  watch: {
    user(val) {
      if (this.user.billing.length > 0) {
        this.payment_method = this.user.billing.filter(
          i => i.preferred
        )[0].billing_id;
      }
    }
  },
  computed: {
    obj_transactions() {
      return this.transactionsList.filter(transaction => {
        let str =
          transaction.psychic_name +
          " " +
          this.$options.filters.fdate(transaction.created) +
          " " +
          transaction.amount;

        if (
          !this.search ||
          str.toLowerCase().indexOf(this.search.toLowerCase()) !== -1
        ) {
          if (this.selected_service.length) {
            if (this.selected_service.includes(transaction.service)) {
              return true;
            }
          } else {
            return true;
          }
        }
      });
    },

    ...mapGetters({
      mobile: "util/mobile"
    })
  },

  filters: {
    fdate: function(date) {
      var created = new Date(date);
      return (
        (created.getMonth() > 8
          ? created.getMonth() + 1
          : "0" + (created.getMonth() + 1)) +
        "/" +
        (created.getDate() > 9 ? created.getDate() : "0" + created.getDate()) +
        "/" +
        created.getFullYear()
      );
    },
    ftime: function(time) {
      if (!time || typeof time === "undefined" || time === "0.00") {
        return "-------";
      }

      return new Date(time * 1000 * 60).toISOString().substr(11, 8);
    }
  },
  props: ["transactions", "name", "user"],
  created() {
    let item = null;
    this.transactions.forEach(i => {

      this.transactionsList.push(i);
      
      if(i.promo && i.promo != 0){
        item = Object.assign({}, i);
        item.amount = item.promo;
        item.service = 'Promo';
        this.transactionsList.push(item);
      }

      if(i.promo_amount && i.promo_amount != 0){
        item = Object.assign({}, i);
        item.amount = item.promo_amount;
        item.service = 'Promo'+` (${item.promo_code})`;
        this.transactionsList.push(item);
      }
    })
    if (this.user.billing.length > 0) {
      this.payment_method = this.user.billing.filter(
        i => i.preferred
      )[0].billing_id;
    }
  },
  mounted() {
    if (this.user.billing.length > 0) {
      this.payment_method = this.user.billing.filter(
        i => i.preferred
      )[0].billing_id;
    }
  },
  methods: {
    f_generate_cvs() {
      let data = [
        {
          name: "Test 4",
          age: 10,
          average: 8.2,
          approved: true,
          description: "using 'Content here, content here' "
        }
      ];

      let title = this.name + " Transaction History " + moment().format('MM-DD-YYYY');
      //    All time earnings: " +
      //   this.finaceData.earning +
      //   ". Current balance: " +
      //   this.finaceData.current_balance +
      //   ". Payment method: ";

      // title += this.finaceData.payment_method ? "Yes" : "No";

      const options = {
        fieldSeparator: ",",
        quoteStrings: '"',
        decimalSeparator: ".",
        showLabels: true,
        showTitle: true,
        title: title,
        useBom: true,
        useKeysAsHeaders: true,
        filename: title
        // headers: ['Column 1', 'Column 2', etc...] <-- Won't work with useKeysAsHeaders present!
      };

      const csvExporter = new ExportToCsv(options);

      csvExporter.generateCsv(
        this.obj_transactions.map((item, i) => {
          return {
            Date: this.f_fdate(item.created),
            Model: item.psychic_name,
            Service: item.service,
            Time: this.f_ftime(item.duration),
            Amount: item.impact == 'negative'
              ? "-" + this.$options.filters.money(item.amount)
              : this.$options.filters.money(item.amount)
          };
        })
      );
    },
    confirmRefund() {
      this.dialogRefund = true;
    },
    makeRefund() {
      this.loading = true;
      var input = {
        id: this.user.id,
        balance: this.user.credit,
        billing_id: this.payment_method
      };
      axios
        .post("/api/admin/refund/account", input)
        .then(response => {
          this.$emit("refund");
          this.loading = false;
          this.dialogRefund = false;
          this.dialogSuccess = true;
          this.payment_method = "";
          this.user.credit = 0;
        })
        .catch(error => {
          alert("Something was wrong");
          location.reload();
        });
    },
    f_fdate(date) {
      var created = new Date(date);
      return (
        (created.getMonth() > 8
          ? created.getMonth() + 1
          : "0" + (created.getMonth() + 1)) +
        "/" +
        (created.getDate() > 9 ? created.getDate() : "0" + created.getDate()) +
        "/" +
        created.getFullYear()
      );
    },
    f_ftime(time) {
      if (!time || typeof time === "undefined" || time === "0.00") {
        return "-------";
      }
      return new Date(time * 1000 * 60)
        .toISOString()
        .substr(11, 8)
        .toString();
    },
    f_generate_pdf() {
      this.loading = true;

      let colums = [
        { header: "Model", dataKey: "psychic_name" },
        { header: "Date", dataKey: "created" },
        { header: "Service", dataKey: "service" },
        { header: "Time", dataKey: "duration" },
        { header: "Amount", dataKey: "amount" }
      ];

      // this.pdf_data = this.obj_transactions;
      this.pdf_data_temp = this.obj_transactions;
      let temp = [];

      for (let i = 0; i < this.pdf_data_temp.length; i++) {
        let elem = Object.assign({}, this.pdf_data_temp[i]);
        elem.created = this.f_fdate(elem.created);
        elem.duration = this.f_ftime(elem.duration);
        elem.psychic_image = "";
        elem.amount = elem.impact == 'negative'
          ? "-" + this.$options.filters.money(elem.amount)
          : this.$options.filters.money(elem.amount);
        temp.push(elem);
      }
      let color = ";";
      let pdfName = this.name + " Transaction History";
      var doc = new jsPDF("p", "pt");
      doc.text(pdfName, 40, 70);
      doc.autoTable({
        headStyles: {
          fillColor: "#9759FF"
        },
        startY: 100,
        columns: colums,
        body: temp
      });
      //doc.autoTable(colums,inf);
      doc.save(pdfName +' '+ moment().format('MM-DD-YYYY') + ".pdf");
      this.loading = false;
    },
    // get_transactions() {
    //   axios
    //     .get("/api/v1/user/transactions/", {})
    //     .then(response => {
    //       this.transactions = response.data.data;
    //       console.log(this.transactions);
    //     })
    //     .catch(error => {
    //       alert("Something was wrong");
    //       location.reload();
    //     });
    // }
  }
};
</script>

<style>
.icon-close {
  position: absolute;
  top: 0;
  right: 0;
  margin-right: 5px;
  margin-top: 5px;
}
.img {
  border-radius: 50%;
  width: 50px;
  height: 50px;
  padding: 5px;
}
.v-data-footer__pagination {
  margin: 0px 10px 0px 10px;
}
td {
  font-weight: 600;
}
</style>
