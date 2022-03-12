<template>
  <div class="homepage">
    
   
    <section class="live-now">  
      <div class="container">
          <div class="text-center model"> <b>Models</b> </a></div>
          <div class="container my-5 d-block col-lg-5 col-md-3 col-sm-7 col-xs-6 text-center " >    
          <div class="category-icone"><a  @click="$refs.modellists.live_view()" href="javascript:void(0)"><i class="fa fa-wifi" ></i><br>Live Now</a> </div>
          <div class="category-icone"><a  @click="$refs.modellists.featured_view()" href="javascript:void(0)"><i class="fa fa-star"></i><br>Featured</a></div>
          <div class="category-icone"><a  @click="$refs.modellists.all_view()" href="javascript:void(0)"><i class="fa fa-users"></i></a><br>All</div>
          <div style="clear:both"></div>
          </div>
          <ModelLists ref="modellists" />
          <div class=" my-5 d-block text-center">
          <a  class="btn-view-more" @click="$refs.modellists.more_view()" href="javascript:void(0)">
            View More</a>
          </div>
      </div>
    </section>

  </div>
</template>

<script>
import { mapGetters } from "vuex";
import ModelLists from "./allmodels_list.vue";

import { Swiper, SwiperSlide } from "vue-awesome-swiper";
import 'swiper/swiper-bundle.css'

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
    };
  },
  props: ["guest", "user"],
  components: {
   ModelLists,
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
    ...mapGetters({
      mobile: "util/mobile",
      paginate: "category/items",
      paginate1: "specialty/items",
    }),
  },

  watch: {
  },
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
    more_view() {
       alert('hi');
    },
  },
  created() {
    const chunk = (arr, size) =>
      Array.from({ length: Math.ceil(arr.length / size) }, (v, i) =>
        arr.slice(i * size, i * size + size)
      );

    this.$store.dispatch("category/getItems").then(() => {
      if(this.$vuetify.breakpoint.xsOnly){
       this.items = chunk(this.paginate.data, 2);
       }
      else this.items = this.paginate.data;
    });

    this.$store.dispatch("specialty/getItems").then(() => {
      if (this.$vuetify.breakpoint.xsOnly) {
        this.specialties = chunk(this.paginate1.data, 3);
      } 
      else this.specialties = this.paginate1.data;
    });
    this.$store.dispatch("util/setUser", this.user);
  },
};
</script>
<style scoped>

.v-expansion-panel:before {
  box-shadow: none;
}

.theme--light.v-expansion-panels .v-expansion-panel {
  background-color: transparent;
}

.v-expansion-panel-header__icon i {
  color: #a163c1 !important;
  font-size: 45px !important;
}

.live-now{
  padding: 30px 0px;
  background: #F1F1F1 0% 0% no-repeat padding-box; 
}
.model {
    font-size: 25px;
    color : #9759FF ;
  }
.category-icone{
  padding: 10px;
  font-size: 13px;
  color: #000;
  text-align: center;
  border-radius: 4px;
  background: rgb(231, 230, 232);
  width:90px;
  float:left;
  margin :10px;
}

