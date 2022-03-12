<template>
  
 <div class="bigcard-wrapper">
  	<div style="padding-bottom:10px" class="col-lg-4 col-md-6 portfolio-item filter-live" v-for="(item, index) in items" :key="index">
  	    <div class="bigcard d-flex mb-4">
		      <div class="model-img"><img :src="item.profile.cover_path" width="100%"></div>
		      <div class="model-info" style="flex-grow: 1;
  align-self: center;
  background: #fff;
  padding: 20px;
  border-radius: 0px 20px 20px 0px;
  box-shadow: 0px 3px 6px #0000001F;">
				<p class="rate">TOP 10% MODEL Live </p>
				<p class="model-name">{{item.profile.display_name.charAt(0).toUpperCase() + item.profile.display_name.slice(1, 8).concat('...')}}</p>
				<p class="model-type">Instagram Model</p>
				<a href="#" class="btn-follow">Follow</a>
		      </div>
	   
       </div> 
      </div>   
     
       <div class="col-lg-4 col-md-6 portfolio-item filter-featured" v-for="(model, index) in models" :key="index">
  	     <div class="bigcard d-flex  mb-4">
		      <div class="model-img"><img :src="item.profile.cover_path" width="100%"></div>
		        <div class="model-info" style="flex-grow: 1;
  align-self: center;
  background: #fff;
  padding: 20px;
  border-radius: 0px 20px 20px 0px;
  box-shadow: 0px 3px 6px #0000001F;">
				<p class="rate">TOP 10% MODEL featured</p>
				<p class="model-name">{{item.profile.display_name.charAt(0).toUpperCase() + item.profile.display_name.slice(1, 8).concat('...')}}</p>
				<p class="model-type">Instagram Model</p>
				<a href="#" class="btn-follow">Follow</a>
		      </div>
         </div>
       </div> 
 </div> 
 
 
  
    
</template>
<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      hover: false,
      // videoAudioDialog: false,
      item: {},
      // video: false,
      // audio: false,

      showLoadMore: true,
      number: null,
      col: 2,
      window: 0,
      items: [],
      page: 1,
      scrollControl: 0,
      init: true,
      rating: false,
      perPage: 0,
    };
  },
  props: {
    setOnline: {
      type: Function,
    },
    setFeatured: {
      type: Function,
    },
    categorySlug: {
      default: 0,
    },
    skeletor: {
      default: false,
    },
    filters: {
      default: null,
    },
    cols: {
      type: Number,
      default: null,
      required: false,
    },
    rows: {
      type: Number,
      default: null,
      required: false,
    },
    rating_rows: {
      type: Number,
      default: null,
      required: false,
    },
    bottomOff: {
      default: false,
    },
    guest: {
      default: true,
    },
    perPageProp: {
      type: Number,
      default: null,
      required: false,
    },
  },

  computed: {
    ...mapGetters({
      models: "psychic/items",
    }),
  },
  methods: {

    getParams() {
      return { cat: this.categorySlug, filters: this.filters };
    },
    
 
  },
  created() {
    let params = this.getParams();

    this.$store.dispatch("psychic/getItems", params).then(() => {
        this.items = this.models;
      });
  },
  mounted() {
    //EventBus.$on(" open_login   ", () => (this.loginDialog = true));
  },
};
</script>

<style scoped>
  
  .btn-follow{
    color: #9759FF;
    background-repeat: #fff;
    padding: 5px 20px;
    font-size: 12px;
    letter-spacing: 0.43px;
    border-radius: 9px;
    border: 2px solid #9759FF;
  }

 .btn-view-more{
  color:#fff;
  display: inline-block;
  padding: 10px 30px;
  border-radius: 9px;
  font-size: 14px;
  background: transparent linear-gradient(90deg, #9759FF 0%, #7272FF 100%) 0% 0% no-repeat padding-box;
} 

.bigcard-wrapper{
  display: grid;
    grid-template-columns: repeat(auto-fit,minmax(337px,1fr));
    grid-gap: 14px;
}
.model-img{
  min-height: 144px;
  max-width: 135px;
  overflow: hidden;
  border-radius: 20px;
  border:2px solid  #E31616;
    
}
img{
    border-radius: 20px;
    border: 2px solid #fff;
}
.model-info{
  flex-grow: 1 !important;
  align-self: center !important;
  background: #fff;
  padding: 20px;
  border-radius: 0px 20px 20px 0px;
  box-shadow: 0px 3px 6px #0000001F;
    
}
.rate{
    font-weight: 500;
    font-size: 12px;
    color: #131220;
    letter-spacing: 0px;
    margin-bottom: 0;
}
.model-name {
    font-size: 18px;
    color:#131220;
    margin-bottom: 0;
}
.model-type{
    font-size: 11px;
    color: #949498;
}
@media only screen and (max-width: 600px) {
    .bigcard-wrapper{
      display: grid !important;
    }

  }

</style>
