<template>
<div :class="[(mobile) ? 'px-20' : '']">
  <div class="bigcard-wrapper">
      <!-- card section -->
        <div class="bigcard d-flex" v-for="(item, index) in showItems" :key="index">
          <div :class="['model-img', (item.online) ? 'model-online' : '']">
            <a v-bind:href="'/'+ item.profile.profile_link" target="_self">
              <img :src="item.profile.cover_path" width="100%">
            </a>
          </div>
          <div class="model-info">
            <p class="rate">TOP 10% MODEL</p>
            <p class="model-name">{{item.profile.display_name.charAt(0).toUpperCase() + item.profile.display_name.slice(1, 8).concat('...')}}</p>
            <h6>Instagram Model</h6>
            <div><!-- v-if="!user || user.role_id != 1" -->
            <a  v-if="myfavorites.includes(item.id)"  v-on:click="saveFavorite(item,'remove')"  class="btn-follow">Following</a>
            <a v-if="!myfavorites.includes(item.id)" v-on:click="saveFavorite(item,'save')"  class="btn-follow-loggedin" >Follow</a>
            </div>
            <!--<a v-bind:href="'/live/'+ item.profile.profile_link" target="_blank" class="btn-follow">View</a>-->
          </div>
        </div>
      <!-- card section end -->
  </div>
  <div class="d-block text-center" style="margin: 50px 0 20px;">
    <a class="btn-view-more" @click="more_view()" href="javascript:void(0)">View More</a>
  </div>
</div>
</template>
<script>
import { mapGetters } from "vuex";

export default {
  // props: {
  //   authqq: {
  //     type: String,
  //   }
  // },
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
      init: true,
      rating: false,
      perPage: 6,    
    };
  },
  props: {
        myfavorites:{
    type: Array,
        default: () => []
    },
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
    user: {
      
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
  watch: {
    page: {
      handler: function(val) {
        this.showItems = this.items.slice(0, val * this.perPage);
      }
    }
  },
  methods: {
    getParams() {
      return { cat: this.categorySlug, filters: this.filters };
    },
    more_view() {
      this.page++;
    }, 

    saveFavorite(item,type) {
           if (this.guest) {
              EventBus.$emit("open_login", { same_page_login: true })
            }else{
      EventBus.$emit("delete_follower", { id: item.id, type:type,});
            }

        
    },
  },
  created() {
    let params = this.getParams();

    this.$store.dispatch("psychic/getSectionItems", params).then(() => {
        this.items = this.models;

        try {
              if(params.filters.is_streaming_live){
            if(this.items.length == 0){
                        this.$root.$emit("hide_section", params);
                      }
              }
            } catch (e) {

            }
        // this.$root.$emit("live_models_number", {
        //       models_number: this.items.length
        // });
        // console.log('this.items', this.items)
        this.showItems = this.items.slice(0, this.page * this.perPage);
      });
  },
  mounted() {
    //EventBus.$on(" open_login   ", () => (this.loginDialog = true));
  },
};
</script>

<style scoped>
.px-20 {
  padding: 0 20px !important;
}
.btn-follow {
  color: #9759FF;
  padding: 4px 20px;
  font-size: 12px;
  font-weight: 600;
  letter-spacing: 0px;
  border-radius: 9px;
  border: 2px solid #9759FF;    
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
.week .btn-follow, .week .btn-follow-loggedin {
  width: 160px;
  display: table-cell;
  text-align: center; 
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
