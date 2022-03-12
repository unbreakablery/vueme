<template>
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

              <v-btn color="purple" dark @click="sendEmail" :loading="loading"
                >Send Test</v-btn
              >
            </v-col>
          </v-row>
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
            <v-col cols="12" md="6">
              <v-autocomplete
                v-model="usersSelected"
                :items="users"
                hide-no-data
                hide-selected
                label="Select models"
                placeholder="Start typing to Search"
                return-object
                clearable
                :filter="customFilter"
                multiple
                :search-input.sync="search"
                item-value="id"
              >
                <template v-slot:no-data>
                  <v-list-item>
                    <v-list-item-title
                      >Escribe nombre o correo del usuario</v-list-item-title
                    >
                  </v-list-item>
                </template>
                <template v-slot:selection="data">
                  <v-chip
                    v-bind="data.attrs"
                    :input-value="data.selected"
                    close
                    @click="data.select"
                    @click:close="remove(data.item)"
                  >
                    <v-avatar left>
                      <img :src="data.item.profile.profile_headshot_url" />
                    </v-avatar>
                    {{ data.item.profile.display_name }}
                  </v-chip>
                </template>
                <template v-slot:item="data">
                  <template v-if="typeof data.item !== 'object'">
                    <v-list-item-content
                      v-text="data.item"
                    ></v-list-item-content>
                  </template>
                  <template v-else>
                    <v-list-item-avatar>
                      <img :src="data.item.profile.profile_headshot_url" />
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-title
                        v-html="data.item.profile.display_name"
                      ></v-list-item-title>
                    </v-list-item-content>
                  </template>
                </template>
              </v-autocomplete>
            </v-col>
          </v-row>

          <v-row v-if="usersSelected">
            <v-col
              cols="12"
              md="6"
              lg="4"
              v-for="(item, index) in usersSelected"
              :key="index"
              class="pa-3"
            >
              <v-icon
                @click="remove(item)"
                style="
                  z-index: 3;
                  position: absolute;
                  right: 20px;
                  margin-top: 6px;
                  font-size: 20px;
                  cursor: pointer;
                  width: 20px;
                  height: 20px;
                "
                >mdi-close</v-icon
              >
              <v-list three-line style="z-index: 2">
                <template>
                  <v-list-item :key="index">
                    <v-list-item-avatar size="60">
                      <v-img :src="item.profile.profile_headshot_url"></v-img>
                    </v-list-item-avatar>

                    <v-list-item-content>
                      <v-list-item-title>
                        <div
                          style="
                            color: #43425d;
                            font-size: 16px;
                            font-weight: 600;
                          "
                        >
                          {{ item.profile.display_name }}
                        </div>
                        <div
                          style="color: #43425d; font-size: 14px; opacity: 50%"
                        >
                          {{ item.reviews.length }} Reviews
                        </div>
                      </v-list-item-title>
                      <v-list-item-subtitle>
                        <v-row>
                          <v-col class="pa-2" style="z-index: 3">
                            <v-menu top close-on-content-click z-index="11">
                              <template v-slot:activator="{ on, attrs }">
                                <v-icon
                                  v-bind="attrs"
                                  v-on="on"
                                  color="teal"
                                  size="20"
                                  style="
                                    position: absolute;
                                    right: 20px;
                                    cursor: pointer;
                                  "
                                  >mdi-pencil</v-icon
                                >
                              </template>

                              <v-list class="pa-3">
                                <v-list-item
                                  class="d-block"
                                  v-for="(item2, index2) in item.reviews"
                                  :key="index2"
                                  @click="changeReview(item, index, item2)"
                                >
                                  <div
                                    class="px-2"
                                    :style="{
                                      backgroundColor:
                                        item2.id == item.review.id
                                          ? '#E0E0E0'
                                          : '',
                                    }"
                                  >
                                    <v-row>
                                      <v-col class="d-flex pb-0">
                                        <span
                                          class="d-flex align-center"
                                          style="
                                            color: #43425d;
                                            font-size: 16px;
                                            font-weight: 600;
                                          "
                                          >{{ item2.title }}</span
                                        >
                                        <v-rating
                                          :value="item2.rating"
                                          dense
                                          size="18"
                                          color="#F5C250"
                                          class="ml-3"
                                        ></v-rating>
                                      </v-col>
                                    </v-row>
                                    <v-row>
                                      <v-col
                                        class="d-flex py-0"
                                        style="color: #656b72; font-size: 12px"
                                        >{{ item2.text }}</v-col
                                      >
                                    </v-row>
                                  </div>
                                </v-list-item>
                              </v-list>
                            </v-menu>
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col class="d-flex pb-0" style="z-index: 2">
                            <span
                              class="d-flex align-center"
                              style="
                                color: #43425d;
                                font-size: 16px;
                                font-weight: 600;
                              "
                              >{{ item.review.title }}</span
                            >
                            <v-rating
                              :value="item.review.rating"
                              dense
                              size="18"
                              color="#F5C250"
                              class="ml-3"
                            ></v-rating>
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col
                            class="d-flex py-0"
                            style="color: #656b72; font-size: 12px"
                            >{{ item.review.text }}</v-col
                          >
                        </v-row>
                        <v-row>
                          <v-col class="d-flex justify-end">
                            <a
                              target="_blank"
                              v-bind:href="'/' + item.profile.profile_link"
                            >
                              <v-btn rounded color="#8EBEF8" dark>
                                <span
                                  style="
                                    font-size: 12px;
                                    font-weight: 600;
                                    text-transform: capitalize;
                                  "
                                  >Profile</span
                                >
                              </v-btn>
                            </a>
                          </v-col>
                        </v-row>
                      </v-list-item-subtitle>
                    </v-list-item-content>
                  </v-list-item>
                </template>
              </v-list>
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
        </v-container>
      </v-form>
    </v-col>
  </v-row>
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
      nameRules: requireField,
      config: {},
      timezones: [],
      date: null,
      datepicker_menu: null,
      time: null,
      menu2: false,
      loading: false,
      users: [],
      usersSelected: [],
      search: null,
      page: 1,
      lastPage: false,
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
    usersSelected(val, old) {
      if (val.length && !val[val.length - 1].review)
        val[val.length - 1].review = val[val.length - 1].reviews[0];
    },
  },
  methods: {
    // allowedDates: (val) => {
    //   return moment(val).day() == 1;
    // },
    changeReview(item, index, review) {
      let item2 = Object.assign({}, item);
      item2.review = review;
      this.$set(this.usersSelected, index, item2);
    },
    remove(item) {
      let index;
      for (let i = 0; i < this.usersSelected.length; i++) {
        if (this.usersSelected[i].id == item.id) {
          index = i;
          break;
        }
      }
      if (index >= 0) this.usersSelected.splice(index, 1);
    },
    customFilter(item, queryText, itemText) {
      const textOne = item.profile.display_name.toLowerCase();
      // const textTwo = item.email.toLowerCase();
      const searchText = queryText.toLowerCase();

      return (
        textOne.indexOf(searchText) > -1 // || textTwo.indexOf(searchText) > -1
      );
    },
    sendEmail() {
      if (
        this.config.emails &&
        confirm(`Are you ready to send to ${this.config.emails} clients?`)
      ) {
        this.save().then(() => {
          this.loading = true;
          axios
            .post("/api/admin/email/send/top-rate")
            .then((response) => {})
            .catch(function (error) {})
            .finally(() => (this.loading = false));
        });
      }
    },
    save() {
      if (!this.$refs.config.validate()) return;

      this.loading = true;

      this.config.users = this.usersSelected.map((i) => {
        return { id: i.id, review: i.review.id };
      });

      return axios
        .post("/api/admin/email/save/top-rate-config", this.config)
        .then((response) => {})
        .catch(function (error) {})
        .finally(() => (this.loading = false));
    },
  },
  async created() {
    await axios
      .get("/api/admin/email/top-rate-config")
      .then((response) => {
        this.timezones = response.data.timezones;
        if (response.data.config) {
          this.config = response.data.config;
          if (this.config.date) {
            this.config.time = this.config.date
              ? moment(this.config.date).format("HH:mm")
              : null;
            this.config.date = this.config.date
              ? moment(this.config.date).format("YYYY-MM-DD")
              : null;
          }
        }
      })
      .catch(function (error) {});

    while (!this.lastPage || this.page < this.lastPage) {
      await axios
        .get("/api/admin/email/user-select?page=" + this.page++)
        .then((response) => {
          if (!this.lastPage) this.lastPage = response.data.meta.last_page;
          this.users.push(...response.data.data);
        })
        .catch(function (error) {});
    }

    if (this.config.users) {
      this.users.forEach((i) => {
        let item = this.config.users.filter((i2) => i2.id == i.id);
        if (item.length) {
          let review = i.reviews.filter((r) => {
            return r.id == item[0].review;
          });
          if (review.length) {
            item = Object.assign({}, i);
            item.review = Object.assign({}, review[0]);
            this.usersSelected.push(item);
          }
        }
      });
    }
  },
};
</script>

