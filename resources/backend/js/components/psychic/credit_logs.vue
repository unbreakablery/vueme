<template>
  <div class="model-credit-logs mt-8" style="background:#fff; padding-top:17px !important">
    <div class="credit-title" style="width:100%; padding-left:20px !important"><h2>Transaction History</h2></div>
    <div class="row ml-0 mr-0">
      <v-col cols="12" class="px-0">
        <v-container class="mx-0 pt-5" style="max-width:100%">
          
  
          <v-card tile class="mx-auto credit-log-card" style="box-shadow: 0px 10px 13px #0000001A!important;">
            <v-card-text class="pa-0" style="height: 50%">
              <v-container class="mb-0 pt-2 pb-3">
                <v-row class="mb-3">
          </v-row>
                <v-row>
                  <v-col class="col-6 col-md-9 col-sm-6">
                    <v-text-field
                      style="background-color: white; max-width:300px !important"
                      filled
                      solo
                      dense
                      flat
                      prepend-inner-icon="mdi-magnify"
                      label="Search"
                      v-model="search"
                      clearable
                      class="magnifyInput credit-log-search"
                    ></v-text-field>
                  </v-col>
                  <v-col class="col-6 col-md-3 col-sm-6 mb-0">
                        <v-select
                          class="widthSelect float-right credit-log-filter"
                          :items="filter_by"
                          label="Filter by"
                          v-model="selected_service"
                          multiple
                          attach
                          height="35"
                          chips
                          dense
                          :menu-props="{contentClass: 'checkListGray'}"
                          solo
                          append-icon="ico-sort-arrows"
                          :style="[ !$vuetify.breakpoint.smAndDown ? {'width': '100% !important'}:{'width': '100% !important','float':'right'}]"
                          @change="serviceSelected"
                        >
                          <template v-slot:selection="{ item, index }">
                            <div v-if="selected_service.length <= 1">{{ item }}</div>
                            <span v-if="index === 1">Show Filtered</span>
                          </template>
                        </v-select>
                      
                  </v-col>
                </v-row>
              </v-container>
              <v-data-table
                :no-data-text='$vuetify.noDataTex="Currently Empty"'

                id="information"
                :items-per-page="10"
                class="col-12 credit-log-table"      
                :search="search"          
                :items="(search != '' && search != null ) || !selected_service.length ? transactions : transactionsEmptySearch"
                :hide-default-header="mobile"
                :headers="headers"
                :custom-filter="filterText"
                
              >
                <template v-slot:item="{item}">
                  <tr :key="item.id">
                    <td class="px-2">{{item.created | fdate}}</td>

                    <td
                      class="px-2"
                      v-if="!mobile || item.client_name==='-------'"
                    >{{item.client_name}}</td>
                    <td class="px-2" v-else>
                      <img class="img" :title="item.client_name" :src="item.client_image" />
                    </td>
                    <td class="px-2">
                      <v-icon>{{item.icon}}</v-icon>

                      <div v-if="!mobile" class="d-inline" color="black">{{item.service}}</div>
                    </td>
                    <td class="px-2">{{item.duration | ftime}}</td>
                    <td
                      class="px-2"
                      :style="[item.impact === 'negative' ? {color:'red'} : {color:'green'}]"
                    >${{item.amount | numFormat('0,0.00')}}</td>
                  </tr>
                </template>
              </v-data-table>
              
            </v-card-text>
          </v-card>
        </v-container>
      </v-col>
    </div>
    <v-row class="ml-0 mr-0">
      <v-btn
        style="margin-left: auto;"
        @click="f_generate_pdf"
        outlined
        color="#F77F98"
        :loading="loading"
        class="download-pdf"
        small
      >Download PDF</v-btn>
    </v-row>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";
