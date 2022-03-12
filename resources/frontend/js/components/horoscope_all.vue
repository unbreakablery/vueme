<template>
  <section class="bannerHoroscope">
    <v-container class="my-3 front">
      <v-row
        justify="space-around"
        :class="!mobile ? 'mt-5 px-4' : 'mt-0 px-4'"
        class="mb-2"
      >
        <v-col cols="12" class="h3 mb-0 d-flex align-center">
          <h2 class="mb-0">Select Your Zodiac Sign</h2>
        </v-col>
      </v-row>
      <v-row class="">
        <div
          class="col-4 col-sm-2 p-0"
          v-for="(item, index) in horoscopes"
          :key="index"
        >
          <v-hover v-slot:default="{ hover }" class="ability_card">
            <a :href="'/horoscope/' + item.slug" style="text-decoration: none">
              <v-row
                class="ma-0 text-center"
                :style="
                  $vuetify.breakpoint.xsOnly
                    ? 'width: 110px; margin: 0px auto !important;'
                    : 'width: 80%;margin: 0px auto !important; '
                "
              >
                <v-col
                  cols="12"
                  class="align-sm-center justify-sm-center sm4 p-0"
                >
                  <img
                    :alt="item.name + ' Zodiac Sign'"
                    :src="'/images/horoscopes/' + (hover ? 'link_' : '') + item.logo"
                        @mouseover="mobile ? '' : hover = true"
                        @mouseleave="mobile ? '' : hover = false"
                        @click="!mobile ? '' : hover = true"
                  />
                </v-col>
                <v-col cols="12" class="align-center text-center p-0 mt-1">
                  <div
                    class="description"
                    style="opacity: 1; font-weight: 600; font-size: 12px"
                  >
                    {{ item.name }}
                  </div>
                  <div
                    class="description"
                    style="font-weight: 400; font-size: 12px"
                  >
                    {{ item.start_period }} - {{ item.end_period }}
                  </div>
                </v-col>
              </v-row>
            </a>
          </v-hover>
        </div>
      </v-row>
      <!-- </v-window-item>
      </v-window> -->
    </v-container>
  </section>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      horoscopes: [],
      hover: false,
    };
  },
  props: [],
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
      paginate2: "horoscope/items",
    }),
  },

  watch: {


    
  },
  methods: {
    
  },
  created() {
    this.$store.dispatch("horoscope/getItems").then(() => {
      this.horoscopes = this.paginate2.data;
    });
  },
};
</script>

