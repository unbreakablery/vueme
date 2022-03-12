<template>
  <div class="homepages">
    

    <v-container class="mb-6 front pt-0 pb-0" :style="$vuetify.breakpoint.xsOnly ? 'margin-top: 30px;margin-bottom:30px' : ''">
      <v-row
        id="specialties"
        justify="space-around"
        :class="!mobile ? 'mt-7 px-4' : 'px-4'"
        class="mb-2"
      >
        <v-col cols="9" class="h3 mb-0 d-flex align-center">
          <h4 class="mb-0">Popular Model Specialties</h4>
        </v-col>
        <v-col class="h3 mb-0 text-lg-right cursor-pointer">
          <div
            class="d-flex justify-end align-center"
            style="font-size: 30px; color: #43425d"
            @click="nextSpecialties"
          >
            <span>&#8226;</span>
            <span>&#8226;</span>
            <span>&#8226;</span>
          </div>
        </v-col>
      </v-row>

      <v-row>
        <v-col>
          <swiper v-if="!$vuetify.breakpoint.xsOnly" ref="mySwiper2" :options="swiperOptions2" class="row">
            <swiper-slide v-for="(item, index) in specialties" :key="index">
              <div
                class="my-2 specialty_card"
                :key="index"
                style="height: 100%"
              >
                <v-hover v-if="!item.loading" v-slot:default="{ hover }">
                  <a
                    :href="'/search?category=' + item.slug"
                    style="text-decoration: none"
                  >
                    <v-row class="ma-0 text-center">
                      <v-col
                        cols="12"
                        class="align-sm-center justify-sm-center sm4 p-0"
                      >
                        <img :alt="item.name" v-bind:src="item.path" style="" />
                      </v-col>
                      <v-col
                        cols="12"
                        class="align-center text-center p-0 mt-1"
                      >
                        <div class="description" style="">{{ item.name }}</div>
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

          <swiper v-else ref="mySwiper2" :options="swiperOptions2" class="row">
            <swiper-slide v-for="(item2, index) in specialties" :key="index">

              <div v-for="(item, index2) in item2" :key="index2"
                class="my-2 specialty_card"
                style="height: 140px" 
              >
                <v-hover v-if="!item.loading" v-slot:default="{ hover }" >
                  <a
                    :href="'/search?category=' + item.slug"
                    style="text-decoration: none"
                  >
                    <v-row class="ma-0 text-center">
                      <v-col
                        cols="12"
                        class="align-sm-center justify-sm-center sm4 p-0"
                      >
                        <img :alt="item.name" v-bind:src="item.path" :style="$vuetify.breakpoint.xsOnly ? '    height: 110px; width:110px' : ''" />
                      </v-col>
                      <v-col
                        cols="12"
                        class="align-center text-center p-0 mt-1"
                      >
                        <div class="description" style="">{{ item.name }}</div>
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

