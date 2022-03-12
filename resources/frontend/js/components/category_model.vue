<template>
  <div class="">
    <div class="bigcard-wrapper">
        <!-- card section -->
          <div class="bigcard d-flex" v-for="(item, index) in showItems" :key="index">
            <div :class="['model-img', (item.online) ? 'model-online' : ' offline_user']">
              <div class="contenedor_parcial" v-bind:style="{ backgroundImage: 'url(' + item.profile.profile_headshot_url + ')' }" >
                <img  :src='item.profile.profile_headshot_url'  width="100%">
              </div>
              

            </div>
            <div class="model-info">
              <p class="rate">TOP 10% MODEL</p>
              <p class="model-name">{{item.profile.display_name.charAt(0).toUpperCase() + item.profile.display_name.slice(1, 8).concat('...')}}</p>
              <p class="model-type">Instagram Model</p>
              
 
              <a v-if="myfavorites.includes(item.id)"  v-on:click="saveFavorite( item,'remove')" class="btn-follow">Followin</a>
              <a  v-if="!myfavorites.includes(item.id)" v-on:click="saveFavorite(item,'save')"  class="btn-follow-loggedin">Follow</a>
            </div>
          </div>
        <!-- card section end -->
    </div>
    <div class="row my-5 d-block text-center">
      <button class="btn-view-more" @click="more_view()" href="javascript:void(0)">View More</button>
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
      showItems: [],
      page: 1,
      scrollControl: 0,
      myfavorites:[],
      init: true,
      rating: false,
      perPage: 9,
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
    cat: {
      type: String
    }
  },
  computed: {
    ...mapGetters({
      psychics: "psychic/items",
      mobile: "util/mobile"
    }),
  },
  watch: {
    page: {
      handler: function(val) {
        this.showItems = this.items.slice(0, val * this.perPage);
      }
    }
  },
  methods: {
    getParams() {
      return { cat: this.cat };
    },
    more_view() {
      console.log(3)
      this.page++;
      if((this.page * this.perPage) >= this.items.length){
        $(".btn-view-more").css("opacity","0.5");
        $(".btn-view-more").attr("disabled",true)
      }

    },
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

  },
  created() {
    let params = this.getParams();


      var that_this  = this;
        axios
        .get("/api/v1/user/myfavorities",{})
        .then((response) => {
          that_this.myfavorites=response.data.data;
        })
        .catch((error) => {
          console.log(error);
        });


    this.$store.dispatch("psychic/getCatItems", params).then(() => {
      this.items = this.psychics;
      if (this.mobile) {
        this.perPage = 10;
      } else {
        this.perPage = 9;
      }
      
      this.showItems = this.items.slice(0, this.page * this.perPage);

      if((this.page * this.perPage) >= this.items.length){
        $(".btn-view-more").css("opacity","0.5");
        $(".btn-view-more").attr("disabled",true)
      }


    });
  },
  mounted() {
    //EventBus.$on(" open_login   ", () => (this.loginDialog = true));
  },
};
</script>

<style scoped>

.btn-follow {
  color: #9759FF;
  padding: 4px 20px;
  font-size: 12px;
  letter-spacing: 0px;
  border-radius: 9px;
  border: 2px solid #9759FF;
  font-weight: 600;
}
.btn-follow-loggedin {
  color: #F77F98;
  padding: 4px 20px;
  font-size: 12px;
  font-weight: 600;
  letter-spacing: 0px;
  border-radius: 9px;
  border: 2px solid #F77F98;    
}
.week .btn-follow {
  width: 160px;
  display: table-cell;
  text-align: center; 
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
  height: 191px;

}
.model-online {
  border: 2px solid #E31616;
  background-size: cover;
  background-position: center;
}
.model-img img {
  border-radius: 20px;
    opacity: 0;
    border: 2px solid #cbcbcd;
    height: 187px;
    background: #cbcbcd;
}
.model-img.offline_user{
     background: #cbcbcd;
    border: 2px solid #666666;
  
}
.contenedor_parcial{
   width:100%;
    background: #cbcbcd;
      background-size: cover;
  background-position: center;
}

.model-info {
  flex-grow: 1;
  align-self: center;
  background: #fff;
  padding: 20px;
  border-radius: 0px 20px 20px 0px;
  box-shadow: 0px 3px 6px rgb(0 0 0 / 10%);
  height: 144px;
  width: 198px;
  max-width: 198px;
  display: flex;
  align-items: flex-start;
  flex-direction: column;
}
.model-info .rate {
  font-weight: 500;
  font-size: 12px;
  color: #131220;
  letter-spacing: 0px;
  margin-bottom: 0;
  line-height: 17px;
}
.model-info .model-name {
  font-size: 18px;
  color: #131220;
  margin-bottom: 0;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 180px;
  font-weight: 600;
  line-height: 26px;
}
.model-info .model-type {
  font-size: 11px;
  font-weight: 600;
  color: #949498;
  line-height: 16px;
  margin-bottom: 10px;
}
.btn-view-more:focus{
  border:none;
  outline: none;
}
.btn-view-more:hover{
  border:none;
  outline: none;
}
.btn-view-more {
  color: #fff;
  width: 160px;
  outline: none;
  display: inline-block;
  padding: 10px 30px;
  border-radius: 9px;
  font-size: 12px;
  font-weight: 600;
  background: transparent linear-gradient(90deg, #9759FF 0%, #7272FF 100%) 0% 0% no-repeat padding-box;
}

@media only screen and (max-width: 600px) {
  .bigcard-wrapper {
    display: grid !important;
  }
}

@media screen and (max-width: 600px) {
  .live-now .bigcard-wrapper {
    display: block;
  }

  .featured .bigcard-wrapper {
    display: block;
  }

  .all .bigcard-wrapper {
    display: block;
  }

  .bigcard {
    margin: 0 5px 15px 5px;
  }

  .gallary-info {
    margin: 20px 0;
  }
}
</style>
