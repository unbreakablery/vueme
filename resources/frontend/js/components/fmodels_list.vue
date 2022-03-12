<template>
  
      <div>
  	<div class="col-lg-4 col-md-6 portfolio-item filter-web" v-for="(model, index) in models" :key="index">
  	    <div class="portfolio-wrap">
              <div class="model-img"><img src="/images/models/model.jpg" width="100%"></div>
	      <div class="model-info">
			<p class="rate">TOP 10% MODEL</p>
			<p class="model-name">{{model.name.toUpperCase()}}</p>
			<p class="model-type">{{model.type}}</p>
			<a href="#" class="btn-follow">Follow</a>
	      </div>
             </div>
          </div>   
      </div>
    
    
    
 </div> 
 
 
 
    
</template>
<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return{
      models: [
        { name : 'Sophie Asveld', type: "FaceBook Model"} ,
        { name : 'Sophie Asveld', type: "Instagram Model"} ,
        { name : 'Sophie Asveld', type: "Instagram Model"} ,
        { name : 'Sophie Asveld', type: "Instagram Model"} ,
        { name : 'Sophie Asveld', type: "Instagram Model"} ,

      ],
      
      perPage: 4
    }
    
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
    more_view() {
        let params = this.getParams();
        if (screen.width <= 760) 
        this.perPage=this.perPage + 10 ;
        else
        this.perPage=this.perPage + 4 ;
        this.$store.dispatch("psychic/perPage", this.perPage);
        this.$store.dispatch("psychic/getItems", params).then(() => {
              this.models=this.models ;
              console.log(this.models);
              
       
      }); 
    },
     all_view() {
        let params = this.getParams();
        if (screen.width <= 760) 
        this.perPage=this.perPage  ;
        else
        this.perPage=this.perPage  ;
        this.$store.dispatch("psychic/perPage", this.perPage);
        this.$store.dispatch("psychic/getItems", params).then(() => {
              this.models=this.models ;
              console.log(this.models);
              
       
      }); 
    },
    featured_view() {
        let params = this.getParams();
        if (screen.width <= 760) 
        this.perPage=this.perPage  ;
        else
        this.perPage=this.perPage  ;
        this.$store.dispatch("psychic/perPage", this.perPage);
        this.$store.dispatch("psychic/getItems", params).then(() => {
              this.models=this.models ;
              console.log(this.models);
              
       
      }); 
    },
    live_view() {
        let params = this.getParams();
        if (screen.width <= 760) 
        this.perPage=this.perPage  ;
        else
        this.perPage=this.perPage  ;
        this.$store.dispatch("psychic/perPage", this.perPage);
        this.$store.dispatch("psychic/getItems", params).then(() => {
              this.models=this.models ;
              console.log(this.models);
              
       
      }); 
    }
    
},
  created() {
      
        let params = this.getParams();
        if (screen.width <= 760)
          this.perPage=4;
        else
          this.perPage=10;    
        this.$store.dispatch("psychic/perPage", this.perPage);
        this.$store.dispatch("psychic/getItems", params).then(() => {
              this.models=this.models ;
              console.log(this.models);
              
       
      }); 
  }
}
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
  flex-grow: 1;
  align-self: center;
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
