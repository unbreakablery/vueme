<template>
  <div>
    <div class="pa-0">
      <v-img
        alt="Home Banner Image"
        style="z-index: 1"
        :src="hero_src"
        aspect-ratio="1"
        :max-height="mobile ? 295 : 362"
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
          <div v-if="seo_ability.length > 0 && seo_ability[0].seo_headline != null" v-html="seo_ability[0].seo_hero_content"></div>
          
        </div>
        
        <div class="d-flex justify-center w-100" style="height: 40px;">
          <SearchInput
              :terms="terms"
              :set-filters="setFilters"
              :stopSearch="stopSearch"
              :key="stopSearch"
              searchPage="true"
            />
        </div>
      </v-img>
    </div>
    <div class="container--fluid filters_container">
    
       <v-container class="py-0">
      <v-row>
        <v-col cols="12">
          <!-- <SearchFilter searchPage="true"/> -->
        </v-col>
      </v-row>
        </v-container>
      </div>

    <div v-if="seo_ability.length > 0 && seo_ability[0].seo_headline != null" class="container--fluid ">
    
       <v-container class="p-0">
      <v-row style="font-weight: 500;" class="align-sm-center justify-sm-center home_banner m-0 mt-1">
        <v-col cols="12" :style="{'color': '#656b72', 'font-size': $vuetify.breakpoint.xsOnly? '12px': '14px'}" v-html="seo_ability[0].seo_headline">
          
        </v-col>
      </v-row>
        </v-container>
    </div>
    

     <div class="container--fluid bg-white">
     <v-container>
      <v-row class="mt-md-5">
        <v-col cols="12">
          <ListItems
            v-if="filters"
            :terms="terms"
            :filters="filters"
            :guest="guest"
            :rows="rows"
            :cols="cols"
            :key="refresh"
          />
        </v-col>
      </v-row>
       </v-container>
    </div>


    <div v-if="seo_ability.length > 0 && seo_ability[0].seo_headline != null" class="container--fluid front">
    
     
      <v-row>
        <div class="d-none d-md-block d-lg-block"><img class="img-fluid" :src="seo_ability[0].seo_img_path"/></div>
        <v-col :style="{'color': '#656b72', 'font-size': $vuetify.breakpoint.xsOnly? '12px': '14px'}" cols="12" :lg="7" :md="7" v-html="seo_ability[0].seo_content" class="pt-10 px-10  pb-10 pb-lg-0"></v-col>
      </v-row>
        
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import ListItems from "./search_user_list.vue";

export default {
  data() {
    return {
      rows: null,
      cols: null,
      filters: null,
      refresh: false,
      stopSearch: false,
      firstLoad: true,
      seo_ability: [],
      hero_src: ""
    };
  },
  props: ["guest", "slug", "user", "terms", "abilities"],
  components: {
    ListItems,
  },
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
    }),
  },
  methods: {
    setFilters(filters) {
      this.filters = filters;
      this.refresh = !this.refresh;

      if(this.filters.ability && this.filters.ability.length == 1){
        this.seo_ability = this.abilities.filter((item) => item.slug == this.filters.ability[0]);
      }else{
        this.seo_ability = [];
      }

      this.getHero();

    },
    getHero(){

    if(this.$vuetify.breakpoint.mdAndUp){
      this.hero_src = "/images/Banner-imgs/search_page_banner.png";
    }else{
      this.hero_src = "/images/Banner-imgs/search_page_banner_mobile.png";
    }

     if(this.seo_ability.length > 0 && this.seo_ability[0].seo_headline != null){
        this.hero_src = this.seo_ability[0].seo_hero_path;
     }  
    }
  },
  created() {
    
    if (this.mobile) {
      this.rows = 16;
      this.cols = 1;
    } else {
      this.rows = 4;
      this.cols = 3;
    }

  this.$store.dispatch("util/setUser", this.user);
  
  },
};
</script>