<v-layout row class="mt-12 front m-0">
<v-container :style="$vuetify.breakpoint.smAndDown ? 'margin-top: 11px;' : 'margin-top: 15px;'" style="padding-top: 6px;" class="container pb-0 mb-0 front mb-10">
    
      <v-row
        :class="!mobile ? 'mt-7 px-4' : 'px-4'"
        class="mb-2"
      >
        <v-col cols="8" class="h3 mb-0 d-flex align-center ">
          <h4 class="mb-0">New On The Blog</h4>
        </v-col>
        <v-col cols="4" class="h3 mb-0 text-lg-right cursor-pointer">
        
    <a  class="d-flex justify-end align-center"
            style="    font-size: 14px;
    color: #43425D;
    font-weight: 600;
    letter-spacing: 0.28px;
    line-height: 18px;
    opacity: 1;"
            href="/blog"
          >
            <div class="d-flex justify-end align-center" style="font-size: 30px;color: #43425D;">
            <span>•</span> <span>•</span> <span>•</span>
            </div>
            </a>
        </v-col>
      </v-row>
        <swiper v-if="$vuetify.breakpoint.xsOnly"
        
        
         ref="mySwiper3" :options="swiperOptions3" class="row">
            <swiper-slide v-for="(i,index) in blogs" :key="i.name" >

               <div class="row" id="videoWidth" >

                 <v-hover v-if="!i.loading" v-slot:default="{ hover }" >
          <div class="cols-12 col-md-6" >
            <div  :class="[(index == 0 && !$vuetify.breakpoint.smAndDown ? 'mr-5 ml-5' : ''), (index == 1 && !$vuetify.breakpoint.smAndDown ? 'ml-5 mr-5' : '')]" >
            <div class="d-flex justify-center align-center w-100 h-100" 
            style="object-fit: contain; right: 5px; bottom: 10px" >
              <i v-if="i.vid"><img :style="$vuetify.breakpoint.smAndDown ? 'width: 66px !important;' : ''" :src=play_icon /></i>
            </div>
            
            <a :href="'/blog/'+i.url"
            
            
            >
            <v-img
              :alt="i.title"
              :id="'blog' + index"
              :src="'/images/blog_images/' + i.image"
              class="w-100"
              :style="$vuetify.breakpoint.xsOnly ? 'height: 180px !important; margin-top: 20px !important;' : 'margin-top: 30px !important;'"
              style="cursor: pointer;"
              aspect-ratio="1"
              
            />
            </a>
            
            <div class="m-auto" v-for="(cati,index) in i.categories" :key="cati.cat_name" :style="$vuetify.breakpoint.smAndDown ? 'margin-bottom: 10px !important;' : 'margin-bottom: 15px !important;'" style="color: #A2A2A2; font-size: 12px; text-align: left;">
              <div :id="'cat' + index" style="    font-size: 12px;
    letter-spacing: 0.24px;font-weight: 600;
    line-height: 22px;    margin: 15px 0px;
    color: #43425D;
    opacity: 1;"> <span v-if="index > 0">|</span> {{cati.name}}</div>
            </div> 
            
            <div class="m-auto" :style="$vuetify.breakpoint.smAndDown ? 'margin-bottom: 10px !important;' : 'margin-bottom: 15px !important;'" style="color: #A2A2A2; font-size: 12px; text-align: left;">
              <div style="font-size: 12px;
    color: #A2A2A2;
    font-weight: 500;margin: 15px 0px;
    letter-spacing: 0.24px;
    line-height: 22px;">{{i.date}}</div>
              <div style="color: #43425D; font-size: 18px; font-weight: bold; margin-top: 10px; min-height: 44px;"
               :style="$vuetify.breakpoint.xsOnly ? 'font-size: 15px;' : ''"
              
              >{{i.title}}</div>
              <div style="    color: #5A6066;
    font-size: 16px;
    font-weight: normal;
    letter-spacing: 0px;
    line-height: 24px; ">{{i.sub_title}}</div>
          <a :href="'/blog/'+i.url" style="    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0px;
    color: #3B3952;
    line-height: 24px;
    margin-top: 15px;">
              …read more
         </a>     
            </div> 
            
            </div>
          </div>
          </v-hover>
        </div>
            </swiper-slide>
          </swiper>

        <div v-else class="row" id="videoWidth">
          <div class="cols-12 col-md-6" v-for="(i,index) in blogs" :key="i.name" >
            <div  :class="[(index == 0 && !$vuetify.breakpoint.smAndDown ? 'mr-5 ml-5' : ''), (index == 1 && !$vuetify.breakpoint.smAndDown ? 'ml-5 mr-5' : '')]" >
            <div class="d-flex justify-center align-center w-100 h-100" 
            style="object-fit: contain; right: 5px; bottom: 10px" >
              <i v-if="i.vid"><img :style="$vuetify.breakpoint.smAndDown ? 'width: 66px !important;' : ''" :src=play_icon /></i>
            </div>
            
            <a :href="'/blog/'+i.url"
            
            
            >
            <img
              :alt="i.title"
              :id="'blog' + index"
              :src="'/images/blog_images/' + i.image"
              class="w-100"
              :style="$vuetify.breakpoint.xsOnly ? 'height: 180px !important; margin-top: 20px !important;' : 'margin-top: 30px !important;'"
              style="cursor: pointer;"
              
            />
            </a>
            
            <div class="m-auto" v-for="(cati,index) in i.categories" :key="cati.cat_name" :style="$vuetify.breakpoint.smAndDown ? 'margin-bottom: 10px !important;' : 'margin-bottom: 15px !important;'" style="color: #A2A2A2; font-size: 12px; text-align: left;">
              <div :id="'cat' + index" style="    font-size: 12px;
    letter-spacing: 0.24px;font-weight: 600;
    line-height: 22px;    margin: 15px 0px;
    color: #43425D;
    opacity: 1;"> <span v-if="index > 0">|</span> {{cati.name}}</div>
            </div> 
            
            <div class="m-auto" :style="$vuetify.breakpoint.smAndDown ? 'margin-bottom: 10px !important;' : 'margin-bottom: 15px !important;'" style="color: #A2A2A2; font-size: 12px; text-align: left;">
              <div style="font-size: 12px;
    color: #A2A2A2;
    font-weight: 500;margin: 15px 0px;
    letter-spacing: 0.24px;
    line-height: 22px;">{{i.date}}</div>
              <div style="color: #43425D; font-size: 18px; font-weight: bold; margin-top: 10px; min-height: 44px;"
               :style="$vuetify.breakpoint.xsOnly ? 'font-size: 15px;' : ''"
              
              >{{i.title}}</div>
              <div style="    color: #5A6066;
    font-size: 16px;
    font-weight: normal;
    letter-spacing: 0px;
    line-height: 24px; ">{{i.sub_title}}</div>
          <a :href="'/blog/'+i.url" style="    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0px;
    color: #3B3952;
    line-height: 24px;
    margin-top: 15px;">
              …read more
         </a>     
            </div> 
            
            </div>
          </div>
          
        </div>
    
