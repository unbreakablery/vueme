<template>
  <v-container>
    <v-tabs v-model="tab">
      <v-tab>Horoscope Config</v-tab>
      <v-tab>Horoscope Signs</v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab" style="background-color: transparent">
      <v-tab-item>
        <v-row>
          <v-col col="12">
            <v-form ref="config">
              <v-container>
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      v-model="config.emails"
                      label="Send Test Email (separate by comman)"
                    ></v-text-field>

                    <v-btn
                      color="purple"
                      dark
                      @click="sendEmail"
                      :loading="loading"
                      >Send Test</v-btn
                    >
                  </v-col>
                </v-row>
                <div v-if="$can('edit', 'email')">
                  <v-row>
                    <v-col cols="12" md="6">
                      <v-text-field
                        v-model="config.subject"
                        label="Subject"
                      ></v-text-field>
                    </v-col>
                  </v-row>
                  <v-row>
                    <v-col cols="12" md="4">
                      <v-menu
                        v-model="datepicker_menu"
                        :close-on-content-click="false"
                        :nudge-right="-184"
                        transition="scale-transition"
                        offset-y
                        min-width="336"
                        width="336"
                      >
                        <template v-slot:activator="{ on }">
                          <v-text-field
                            clearable
                            v-model="computedDateFormatted"
                            hide-details
                            label="Pick date"
                            v-on="on"
                            @click:append="datepicker_menu = true"
                            prepend-inner-icon="mdi-calendar-month"
                          ></v-text-field>
                        </template>

                        <v-date-picker
                          :allowed-dates="allowedDates"
                          :show-current="today"
                          :min="today"
                          width="336"
                          class="appointment-picker"
                          v-model="config.date"
                          @input="datepicker_menu = false"
                          no-title
                        ></v-date-picker>
                      </v-menu>
                    </v-col>
                    <v-col cols="12" md="4">
                      <v-menu
                        ref="menu"
                        v-model="menu2"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        :return-value.sync="config.time"
                        transition="scale-transition"
                        offset-y
                        max-width="290px"
                        min-width="290px"
                      >
                        <template v-slot:activator="{ on, attrs }">
                          <v-text-field
                            clearable
                            v-model="config.time"
                            label="Pick time"
                            prepend-inner-icon="mdi-clock-outline"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-time-picker
                          ampm-in-title
                          v-if="menu2"
                          v-model="config.time"
                          full-width
                          @click:minute="$refs.menu.save(config.time)"
                        ></v-time-picker>
                      </v-menu>
                    </v-col>
                    <!-- <v-col cols="12" md="4">
                    <v-checkbox
                      v-model="scheduled"
                      label="Scheduled"
                      hide-details
                    ></v-checkbox>
                  </v-col>-->
                    <v-col cols="12" md="6">
                      <v-autocomplete
                        v-model="config.timezone"
                        :items="timezones"
                        hide-no-data
                        hide-selected
                        label="Timezones"
                        placeholder="Start typing to Search. Default is PST"
                        return-object
                        clearable
                      ></v-autocomplete>
                    </v-col>
                  </v-row>

                  <v-row>
                    <v-col cols="12" class="d-flex justify-end">
                      <v-btn
                        color="purple"
                        dark
                        class="mr-3"
                        @click="save"
                        :loading="loading"
                        >save</v-btn
                      >
                    </v-col>
                  </v-row>
                </div>
              </v-container>
            </v-form>
          </v-col>
        </v-row>
      </v-tab-item>
      <v-tab-item>
        <v-row>
          <v-col col="12" class="signs">
            <v-data-table
              style="padding: 10px"
              :disable-pagination="true"
              hide-default-footer
              :headers="[
                {
                  text: 'Name',
                  align: 'start',
                  sortable: false,
                  value: 'name',
                },

                {
                  text: 'Period',
                  align: 'start',
                  sortable: false,
                  value: 'period',
                },


                {
                  text: 'About',
                  align: 'start',
                  sortable: false,
                  value: 'about',
                },
                { text: '', value: 'actions', sortable: false },
              ]"
              :items="signs"
              class="elevation-1"
            >

            <template #item.period="{ item }">{{ item.start_period }}-{{ item.end_period }}</template>



              <template v-slot:item.actions="{ item }">

 <v-btn icon @click="sendSignEmail(item.id)">
                  <v-icon color="teal" class="mr-2"
                    >mdi-email</v-icon
                  >
                </v-btn>

                <v-btn icon>
                  <v-icon color="teal" class="mr-2" @click="editItem = item"
                    >mdi-pencil</v-icon
                  >
                </v-btn>
              </template>
            </v-data-table>
          </v-col>
        </v-row>
      </v-tab-item>
    </v-tabs-items>

    <v-dialog v-model="dialog" max-width="700px">
      <v-card>
        <v-card-title>
          <span class="headline"
            >{{ editItem.id ? "Edit" : "Create" }} Sign</span
          >
        </v-card-title>

        <v-card-text>
          <v-container>
            <v-form ref="sign">
              <v-row>
                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="editItem.name"
                    label="Name"
                    :rules="nameRules"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-textarea
                    v-model="editItem.text"
                    :rules="nameRules"
                    required
                    outlined
                    name="input-7-4"
                    label="text"
                  ></v-textarea>
                </v-col>
                <v-col cols="12">
                  <v-textarea
                    v-model="editItem.about"
                    :rules="nameRules"
                    required
                    outlined
                    name="input-7-4"
                    label="About"
                  ></v-textarea>
                </v-col>
                </v-row>
              <v-row>
                <v-col cols="6">
                  <v-text-field
                    v-model="editItem.start_period"
                    label="From"
                    :rules="nameRules"
                    required
                  ></v-text-field>
                  </v-col>
                <v-col cols="6">
                  <v-text-field
                    v-model="editItem.end_period"
                    label="To"
                    :rules="nameRules"
                    required
                  ></v-text-field>
                </v-col>
              </v-row>

               <v-row>
                <v-col cols="6">
                   
                  <v-text-field
                    v-model="editItem.glance_1"
                    label="Symbol"
                    :rules="nameRules"
                    required
                  ></v-text-field>

              </v-col><v-col cols="6">

                  <v-text-field
                    v-model="editItem.glance_2"
                    label="Sociability Scale"
                    :rules="nameRules"
                    required
                  ></v-text-field>
                  </v-col><v-col cols="6">
                  <v-text-field
                    v-model="editItem.glance_3"
                    label="Optimist Scale"
                    :rules="nameRules"
                    required
                  ></v-text-field>
                  </v-col><v-col cols="6">
                  <v-text-field
                    v-model="editItem.glance_4"
                    label="Best Day of Week"
                    :rules="nameRules"
                    required
                  ></v-text-field>
                  </v-col><v-col cols="6">
                  <v-text-field
                    v-model="editItem.glance_5"
                    label="Element Energy"
                    :rules="nameRules"
                    required
                  ></v-text-field>
                  </v-col><v-col cols="6">
                  <v-text-field
                    v-model="editItem.glance_6"
                    label="Chinese Zodiac"
                    :rules="nameRules"
                    required
                  ></v-text-field>
                  </v-col><v-col cols="6">
                  <v-text-field
                    v-model="editItem.glance_7"
                    label="Keeps Your Secrets"
                    :rules="nameRules"
                    required
                  ></v-text-field>
                  </v-col><v-col cols="6">
                  <v-text-field
                    v-model="editItem.glance_8"
                    label="Romance Month"
                    :rules="nameRules"
                    required
                  ></v-text-field>
                  </v-col><v-col cols="6">
                  <v-text-field
                    v-model="editItem.glance_9"
                    label="Key Body Area"
                    :rules="nameRules"
                    required
                  ></v-text-field>
                  </v-col><v-col cols="6">
                  <v-text-field
                    v-model="editItem.glance_10"
                    label="Ruling Planet"
                    :rules="nameRules"
                    required
                  ></v-text-field>
                  </v-col><v-col cols="6">
                  <v-text-field
                    v-model="editItem.glance_11"
                    label="Karmic Love Partner"
                    :rules="nameRules"
                    required
                  ></v-text-field>
                  </v-col><v-col cols="6">
                  <v-text-field
                    v-model="editItem.glance_12"
                    label="Zodiac Birthstone"
                    :rules="nameRules"
                    required
                  ></v-text-field>
                  </v-col>
                  
                  
              </v-row>
            </v-form>
          </v-container>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false"
            >Cancel</v-btn
          >
          <v-btn
            color="blue darken-1"
            text
            @click="saveSign()"
            :loading="loading"
            >Save</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
  
