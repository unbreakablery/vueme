<template>
  <div
    class="search-container d-flex justify-center"
  >
    <div
      v-if="showInput"
      @click="hideFilter"
      style="
        background: transparent;
      "
    ></div>
    <div style="z-index: 90" class="d-flex justify-center w-100">
      <v-row>
        <v-col
          class="d-flex align-center text--black px-0"
          style="font-weight: 600;"
        >
          <v-text-field
            style="width: 265px"
            v-if="showInput"
            v-model="search"
            class="search-input"
            height="40px"
            label="Search for a Model…"
            solo
            rounded
            v-on:keyup.enter="onEnter"
          >
            <template v-slot:append>
              <img
                @click="showFilter"
                class="cursor-pointer"
                width="40"
                height="40"
                src="/images/icons/search_filter.png"
                alt=""
              />
            </template>
          </v-text-field>
          <a
            v-if="!searchPage && showInput"
            :href="getParamUrl"
            style="text-decoration: none;"
          >
            <v-btn
              class="mx-2"
              dark
              height="40"
              width="40"
              color="#8EBEF8"
              style="border-radius: 10px; width: 40px; min-width: 40px;"
            >
              <v-icon dark size="20"> mdi-magnify </v-icon>
            </v-btn>
          </a>
          <v-icon
            v-else-if="!showInput"
            @click="showInput = true"
            dark
            size="20"
            style="
              border-radius: 10px;
              font-weight: 600;
              color: #000;
            "
          >
            mdi-magnify</v-icon
          >Search
        </v-col>
      </v-row>
    </div>
  </div>
</template>
<script>
import { mapGetters } from "vuex";

export default {
  props: ["searchPage", "terms", "setFilters"],
  data: () => ({
    filter: {},
    search: null,

    timeout: null,
    prevSearch: "",
    stopSearch: true,
    filterActive: false,
    showInput: true,
  }),

  computed: {
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

    onEnter() { 
      if (!this.searchPage || this.menu) window.location = this.getParamUrl;
    },
    setTerms() {
      if (this.terms.ability)
        this.terms.ability = this.terms.ability
          .split(",")
          .map((i) => parseInt(i));
      if (this.terms.category)
        this.terms.category = this.terms.category
          .split(",")
          .map((i) => parseInt(i));
      if (this.terms.tool)
        this.terms.tool = this.terms.tool.split(",").map((i) => parseInt(i));
      if (this.terms.style)
        this.terms.style = this.terms.style.split(",").map((i) => parseInt(i));
      if (this.terms.language)
        this.terms.language = this.terms.language
          .split(",")
          .map((i) => parseInt(i));
      this.filter = this.terms.length == 0 ? {} : this.terms;
      if (this.terms.search) this.search = this.terms.search;

      this.searching();
    },
    searching() {
      this.filter.search = this.search;
      this.setFilters(this.filter ? this.filter : []);
    },
    showFilter() {
      if (this.$vuetify.breakpoint.xsOnly)
        EventBus.$emit("filter_show_header", true);
      else {
        this.filterActive = !this.filterActive;
        EventBus.$emit("filter_show_header", this.filterActive);
      }
    },

    hideFilter() {
      this.showInput = false;
    },
  },
  watch: {
    search() {
      EventBus.$emit("set_search2_header", this.search);

      if (!this.searchPage) return;

      if (this.loading) return;

      if (!this.search) {
        this.searching();
        return;
      }
      if (this.search.length < 3) {
        this.prevSearch = this.search;
        return;
      }
      if (
        this.prevSearch.length > this.search.length &&
        this.prevSearch.indexOf(this.search) == 0
      ) {
        this.prevSearch = this.search;
        return;
      }
      this.prevSearch = this.search;

      clearTimeout(this.timeout);

      // if (!this.stopSearch)
      this.timeout = setTimeout(() => {
        this.searching();
      }, 1000);
    },
  },

  created() {
    if (this.searchPage) this.setTerms();
    this.showInput = false;

    EventBus.$on("set_filter_header", (data) => {
      this.filter = data;
      if (this.searchPage) this.searching();
    });

    EventBus.$on("hide_filter_header", (data) => {
      this.filterActive = false;
    });

    EventBus.$on("get_filter_header", () => {
      if (Object.keys(this.filter).length > 1 || this.filter.search)
        this.filterActive = true;
      EventBus.$emit("ini_filter_header", this.filter);
    });

    EventBus.$on("set_search_header_header", (search) => {
      this.search = search;
    });
  },
};
</script>

<style>
.search-input {
  max-height: 40px;
}
.search-input .v-label,
.search-input input {
  color: #43425d !important;
  font-size: 14px;
  font-weight: 500;
  padding-left: 15px;
}

.search-container {
  z-index: 3;
}
.search-menu .v-input__slot {
  background-color: #f4f4f4 !important;
}
</style>