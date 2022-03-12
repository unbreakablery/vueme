<template>
  <div class="homepages">
  
    <v-container class="my-3 front" >

      <v-row
        justify="space-around"
        :class="!mobile ? 'mt-5 px-4' : 'mt-0 px-4'"
        class="mb-2"
      >
        <v-col cols="9" class="h3 mb-0 d-flex align-center">
          <h4 class="mb-0">Popular Model Abilities</h4>
        </v-col>
        <v-col class="h3 mb-0 text-lg-right cursor-pointer">
          <div
            class="d-flex justify-end align-center"
            style="font-size: 30px; color: #43425d"
            @click="nextAbilities"
          >
            <span>&#8226;</span>
            <span>&#8226;</span>
            <span>&#8226;</span>
          </div>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <swiper v-if="!$vuetify.breakpoint.xsOnly" ref="mySwiper" :options="swiperOptions">
            <swiper-slide v-for="(item, index) in items" :key="index">
              <div class="my-2 ability_card" :key="index" style="height: 100%">
                <v-hover v-if="!item.loading" v-slot:default="{ hover }">
                  <a
                    :href="'/search?ability=' + item.slug"
                    style="text-decoration: none"
                  >
                    <v-row class="ma-0 text-center">
                      <v-col
                        cols="12"
                        class="align-sm-center justify-sm-center sm4 p-0"
                      >
                        <img
                          :alt="item.image.name + ' File'"
                          v-bind:src="'/files/' + item.image.path"
                          
                        />
                      </v-col>
                      <v-col
                        cols="12"
                        class="align-center text-center p-0 mt-1"
                      >
                        <div class="description" style="">
                          {{ item.description }}
                        </div>
                      </v-col>
                    </v-row>
                  </a>
                </v-hover>
                <v-skeleton-loader
                  v-else
                  height="100"
                  type="image"
                  class="mx-auto"
                ></v-skeleton-loader>
              </div>
            </swiper-slide>
          </swiper>

          <swiper v-else ref="mySwiper" :options="swiperOptions">
            <swiper-slide v-for="(item2, index) in items" :key="index">
              <div class="my-2 ability_card" style="height: 100px" v-for="(item, index2) in item2" :key="index2">
                <v-hover v-if="!item.loading" v-slot:default="{ hover }">
                  <a
                    :href="'/search?ability=' + item.slug"
                    style="text-decoration: none"
                  >
                    <v-row class="ma-0 text-center">
                      <v-col
                        cols="12"
                        class="align-sm-center justify-sm-center sm4 p-0"
                      >
                        <img
                          :alt="item.image.name + ' File'"
                          v-bind:src="'/files/' + item.image.path"
                          style=""
                        />
                      </v-col>
                      <v-col
                        cols="12"
                        class="align-center text-center p-0 mt-1"
                      >
                        <div class="description" style="">
                          {{ item.description }}
                        </div>
                      </v-col>
                    </v-row>
                  </a>
                </v-hover>
                <v-skeleton-loader
                  v-else
                  height="100"
                  type="image"
                  class="mx-auto"
                ></v-skeleton-loader>
              </div>
            </swiper-slide>
          </swiper>
        </v-col>
      </v-row>
      <!-- </v-window-item>
      </v-window> -->
    </v-container>


  </div>
</template>

<script>
import { mapGetters } from "vuex";
import ListItems from "./specialtie_user_list.vue";
import { Swiper, SwiperSlide } from "vue-awesome-swiper";
import "swiper/swiper-bundle.css";

export default {
  data() {
    return {
      window: 0,
      window1: 0,
      online: true,
      featured: true,
      categories: [],
      items: [],
      specialties: [],
      horoscopes: [],
      specialtiesList: [],
      links: [
        "/specialty/psychic",
        "/specialty/medium",
        "/specialty/astrology",
        "/specialty/palm-reading",
        "/specialty/tarot-card-reader",
        "/specialty/clairvoyant",
        "/specialty/spiritual-healer",
      ],
      filter: false,
      swiperOptions: {
        loop: true,
        breakpoints: {
          // when window width is >= 320px
          320: {
            slidesPerView: 5,
          },
          // when window width is >= 960
          960: {
            slidesPerView: 6,
          },
          // when window width is >= 1264
          1264: {
            slidesPerView: 9,
          },
        },
      },
    };
  },
  components: {
    ListItems,
    Swiper,
    SwiperSlide,
  },
  computed: {
    swiper() {
      return this.$refs.mySwiper.$swiper;
    },
    ...mapGetters({
      mobile: "util/mobile",
      paginate: "category/items",
    }),
  },

  watch: {},
  methods: {
    nextAbilities() {
      this.swiper.slideNext();
    },
    
    getLoadingArray() {
      let array = [];
      for (let i = 0; i < 6; i++) array.push({ loading: true });
      return array;
    },
    setFeatured(val) {
      this.featured = val;
    },
    f_open_login() {
      EventBus.$emit("open_sign_up_user", {});
    },
    onImgLoaded(i) {
      document.getElementById("cover" + i).style.width =
        document.getElementById("blog" + i).width + "px";
      document.getElementById("cover" + i).style.height =
        document.getElementById("blog" + i).height + "px";
    },
    showImage(image) {
      this.image = image;
      this.dialog = true;
    },
    openLink(i) {
      window.open(i.link, "_blank");
    },
  },
  created() {
    const chunk = (arr, size) =>
      Array.from({ length: Math.ceil(arr.length / size) }, (v, i) =>
        arr.slice(i * size, i * size + size)
      );

    this.$store.dispatch("category/getItems").then(() => {
      if (this.$vuetify.breakpoint.xsOnly) {
        this.items = chunk(this.paginate.data, 2);
      } else this.items = this.paginate.data;
    });



    this.$store.dispatch("util/setUser", this.user);
  },
};
</script>
<style>
.v-expansion-panel:before {
  box-shadow: none;
}

.theme--light.v-expansion-panels .v-expansion-panel {
  background-color: transparent;
}

.v-expansion-panel-header__icon i {
  color: #9759FF !important;
  font-size: 45px !important;
}
.ability_card.mr11 {
    margin-right: 15px !important;
}
.imgHoroscopeHome{
  max-height: 359px  !important;
}

@media screen and (max-width: 525px) {
      .imgHoroscopeHome{
          max-height: 275px !important;
      }
}
</style>
