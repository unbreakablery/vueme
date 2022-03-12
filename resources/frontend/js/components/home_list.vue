<template>
  <div :class="guest? 'homepage' : 'homepage-loggedin'">
    <section class="suggestion pb-5" style="background: #E7E6E8;" >
      <div class="container">
  			<div class="d-flex justify-content-between py-5 section-title">
  				<h4 class="mb-0" style="color: #131220;font-size: 18px;font-weight: 600;">Suggestions For You</h4>
  				<a class="mb-0" href="/explore" style="font-weight: 600; color:#F77F98;font-size: 14px">View more</a>
  			</div>
        <list-items 
            ref="listitems"
          :guest= guest
          :myfavorites=myfavorites
          :user="this.user"
          />
      </div>
    </section>
    <!-- <SearchFilter /> -->

    <section class="live-now">  
      <div class="container">
          <div class="d-flex mb-4 section-title">
            <div class="category-icone">
              <svg xmlns="http://www.w3.org/2000/svg" width="24.001" height="16.006" viewBox="0 0 24.001 16.006">
                <defs></defs>
                <g transform="translate(0.002 0)">
                  <path class="a" d="M3.532,16.005H3.5a.692.692,0,0,1-.482-.228A11.511,11.511,0,0,1,3.02.234.692.692,0,0,1,3.5.006h.03A.68.68,0,0,1,4,.193L4.474.65V.661a.653.653,0,0,1,.014.907,9.594,9.594,0,0,0,0,12.889.644.644,0,0,1-.014.9L4,15.818A.68.68,0,0,1,3.532,16.005Zm16.937-.013a.684.684,0,0,1-.47-.187l-.472-.457a.644.644,0,0,1-.015-.9,9.592,9.592,0,0,0,0-12.889A.651.651,0,0,1,19.527.65L20,.187A.684.684,0,0,1,20.469,0h.03a.687.687,0,0,1,.482.228V.221a11.51,11.51,0,0,1,0,15.543.691.691,0,0,1-.482.228Zm-13.63-3.22H6.8a.694.694,0,0,1-.489-.244,7.023,7.023,0,0,1,0-9.046A.687.687,0,0,1,6.8,3.238h.036a.683.683,0,0,1,.475.191l.473.457V3.9a.634.634,0,0,1,.054.855,5.119,5.119,0,0,0,0,6.514.632.632,0,0,1-.054.854l-.473.457A.684.684,0,0,1,6.839,12.773Zm10.325-.021a.683.683,0,0,1-.475-.191l-.473-.457a.634.634,0,0,1-.054-.855,5.119,5.119,0,0,0,0-6.514.634.634,0,0,1,.054-.855l.473-.457V3.407a.682.682,0,0,1,.475-.191H17.2a.694.694,0,0,1,.489.244,7.023,7.023,0,0,1,0,9.046.694.694,0,0,1-.489.244ZM12,10.331A2.332,2.332,0,1,1,14.335,8,2.335,2.335,0,0,1,12,10.331Z" transform="translate(-0.003 0.001)"/>
                  <path class="b" d="M3.5,16a.684.684,0,0,1-.482-.229,11.511,11.511,0,0,1,0-15.539A.684.684,0,0,1,3.5,0h.029A.686.686,0,0,1,4,.19l.472.461a.649.649,0,0,1,.015.907,9.594,9.594,0,0,0,0,12.889.646.646,0,0,1-.015.9L4,15.812A.686.686,0,0,1,3.529,16Zm16.968,0A.685.685,0,0,1,20,15.81l-.472-.462a.646.646,0,0,1-.015-.9,9.593,9.593,0,0,0,0-12.888.647.647,0,0,1,.015-.905L20,.188A.682.682,0,0,1,20.468,0H20.5a.681.681,0,0,1,.482.229,11.511,11.511,0,0,1,0,15.539A.688.688,0,0,1,20.5,16Zm-3.783-3.421-.473-.463a.631.631,0,0,1-.054-.855,5.113,5.113,0,0,0,0-6.518.631.631,0,0,1,.054-.855l.473-.464a.686.686,0,0,1,.474-.191H17.2a.686.686,0,0,1,.488.245,7.033,7.033,0,0,1,0,9.045.686.686,0,0,1-.488.245h-.038A.683.683,0,0,1,16.685,12.577ZM6.8,12.767a.686.686,0,0,1-.488-.245,7.033,7.033,0,0,1,0-9.045A.686.686,0,0,1,6.8,3.233h.037a.687.687,0,0,1,.475.191l.473.464a.631.631,0,0,1,.054.855,5.113,5.113,0,0,0,0,6.518.631.631,0,0,1-.054.855l-.473.463a.683.683,0,0,1-.474.192ZM9.665,8A2.333,2.333,0,1,1,12,10.333,2.333,2.333,0,0,1,9.665,8Z" transform="translate(0 0)"/>
                  <path class="b" d="M1.076,0A1.076,1.076,0,1,0,2.152,1.076,1.077,1.077,0,0,0,1.076,0" transform="translate(10.922 6.924)"/>
                </g>
              </svg>
            </div>
            <h3 class="category-name">Live Now</h3>
          </div>
          <BigModelLists 
            ref="biglistitems"
            :filters="{ is_streaming_live: true }"
            :guest= guest
            :myfavorites=myfavorites
            :user="this.user"
           />
      </div>
    </section>

    <section class="featured" >  
      <div class="container">
          <div class="d-flex mb-4 section-title">
            <div class="category-icone"><i class="fa fa-star"></i></div>
  				  <h3 class="category-name">Featured</h3>
          </div>
          <BigModelLists  
            ref="biglistitems1"
            :filters="{ featured: true }"
            :guest= guest
            :myfavorites=myfavorites
            :user="this.user"
            />
      </div>
    </section>

    <section class="all">
  		<div class="container">
  			<div class="d-flex mb-4 section-title">
  				<div class="category-icone"><i class="fa fa-users"></i></div>
  				<h3 class="category-name">All</h3>
  			</div>
        <BigModelLists  
          ref="biglistitems2"
          :guest= guest
          :myfavorites=myfavorites
          :user="this.user"
        />
  		</div>
  	</section>

  	<section class="week">
  		<div class="container">
  			<h3 class="week-title mb-4 ">Model of the Week</h3>
  			<div class="row">
  				<div class="model-gallary col-md-6 col-sm-12 col-12">
  					<div class="img-item"><img src="/images/models/model2.png" width="100%" height="100%">
						<div class="hover-overlay">Eva McKenzie</div>
					</div>
  					<div class="img-item"><img src="/images/models/big-model.png" width="100%" height="100%">
						<div class="hover-overlay">Eva McKenzie</div>
					</div>
  					<div class="img-item"><img src="/images/models/model1.jpg" width="100%" height="100%">
						<div class="hover-overlay">Eva McKenzie</div>
					</div>
  				</div>
  				<div class="gallary-info col-md-6 col-sm-12 col-12">
  					<p class="rate mb-0">Top 10% Model</p>
  					<h4 class="model-name mb-0">Sophie Asveld</h4>
            <h2 class="model-name-mobile mb-0">Sophie Asveld</h2>
  					<p class="model-title">Brunette</p>
  					<p class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>

  					<a href="#" v-if="guest" class="btn-follow">Follow</a>
            <a href="#" v-if="!guest" class="btn-follow-loggedin">Follow</a>

  				</div>
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
      live_models:0,
      window: 0,
      window1: 0,
      online: true,
      featured: true,
      categories: [],
      items: [],
      specialties: [],
      specialtiesList: [],
      myfavorites:[],
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
  props: [
    "user",
    "guest",
    "abilities",
    "country_all",
    "redeem",
    "search",
    "tools",
    "styles",
  ],
  watch: {
  },
  mounted(){
    this.$root.$on('live_models_number', (data) =>
     {
       this.live_models = data.models_number;
     });

    this.$root.$on('hide_section', (data) =>
     {
        if(data.filters.is_streaming_live){
          $("section.live-now").css("display","none");
        }
      
     });
     var that_this = this;
           EventBus.$on("delete_follower", (data) => {
        var id = data.id;
        var type = data.type;
                  that_this.$store
          .dispatch("favorite/saveFavorite", {
            id: id,
            type:type,
          })
          .then(() => {
            if(type=='remove'){
              var  arr= that_this.myfavorites;
              for( var i = 0; i < arr.length; i++){                                 
                if ( arr[i] === id) { 
                    arr.splice(i, 1); 
                    i--; 
                }
                }
                that_this.myfavorites = arr; 
            }else{
              that_this.myfavorites.push(id)
            }
   
          });
    });



  },
  methods: {

                saveFavorite(item,type) {
         
          var that_this = this;
      if (this.guest) EventBus.$emit("open_login", { same_page_login: true });
      else {
          this.$store
          .dispatch("favorite/saveFavorite", {
            id: item.id,
            type:type,
          })
          .then(() => {
            if(type=='remove'){
              var  arr= that_this.myfavorites;
              for( var i = 0; i < arr.length; i++){                                 
                if ( arr[i] === item.id) { 
                    arr.splice(i, 1); 
                    i--; 
                }
                }
                that_this.myfavorites = arr; 
            }else{
              that_this.myfavorites.push(item.id)
            }
          });
      }
        
    },


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

        var that_this  = this;
        axios
        .get("/api/v1/user/myfavorities",{})
        .then((response) => {
          that_this.myfavorites=response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    



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

  .suggestion {
    position: relative;}
  .suggestion .card-wrapper {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(155px, 1fr));
    grid-gap: 28px; }

.btn-follow {
  color: #9759FF;
  background-repeat: #fff;
  padding: 5px 20px;
  font-size: 12px;
  font-weight: 600;
  letter-spacing: 0px;
  border-radius: 9px;
  border: 2px solid #9759FF;  
  display: flex;
  align-items: center;
  justify-content: center;  
  }
.btn-follow-loggedin {
  color: #F77F98;
  background-repeat: #fff;
  font-size: 12px;
  font-weight: 600;
  letter-spacing: 0px;
  border-radius: 9px;
  border: 2px solid #F77F98; 
  display: flex;
  align-items: center;
  justify-content: center;   
  }
  .week .btn-follow, .week .btn-follow-loggedin
  {
    width: 160px;
    height: 40px;
    text-align: center; 
  }

.live-now {
  padding: 30px 0px;
  background: #F1F1F1 0% 0% no-repeat padding-box; }

.category-icone {
  font-size: 20px;
  color: #000;
  text-align: center;
  border-radius: 4px;
  background: #F77F98; 
  width: 50px;
    height: 36px;
    display: table;
}
.category-icone i
{
  display: table-cell;
    vertical-align: middle;
}
.category-icone svg
{
  margin: 10px;
}

.category-name {
  color: #F77F98;
  font-size: 22px;
  margin:0;
  margin-left: 16px;
  align-self: center; 
  font-weight: 600;
}

.bigcard-wrapper {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(337px, 1fr));
  grid-gap: 20px;
}
.bigcard {
  width: 335px !important;
}
.model-img {
  min-height: 144px;
  max-width: 135px;
  overflow: hidden;
  border-radius: 20px;
  border: 2px solid #E31616;
}
.model-img img {
  border-radius: 20px;
  border: 2px solid #fff;
}
.model-info {
  flex-grow: 1;
  align-self: center;
  background: #fff;
  padding: 20px;
  border-radius: 0px 20px 20px 0px;
  box-shadow: 0px 3px 6px rgb(0 0 0 / 10%);
}

.model-info .rate {
  font-weight: 500;
  font-size: 12px;
  color: #131220;
  letter-spacing: 0px;
  margin-bottom: 0;
}
.model-info .model-name {
  font-size: 18px;
  color: #131220;
  margin-bottom: 0;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 180px;
}
.model-info .model-type h6 {
  color: #949498;
  font-size: 12px;
  font-family: 'Montserrat', sans-serif;
  margin-bottom: 25px!important;
  line-height: 16px;
  font-weight: 600; 
}

.btn-view-more {
  color: #fff;
  width: 160px;
  display: inline-block;
  padding: 10px 30px;
  border-radius: 9px;
  font-size: 12px;
  font-weight: 600;
  letter-spacing: 0;
  background: transparent linear-gradient(90deg, #9759FF 0%, #7272FF 100%) 0% 0% no-repeat padding-box;
}

.featured {
  padding: 30px 0px;
  background: #f9f9f9;
}
.featured .model-img {
  border: none;
}

.all {
  padding: 30px 0px;
  background: #F1F1F1;
}
.all .model-img {
  border: none;
}

.week {
  padding: 30px 0px;
  background: #fff;
}
.week .week-title {
  text-align: center;
  color: #42424D;
  font-size:24px;
  font-weight: 500;
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
  position: relative;
  border-radius: 10px;
  overflow: hidden;
}
.week .img-item:nth-child(2) {
  grid-row: 1/-1;
  grid-column: 2/-1;
  justify-self: start;
}
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
  visibility: hidden;
}
.week .img-item:hover .hover-overlay {
  bottom: 0;
  opacity: 1;
  visibility: visible;
}
.week .gallary-info {
  margin-top: 30px;
  flex-grow: 1;
}
.gallary-info .rate {
  color: #131220;
  font-size: 12px;     
  font-weight: 500;
}
.gallary-info .model-name {
  margin: 11px 0 8px;
  color: #131220;
  display: block;
  font-size: 28px;   font-weight: 600;
}
.gallary-info .model-name-mobile {
  margin: 11px 0 8px;
  color: #131220;
  display: none;
  font-size: 18px;   font-weight: 600;
}
.gallary-info .model-title {
  color: #949498;
  font-size: 14px; font-weight: 600;
}
.gallary-info .description {
  color: #131220; 
  font-size: 14px;
  font-weight: 500;
}

.signin {
  padding: 35px 0px;
  background: #F1F1F1; }
  .signin .slogan {
    color: #000;
    text-transform: uppercase;
    text-align: center;
    font-size: 40px;
    font-weight: 700; }
  .signin .slogan-2 {
    font-size: 28px;
    text-align: center;
    font-weight: 400; }
  .signin .text-light {
    font-size: 12px;
    margin-left: 10px; }
  .signin label {
    font-size: 12px; 
  }
  .signin h4,
  .signin h5
  {
    font-size: 12px; 
    line-height: 14px;
    font-weight: 600;
    display: inline-block;
    margin-bottom: .5rem;
  }
  .signin h4 span
  {
    color: #f00;
  }
  .signin h5 a
  {
    color: #F78099;
  }
  .signin h5.apply_h5
  {
    display: block;
  }
  .signin h5.apply_h5 span
  {
    display: inline-block;
    width: 49%;
    text-align: center;
  }

.social_buttons
{
  text-align: center;
  width: 100%;
  display: block;
}
.btn-google {
  padding: 4px;
  background: #4285F4;
  display: block;
  border-radius: 5px; }
  .btn-google .fa-google {
    font-size: 18px;
    padding: 8px;
    color: #fff;}

.btn-twitter {
  display: block;
  padding: 5px;
  border-radius: 5px;
  background: #03AFF0; }
  .btn-twitter .fa-twitter {
    font-size: 18px;
    padding: 8px;color: #fff; }
.social_buttons span.text-light
{
  vertical-align: text-top;
}
.signin hr
{
  border-color: #898990;
}
.or_hr
{
  position: relative;
  border-color: #898990;
}
.or_hr:after
{
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
  .homepage{
    margin-top: 58px;
  }
  .homepage-loggedin{
    margin-top: 98px;
  }

@media screen and (max-width: 420px) and (min-width: 260px) {
  .homepage{
    margin-top: 58px;
  }
  .homepage-loggedin{
    margin-top: 40px;
  }
  .suggestion .card-wrapper {
    grid-gap: 15px; }
    .week .week-title {
      font-size: 20px;
    }
}

.mobile_1 {
  display: none; }

@media screen and (max-width: 992px) {

  .mobile_1 {
    position: absolute;
    top: 24px;
    right: 0px;
    left: 0;
    margin: 0 auto;
    text-align: center;
    display: block; }
    .mobile_1 .pr-0 {
      display: block; }

  .pr-0 {
    display: none; } }
  /* @media only screen and (max-width: 600px) {
    .homepage{
      margin-top: 66px;
    }
    .homepage-loggedin{
      margin-top: 66px;
    }
  } */
@media screen and (max-width: 600px) {
.gallary-info .model-name {
  display: none;
  }
.gallary-info .model-name-mobile {
  display: block;
  }
    .suggestion .card-wrapper {
      display: table; }
  .section-title {
    margin-left: 10px;
    margin-right: 10px;
  }
  .main_card {
    position: relative;
    min-height: 1px;
    padding-right: 5px;
    padding-left: 5px;
    float: left;
    width: 50%;
    margin-bottom: 20px; }

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
    max-width: 100%;
    flex: 0 0 100%;
    text-align: center;
    margin: 10px auto;
    display: table; }
  .signin .btn-google {
    width: 100%; }
  .signin .d-flex {
    display: block !important; }
  .signin .text-center {
    margin: 20px 0; } }
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
