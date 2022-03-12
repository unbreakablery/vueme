<template>
  <div class="homepage">
    <section class="suggestion pb-3" style="background: #E7E6E8;" >
      <div class="container">
       <div class="title"> <b>Explore</b> </div>
       <div class="card-wrapper"  > 
                  <span style="display:none"> {{  x = 1 }} </span>
	    <div class="main_card"  v-for="model in models" >
		     <div v-if="x!=4" class="mycard" >
                  <div class="img"><img src="/images/models/model.jpg" style="width:100%;height: auto" alt="model image"></div>
                  <p class="model-name"><b>{{model.name.toUpperCase().substring(0, 12)}}</b></p>
            
                <a href="#" class="btn-follow">Follow</a>
                <div v-if="x===1">
                      <a href="#" >
                          <img src="/images/models/newmodellock.png" style="width:90%;height: auto;border-radius: 10%;" alt="model image">
                      </a>
                  </div>
                <div v-if="x>1">
                      <img src="/images/models/newmodel.png" style="width:100%;height: auto;border-radius: 10%;" alt="model image">
                </div>
                  <div id="overlay"></div>
                <p class="textlaying">Laying in the bad all alone tonight, care to lay dawn with me?</p>
                <div style="padding-top:10px;width:100%">
                      <i class="fa fa-heart" aria-hidden="true" style="float:left;color:blue"><span class="spanp">500</span></i>  <i class="fas fa-comment"  style="float:left;"><span class="spanp">300</span></i> <i class="fas fa-external-link-alt" style="float:right"></i>
                  </div>
                  
		     </div>
		     
		     <div v-if="x===4" class="mycard" >
			        <div class="img"><img src="/images/models/model.jpg" style="width:100%;height: auto" alt="model image"></div>
		         	<p class="model-name"><b>{{model.name.toUpperCase().substring(0, 12)}}</b></p>
		        	<a href="#" class="btn-follow">Follow</a>
		          <div style="clear:both"></div>
			       <div class="intagram">
			             <div class="imgint"><img src="/images/models/model.jpg" style="width:100%;height: auto" alt="model image"></div>
			              <p class="model-name-insta"><b>{{model.name.toUpperCase().substring(0, 12)}}</b><br>32.5k Followers</p>
			             <a href="#" class="btn-follow">view profile</a>
			             <div style="clear:both"></div>
			             <span v-if="!isMobile()">
					     <img src="/images/models/instagram.png" style="width:100%;height: auto;" alt="model image">
					     <a href="">view more on instagram</a>
					     
			             </span>
			             <span v-else>
			                   <p class="textlaying" style="padding-left:5px"> Check out my latesh photo fom last week's photoshot on my Sexy1on1 page! </p>
			                  <p> <i class="fa fa-heart" aria-hidden="true" style="color:blue"><span class="spanpn">1,830 10:50AM Jun 18,2019</span></i> </p> 
			                   <i class="fas fa-comment"  style="">
			                   <span class="spanpn">1,800 people taking about this</span></i> 
			             </span>
			        </div>
			
		          
		      
		        
		      
              <div style="padding-top:10px;width:100%">
              
              </div>
		     </div>
		      <span style="display:none"> {{  x = x+1 }} </span>
         </div> 
         
              
            
      
    </div>
              <div style="text-align:center;padding-top:30px">
                <a  @click="more_view()" href="javascript:void(0)">
                  <span class="viewmore" >View more</span>
                </a>
              </div>          
   </div>
  </section>
 </div>     
</template>


<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return{
      models: [ ],
      perPage: 8,
      count1:1,
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
      getcount: function() {
               
       return  this.count1 +=1;
        
},isMobile() {
                if( screen.width <= 760 ) {
                    return true;
                }
                else {
                    return false;
                }
            }
        ,
     more_view() {
         let params = this.getParams();
        this.perPage= this.perPage +10;
        this.$store.dispatch("psychic/perPage", this.perPage);
        this.$store.dispatch("psychic/getItems", params).then(() => {
              this.models=this.models ;
             
              
       
      }); 
    },
  
   } ,
  created() {
        let params = this.getParams();
         this.$store.dispatch("psychic/perPage", this.perPage);
        this.$store.dispatch("psychic/getItems", params).then(() => {
              this.models=this.models ;
 
      }); 
  }
}
</script>



