<template>
  <div>
    <v-container fluid v-if="!loading">
      <v-data-iterator :items="items" hide-default-footer hide-default-header>
        <template v-slot:default="props">
          <v-row>
            <v-col v-for="item in props.items" :key="item.name" cols="12" sm="6" md="6">
              <v-card>
                <v-card-title class="subheading font-weight-bold">
                  <v-row>
                    <v-col>{{ item.avg_service ? 'Models' : 'Clients' }}</v-col>
                    <v-col class="d-flex justify-end">
                      <v-btn
                        icon
                        @click="downloadExcel(item.avg_service ? 'Models' : 'Clients')"
                        class="float-right"
                      >
                        <v-icon color="purple" large class="cursor-pointer">mdi-file-excel</v-icon>
                      </v-btn>
                    </v-col>
                  </v-row>
                </v-card-title>

                <v-divider></v-divider>

                <v-list dense>
                  <v-list-item>
                    <v-list-item-content>AVG Chat:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.avg_chat}} per day</v-list-item-content>
                  </v-list-item>

                  <v-list-item>
                    <v-list-item-content>AVG Call:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.avg_call}}</v-list-item-content>
                  </v-list-item>

                  <v-list-item>
                    <v-list-item-content>AVG Video:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.avg_video}}</v-list-item-content>
                  </v-list-item>

                  <v-list-item
                    v-if="item.avg_new_session_per_psychic || item.avg_new_session_per_psychic == 0"
                  >
                    <v-list-item-content>AVG New Client:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.avg_new_session_per_psychic}}</v-list-item-content>
                  </v-list-item>

                  <v-list-item v-if="item.avg_service && (item.avg_new_session || item.avg_new_session == 0)">
                    <v-list-item-content>AVG New Session:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.avg_new_session}}</v-list-item-content>
                  </v-list-item>

                  <v-list-item>
                    <v-list-item-content>AVG Session:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.avg_session}}</v-list-item-content>
                  </v-list-item>

                  <v-list-item v-if="item.avg_service">
                    <v-list-item-content>AVG Service Total:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.avg_service}}</v-list-item-content>
                  </v-list-item>

                  
                </v-list>
              </v-card>
            </v-col>
          </v-row>
        </template>
      </v-data-iterator>

      <v-row>
        <v-col cols="12" md="6">
          <v-data-iterator :items="[avg]" hide-default-footer hide-default-header>
        <template v-slot:default="props">
          <v-row>
            <v-col v-for="item in props.items" :key="item.name" cols="12">
              <v-card>
                <v-card-title class="subheading font-weight-bold">
                  <v-row>
                    <v-col cols="11">Services Average Time Response</v-col>
                    <v-col cols="1" class="d-flex justify-end">
                      <v-btn icon @click="downloadExcelTimeAvg()" class="float-right">
                        <v-icon color="purple" large class="cursor-pointer">mdi-file-excel</v-icon>
                      </v-btn>
                    </v-col>
                  </v-row>
                </v-card-title>

                <v-divider></v-divider>

                <v-list dense>
                  <!-- <v-list-item>
                    <v-list-item-content>AVG Chat:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.avg_chat_response | secondsToDhms}}</v-list-item-content>
                  </v-list-item> -->

                  <v-list-item>
                    <v-list-item-content>AVG Call Now:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.avg_call_now | secondsToDhms}}</v-list-item-content>
                  </v-list-item>

                  <v-list-item>
                    <v-list-item-content>AVG Call Later:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.avg_call_later | secondsToDhms}}</v-list-item-content>
                  </v-list-item>

                  <v-list-item>
                    <v-list-item-content>AVG Call:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.avg_call | secondsToDhms}}</v-list-item-content>
                  </v-list-item>

                  <v-list-item>
                    <v-list-item-content>AVG Video Now:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.avg_video_now | secondsToDhms}}</v-list-item-content>
                  </v-list-item>

                  <v-list-item>
                    <v-list-item-content>AVG Video Later:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.avg_video_later | secondsToDhms}}</v-list-item-content>
                  </v-list-item>

                  <v-list-item>
                    <v-list-item-content>AVG Video:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.avg_video | secondsToDhms}}</v-list-item-content>
                  </v-list-item>
                </v-list>
              </v-card>
            </v-col>
          </v-row>
        </template>
      </v-data-iterator>
        </v-col>
        <v-col cols="12" md="6">
          <v-data-iterator :items="[rate]" hide-default-footer hide-default-header>
        <template v-slot:default="props">
          <v-row>
            <v-col v-for="item in props.items" :key="item.name" cols="12">
              <v-card>
                <v-card-title class="subheading font-weight-bold">
                  <v-row>
                    <v-col cols="11">Services Average Rate Per Minutes</v-col>
                    <!-- <v-col cols="1" class="d-flex justify-end">
                      <v-btn icon @click="downloadExcelTimeAvg()" class="float-right">
                        <v-icon color="purple" large class="cursor-pointer">mdi-file-excel</v-icon>
                      </v-btn>
                    </v-col> -->
                  </v-row>
                </v-card-title>

                <v-divider></v-divider>

                <v-list dense>

                  <v-list-item>
                    <v-list-item-content>AVG Chat Rate per Month:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.chat_rate_month_avg | money}}</v-list-item-content>
                  </v-list-item>

                  <v-list-item>
                    <v-list-item-content>AVG Call Rate per Month:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.call_rate_month_avg | money}}</v-list-item-content>
                  </v-list-item>

                  <v-list-item>
                    <v-list-item-content>AVG Video Rate per Month:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.video_rate_month_avg | money}}</v-list-item-content>
                  </v-list-item>

                  <v-list-item>
                    <v-list-item-content>AVG Chat Rate per Year:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.chat_rate_year_avg | money}}</v-list-item-content>
                  </v-list-item>

                  <v-list-item>
                    <v-list-item-content>AVG Call Rate per Year:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.call_rate_year_avg | money}}</v-list-item-content>
                  </v-list-item>

                  <v-list-item>
                    <v-list-item-content>AVG Video Rate per Year:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.video_rate_year_avg | money}}</v-list-item-content>
                  </v-list-item>

                  <v-list-item>
                    <v-list-item-content>AVG Chat Rate All Time:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.chat_rate_avg | money}}</v-list-item-content>
                  </v-list-item>

                  <v-list-item>
                    <v-list-item-content>AVG Call Rate All Time:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.avg_rate_call | money}}</v-list-item-content>
                  </v-list-item>

                  <v-list-item>
                    <v-list-item-content>AVG Video Rate All Time:</v-list-item-content>
                    <v-list-item-content class="align-end">{{item.avg_rate_video | money}}</v-list-item-content>
                  </v-list-item>
                </v-list>
              </v-card>
            </v-col>
          </v-row>
        </template>
      </v-data-iterator>
        </v-col>
      </v-row>            
    </v-container>
    <v-skeleton-loader v-else type="table-tbody" class="mx-auto"></v-skeleton-loader>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import moment from "moment";