</v-container>
</v-layout>

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
      swiperOptions2: {
        loop: true,
        breakpoints: {
          // when window width is >= 320
          320: {
            slidesPerView: 3,
          },

          768: {
            slidesPerView: 6,
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
      swiperOptions3: {
        loop: true,
        breakpoints: {
          // when window width is >= 320
          320: {
            slidesPerView: 1,
            
          },

          768: {
            slidesPerView: 1,
          },
          // when window width is >= 960
          960: {
            slidesPerView: 1,
          },
          // when window width is >= 1264
          1264: {
            slidesPerView: 1,
          },
        },
      },
    };
  },
  props: ["guest", "user", "blogs"],
  components: {
    ListItems,
    Swiper,
    SwiperSlide,
  },
  computed: {
    swiper() {
      return this.$refs.mySwiper.$swiper;
    },
    swiper2() {
      return this.$refs.mySwiper2.$swiper;
    },
    swiper3() {
      return this.$refs.mySwiper3.$swiper;
    },
    ...mapGetters({
      mobile: "util/mobile",
      paginate: "category/items",
      paginate1: "specialty/items",
      paginate2: "horoscope/items",
    }),
  },

  watch: {},
  methods: {
    nextAbilities() {
      this.swiper.slideNext();
    },
    nextSpecialties() {
      this.swiper2.slideNext();
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

    this.$store.dispatch("horoscope/getItems").then(() => {
      this.horoscopes = this.paginate2.data;
    });

    this.$store.dispatch("specialty/getItems").then(() => {
      if (this.$vuetify.breakpoint.xsOnly) {
        this.specialties = chunk(this.paginate1.data, 3);
      } else this.specialties = this.paginate1.data;
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
