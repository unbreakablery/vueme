<template>
<div class="card-wrapper"  >
  <!-- <ListItems/> -->
    <!-- card start -->
    <div class="main_card" v-for="(item, index) in items" :key="index" >
      <div class="mycard card_folllou" >
        <a v-bind:href="'/'+ item.profile.profile_link" target="_self">
        <div class="img"><img :src="item.profile.profile_headshot_url" style="width:100%;height: auto" alt="model image"></div>
        </a>
        <p class="name">{{item.profile.display_name.charAt(0).toUpperCase() + item.profile.display_name.slice(1, 8).concat('...')}}</p>
        <p class="card-title">Brunette</p>
        <span><!-- v-if="!user || user.role_id != 1" -->
          <a  v-if="myfavorites.includes(item.id)"  v-on:click="saveFavorite2(item,'remove')" class="btn-follow">Following</a>
          <a   v-if="!myfavorites.includes(item.id)" v-on:click="saveFavorite2(item,'save')" class="btn-follow-loggedin">Follow</a>
        </span>
      </div>
    </div>
    <!-- card end -->
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
    myfavorites:{
    type: Array,
        default: () => []
    },
    guest: {
       default:false,
      type: Boolean
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
    }),
  },
  methods: {

    getParams() {
      return { cat: this.categorySlug, filters: this.filters };
    },
    saveFavorite2(item,type) {
           if (this.guest) {
              EventBus.$emit("open_login", { same_page_login: true })
            }else{
      EventBus.$emit("delete_follower", { id: item.id, type:type,});
            }

        
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
 .suggestion .card-wrapper {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(155px, 1fr));
    grid-gap: 28px; }
  .suggestion .mycard {
    text-align: center;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: .35rem;
    min-height: 194px;
    padding: 16px 10px 18px; }
    .suggestion .mycard .img {
      margin: 0 auto;
      width: 64px;
      height: 64px;
      margin-bottom: 11px;
      border-radius: 50%;
      border: 2px solid #E31616;
      overflow: hidden; }
    .suggestion .mycard .name {
      color: #131220;
      font-size: 12px;
      font-weight: 700px;
      margin-bottom: 5px;
      letter-spacing: 0px; 
        line-height: 18px;
        font-weight: 600; 
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 139px;
        margin: 0 auto;
      }
    .suggestion .mycard .card-title {
      color: #949498;
      font-size: 12px;
      font-family: 'Montserrat', sans-serif;
      margin-bottom: 25px;
        line-height: 16px;
        font-weight: 600; }
.btn-follow {
  color: #9759FF;
  background-repeat: #fff;
  padding: 5px 18px;
  font-size: 12px;
  font-weight: 600;
  letter-spacing: 0px;
  border-radius: 9px;
  border: 2px solid #9759FF;    
  }
.btn-follow-loggedin {
  color: #F77F98;
  background-repeat: #fff;
  padding: 5px 20px;
  font-size: 12px;
  font-weight: 600;
  letter-spacing: 0px;
  border-radius: 9px;
  border: 2px solid #F77F98;    
  }
  .week .btn-follow
  {
  width: 160px;
    display: table-cell;
    text-align: center; 
  }
@media screen and (max-width: 1060px) {
  .suggestion .card-wrapper {
    display: flex!important;
    overflow-x: scroll;
    grid-gap: 15px; 
  }
  .suggestion .card-wrapper::-webkit-scrollbar {
    height: 0;
  }

  .main_card {
    position: relative;
    min-height: 1px;
    float: left;
    width: 50%;
    min-width: 155px;
    margin-bottom: 0px; }
}

</style>