import moment from "moment";
export default {
  data: function() {
    return {
      loading: false,
      search: "",
      flag: true,
      selected_service: "",
      pdf_data: [],
      pdf_data_temp: [],
      filter_by: [
        "Calling",
        "Chat",
        "Video Chat",
        "Chat Refunded",
        "Failed Call",
        "Failed V-Chat"
      ],

      headers: [
        { text: "Date", value: "created" },
        { text: "Client", value: "client_name" },
        { text: "Service", value: "service" },
        { text: "Time", value: "duration" },
        { text: "Amount", value: "amount" }
      ],
      transactionsEmptySearch:[],
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

      // if (time < 1) { return '< 1'; }

      return new Date(time * 1000 * 60).toISOString().substr(11, 8);
      // var h = Math.floor(time / 3600);
      // var m = Math.floor(time % 3600 / 60);
      // var s = Math.floor(time % 3600 % 60);
      //  let r ='';
      //           if(m){
      //             r=m.toString();
      //           }
      //       return (h.toString() +'-'+m.toString() +'-'+s.toString());
    }
  },
  props: ["transactions", "name"],
  created() {
    //this.get_transactions();
  },
  methods: {
    serviceSelected() {
        if( this.search== "" || this.search == null){
        this.transactionsEmptySearch=this.transactions.filter((transaction) => {
        if (this.selected_service.includes(transaction.service)) {
          return true;
        }
        });
        }
      },
       filterText (value, search, item) {
         if(value != null && search != null && typeof value === 'string' && value.toString().indexOf(search) !== -1)  {
         if (this.selected_service.length) {
            if (this.selected_service.includes(item.service)) {
              return true;
            }
         }
         else
         return true;
       }
        else if (this.selected_service.length && ( search== "" || search == null)) {
            if (this.selected_service.includes(item.service)) {
              return true;
            }
         }
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
      doc.save(pdfName + ' ' +  moment().format('MM-DD-YYYY') + ".pdf");
      this.loading = false;
    },
    get_transactions() {
      axios
        .get("/api/v1/user/transactions/", {})
        .then(response => {
          this.transactions = response.data.data;
        })
        .catch(error => {
          alert("Something was wrong");
          location.reload();
        });
    }
  }
};
</script>

<style lang="scss">
.model-credit-logs {
  .v-btn:not(.v-btn--round).v-size--small.download-pdf {
    padding: 13px 35px!important;
    display: block;
    height: auto!important;
    border-radius: 12px;
    span {
      font-size: 12px;
    }
  }
  .credit-title {
    font-size: 24px !important;
    color: #42424D;
  }
  .credit-log-card {
    padding-left: 20px;
    padding-right: 20px;
  }
  .history-period {
    span {
      justify-content: space-between;
    }
  }
  .credit-log-search {
    width: 100%!important;
    max-width: 100%!important;
    .v-input__control {
      .v-input__slot {
        border: 1px solid #13122066;
        border-radius: 35px;
        .v-text-field__slot {
          input {
            border: none;
            padding-left: 0px!important;
          }
        }
      }
    }
  }
  .payout-description {
    font-size: 14px;
    margin-bottom: 14px;
  }
  .view-pay-schedule {
    font-size: 14px;
    color: #227ce6 !important;
    text-decoration: underline;
  }
  .credit-log-filter {
    width: 100%!important;
    .v-select__slot {
      .v-label {
        color: #42424D!important;
        opacity: 1;
      }
      border: none!important;
      .v-select__selections {
        input {
          border: none;
        }
      }
    }
  }
  .credit-log-table {
    padding-left: 0px!important;
    padding-right: 0px!important;
    .v-data-footer {
      .v-data-footer__select {
        .v-input {
          .v-input__control {
            .v-input__slot:before {
              border: none!important;
            }
            .v-input__slot {
              .v-select__slot {
                border: none!important;
                .v-select__selections {
                  input {
                    border: none!important;
                  }
                }
              }
            }
          }
        }
      }
    }
  }
}
@media (max-width: 769px) {
  .credit-title {
    padding-left: 24px;
  }
  .payout-description, .view-pay-schedule {
    padding-left: 24px;
    padding-right: 24px;
  }
}
</style>

<style>
#list-58 .v-list-item {
  border: 1px solid #f0f0f8 !important;
  color: #8e8d99 !important;
  background: #f0f0f8 !important;
}
.v-label {
  font-size: 12px !important;
}

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
.v-data-footer__select .v-select__selections .v-select__selection--comma {
  color: #3f3e3f!important;
  font-weight: 500;
}


</style>
