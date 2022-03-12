<template>
  <div class="homepage">
    <!-- <div class="pa-0"> testing
      <v-img
        alt="Home Banner Image"
        style="z-index: 1"
        :src="
          guest
            ? '/images/Banner-imgs/horoscopeHub.png'
            : '/images/Banner-imgs/horoscopeHub.png'
        "
        aspect-ratio="1"
        :max-height="mobile ? 275 : 359"
        class="align-sm-center justify-sm-center home_hero"
      >
        <div
          class="justify-center text-center"
          style="
            position: absolute;
            width: 100%;
            margin-top: -50px;
            padding: 0 47px;
          "
          :style="{ top: mobile ? '45%' : '45%' }"
        >
          <h1>Horoscope Hub</h1>
          <h3>
            your source for weekly horoscope readings on demand
          </h3>
          <v-btn
            v-if="guest"
            rounded
            color="#8EbEF8"
            class="m-0 elevation-0 white--text"
            href="/signup"
            >Chat Now</v-btn
          >
        </div>
        <div
          v-if="user"
          class="d-flex justify-center w-100"
          style="height: 40px"
        >
          <SearchInput />
        </div>
      </v-img>
    </div>

    <SearchFilter />

<v-container class="my-3 front">

      <v-row
        justify="space-around"
        :class="!mobile ? 'mt-5 px-4' : 'mt-0 px-4'"
        class="mb-2 "
      >
        <v-col cols="12" class="h3 mb-0 d-flex align-center">
          <h2 class="mb-0">Select Your Zodiac Sign</h2>
        </v-col>
        
      </v-row>
      <v-row class="">

            <div class="col-4 col-sm-2 p-0 " v-for="(item, index) in horoscopes" :key="index">
                <v-hover v-slot:default="{ hover }" class="ability_card" >
                  
                  <a
                    :href="'/horoscope/' + item.slug"
                    style="text-decoration: none"
                  >
                    <v-row class="ma-0 text-center"
                        :style="$vuetify.breakpoint.xsOnly ? 'width: 110px; margin: 0px auto !important;' : 'width: 80%;margin: 0px auto !important; '"
                        
                    >
                      <v-col
                        cols="12"
                        class="align-sm-center justify-sm-center sm4 p-0"
                        
                      >
                        <img
                          :alt="item.name + ' Zodiac Sign'"
                          :src="'/images/horoscopes/' + item.logo"
                          
                        />
                      </v-col>
                      <v-col
                        cols="12"
                        class="align-center text-center p-0 mt-1"
                      >
                        <div class="description" style="opacity: 1;font-weight: 600;     font-size: 12px;">
                          {{ item.name }}
                        </div>
                        <div class="description" style="font-weight: 400;font-size: 12px;">
                          {{ item.start_period }} - {{ item.end_period }}
                        </div>
                      </v-col>
                    </v-row>
                  </a>
                </v-hover>
            </div>
            
              <!-- <div 
              class="my-2  ability_card" style="height: auto;" v-for="(item, index) in horoscopes" :key="index"
              :style="$vuetify.breakpoint.xsOnly ? 'margin: 0px 0px; width: 33%;' : 'margin: 0px 0px;width: 185px;'"
              
              :class="[(index == 0 && !$vuetify.breakpoint.xsOnly || index == 6 && !$vuetify.breakpoint.xsOnly ? 'ml-0 mr11' : ''), 
                        (index == 5 && !$vuetify.breakpoint.xsOnly || index == 11  && !$vuetify.breakpoint.xsOnly ? 'mr-0' : ''),
                        (index > 0 && index < 5  && !$vuetify.breakpoint.xsOnly  ? 'mr11' : ''),
                        (index > 5 && index < 11  && !$vuetify.breakpoint.xsOnly  ? 'mr11' : ''),
                        ($vuetify.breakpoint.xsOnly ? 'mb-0': 'mb-5')]"
              >
              
                <v-hover v-slot:default="{ hover }" >
                  
                  <a
                    :href="'/horoscope/' + item.slug"
                    style="text-decoration: none"
                  >
                    <v-row class="ma-0 text-center"
                        :style="$vuetify.breakpoint.xsOnly ? 'max-width: 95%; margin: 0px auto !important;' : 'width: 185px;margin: 0px auto !important; '"
                        
                    >
                      <v-col
                        cols="12"
                        class="align-sm-center justify-sm-center sm4 p-0"
                        
                      >
                        <img
                          :alt="item.name + ' Zodiac Sign'"
                          :src="'/images/horoscopes/' + item.logo"
                          style=""
                        />
                      </v-col>
                      <v-col
                        cols="12"
                        class="align-center text-center p-0 mt-1"
                      >
                        <div class="description" style="opacity: 1;font-weight: 600;     font-size: 12px;">
                          {{ item.name }}
                        </div>
                        <div class="description" style="font-weight: 400;font-size: 12px;">
                          {{ item.start_period }} - {{ item.end_period }}
                        </div>
                      </v-col>
                    </v-row>
                  </a>
                </v-hover>
               
              </div> -->
            
          
        
      </v-row>
      <!-- </v-window-item>
      </v-window> -->
    </v-container>

    <v-layout row class="mt-12 front m-0">
      <v-flex
        :style="
          ({ height: $vuetify.breakpoint.xsOnly ? '274px' : '178px' },
          { background: '#F4F4F4' })
        "
      >
        <v-container class="p-0">
          <div
            class="align-sm-center text-center-md justify-sm-center home_banner pr-0 pl-0 mr-5 ml-5"
          >
            <h3 class="mb-5">Let the Zodiac Guide You</h3>
            <p
              class="text-center-md"
              style="
                font-size: 14px !important;
                color: #656b72;
                font-weight: 500;
              "
            >
              The world can be a lonely, confusing place - but it doesn’t have to stay that way! Reading your free horoscope from Respectfully™ allows you to gain insight into everything from navigating relationships to understanding your own strengths and weaknesses. Instead of facing the world on your own, let the zodiac star sign guide you to a happier and healthier life.
            </p>
          </div>
        </v-container>
      </v-flex>
    </v-layout>

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

   



    <v-layout row class="mt-12 front m-0">
      <v-flex
        :style="
          ({ height: $vuetify.breakpoint.xsOnly ? '274px' : '178px' },
          { background: '#F4F4F4' })
        "
      >
        <v-container class="p-0">
          <div
            class="align-sm-center text-center-md justify-sm-center home_banner pr-0 pl-0 mr-5 ml-5"
          >
            <h4 class="mb-5">Zodiac Signs Frame Your Future</h4>
            <p
              class="text-center-md"
              style="
                font-size: 14px !important;
                color: #656b72;
                font-weight: 500;
              "
            >
              Feeling as if you need more support in this crazy life? The Respectfully™ top-rated online models can perform a tailored horoscope reading online for your star sign offering insight into your personality and valuable information about your future. You can then use this knowledge to improve your relationships, your career, your finances, and more. Book a reading with any of our models or check out our free horoscopes to get you started on the path you were always meant to be on.
            </p>
          </div>
        </v-container>
      </v-flex>
    </v-layout>

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
            
            <div class="m-auto d-inline-block" v-for="(cati,index) in i.categories" :key="cati.cat_name" :style="$vuetify.breakpoint.smAndDown ? 'margin-bottom: 10px !important;' : 'margin-bottom: 15px !important;'" style="color: #A2A2A2; font-size: 12px; text-align: left;">
              <span v-if="index > 0" class="mx-2">|</span>
              <div class="d-inline-block" :id="'cat' + index" style="    font-size: 12px;
    letter-spacing: 0.24px;font-weight: 600;
    line-height: 22px;    margin: 15px 0px;
    color: #43425D;
    opacity: 1;">{{cati.name}}</div>      
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
</style>
