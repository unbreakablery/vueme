<template>
<div>
  <div class="row">
    <div class="col-lg-12 d-flex justify-content-center">
      <ul id="portfolio-flters">
        <!-- <button v-for="(val, key) in option.getFilterData" class="button" :class="[key===filterOption? 'is-checked' : '']" @click="filter(key)">{{key}}
        </button> -->
        <li class="models-live" @click="filter('live')"><i class="fas fa-broadcast-tower models-tab-icon"></i><br/>Live Now</li>
        <li class="models-featured" @click="filter('featured')" ><i class="fa fa-star models-tab-icon"></i><br>Featured</li>
        <li class="models-all" @click="filter('all')"><i class="fa fa-users models-tab-icon icon-active"></i><br>All</li>
      </ul>
    </div>
  </div>
  
  <div id="root_isotope" class="isoDefault">
    <transition-group name="list" tag="div" class="bigcard-wrapper">
      <div class="bigcard d-flex" v-for="e in list" :key="e.id">
        <div :class="['model-img', (e.online) ? 'model-online' : '']"><img :src="e.profile.cover_path" width="100%"></div>
        <div class="model-info">
          <p class="rate">TOP 10% MODEL</p>
          <p class="model-name">{{e.profile.display_name.charAt(0).toUpperCase() + e.profile.display_name.slice(1, 8).concat('...')}}</p>
          <h6 class="model-type">Instagram Model</h6>
          <a href="#" v-if="myfavorites.includes(e.id)"  v-on:click="saveFavorite(e,'remove')" class="btn-follow">Following</a>
          <a href="#"  v-if="!myfavorites.includes(e.id)" v-on:click="saveFavorite(e,'save')" class="btn-follow-loggedin">Follow</a>
        </div>
      </div>
    </transition-group>
  </div>
  
  <div class="col-12 portfolio-item">
    <div class="my-5 d-block text-center">
      <a class="btn-view-more" @click="viewMore()" href="javascript:void(0)">
      View More</a>
    </div>
  </div>
</div>
</template>
<script>

document.addEventListener('DOMContentLoaded', () => {

  let myBtns=document.querySelectorAll('.models-tab-icon');
  myBtns.forEach(function(btn) {

    btn.addEventListener('click', () => {
      myBtns.forEach(b => b.classList.remove('icon-active'));
      btn.classList.add('icon-active');
    });

  });
});

import { mapGetters } from "vuex";

export default {
  components: {
    
  },
  props: ['guest'],
  data() {
    return {
      liveItems: [],
      featuredItems: [],
      allItems:[],
      livePage: 1,
      featuredPage: 1,
      allPage: 1,
      myfavorites:[],
      
      list: [],
      perPage: 12,
      defaultPerPage: 15,
      currentPage: ''
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
      mobile: "util/mobile"
    }),
  },
  methods: {

    getParams() {
      return { cat: this.categorySlug, filters: this.filters };
    },

    other_methos(){

    let params = this.getParams();

    this.$store.dispatch("psychic/getSectionItems", params).then(() => {
      this.models.forEach(element => {
        this.allItems.push({
          id: element.id,
          profile: element.profile,
          online: (element.online == 1 || element.online == true) ? true : false
        });

        if (element.featured == 1) {
          this.featuredItems.push({
            id: element.id,
            profile: element.profile,
            online: (element.online == 1 || element.online == true) ? true : false
          });
        }
        if (element.is_streaming_live == 1) {
          this.liveItems.push({
            id: element.id,
            profile: element.profile,
            online: (element.online == 1 || element.online == true) ? true : false
          });
        }
      });
      this.list = this.allItems.slice(0, this.defaultPerPage);
      this.currentPage = 'all';
    });
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



    filter: function(key) {
      switch (key) {
        case 'all':
          this.allPage = 1;
          this.currentPage = 'all';
          this.list = this.allItems.slice(0, this.defaultPerPage);
          break;
        case 'live':
          this.livePage = 1;
          this.currentPage = 'live';
          this.list = this.liveItems.slice(0, this.defaultPerPage);
          break;
        case 'featured':
          this.livePage = 1;
          this.currentPage = 'featured';
          this.list = this.featuredItems.slice(0, this.defaultPerPage);
          break;
      }
    },
    viewMore() {
      switch (this.currentPage) {
        case 'all':
          this.allPage++;
          this.list = this.allItems.slice(0, this.defaultPerPage + (this.allPage - 1) * this.perPage);
          break;
        case 'live':
          this.livePage++;
          this.list = this.liveItems.slice(0, this.defaultPerPage + (this.livePage - 1) * this.perPage);
          break;
        case 'featured':
          this.featuredPage++;
          this.list = this.featuredItems.slice(0, this.defaultPerPage + (this.featuredPage - 1) * this.perPage);
          break;
      }
    }
  },
  created() {
    if (this.mobile) {
      this.perPage = 10;
      this.defaultPerPage = 10;
    }

      var that_this  = this;
        axios
        .get("/api/v1/user/myfavorities",{})
        .then((response) => {
          that_this.myfavorites=response.data.data;
          
        
        })
        .catch((error) => {
          console.log(error);
        });
      that_this.other_methos();
  },
  mounted() {
   // EventBus.$on(" open_login   ", () => (this.loginDialog = true));
  },
};
</script>
<style scoped>
.px-20 {
  padding: 0 20px !important;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
.list-item {
  display: inline-block;
  margin-right: 10px;
}
.list-enter-active, .list-leave-active {
  transition: all 1s;
}
.list-enter, .list-leave-to /* .list-leave-active below version 2.1.8 */ {
  opacity: 0;
  transform: translateY(30px);
}

.portfolio-container {
  min-height: calc(100vh);
}
.btn-follow {
  color: #9759FF;
  background-repeat: #fff;
  padding: 5px 20px;
  font-size: 12px;
  letter-spacing: 0.43px;
  border-radius: 9px;
  border: 2px solid #9759FF;  
  font-weight: 600;  
  width: 80px;
  height: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  }
  .btn-follow-loggedin {
  color: #F77F98;
  background-repeat: #fff;
  padding: 5px 20px;
  font-size: 12px;
  letter-spacing: 0.43px;
  border-radius: 9px;
  border: 2px solid #F77F98;   
  font-weight: 600;  
  width: 80px;
  height: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  }
  .week .btn-follow, .week .btn-follow-loggedin
  {
    width: 160px;
    display: table-cell;
    text-align: center; 
  }

.bigcard-wrapper {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(337px, 1fr));
  grid-gap: 20px; 
  margin-bottom: 30px;
  margin-left: 15px;
  margin-right: 15px;
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
}
.model-img img {
  border-radius: 20px;
  border: 2px solid #fff;
  height: 187px;
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
.model-info h6 {
  color: #949498;
  font-size: 12px;
  font-family: 'Montserrat', sans-serif;
  margin-bottom: 10px!important;
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
  background: transparent linear-gradient(90deg, #9759FF 0%, #7272FF 100%) 0% 0% no-repeat padding-box;
}

@media only screen and (max-width: 600px) {
  .bigcard-wrapper{
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

  .model-info .model-name {
    font-size: 16px;
  }
}
/* .item {
    padding: 5px 15px;
  } */

</style>
