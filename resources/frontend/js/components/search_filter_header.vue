<template>
  <div>
    <v-card
      v-if="show"
      width="372"
      style="
        background-color: #ccc;
        position: absolute;
        top: 51px;
        left: -44%;
        border-radius: 25px !important;
        z-index: 10;
      "
      class="pa-5"
    >
      <div style="z-index: 101">
        <v-row class="mt-0">
          <v-col cols="12" class="px-3 d-flex justify-start">
            <label
              for="Filters"
              style="color: #000; font-size: 14px; font-weight: 600"
              >Filters</label
            >
            <v-icon
              @click="hideFilter"
              color="#000"
              style="
                position: absolute;
                right: 10px;
                font-size: 20px;
                cursor: pointer;
              "
              >mdi-close</v-icon
            >
          </v-col>
        </v-row>
        <v-row class="mt-5">
          <v-col cols="6" class="px-3">
            <label
              style="
                color: #000 !important;
                font-size: 12px !important;
                font-weight: 600;
              "
              >Specialties</label
            >
            <v-select
              v-model="category"
              :items="ablilities"
              label="Select"
              filled
              background-color="#FFFFFF"
              class="blueCheckList"
              dense
              solo
              :height="32"
              item-text="name"
              item-value="slug"
              clearable
              multiple
            >
              <template v-slot:selection="{ item, index }">
                <div
                  v-if="index == 0"
                  class="v-select__selection v-select__selection--comma"
                >
                  {{ category.length }} Selected
                </div>
              </template>
            </v-select>
          </v-col>

          <v-col cols="6" class="px-3">
            <label
              style="
                color: #000 !important;
                font-size: 12px !important;
                font-weight: 600;
              "
              >Abilities</label
            >
            <v-select
              v-model="ability"
              :items="categories"
              label="Select"
              filled
              background-color="#FFFFFF"
              class="blueCheckList"
              dense
              solo
              :height="32"
              item-text="name"
              item-value="slug"
              clearable
              multiple
            >
              <template v-slot:selection="{ item, index }">
                <div
                  v-if="index == 0"
                  class="v-select__selection v-select__selection--comma"
                >
                  {{ ability.length }} Selected
                </div>
              </template>
            </v-select>
          </v-col>
        </v-row>

        <v-row class="mt-5">
          <v-col class="px-3">
            <label
              style="
                color: #000 !important;
                font-size: 12px !important;
                font-weight: 600;
              "
              >Tools</label
            >
            <v-select
              v-model="tool"
              :items="tools"
              label="Select"
              filled
              background-color="#FFFFFF"
              class="blueCheckList"
              dense
              solo
              :height="32"
              item-text="name"
              item-value="slug"
              clearable
              multiple
            >
              <template v-slot:selection="{ item, index }">
                <div
                  v-if="index == 0"
                  class="v-select__selection v-select__selection--comma"
                >
                  {{ tool.length }} Selected
                </div>
              </template>
            </v-select>
          </v-col>

          <v-col class="px-3">
            <label
              style="
                color: #000 !important;
                font-size: 12px !important;
                font-weight: 600;
              "
              >Language</label
            >
            <v-select
              v-model="language"
              :items="languages"
              label="Select"
              filled
              background-color="#FFFFFF"
              class="blueCheckList"
              dense
              solo
              :height="32"
              item-text="name"
              item-value="slug"
              clearable
              multiple
            >
              <template v-slot:selection="{ item, index }">
                <div
                  v-if="index == 0"
                  class="v-select__selection v-select__selection--comma"
                >
                  {{ language.length }} Selected
                </div>
              </template>
            </v-select>
          </v-col>
        </v-row>

        <v-row class="mt-5">
          <v-col class="d-flex align-end">
            <v-btn
              @click="online = !online"
              rounded
              small
              height="30"
              text-color="#1F1E34"
              style="
                font-weight: 500 !important;
                font-size: 12px !important;
                padding: 8px 5px;
              "
              :style="{
                backgroundColor: online
                  ? '#C1DBFB !important'
                  : '#ffffff !important',
              }"
              class="my-2"
            >
              <span style="opacity: 0.5">Online</span>
            </v-btn>

            <v-btn
              @click="chat = !chat"
              rounded
              small
              height="30"
              text-color="#1F1E34"
              style="
                font-weight: 500 !important;
                font-size: 12px !important;
                padding: 8px 5px;
                margin-left: 8px;
              "
              :style="{
                backgroundColor: chat
                  ? '#C1DBFB !important'
                  : '#ffffff !important',
              }"
              class="my-2"
            >
              <i class="far fa-comments" style="color: #000; font-size: 15px" aria-hidden="true"></i>
            </v-btn>

            <v-btn
              @click="video = !video"
              rounded
              small
              height="30"
              text-color="#1F1E34"
              style="
                font-weight: 500 !important;
                font-size: 12px !important;
                padding: 8px 5px;
                margin-left: 8px;
              "
              :style="{
                backgroundColor: video
                  ? '#C1DBFB !important'
                  : '#ffffff !important',
              }"
              class="my-2"
            >
              <v-icon size="20" color="#000">mdi-video-outline</v-icon>
            </v-btn>

            <v-btn
              @click="call = !call"
              rounded
              small
              height="30"
              text-color="#1F1E34"
              style="
                background-color: #ffffff !important;
                font-weight: 500 !important;
                font-size: 12px !important;
                padding: 8px 5px;
                margin-left: 8px;
              "
              :style="{
                backgroundColor: call
                  ? '#C1DBFB !important'
                  : '#ffffff !important',
              }"
              class="my-2"
            >
              <v-icon size="20" color="#000">mdi-phone-outline</v-icon>
            </v-btn>
          </v-col>
        </v-row>

        <v-row class="mt-5">
          <v-col cols="6" class="px-3">
            <label
              style="
                color: #000 !important;
                font-size: 12px !important;
                font-weight: 600;
              "
              >Style</label
            >
            <v-select
              v-model="style"
              :items="styles"
              label="Select"
              filled
              background-color="#FFFFFF"
              class="blueCheckList"
              dense
              solo
              :height="32"
              item-text="name"
              item-value="slug"
              clearable
              multiple
            >
              <template v-slot:selection="{ item, index }">
                <div
                  v-if="index == 0"
                  class="v-select__selection v-select__selection--comma"
                >
                  {{ style.length }} Selected
                </div>
              </template>
            </v-select>
          </v-col>

          <v-col cols="6" class="px-3">
            <label
              style="
                color: #000 !important;
                font-size: 12px !important;
                font-weight: 600;
              "
              >Rate</label
            >
            <v-select
              v-model="price"
              hide-details
              :items="prices"
              label="Select"
              filled
              background-color="#FFFFFF"
              class="blueCheckList"
              dense
              solo
              :height="32"
              clearable
            >
              <template v-slot:selection="{ item }">
                <div
                  class="v-select__selection v-select__selection--comma"
                  v-if="item.min == '-1'"
                >
                  ${{ item.max }} or less
                </div>
                <div
                  class="v-select__selection v-select__selection--comma"
                  v-else-if="item.max == '-1'"
                >
                  ${{ item.min }} or more
                </div>
                <div
                  class="v-select__selection v-select__selection--comma"
                  v-else
                >
                  ${{ item.min }} to ${{ item.max }}
                </div>
              </template>
              <template v-slot:item="{ item }">
                <!-- <div v-if="item.min == '-1'" style="color:#000">${{item.max}} or less</div>
                <div v-else-if="item.max == '-1'" style="color:#000">${{item.min}} or more</div>
                <div v-else style="color:#000">${{item.min}} to ${{item.max}}</div> -->
                <div v-if="item.min == '-1'" class="v-list-item__content">
                  <div class="v-list-item__title">${{ item.max }} or less</div>
                </div>
                <div v-else-if="item.max == '-1'" class="v-list-item__content">
                  <div class="v-list-item__title">${{ item.min }} or more</div>
                </div>
                <div v-else class="v-list-item__content">
                  <div class="v-list-item__title">
                    ${{ item.min }} to ${{ item.max }}
                  </div>
                </div>
              </template>
            </v-select>
          </v-col>
        </v-row>

        <v-row class="mt-5">
          <v-col cols="12" class="d-flex justify-center">
            <a
              v-if="!searchPage"
              :href="getParamUrl"
              style="text-decoration: none"
            >
              <v-btn class="mx-2" dark color="#8EBEF8" rounded> Apply </v-btn>
            </a>
            <v-btn
              v-else
              @click="show = false"
              class="mx-2"
              dark
              color="#8EBEF8"
              rounded
            >
              Apply
            </v-btn>
          </v-col>
        </v-row>
      </div>
    </v-card>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  props: ["searchPage"],
  data: () => ({
    prices: [
      { min: -1, max: 1 },
      { min: 2, max: 3 },
      { min: 4, max: 5 },
      { min: 6, max: -1 },
    ],
    services: [],
    languages: [],
    categories: [],
    ablilities: [],
    tools: [],
    styles: [],

    service: null,
    category: null,
    ability: null,
    price: null,
    tool: null,
    style: null,
    language: null,
    call: false,
    video: false,
    chat: false,
    online: false,

    search: null,
    timeout: null,
    prevSearch: "",
    stopSearch: true,
    show: false,
  }),

  computed: {
    filter() {
      let param = {};
      if (this.price) {
        param.min = this.price.min;
        param.max = this.price.max;
      }
      if (this.category) param.category = this.category.filter(i => i);
      if (this.service) param.service = this.service.filter(i => i);
      if (this.tool) param.tool = this.tool.filter(i => i);
      if (this.style) param.style = this.style.filter(i => i);
      if (this.language) param.language = this.language.filter(i => i);
      if (this.ability) param.ability = this.ability.filter(i => i);
      if (this.online) param.online = this.online;
      if (this.call) param.call = this.call;
      if (this.chat) param.chat = this.chat;
      if (this.video) param.video = this.video;

      return param;
    },
    getParamUrl: function () {
      let query = "/search?",
        first = true;
      for (const prop in this.filter) {
        if (first) query += `${prop}=${this.filter[prop]}`;
        else query += `&${prop}=${this.filter[prop]}`;
        first = false;
      }
      if (this.search) query += "&search=" + this.search;
      return query;
    },
  },

  methods: {
    hideFilter() {
      this.show = false;
      EventBus.$emit("hide_filter_header");
    },
  },

  watch: {
    filter() {
      EventBus.$emit("set_filter_header", this.filter);
    },
    search() {
      if (!this.search) {
        EventBus.$emit("set_search_header", this.search);
        return;
      }

      clearTimeout(this.timeout);

      this.timeout = setTimeout(() => {
        EventBus.$emit("set_search_header", this.search);
      }, 1000);
    },
  },
  created() {
    EventBus.$on("filter_show_header", (data) => {
      if(this.$vuetify.breakpoint.mdAndUp)
      this.show = data;
    });

    EventBus.$on("set_search2_header", (data) => {
      this.search = data;
    });

    EventBus.$on("ini_filter_header", (data) => {
      if (data) {
        if (typeof data == "object") {
          
          for (const prop in data) {
            if (prop == "min" || prop == "max") continue;
            this[prop] = data[prop];
          }
          if (data.min || data.max)
            this.price = {
              min: parseInt(data.min),
              max: parseInt(data.max),
            };
        }
      }
    });

    EventBus.$emit("get_filter_header");

    this.$store
      .dispatch("util/getTableList", {
        query: { table: "specialties", fields: ["id", "name", "slug"] },
      })
      .then((response) => {
        this.ablilities = response.data.data;
      });
    this.$store
      .dispatch("util/getTableList", {
        query: { table: "category", fields: ["id", "name", "slug"] },
      })
      .then((response) => {
        this.categories = response.data.data;
      });
    this.$store
      .dispatch("util/getTableList", {
        query: { table: "tools", fields: ["id", "name", "slug"] },
      })
      .then((response) => {
        this.tools = response.data.data;
      });
    this.$store
      .dispatch("util/getTableList", {
        query: { table: "languages", fields: ["id", "name", "slug"] , where: {status: 1}},
      })
      .then((response) => {
        this.languages = response.data.data;
      });
    this.$store
      .dispatch("util/getTableList", {
        query: { table: "styles", fields: ["id", "name", "slug"] },
      })
      .then((response) => {
        this.styles = response.data.data;
      });
  },
};
</script>
<style>
.dialog-search {
  margin: 24px 5px !important;
  border-radius: 25px !important;
}
</style>