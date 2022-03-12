<template>
  <div class="pa-5">
    <v-row class="mb-3">
      <v-col cols="12" class="headline">{{name}} Transaction History</v-col>
      <v-col cols="12" class="font-weight-bold">All time earnings {{finaceData.earning | money}}</v-col>
      <v-col
        cols="12"
        class="font-weight-bold"
      >Current bce {{finaceData.current_balance | money}}</v-col>
      <v-col
        cols="12"
        class="font-weight-bold"
      >Payout Method Added? {{finaceData.payment_method ? 'Yes' : 'No'}}</v-col>
    </v-row>
    <v-card flat tile class="mx-auto">
      <v-card-text class="pa-0">
        <v-row>
          <v-col class="col-12 col-md-4">
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
          <v-col class="col-12 col-md-4">
            <v-select
              class="mt-0"
              clearable
              :items="['Calling', 'Chat', 'Video Chat','Chat Refunded','Failed Call','Failed V-Chat']"
              label="Filter by"
              v-model="selected_service"
              multiple
              attach
              chips
              dense
            ></v-select>
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
                <th class="px-2" colspan="1">Id</th>
                <th class="px-2" colspan="1">Date</th>
                <th class="px-2" colspan="1">Client</th>
                <th class="px-2" colspan="1">Service</th>
                <th class="px-2" colspan="1">Time</th>
                <th class="px-2" colspan="1">Amount</th>
                <th class="px-2" colspan="1">Action</th>
              </tr>
            </thead>
          </template>

          <template v-slot:item="{item}">
            <tr :key="item.id">
              <td class="px-2">{{item.id}}</td>
              <td class="px-2">{{item.created | fdate}}</td>

              <td class="px-2" v-if="!mobile || item.client_name==='-------'">{{item.client_name}}</td>
              <td class="px-2" v-else>
                <img class="img" :title="item.client_name" :src="item.client_image" />
              </td>
              <td class="px-2">
                <v-icon v-if="item.service==='Video Chat'" color="black">mdi-video</v-icon>
                <v-icon v-if="item.service==='Call'" color="black">mdi-phone</v-icon>
                <v-icon v-if="item.service==='Chat' || item.service==='Free Message'" color="black" >mdi-message</v-icon>
                <div v-if="!mobile" class="d-inline" color="black">{{item.service}}</div>
              </td>
              <td class="px-2">{{item.duration | ftime}}</td>
              <td
                class="px-2"
                :style="[item.impact == 'negative' ? {color:'red'} : {color:'green'}]"
              >{{item.impact == 'negative' ? '-' : ''}}${{item.amount | numFormat('0,0.00')}}</td>
              <td class="px-2">
                <span v-if="item.refunded" class="success--text">Retracted</span>
                <v-btn
                  v-else-if="(item.service==='Video Chat' || item.service==='Call' || item.service==='Chat') && !item.refunded && item.amount > 0"
                  color="primary"
                  @click="confirmRetract(item)"
                >Retract</v-btn>
              </td>
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

    <v-dialog v-model="dialogRetract" scrollable max-width="450px">
      <v-card class="px-4">
        <v-subheader class style="position: absolute; right: 0;">
          <v-icon
            class="d-block text-right"
            style="position: absolute;right: 15px;z-index: 9;"
            @click="dialogRetract=false"
          >mdi-close</v-icon>
        </v-subheader>
        <div class="message my-10">
          <h4>Confirm Transaction Retract</h4>
        </div>
        <div class="mb-8">
          <div class="mb-2">Date: {{this.selectedTrasaction.created | fdate}}</div>
          <div class="mb-2">
            Service:
            <v-icon v-if="this.selectedTrasaction.service==='Video Chat'" color="black">mdi-video</v-icon>
            <v-icon v-if="this.selectedTrasaction.service==='Call'" color="black">mdi-phone</v-icon>
            <v-icon v-if="this.selectedTrasaction.service==='Chat'" color="black">mdi-message</v-icon>
            <div v-if="!mobile" class="d-inline" color="black">{{this.selectedTrasaction.service}}</div>
          </div>
          <div class="mb-2">Duration: {{this.selectedTrasaction.duration | ftime}}</div>
          <div class="mb-2">
            Amount:
            <b>${{this.selectedTrasaction.amount | numFormat('0,0.00')}}</b>
          </div>
        </div>
        <div class="text-center mb-4">
          <v-btn
            type="button"
            color="primary"
            :loading="loading"
            @click="makeRetract()"
          >Submit Retract</v-btn>
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
          <h4>Transaction Successfully Retracted</h4>
        </div>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";
import { ExportToCsv } from "export-to-csv";
import axios from "axios";
import moment from "moment";
export default {
  data: function() {
    return {
      loading: false,
      dialogRetract: false,
      dialogSuccess: false,
      search: "",
      flag: true,
      selected_service: "",
      pdf_data: [],
      pdf_data_temp: [],
      selectedTrasaction: {},

      headers: [
        { text: "Id", value: "id" },
        { text: "Date", value: "created" },
        { text: "Client", value: "client_name" },
        { text: "Service", value: "service" },
        { text: "Time", value: "duration" },
        { text: "Amount", value: "amount" }
      ]
    };
  },
  watch: {},
  computed: {
    obj_transactions() {
      return this.transactions.filter(transaction => {
        let str =
          transaction.client_name +
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
      var created = new Date(date); //return moment(created).format('MM/DD/YYYY hh:mm A');
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
  props: ["transactions", "name", "finaceData"],
  created() {
  },
  methods: {
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
            Client: item.client_name ? item.client_name : "------------",
            Service: item.service,
            Time: this.f_ftime(item.duration),
            Amount: item.impact == 'negative'
              ? "-" + this.$options.filters.money(item.amount)
              : this.$options.filters.money(item.amount)
          };
        })
      );
    },
    f_generate_pdf() {
      this.loading = true;

      let colums = [
        { header: "Date", dataKey: "created" },
        { header: "Client", dataKey: "client_name" },
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
        elem.client_image = "";
        elem.amount = elem.impact == 'negative'
          ? "-" + this.$options.filters.money(elem.amount)
          : this.$options.filters.money(elem.amount);
        temp.push(elem);
      }
      let color = ";";
      let pdfName = this.name + " - Transaction History";
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
    get_transactions() {
      axios
        .get("/api/v1/user/transactions/")
        .then(response => {
          this.transactions = response.data.data;
        })
        .catch(error => {
          alert("Something was wrong");
          location.reload();
        });
    },
    confirmRetract(item) {
      this.selectedTrasaction = item;
      this.dialogRetract = true;
    },
    makeRetract() {
      this.loading = true;
      axios
        .post("/api/admin/retract/transaction/" + this.selectedTrasaction.id)
        .then(response => {
          this.$emit("retract");
          this.loading = false;
          this.dialogRetract = false;
          this.dialogSuccess = true;
        })
        .catch(error => {
          alert("Something was wrong");
          location.reload();
        });
    }
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
  font-weight: 500;
  font-size: 12px;
}
.v-card label {
  color: #3f3e3f !important;
  font-weight: 500 !important;
}
</style>