</template>

<script>
import { mapGetters } from "vuex";
import moment from "moment";
import { requireField } from "../../util";
import axios from "axios";

export default {
  data() {
    return {
      valid: true,
      tab: 0,
      nameRules: requireField,
      config: {},
      timezones: [],
      date: null,
      datepicker_menu: null,
      time: null,
      menu2: false,
      loading: false,
      signs: [],
      dialog: false,
      editItem: {},
    };
  },
  computed: {
    computedDateFormatted: {
      set(v) {
        return v;
      },
      get() {
        if (this.config.date)
          return moment(this.config.date).format("MM/DD/YYYY");
      },
    },
    today() {
      const d = new Date();
      return d.toISOString().substr(0, 10);
    },
  },
  watch: {
    editItem(val) {
      if (val.name) this.dialog = true;
    },
    dialog(val) {
      if (!val) this.editItem = {};
    },
  },
  methods: {

     sendSignEmail(id) {
      if (
        confirm(`Are you ready to send a test email?`)
      ) {
        
          axios
            .post("/api/agency/horoscope/send/sign-email/"+id)
            .then((response) => {})
            .catch(function (error) {})
            .finally(() => (this.loading = false));
        
      }
    },



    allowedDates: (val) => {
      return moment(val).day() == 1;
    },
    sendEmail() {
      if (
        this.config.emails &&
        confirm(`Are you ready to send to ${this.config.emails} clients?`)
      ) {
        this.save().then(() => {
          this.loading = true;
          axios
            .post("/api/agency/horoscope/send/email")
            .then((response) => {})
            .catch(function (error) {})
            .finally(() => (this.loading = false));
        });
      }
    },
    saveSign() {
      if (!this.$refs.sign.validate()) return;

      this.loading = true;

      axios
        .post("/api/agency/horoscope/signs", this.editItem)
        .then((response) => {
          this.dialog = false;
        })
        .catch(function (error) {})
        .finally(() => (this.loading = false));
    },
    save() {
      if (!this.$refs.config.validate()) return;

      this.loading = true;

      return axios
        .post("/api/agency/horoscope/save", this.config)
        .then((response) => {})
        .catch(function (error) {})
        .finally(() => (this.loading = false));
    },
  },
  created() {
    axios
      .get("/api/agency/horoscope-config")
      .then((response) => {
        this.signs = response.data.signs;
        this.timezones = response.data.timezones;
        if (response.data.config) {
          this.config = response.data.config;
          this.config.time = this.config.date
            ? moment(this.config.date).format("HH:mm")
            : null;
          this.config.date = this.config.date
            ? moment(this.config.date).format("YYYY-MM-DD")
            : null;
        }
      })
      .catch(function (error) {});
  },
};
</script>

<style>
.signs table td {
  padding: 15px 8px !important;
}
</style>
