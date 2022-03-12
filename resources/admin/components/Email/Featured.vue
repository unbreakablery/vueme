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
                v-model="userSelected"
                :items="users"
                hide-no-data
                hide-selected
                label="Select models"
                placeholder="Start typing to Search"
                return-object
                clearable
                :filter="customFilter"
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
                    @click:close="userSelected = null"
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
                    <!-- <v-list-item-avatar height="100%" min-height="100%" style="position: absolute;"> -->
                    <img
                      :src="data.item.profile.profile_headshot_url"
                      style="position: absolute; top: 14px; border-radius: 50%"
                      height="40"
                      width="40"
                    />
                    <!-- </v-list-item-avatar> -->
                    <v-list-item-content
                      style="max-width: 400px; margin-left: 50px"
                    >
                      <v-row>
                        <v-col cols="12" class="py-0">
                          <v-list-item-title
                            v-html="data.item.profile.display_name"
                          ></v-list-item-title>
                        </v-col>
                        <v-col cols="12" class="py-0" v-if="data.item.reviews">
                          <div class="d-inline-block">
                            <v-rating
                              :value="ratingAvg(data.item.reviews)"
                              dense
                              size="18"
                              color="#F5C250"
                            ></v-rating>
                          </div>
                          <span
                            v-if="data.item.reviews"
                            style="
                              color: #43425d;
                              font-size: 14px;
                              opacity: 50%;
                            "
                            >{{ data.item.reviews.length }} Reviews</span
                          >
                          <div class="mt-2" style="color: #43425d">
                            {{ getCategories(data.item.categories) }}
                          </div>
                          <div
                            class="mt-2"
                            style="color: #43425d"
                            v-if="data.item.profile.description"
                          >
                            {{
                              data.item.profile.description.length > 200
                                ? data.item.profile.description.substring(
                                    1,
                                    200
                                  ) + "..."
                                : data.item.profile.description
                            }}
                          </div>
                        </v-col>
                      </v-row>
                      <v-divider></v-divider>
                    </v-list-item-content>
                  </template>
                </template>
              </v-autocomplete>
            </v-col>
          </v-row>

          <v-row v-if="userSelected">
            <v-col cols="12" md="6" class="pa-3">
              <v-icon
                @click="userSelected = null"
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
                  <v-list-item>
                    <v-list-item-avatar size="60">
                      <v-img
                        :src="userSelected.profile.profile_headshot_url"
                      ></v-img>
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
                          {{ userSelected.profile.display_name }}
                        </div>
                        <div
                          class="d-flex align-center"
                          v-if="userSelected.reviews"
                          style="color: #43425d; font-size: 14px"
                        >
                          <v-rating
                            :value="ratingAvg(userSelected.reviews)"
                            dense
                            size="18"
                            color="#F5C250"
                          ></v-rating>
                          <span class="ml-3" style="opacity: 50%"
                            >{{ userSelected.reviews.length }} Reviews</span
                          >
                        </div>
                      </v-list-item-title>
                      <v-list-item-subtitle>
                        <v-row>
                          <v-col class="d-flex pb-0" style="z-index: 2">
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col
                            class="d-flex py-0"
                            style="color: #656b72; font-size: 12px"
                            >{{ getCategories(userSelected.categories) }}</v-col
                          >
                        </v-row>
                        <v-row>
                          <v-col class="d-flex justify-end py-0">
                            <v-icon
                              @click="dialog = true"
                              color="teal"
                              size="20"
                              style="cursor: pointer"
                              >mdi-pencil</v-icon
                            >
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col class="d-flex">
                            {{ userSelected.profile.description }}
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
      <v-dialog v-model="dialog" max-width="700px">
        <v-card>
          <v-card-text>
            <v-container class="pb-0">
              <v-form ref="sign">
                <v-row>
                  <v-col cols="12" class="py-0 pt-5">
                    <v-textarea
                      v-model="description"
                      :rules="nameRules"
                      required
                      outlined
                      name="input-7-5"
                      label="Description"
                    ></v-textarea>
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
            <v-btn color="blue darken-1" text @click="saveDescription()"
              >Save</v-btn
            >
          </v-card-actions>
        </v-card>
      </v-dialog>
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
      userSelected: null,
      search: null,
      dialog: false,
      description: null,
      page: 1,
      lastPage: false,

    };
  },
  watch: {
    dialog(val) {
      if (val) {
        this.description = this.userSelected.profile.description;
      }
    },
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
  methods: {
    saveDescription() {
      this.userSelected.profile.description = this.description;
      this.dialog = false;
    },
    getCategories(categories) {
      if (!categories) return "";
      let html = "";
      for (let i = 0; i < categories.length; i++) {
        if (i > 0) html = html + ` • ${categories[i].name}`;
        else html = `${categories[i].name}`;
      }

      return html;
    },
    ratingAvg(reviews) {
      if (!reviews || reviews.length == 0) return 0;
      return (
        reviews.reduce((a, b) => {
          return a.rating ? a.rating + b.rating : a + b.rating;
        }) / reviews.length
      );
    },
    customFilter(item, queryText) {
      const textOne = item.profile.display_name.toLowerCase();
      const searchText = queryText.toLowerCase();
      return textOne.indexOf(searchText) > -1;
    },
    sendEmail() {
      if (
        this.config.emails &&
        confirm(`Are you ready to send to ${this.config.emails} clients?`)
      ) {
        this.save().then(() => {
          this.loading = true;
          axios
            .post("/api/admin/email/send/featured")
            .then((response) => {})
            .catch(function (error) {})
            .finally(() => (this.loading = false));
        });
      }
    },
    save() {
      if (!this.$refs.config.validate()) return;

      this.loading = true;

      this.config.users = this.userSelected
        ? [this.userSelected].map((i) => {
            return { id: i.id, description: i.profile.description };
          })
        : null;

      return axios
        .post("/api/admin/email/save/featured-config", this.config)
        .then((response) => {})
        .catch(function (error) {})
        .finally(() => (this.loading = false));
    },
  },
  async created() {

    await axios
      .get("/api/admin/email/featured-config")
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
          i.profile.description = item[0].description;
          item = Object.assign({}, i);
          this.userSelected = item;
        }
      });
    }
  },
};
</script>

