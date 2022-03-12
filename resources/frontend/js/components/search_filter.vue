<template>
  <div>
    <div
      v-if="$vuetify.breakpoint.mdAndUp && show"
      style="height: 96px; background: #f4f4f4"
    >
      <v-container>
        <v-row>
          <v-col cols="9">
            <v-row>
              <v-col class="px-1">
                <label style="color: #a2a2a2; font-size: 12px; font-weight: 600"
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

              <v-col class="px-1">
                <label style="color: #a2a2a2; font-size: 12px; font-weight: 600"
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

              <v-col class="px-1">
                <label style="color: #a2a2a2; font-size: 12px; font-weight: 600"
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

              <v-col class="px-1">
                <label style="color: #a2a2a2; font-size: 12px; font-weight: 600"
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

              <v-col class="px-1">
                <label style="color: #a2a2a2; font-size: 12px; font-weight: 600"
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

              <v-col class="px-1">
                <label style="color: #a2a2a2; font-size: 12px; font-weight: 600"
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
                    <!-- <div v-if="item.min == '-1'" style="color:#A2A2A2">${{item.max}} or less</div>
                <div v-else-if="item.max == '-1'" style="color:#A2A2A2">${{item.min}} or more</div>
                <div v-else style="color:#A2A2A2">${{item.min}} to ${{item.max}}</div> -->
                    <div v-if="item.min == '-1'" class="v-list-item__content">
                      <div class="v-list-item__title">
                        ${{ item.max }} or less
                      </div>
                    </div>
                    <div
                      v-else-if="item.max == '-1'"
                      class="v-list-item__content"
                    >
                      <div class="v-list-item__title">
                        ${{ item.min }} or more
                      </div>
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
          </v-col>
          <v-col cols="3" class="d-flex align-end" style="padding-left: 4px">
            <v-row>
              <v-col class="d-flex align-end px-1">
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
                  <i class="far fa-comments" style="color: #9696A0; font-size: 15px" aria-hidden="true"></i>
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
                  <v-icon size="20" color="#9696A0">mdi-video-outline</v-icon>
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
                  <v-icon size="20" color="#9696A0">mdi-phone-outline</v-icon>
                </v-btn>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
      </v-container>
    </div>
    <v-dialog
      v-else-if="show"
      content-class="dialog-search"
      v-model="show"
      width="100%"
      persistent
    >
      <v-card style="background-color: #f4f4f4" class="pa-5">
        <v-row>
          <v-col style="height: 50px;" class="w-100 pt-0">
            <v-icon
              @click="hideFilter"
              color="#A2A2A2"
              style="
                position: absolute;
                right: 10px;
                font-size: 20px;
                cursor: pointer;
              "
              >mdi-close</v-icon
            >
          </v-col></v-row>
        
        <v-row>
          <v-col class="d-flex justify-center">
            <v-row style="max-width: 321px">
              <v-col
                class="d-flex align-center text--grey px-0"
                style="height: 40px; min-width: auto; max-width: 321px"
              >
                <v-text-field
                  v-model="search"
                  class="search-input"
                  height="40px"
                  label="Search for a Model…"
                  solo
                  rounded
                >
                  <!-- <template v-slot:append>
                    <img @click="show = false"
                      class="cursor-pointer"
                      width="40"
                      height="40"
                      src="/images/icons/search_filter.png"
                      alt=""
                    />
                  </template> -->
                </v-text-field>
                <a
                  v-if="!searchPage"
                  :href="getParamUrl"
                  style="text-decoration: none"
                >
                  <v-btn
                    class="mx-2"
                    dark
                    height="40"
                    width="40"
                    color="#8EBEF8"
                    style="border-radius: 10px; width: 40px; min-width: 40px"
                  >
                    <v-icon dark size="20"> mdi-magnify </v-icon>
                  </v-btn>
                </a>
                <v-btn
                  v-else
                  @click="show = false"
                  class="mx-2"
                  dark
                  height="40"
                  width="40"
                  color="#8EBEF8"
                  style="border-radius: 10px; width: 40px; min-width: 40px"
                >
                  <v-icon dark size="20"> mdi-magnify </v-icon>
                </v-btn>
              </v-col>
            </v-row>
          </v-col>
        </v-row>

        <v-row class="mt-15">
          <v-col cols="6" class="px-3">
            <label
              style="
                color: #a2a2a2 !important;
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
                color: #a2a2a2 !important;
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
                color: #a2a2a2 !important;
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
                color: #a2a2a2 !important;
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
              <i class="far fa-comments" style="color: #9696A0; font-size: 15px" aria-hidden="true"></i>              
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
              <v-icon size="20" color="#9696A0">mdi-video-outline</v-icon>
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
              <v-icon size="20" color="#9696A0">mdi-phone-outline</v-icon>
            </v-btn>
          </v-col>
        </v-row>

        <v-row class="mt-5">
          <v-col cols="6" class="px-3">
            <label
              style="
                color: #a2a2a2 !important;
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
                color: #a2a2a2 !important;
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
                <!-- <div v-if="item.min == '-1'" style="color:#A2A2A2">${{item.max}} or less</div>
                <div v-else-if="item.max == '-1'" style="color:#A2A2A2">${{item.min}} or more</div>
                <div v-else style="color:#A2A2A2">${{item.min}} to ${{item.max}}</div> -->
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
      </v-card>
    </v-dialog>
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
      EventBus.$emit("hide_filter");
    },
  },

  watch: {
    filter() {
      EventBus.$emit("set_filter", this.filter);
    },
    search() {
      if (!this.search) {
        EventBus.$emit("set_search", this.search);
        return;
      }

      clearTimeout(this.timeout);

      this.timeout = setTimeout(() => {
        EventBus.$emit("set_search", this.search);
      }, 1000);
    },
  },
  created() {
    EventBus.$on("filter_show", (data) => {
      this.show = data;
    });

    EventBus.$on("set_search2", (data) => {
      this.search = data;
    });

    EventBus.$on("ini_filter", (data) => {
      if (data) {
        if (typeof data == "object") {
          if (
            this.$vuetify.breakpoint.mdAndUp && this.searchPage
          )
            this.show = true;
          for (const prop in data) {
            if (prop == "min" || prop == "max") continue;
            this[prop] = data[prop];
            // isNaN(data[prop]) || !data[prop]
            //   ? data[prop]
            //   : parseInt(data[prop]);
          }
          if (data.min || data.max)
            this.price = {
              min: parseInt(data.min),
              max: parseInt(data.max),
            };
        }
      }
    });

    EventBus.$emit("get_filter");

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
        query: { table: "languages", fields: ["id", "name", "slug"], where: {status: 1} },
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