.category-name{
  color: #42424D;
  font-size: 22px;
  margin-left: 16px;
  align-self: center;
}
.btn-view-more{
  color:#fff;
  display: inline-block;
  padding: 10px 30px;
  border-radius: 9px;
  font-size: 14px;
  background: transparent linear-gradient(90deg, #9759FF 0%, #7272FF 100%) 0% 0% no-repeat padding-box;
}
.week {
  padding: 30px 0px;
  background: #fff;
}
.week .title {
  text-align: center;
  color: #42424D;
}
.week .model-gallary {
  flex-grow: 1;
  display: grid;
  grid-template: 1fr 1fr/1fr 2fr;
  grid-gap: 5px;
}
.week .img-item {
  border-radius: 15px;
  overflow: hidden;
}
.week .img-item:nth-child(2) {
  grid-row: 1/-1;
  grid-column: 2/-1;
  justify-self: start;
}
.week .gallary-info {
  flex-grow: 1;
}

.gallary-info .rate {
  color: #949498;
  font-size: 11px;
}
.gallary-info .model-name {
  color: #131220;
  font-size: 22px;
}
.gallary-info .model-title {
  color: #949498;
  font-size: 12px;
}
.gallary-info .description {
  font-size: 14px;
  color: #4e4d5c;
}

.signin {
  padding: 35px 0px;
  background: #F1F1F1;
}
.signin .slogan {
  color: #000;
  text-transform: uppercase;
  text-align: center;
  font-size: 32px;
  font-weight: 700;
}
.signin .slogan-2 {
  font-size: 28px;
  text-align: center;
  font-weight: 400;
}
.signin .text-light {
  font-size: 12px;
  margin-left: 10px;
}
.signin label {
  font-size: 12px;
}
 .hrclass {
  float:left;width:45%;height: 1px;color: #343a4040
  }
.btn-google {
  padding: 10px;
  background: #4285F4;
  display: block;
  border-radius: 5px;
  padding-bottom: 15px;
  padding-top: 15px;
}


.btn-twitter {
  display: block;
  padding: 10px;
  border-radius: 5px;
  background: #03AFF0;
   padding-bottom: 15px;
  padding-top: 15px;
}
.btn-twitter .fa-twitter {
  font-size: 18px;
  padding: 8px;
}
.featured {
  padding: 30px 0px;
  background: #fff; }
  .featured .model-img {
    border: none; }

.all {
  padding: 30px 0px;
  background: #F1F1F1; }
  .all .model-img {
    border: none; }

.week {
  padding: 30px 0px;
  background: #fff; }
.week .title {
  text-align: center;
  color: #42424D; }
.week .model-gallary {
  flex-grow: 1;
  display: grid;
  grid-template: 1fr 1fr/1fr 2fr;
  grid-gap: 5px; }
.week .img-item {
  border-radius: 15px;
  overflow: hidden;
  position: relative;
  border-radius: 10px;
  overflow: hidden; }
.week .img-item:nth-child(2) {
  grid-row: 1/-1;
  grid-column: 2/-1;
  justify-self: start; }
.week .img-item .hover-overlay {
  position: absolute;
  background-color: rgba(0, 0, 0, 0.6);
  left: 0;
  bottom: -50px;
  padding: 10px;
  width: 100%;
  color: #fff;
  text-align: center;
  opacity: 0;
  transition: ease all 0.5s;
  -webkit-transition: ease all 0.5s;
  -moz-transition: ease all 0.5s;
  visibility: hidden; }
.week .img-item:hover .hover-overlay {
  bottom: 0;
  opacity: 1;
  visibility: visible; }
.week .gallary-info {
  flex-grow: 1; }
.gallary-info .rate {
  color: #949498;   
  font-size: 11px; }
.gallary-info .model-name {
  color: #131220;
  font-size: 22px; }
.gallary-info .model-title {
  color: #949498;
  font-size: 12px; }
.gallary-info .description {
  font-size: 14px;
  color: #4e4d5c; }
.btn-follow {
  color: #9759FF;
  background-repeat: #fff;
  padding: 5px 40px !important;
  font-size: 12px;
  letter-spacing: 0.43px;
  border-radius: 9px;
  border: 2px solid #9759FF; }
.signin {
  padding: 35px 0px;
  background: #F1F1F1; }
  .signin .slogan {
    color: #000;
    text-transform: uppercase;
    text-align: center;
    font-size: 32px;
    font-weight: 700; }
  .signin .slogan-2 {
    font-size: 28px;
    text-align: center;
    font-weight: 400; 
    color:black;}
  .signin .text-light {
    font-size: 12px;
    margin-left: 10px; }
  .signin label {
    font-size: 12px; }

.form-control{
  background: white;
  border:2px solid #0000001F;
}
.mobile_1 {
  display: none; }
@media screen and (max-width: 992px) {
  .menubar .d-flex {
    display: block !important; }
  .menubar .navbar {
    z-index: 999; }

  .mobile_1 {
    position: absolute;
    top: 35px;
    right: 0px;
    left: 0;
    margin: 0 auto;
    text-align: center;
    display: block; }
    .mobile_1 .pr-0 {
      display: block; }

  .pr-0 {
    display: none; } }
@media screen and (max-width: 600px) {

.form-check-label { padding-left:5px }
  .btn-follow {
  color: #9759FF;
  padding: 5px 40px !important;
  font-size: 12px;
  letter-spacing: 0.43px;
  border-radius: 9px;
  border: 2px solid #9759FF;
  backgroud:  }
  .suggestion {
    height: 262px;
    position: relative;
    overflow: scroll;
    scrollbar-width: thin; }
    .suggestion .card-wrapper {
      display: flex; }

  .main_card {
    position: relative;
    min-height: 1px;
    padding-right: 5px;
    padding-left: 5px;
    float: left;
    width: 50%;
    margin-bottom: 20px; }
    
   
    .mobile_1 .pr-0 {
      display: block; }

  .live-now .bigcard-wrapper {
    display: block; }

  .featured .bigcard-wrapper {
    display: block; }

  .all .bigcard-wrapper {
    display: block; }

  .bigcard {
    margin-bottom: 15px; }

  .gallary-info {
    margin: 20px 0; }

  .signin .col-6 {
    max-width: 75%;
    flex: 0 0 100%;
    text-align: center;
    margin: 10px auto;
    display: table; }
  .signin .btn-google {
    width: 100%; }
  .signin .d-flex {
    display: block !important; }
  .signin .text-center {
    margin: 20px 0; } 
    .hrclass {
  float:left;width:42%;height: 1px;color: #343a4040
  }
  


    }
  .homepage{
    margin-top: 140px;
  }
  .text-dark,.text-danger{
    font-size: 12px;
    font-family: 'Courier New', Courier, monospace;
  }
@media screen and (max-width: 420px) and (min-width: 260px) {
  .btn-follow {
    font-size: 12px; }

  .model-info .model-type {
    font-size: 10px; }
  .model-info .model-name {
    font-size: 14px; }
  .model-info .rate {
    font-size: 11px; }

  .signin .slogan {
    font-size: 24px; }
  .signin .slogan-2 {
    font-size: 16px; } }
    
   
</style>