import { objectToGetParameters } from "../../util";
import axios from "axios";
import { ExportToCsv } from "export-to-csv";

export default {
  data() {
    return {
      store: "service",
      items: [],
      avg: {},
      rate: {}
    };
  },
  computed: {
    ...mapGetters({
      loading: "service/loading",
    }),
  },
  filters: {
    secondsToDhms(seconds) {

      seconds = Number(seconds);
      let d = Math.floor(seconds / (3600 * 24));
      d = d > 0 ? d + (d == 1 ? " Day, " : " Days, ") : "";
      return d + moment.utc(seconds*1000).format('HH:mm:ss');
    },
  },
  methods: {
    downloadExcel(type) {
      let data = [
        {
          name: "Service AVG",
          age: 10,
          average: 8.2,
          approved: true,
          description: "using 'Content here, content here' ",
        },
      ];

      const title = type + " Service AVG";

      const options = {
        fieldSeparator: ",",
        quoteStrings: '"',
        decimalSeparator: ".",
        showLabels: true,
        showTitle: true,
        title: title,
        useBom: true,
        useKeysAsHeaders: true,
        filename: title,
        // headers: ['Column 1', 'Column 2', etc...] <-- Won't work with useKeysAsHeaders present!
      };

      const csvExporter = new ExportToCsv(options);
      const index = type == "User" ? 1 : 0;
      let values = {
        // 'Quantity': this.items[index].cont,
        "AVG Chat": this.items[index].avg_chat,
        "AVG Call": this.items[index].avg_call,
        "AVG Video": this.items[index].avg_video,
        "AVG Session": this.items[index].avg_session,
      };
      if (index == 0) {
        this.$set(values, "AVG Service", this.items[index].avg_service);
      }

      csvExporter.generateCsv([values]);
    },
    downloadExcelTimeAvg() {
      let data = [
        {
          name: "Service AVG response time",
          age: 10,
          average: 8.2,
          approved: true,
          description: "using 'Content here, content here' ",
        },
      ];

      const title = "Service AVG response time";

      const options = {
        fieldSeparator: ",",
        quoteStrings: '"',
        decimalSeparator: ".",
        showLabels: true,
        showTitle: true,
        title: title,
        useBom: true,
        useKeysAsHeaders: true,
        filename: title,
        // headers: ['Column 1', 'Column 2', etc...] <-- Won't work with useKeysAsHeaders present!
      };

      const csvExporter = new ExportToCsv(options);

      let values = {
        // 'Quantity': this.items[index].cont,
        // "AVG Chat": this.$options.filters.secondsToDhms(this.avg.avg_chat_response),
        "AVG Call Now": this.$options.filters.secondsToDhms(this.avg.avg_call_now),
        "AVG Call Later": this.$options.filters.secondsToDhms(this.avg.avg_call_later),
        "AVG Video Now": this.$options.filters.secondsToDhms(this.avg.avg_video_now),
        "AVG Video Later": this.$options.filters.secondsToDhms(this.avg.avg_video_later),
      };

      csvExporter.generateCsv([values]);
    },
  },
  created() {
    this.$store.dispatch(this.store + "/getItems").then((response) => {
      this.items = [response.data.Model, response.data.User];
      this.avg = response.data.avg_time;
      this.rate = response.data.rate;
    });
  },
};
</script>
