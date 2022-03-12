<template>
  <div :class="[(user) ? 'howpage-loggedin' : 'howpage']">
    <section class="get-start-section" style="background: #F1F1F1;">
      <div class="container">
  			<div class="d-flex justify-content-center section-title">
  				<h4 class="section-title-text">Get Started Today</h4>
  			</div>
        <div class="card-wrapper">
          <!-- card start -->
          <div class="main_card">
            <div class="mycard" >
              <div class="img">
                <img src="/images/icons/Group 27996.svg" width="100%" height="100%">
              </div>
              <p class="card-name">Sign Up</p>
              <p class="card-title">It's easy and totally free to sign up.</p>
            </div>
          </div>
          <!-- card end -->
          <!-- card start -->
          <div class="main_card">
            <div class="mycard" >
              <div class="img">
                <img src="/images/icons/Group 27995.svg" width="100%" height="100%">
              </div>
              <p class="card-name">Browse Models</p>
              <p class="card-title">Instantly browse our gallery of real models from around the globe.</p>
            </div>
          </div>
          <!-- card end -->
          <!-- card start -->
          <div class="main_card">
            <div class="mycard" >
              <div class="img">
                <img src="/images/icons/Group 27993.svg" width="100%" height="100%">
              </div>
              <p class="card-name">Get The Goods</p>
              <p class="card-title">Follow your favorite models to see their latest posts in your feed.</p>
            </div>
          </div>
          <!-- card end -->
        </div>
      </div>
    </section>

    <section class="world-models-section" style="background: #FFFFFF;">
      <div class="container">
  			<div class="d-flex justify-content-center section-title">
  				<h4 class="section-title-text" >Get Up Close &amp; Personal</h4>
  			</div>
        <div class="card-wrapper">
          <!-- card start -->
          <div class="main_card">
            <div class="mycard" >
              <div class="img">
                <img src="/images/Banner-imgs/banner-phone.png" width="100%">
              </div>
            </div>
          </div>
          <!-- card end -->
          <!-- card start -->
          <div class="main_card d-flex align-items-center">
            <div class="mycard" >
              <p class="card-name text-left">
                Welcome to your new favorite guilty pleasure.
                Get interactive live action and intimate private 
                shows from the sexiest models around the 
                globe. It's no secret, Respectfully models like it when you watch.
              </p>
            </div>
          </div>
          <!-- card end -->
        </div>
      </div>
    </section>
    
    <section class="get-start-section" style="margin-top: 0;background: #efe9fa;">
      <div class="container">
  			<div class="d-flex justify-content-center section-title">
  				<h4 class="section-title-text">Connect Your Way</h4>
  			</div>
        <div class="card-wrapper">
          <!-- card start -->
          <div class="main_card">
            <div class="mycard" style="height: 244px;">
              <div class="img">
                <img src="/images/icons/Group 27994.svg" width="100%" height="100%">
              </div>
              <p class="card-name">Stream It Live</p>
              <p class="card-title">
                Tune in for endless live action and send her a tip to show some extra love.
              </p>
            </div>
          </div>
          <!-- card end -->
          <!-- card start -->
          <div class="main_card">
            <div class="mycard" style="height: 244px;">
              <div class="img">
                <img src="/images/icons/Group 27990.svg" width="100%" height="100%">
              </div>
              <p class="card-name">Get a Private Show</p>
              <p class="card-title">Don't like to share? Reserve a private show with your favorite model.</p>
            </div>
          </div>
          <!-- card end -->
          <!-- card start -->
          <div class="main_card">
            <div class="mycard" style="height: 244px;">
              <div class="img">
                <img src="/images/icons/Group 27997.svg" width="100%" height="100%">
              </div>
              <p class="card-name">Subscribe For All Access</p>
              <p class="card-title">
                Subscribe to her Fan Club for your VIP access pass to every single live stream.
              </p>
            </div>
          </div>
          <!-- card end -->
          <!-- card start -->
          <div class="main_card">
            <div class="mycard" style="height: 244px;">
              <div class="img">
                <img src="/images/icons/Group 27982.svg" width="100%" height="100%">
              </div>
              <p class="card-name">Play for Keeps</p>
              <p class="card-title">
                Know exactly what you like? Unlock individual live streams, a la carte.
              </p>
            </div>
          </div>
          <!-- card end -->
        </div>
      </div>
    </section>
    
    <section class="signin" :class="guest? '':'d-none'">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-sm-12 col-12 align-self-center">
            <h1 class="slogan">100% free sign up</h1>
            <h1 class="slogan-2" style="color: #131220;">Our models are ready and waiting.</h1>
          </div>
          <div class="col-md-6 col-sm-12 col-12">
            <fan-signup
              :user="user"
              :guest="guest"
              :abilities="abilities"
              :country_all="country_all"
              :styles="styles"
              :tools="tools"
            />
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import ListItems from "./model_list.vue";
import BigModelLists from "./big_model_list.vue";

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
  props: [
    "guest",
    "user",
    "abilities",
    "country_all",
    "redeem",
    "search",
    "tools",
    "styles",
  ],
  components: {
    ListItems,
    BigModelLists,
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
  color: #9759FF !important;
  font-size: 45px !important;
}

