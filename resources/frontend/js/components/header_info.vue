<template>
<div>
   <!-- <header v-if="user && (login_counter == 1 || login_counter == 2)" :style="[mobile ?{'height':'60px'}:{'height':'45px'}]" style="background-color:#43435B;padding: 10px 0;backdrop-filter: blur(11px);">
            <div class="container p-0">
                <div class="row m-0 flex">
                    <div class="col-12 text-center info_browser" style="padding: 0px 30px !important;">
                        <span class="text-white m-0 small-device">{{getSystemMessage()}}</span>
                    </div>
                    <v-icon style="position: absolute;right: 10px;color: white;font-size: 15px;padding: 5px;" @click="remove_header_info">mdi-close</v-icon>
                </div>
            </div> 
      </header> -->
        <!-- <header class="py-lg-2 py-1" v-if="!user" :style="[mobile ?{'height':'40px', 'font-size': '10px!important'}:{'height':'45px'}]" style="background-color:#43435B;backdrop-filter: blur(11px);">
            <div class="container p-0">
                <div class="row m-0 flex">
                    <div class="col-12 text-center info_browser" style="padding: 0px 30px !important;">
                        <a :style="[mobile ?{'font-size': '10px!important'}:{'font-size': '14px'}]" href="https://www.startengine.com/models-1on1?utm_source=respectfully&utm_medium=website_banner&utm_campaign=start_engine" target="_blank" class="text-white m-0 small-device">
                        Invest in your future, become part of Respectfully™
                        <img src="/images/icons/chevron-right.svg" />
                        </a>
                    </div>
                     
                </div>
            </div> 
      </header> -->
      </div>
</template>

<script>

    import Vue from "vue";
    import { mapGetters } from "vuex";
    export default {
        name: 'info_header',
        props:['user','included'],
        data: function() {
           return {
               login_counter: this.user ? this.user.login_counter : 0,               
           };
        },
        computed: {
            ...mapGetters({
            space_header: "util/space",
            mobile: "util/mobile",
            }),

        },
        mounted() {
           
        },
        created(){
      
         
         if(this.mobile){
             if(!this.user){             
              this.$store.commit("util/space",{space : this.space_header + 40});              
            }
             else if(this.user && (this.login_counter == 1 || this.login_counter == 2)){             
              this.$store.commit("util/space",{space : this.space_header + 60});              
            }
          }else{
              let value = this.included == 'backend' ? 80 : 118;
              if(!this.user){
                    this.$store.commit("util/space",{space : value + 0});
              }else if(this.user && (this.login_counter == 1 || this.login_counter == 2)){
                   this.$store.commit("util/space",{space : value + 0});
              }else{
                  this.$store.commit("util/space",{space : value});
              }
          }  
          
        },
        methods: {
          getSystemMessage() {
                    var userAgent = navigator.userAgent || navigator.vendor || window.opera;
                    
                    // if (/android/i.test(userAgent)) {
                    //     return 'For the best video & call experience, we recommend using Chrome on a computer.';
                    // }
                    if (/iPad|iPhone|iPod|Mac/.test(userAgent) && !window.MSStream) {
                        return 'For the best video & call experience, we recommend using Safari on a computer.';
                    }

                    return 'For the best video & call experience, we recommend using Chrome on a computer.';
                },  
          remove_header_info() {  

           Vue.set(this.user, "login_counter", 3);
           this.login_counter = 3;
            let remove_height = this.mobile ? 60 : 45;
            this.$store.commit("util/space",{space : this.space_header - remove_height});
      axios
        .post("/api/v1/user/header/info")
        .then((res) => {
          
         
        })
        .catch((error) => {
     
        });
    },
        },
    };
</script>

<style scoped>
  .small-device{
      font-size: 14px;
      font-weight: 600;
  }
  @media only screen and (max-width: 370px) {
     .small-device{
      font-size: 13px;
      
  }
  @media only screen and (max-width: 348px) {
     .small-device{
      font-size: 9px;
      
  }
  }
  }
</style>