<style scoped>

#overlay {
  position: relative; /* Sit on top of the page content */
  display: block; /* Hidden by default */
  width: 100%; /* Full width (cover the whole page) */
  height: 100%; /* Full height (cover the whole page) */
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0,0,0,0.5); /* Black background with opacity */
  z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
  cursor: pointer; /* Add a pointer on hover */
}
  .card-wrapper{
      display: grid !important;
      grid-template-columns: 1fr 1fr 1fr 1fr;
      grid-gap: 14px;
      
      
  }
  .mycard{
      
      text-align: center;
      
      background-clip: border-box;
      
      border-radius: .25rem;
      padding:15px 10px;
      
      
  } 
  
  .intagram {
  background: white 0% 0% no-repeat padding-box;
    padding-top: 10px;
    font-size: 10px;
    letter-spacing: 0.43px;
    border-radius: 5%;
    border: 1px solid #949498;
  } 
  .img{
      margin: 0 auto;
      width: 34px;
      height: 34px;
      margin-bottom: 10px;
      border-radius: 50%;
      border: 2px solid #E31616;
      overflow: hidden;
      float:left;
  }
  .imgint{
      margin: 0 auto;
      width: 24px;
      height: 24px;
      margin-bottom: 10px;
      margin-left: 10px;
      border-radius: 50%;
      border: 2px solid #E31616;
      overflow: hidden;
      float:left;
  }
  .model-name{
      color:#42424D;
      font-size: 12px;
      font-weight: 700px;
      margin-bottom: 5px;
      letter-spacing: 0px;
      float:left;
      padding:10px;
     
  }
  .model-name-insta{
      color:#42424D;
      font-size: 10px;
      font-weight: 700px;
      letter-spacing: 0px;
      float:left;
      padding-left:5px;
  }
  .model-title{
      color:#949498;
      font-size: 11px !important;
      margin-bottom: 20px;
  }
  .textlaying{
      color:#949498;
      font-size: 12px !important;
      margin-top: 20px;
      text-align:left;
  }
  .title{
      color:#9759FF;
      font-size: 15px !important;
      margin-top: 20px;
      text-align:center;
  }
  .spanp{
     padding:5px;
     color:#949498;
      font-size: 11px !important;
  }
  .spanpn{
     padding:5px;
     color:#949498;
      font-size: 11px !important;
      text-align:left;
  }
  .btn-follow{
    color: #9759FF !important;
    background-repeat: #fff;
    background: #F1F1F1 0% 0% no-repeat padding-box;
    padding: 5px 20px;
    font-size: 10px;
    letter-spacing: 0.43px;
    border-radius: 9px;
    border: 2px solid #9759FF;
    float:right;
  }
  
  .viewmore{
    color: #fff;
    background-repeat:#9759FF ;
    background: #9759FF 0% 0% no-repeat padding-box; 
    padding: 5px 20px;
    font-size: 12px;
    letter-spacing: 0.43px;
    border-radius: 9px;
    border: 2px solid #9759FF;
  }
  .live-now{
    padding: 30px 0px;
    background: #F1F1F1 0% 0% no-repeat padding-box; 
  }
  @media only screen and (max-width: 600px) {
    .card-wrapper{
     display: grid !important;
     grid-template-columns: 1fr ;
    }
    }
 @media screen  and (max-width: 1100px) and (min-width: 600px) {
  .card-wrapper{
   display: grid !important;
     grid-template-columns: 1fr 1fr ;
    }
  }
 @media screen and (min-width: 1100px)  { 
  .card-wrapper{
   display: grid !important;
     grid-template-columns: 1fr 1fr 1fr 1 fr ;
    }
  }

  
</style>