.howpage {
  margin-top: 56px;
}
.howpage-loggedin {
  margin-top: 96px;
}
.section-title h4 {
  margin-bottom: 40px;
  text-align: center;
}

.section-title-text{
  color: #42424D; 
  font-size: 24px;
  font-weight: 500; 
  margin-top: 50px;
}

.mycard {
  padding: 25px 20px !important;
}
.get-start-section {
  padding-bottom: 50px;
}

.get-start-section .card-wrapper {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(155px, 1fr));
  grid-gap: 45px;
}
.get-start-section .main_card {
  max-width: 330px;
}
.get-start-section .mycard {
  text-align: center;
  background-color: #fff;
  background-clip: border-box;
  border-radius: 12px;
  padding: 25px 0px 25px 0px;
}
.get-start-section .mycard .img {
  margin: 0 auto;
  width: 80px;
  height: 80px;
  margin-bottom: 10px;
  overflow: hidden;
}
.get-start-section .mycard .card-name {
  color: #131220;
  font-size: 18px;
  margin-bottom: 5px;
  letter-spacing: 0px; 
  line-height: 18px;
  font-weight: 600; 
  margin: 0 auto;
}
.get-start-section .mycard .card-title {
  color: #131220;
  font-size: 14px;
  width:200px;
  height: 58px;
  margin-top: 10px;
  margin-bottom: 0px;
  margin-right: auto;
  margin-left: auto;
  line-height: 20px;
  font-weight: 500;
}

.world-models-section .card-wrapper {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(155px, 1fr));
  grid-gap: 0px; 
}
.world-models-section .mycard {
  text-align: center;
  background-color: #fff;
  background-clip: border-box; 
}
.world-models-section .mycard .img {
  margin: 0 auto;
  overflow: hidden; 
}
.world-models-section .mycard .card-name {
  color: #131220;
  font-size: 18px;
  margin-bottom: 5px;
  letter-spacing: 0px; 
  line-height: 24px;
  font-weight: 600; 
  padding: 0 63px;
  margin: 0 auto;
}
.world-models-section .mycard .card-title {
  color: #131220;
  font-size: 14px;
  width:435px;
  height: 38px;
  margin-top: 16px;
  margin-right: auto;
  margin-left: auto;
  line-height: 20px;
  font-weight: 500; 
}

.credits-section .card-wrapper {
  display: grid;
  grid-template-columns: 1fr 2fr;
  grid-gap: 90px; 
}
.credits-title {
  flex-direction: column;
  align-items: center;
}
.sub-card-wrapper {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));;
  grid-gap: 10px; 
}
.credits-section .mycard {
  text-align: center;
  background-color: #F1F1F1;
  background-clip: border-box; 
}
.credits-section .mycard .img {
  margin: 0 auto;
  width: 96px;
  height: 96px;
  margin-bottom: 22px;
  overflow: hidden; 
}
.credits-section .mycard .card-name {
  color: #949498;
  font-size: 16px;
  margin-bottom: 5px;
  letter-spacing: 0px; 
  line-height: 18px;
  font-weight: 700; 
  white-space: nowrap;
  margin: 0 auto;
}
.credits-section .mycard .card-title {
  color: #131220;
  font-size: 14px;
  width:246px;
  height: 77px;
  margin-top: 16px;
  margin-right: auto;
  margin-left: auto;
  line-height: 20px;
  font-weight: 500; 
}

.connect-section, .credits-section {
  padding-bottom: 50px;
}

.connect-section .card-wrapper {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(155px, 1fr));
  grid-gap: 70.5px; 
}
.connect-section .mycard {
  text-align: center;
  background-color: #fff;
  background-clip: border-box;
  border: 1px solid rgba(0, 0, 0, 0.125);
  border-radius: .35rem;
}
.connect-section .mycard .img {
  margin: 53px auto 54px auto;
  width: 60px;
  height: 60px;
  overflow: hidden; 
}
.connect-section .mycard .card-name {
  color: #FFFFFF;
  font-size: 24px;
  margin-bottom: 5px;
  letter-spacing: 0px;
  line-height: 18px;
  font-weight: 700;
  white-space: nowrap;
  margin: 0 auto 35px auto;
  padding: 12px 0;
  background-color: #F77F98;
  border-radius: 6px 6px 0 0;
}
.connect-section .mycard .card-title {
  color: #131220;
  font-size: 14px;
  width:300px;
  height: 60px;
  margin-top: 30px;
  margin-bottom: 30px;
  margin-right: auto;
  margin-left: auto;
  line-height: 20px;
  font-weight: 500; 
}
/* ///////////////////////////// */
.btn-follow {
  color: #9759FF;
  background-repeat: #fff;
  padding: 5px 20px;
  font-size: 12px;
  letter-spacing: 0.43px;
  border-radius: 9px;
  border: 2px solid #9759FF;    
}
.week .btn-follow {
  width: 160px;
  display: table-cell;
  text-align: center; 
}

.signin {
  padding: 35px 0px;
  background: #F1F1F1;
}
.signin .slogan {
  color: #000;
  text-transform: uppercase;
  text-align: center;
  font-size: 40px;
  font-weight: 700;
}
.signin .slogan-2 {
  font-size: 24px;
  text-align: center;
  font-weight: 500; 
  color: #42424D;
}
.signin .text-light {
  font-size: 14px;
  margin-left: 10px;
  font-weight: 600;
}
.signin label {
  font-size: 12px; 
}
.signin h4,
.signin h5 {
  font-size: 12px; 
  line-height: 14px;
  font-weight: 600;
  display: inline-block;
  margin-bottom: .5rem;
  color: #131220;
}
.signin h5 {
  font-weight: 500;
}
.signin h4 span {
  color: #f00;
}
.signin h5 a {
  color: #F78099;
}
.text-danger {
  color: #E85D4ECC !important;
  font-weight: 600;
}
.signin h5.apply_h5 {
  display: block;
}
.signin h5.apply_h5 span {
  display: inline-block;
  width: 49%;
  text-align: center;
}

.social_buttons {
  text-align: center;
  width: 100%;
  display: block;
}
.btn-google {
  padding: 4px;
  background: #4285F4;
  display: block;
  border-radius: 5px;
}
.btn-google .fa-google {
  font-size: 18px;
  padding: 8px;
  color: #fff;
}

.btn-twitter {
  display: block;
  padding: 5px;
  border-radius: 5px;
  background: #03AFF0;
}
.btn-twitter .fa-twitter {
  font-size: 18px;
  padding: 8px;color: #fff;
}
.social_buttons span.text-light {
  vertical-align: text-top;
}
.signin hr {
  border-color: #898990;
}

.btn-view-more {
  color: #fff;
  width: 160px;
  display: inline-block;
  padding: 10px 30px;
  border-radius: 9px;
  font-size: 14px;
  background: transparent linear-gradient(90deg, #9759FF 0%, #7272FF 100%) 0% 0% no-repeat padding-box;
}

.or_hr {
  position: relative;
  border-color: #898990;
}
.or_hr:after {
  content: 'or';
  position: absolute;
  left: calc(50% - 15px);
  top: -13px;
  bottom: -5px;
  height: 20px;
  width: 30px;
  background: #f1f1f1;
  font-size: 14px;
  color: #898990;
  font-weight: 500;
  text-align: center;
}
.homepage {
  margin-top: 100px;
}

@media screen and (max-width: 420px) and (min-width: 260px) {
  .homepage {
    margin-top: 0px;
  }
}

.mobile_1 {
  display: none;
}

@media screen and (max-width: 992px) {
  .mobile_1 {
    position: absolute;
    top: 24px;
    right: 0px;
    left: 0;
    margin: 0 auto;
    text-align: center;
    display: block;
  }
  .mobile_1 .pr-0 {
    display: block;
  }

  .pr-0 {
    display: none; 
  } 
}

@media screen and (max-width: 600px) {
  .howpage-loggedin {
    margin-top: 40px;
  }
  .card-wrapper {
    margin-left: 20px;
    margin-right: 20px;
  }
  p.card-title {
    width: 100% !important;
  }
  .world-models-section .mycard .card-name {
    padding: 0 20px;
  }
  .signin .slogan {
    font-size: 24px;
  }
  .get-start-section, .world-models-section {
    position: relative;
  }
  .get-start-section .card-wrapper, .world-models-section .card-wrapper {
    display: table;
    margin: auto;
  }
  .section-title {
    margin-left: 10px !important;
    margin-right: 10px !important;
  }
  .section-title-text {
    color: #42424D; 
    font-size: 20px;
    font-weight: 500; 
  }

  .main_card {
    margin-bottom: 20px; 
  }
  .world-models-section .mycard .card-title {
    width: 334px;
    height: 58px;
  }
  .credits-section .card-wrapper {
    display: grid;
    grid-template-columns: none;
    grid-gap: 0;
    margin: 0 10px;
  }
  .sub-card-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-gap: 0px;
  }

  .connect-section .card-wrapper {
    display: grid;
    grid-template-columns: none;
    grid-gap: 0;
    margin: 0px 38px;
    
  }

  .signin .col-6 {
    max-width: 100%;
    flex: 0 0 100%;
    text-align: center;
    margin: 10px auto;
    display: table;
  }
  .signin .btn-google {
    width: 100%;
  }
  .signin .d-flex {
    display: block !important;
  }
  .signin .text-center {
    margin: 20px 0;
  }
}
@media screen and (max-width: 420px) and (min-width: 260px) {
  .btn-follow {
    font-size: 12px;
  }

  .model-info .model-type {
    font-size: 10px;
  }
  .model-info .model-name {
    font-size: 14px;
  }
  .model-info .rate {
    font-size: 11px;
  }
  .signin .slogan-2 {
    font-size: 16px;
  } 
  .section-title-text {
    color: #42424D; 
    font-size: 20px;
    font-weight: 500; 
  }
}
</style>
