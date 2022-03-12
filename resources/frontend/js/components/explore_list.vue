<template>
  <div class="row">

    <div class="myfeed">
        <div class="col-md-6 col-lg-4 myfeed-padding" v-for="(item, index) in items" :key="index">
            <div v-if="index < 3" class="explore-box">
                <div class="model-info">
                <div class="row">
                    <div div class="col-8">
                    <div class="profile-pic"><img src="images/models/model.jpg" class="w-100"/></div>
                    <div class="name">{{item.profile.display_name.charAt(0).toUpperCase() + item.profile.display_name.slice(1, 8).concat('...')}}</div>
                    </div>
                    <div class="col-4">
                      <a  v-if="myfavorites.includes(item.id)"  v-on:click="saveFavorite(item,'remove')" class="follow-btn">Following</a>
                     <a  v-if="!myfavorites.includes(item.id)" v-on:click="saveFavorite(item,'save')" class="follow-btn btn-follow-loggedin">Follow</a>
 
                      </div>
                </div>
                </div>
                <div class="image"> <img src="images/models/big-model.png" class="w-100"/></div>
                <div class="text">
                <p>Laying in bed all alone tonight, care to lay down with me?</p>
                <div class="meta">
                    <div class="row">
                    <div class="col-8"><a class="mr-2" href="#"><i class="fas fa-heart"></i> 323</a><a href="#"><i class="fas fa-comment"></i> 13</a></div>
                    <div class="col-4 text-right"><a href="#"><i class="fas fa-share-square"></i></a></div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <section class="suggestion cards pb-5 suggestions-bg">
        <div class="container">
  			<div class="d-flex justify-content-between mt-6 mb-3 section-title">
  				<h4 class="mb-0" style="color: #131220;font-size: 18px;font-weight: 600;">Suggestions For You</h4>
  				<a class="mb-0 view-more" @click="$refs.listitems.more_view()" href="javascript:void(0)">View more</a>
  			</div>
        <ListItems 
            ref="listitems"
            :guest= guest
            :myfavorites=myfavorites
          />
        </div>
    </section>
    <div class="myfeed">
        <div class="col-md-6 col-lg-4 myfeed-padding" v-for="(item, index) in items" :key="index">
            <div v-if="index < 3" class="explore-box">
                <div class="model-info">
                <div class="row">
                    <div div class="col-8">
                    <div class="profile-pic"><img src="images/models/model.jpg" class="w-100"/></div>
                    <div class="name">{{item.profile.display_name.charAt(0).toUpperCase() + item.profile.display_name.slice(1, 8).concat('...')}}</div>
                    </div>
                    <div class="col-4">
                      <a v-if="myfavorites.includes(item.id)"  v-on:click="saveFavorite(item,'remove')"  class="follow-btn">Following</a>
                      <a v-if="!myfavorites.includes(item.id)" v-on:click="saveFavorite(item,'save')"  class="follow-btn btn-follow-loggedin">Follow</a>
                      


                    </div>
                </div>
                </div>
                <div class="image"> <img src="images/models/big-model.png" class="w-100"/></div>
                <div class="text">
                <p>Laying in bed all alone tonight, care to lay down with me?</p>
                <div class="meta">
                    <div class="row">
                    <div class="col-8"><a class="mr-2" href="#"><i class="fas fa-heart"></i> 323</a><a href="#"><i class="fas fa-comment"></i> 13</a></div>
                    <div class="col-4 text-right"><a href="#"><i class="fas fa-share-square"></i></a></div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="suggestions-for-you text-center d-none d-md-block" style="color: #6537B1">Suggestions For You</div>
    <div class="myfeed">
        <div class="col-md-6 col-lg-4">
            <div class="explore-box lock">
            <div class="model-info">
                <div class="row">
                    <div class="col-8">
                        <div class="profile-pic"><img src="/images/models/model.jpg" class="w-100"/></div>
                        <div class="name">Sophie Asveld</div>
                    </div>
                    <div class="col-4"><a class="follow-btn btn-follow-loggedin">Follow</a></div>
                </div>
            </div>
            <div class="image">
                <div class="lock-content">
                    <div class="wrap">
                        <div class="icon"><img src="/images/models/padlock.svg" class="w-100"/></div>
                        <div class="text"><strong>$50</strong> to unlock this media</div>
                        <div class="button-box">
                        <a href="#" class="btn theme btn-primary">Unlock</a>
                        </div>
                    </div>
                </div> 
                <img src="/images/models/big-model.png" class="w-100  blur-img"/>
            </div>
            <div class="text">
                <p>Laying in bed all alone tonight, care to lay down with me?</p>
                <div class="meta">
                    <div class="row">
                        <div class="col-8"><a class="mr-2" href="#"><i class="fas fa-heart"></i> 323</a><a href="#"><i class="fas fa-comment"></i> 13</a></div>
                        <div class="col-4 text-right"><a href="#"><i class="fas fa-share-square"></i></a></div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    
        <div class="col-md-6 col-lg-4 myfeed-padding" v-for="(item, index) in items" :key="index">
            <div v-if="index < 2" class="explore-box">
                <div class="model-info">
                <div class="row">
                    <div div class="col-8">
                    <div class="profile-pic"><img src="images/models/model.jpg" class="w-100"/></div>
                    <div class="name">{{item.profile.display_name.charAt(0).toUpperCase() + item.profile.display_name.slice(1, 8).concat('...')}}</div>
                    </div>
                    <div class="col-4">
                      <a v-if="myfavorites.includes(item.id)"  v-on:click="saveFavorite(item,'remove')" class="follow-btn">Following</a>
                      <a v-if="!myfavorites.includes(item.id)" v-on:click="saveFavorite(item,'save')" class="follow-btn btn-follow-loggedin">Follow</a>
                       

                      </div>
                </div>
                </div>
                <div class="image"> <img src="images/models/big-model.png" class="w-100"/></div>
                <div class="text">
                <p>Laying in bed all alone tonight, care to lay down with me?</p>
                <div class="meta">
                    <div class="row">
                    <div class="col-8"><a class="mr-2" href="#"><i class="fas fa-heart"></i> 323</a><a href="#"><i class="fas fa-comment"></i> 13</a></div>
                    <div class="col-4 text-right"><a href="#"><i class="fas fa-share-square"></i></a></div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>


  </div>
</template>


<script>
import { mapGetters } from "vuex";
import ListItems from "./model_list.vue";
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
      myfavorites:[],
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
  components: {
      ListItems
  },
  computed: {
    ...mapGetters({
      psychics: "psychic/items",
    }),
  },
  methods: {

    getParams() {
      return { cat: this.categorySlug, filters: this.filters };
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

    this.$store.dispatch("psychic/getItems", params).then(() => {
        this.items = this.psychics;
      });

            var that_this  = this;
        axios
        .get("/api/v1/user/myfavorities",{})
        .then((response) => {
          that_this.myfavorites=response.data.data;
          
        
        })
        .catch((error) => {
          console.log(error);
        });
    


  },
  mounted() {
    var that_this = this;
    EventBus.$on(" open_login   ", () => (this.loginDialog = true));
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
};
</script>



<style scoped>
.suggestions-for-you {
        font-size:18px;
        font-weight:700;
        line-height:22px;
        margin-bottom:25px;
        margin-top: 20px;
        width: 100%;
    }
.myfeed {
    max-width: 1093px;
    margin: auto;
    display: flex;
    flex-wrap: wrap;
    flex: 1 1 auto;
    margin-bottom: 35px;
}
.myfeed-padding {
    padding: 0 9.5px
}
.page-title
{
	font-size:18px;
	font-weight:700;
	line-height:22px;
	color:#6537B1;
	margin-bottom:25px;
}
.main-button-box
{
	margin-top:30px;
	margin-bottom:30px;
}
.heigh-440-overhidden
{
	height:440px;
	overflow:hidden;
}
.content
{
	padding-top:80px;
	padding-bottom:30px;
	background:#F9F9F9;
}
.explore-box
{
  padding: 15px 0;
}
.explore-box .model-info
{
	margin-bottom:10px;
}
.model-info .row {
  align-items: center;
}

.explore-box .model-info .profile-pic
{
	width:40px;
	height:40px;
	border:2px solid #E31616;
	border-radius:100%;
	overflow:hidden;
	float:left;
	margin-right:10px;
}
.explore-box .model-info .name
{
	font-size:18px;
	font-weight:600;
	line-height:40px;
	color:#131220;

	white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 130px;
}
.explore-box .model-info .name .subname
{
font-size: 10px;
font-weight: 600;
line-height: 13px;
color: #A1A0A6;
display: block;
margin-bottom: -13px;
}
.explore-box .model-info .follow-btn
{
	font-size:12px;
  font-weight: 600;
	color:#F77F98 !important;
	text-align: center;
  letter-spacing: 0.43px;
	display: flex;
  align-items: center;
  justify-content: center;
	width:80px;
	height:30px;
	text-align:center;
	border-radius:9px;
	border:2px solid #F77F98;
	line-height:30px;
	float:right;
	cursor:pointer;
}
.explore-box .model-info .follow-btn:hover
{
	background: transparent linear-gradient(180deg, #7272FF 0%, #9759FF 100%) 0% 0% no-repeat padding-box;
	color:#FFF !important;
}
.explore-box .image
{
	height:330px;
	overflow:hidden;
	border-radius:50px;
}
.explore-box .text
{
	margin-top:20px;
}
.explore-box .text p
{
	font-size:16px;
	font-weight:600;
	color:#131220;
	line-height: 26px;

}
.explore-box .text .meta a
{
	font-size:12px;
	line-height:17px;
	color:#131220;
}
.explore-box .text .meta a .fa-heart
{
	/* color: #42424D; */
    color:#9759FF;
}
.explore-box .text .meta a i
{
	font-size:18px;
	/* color: #42424D; */
    /* color:#9759FF; */
}
.explore-box .text .meta a:hover .fa-heart
{
	color:#9759FF;
	
}
.explore-box.lock .image
{
	position:relative;
}
.explore-box.lock .lock-content
{
	position:absolute;
	top:0px;
	left:0px;
	right:0px;
	bottom:0px;
	width:100%;
	height:100%;
	background:rgba(26,26,30,0.7);
	z-index: 9;
}
.explore-box.lock .image .blur-img
{filter: blur(8px);
  -webkit-filter: blur(8px);
  }
.explore-box.lock .lock-content .wrap
{
	position:absolute;
	width: 190px;
height: 198px;
	margin:auto;
	left:0px;
	right:0px;
	top:0px;
	bottom:0px;
	text-align:center;
	
}
.explore-box.lock .lock-content .wrap .icon
{
width: 100px;
margin: auto;
margin-bottom: 15px;
}
.explore-box.lock .lock-content .wrap .text
{
	margin-top:0px;
	margin-bottom:20px;
	color:#FFF;
	font-size:14px;
	line-height:21px;
}
.explore-box.lock .lock-content .wrap .button-box a 
{
	line-height:30px;
  border-radius: 12px !important;
}
/*
* ----------------------------------------------------------------------------------------
* 3.1 Explorer css
* ----------------------------------------------------------------------------------------
*/
.toggle-title
{
	width:280px;
	height:48px;
	background: #E7E6E8 0% 0% no-repeat padding-box;
    border-radius: 24px;
    padding:4px;
    margin:auto;
    margin-bottom:20px;
}
.toggle-title .t-btn
{
	font-size:16px;
	font-weight:600;
	line-height:26px;
	width:134px;
	height:40px;
	text-align:center;
	line-height:40px;
    color: #6537B1;
    opacity: 0.2;
	display:inline-block;
}
.toggle-title .t-btn.active
{
background: #FFFFFF;
box-shadow: 0px 1px 2px #0000001F;
border-radius: 24px;
opacity:1;	
}
.suggestion {
  padding-bottom: 20px; 
  width: 100%;
}
.suggestion-bottom {
  padding-bottom: 20px; 
  width: 100%;
}
.suggestion .container {
    max-width: 1074px!important;
}
.suggestion-bottom .caught {
    max-width: 1074px;
    display: flex;
    flex-direction: column;
    margin: auto;
}
.suggestion-bottom .caught h4,
.suggestion-bottom .caught h5,
.suggestion-bottom .caught .v-btn {
    width: fit-content;
    margin: auto;
    background: rgb(231, 230, 232);
}
.suggestion-bottom .caught .v-btn {
    padding: 0;
    width: 80px;
    height: 30px!important;
    border-radius: 9px!important;
    display: block;
    border-radius: 9px;
    border: 2px solid #F77F98;
    float: right;
    cursor: pointer;
    margin-top: 15px;
} 
.suggestion-bottom .caught .v-btn span {
    font-size: 12px;
    color: #F77F98 !important;
    text-align: center;
    letter-spacing: 0.43px;
    font-weight: 600;
}
.suggestion-bottom .caught h4 {
    color: #131220;
    margin-top: 40px;
    font-weight: 600;
    font-size: 18px;
    letter-spacing: 0;
}
.suggestion-bottom .caught h5 {
    margin-top: 10px;
    color: #949498;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0;
}
.suggestion .card-wrapper {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(155px, 1fr));
    grid-gap: 25px; 
}
@media screen and (max-width: 600px) {
  .suggestion {
        position: relative;
        scrollbar-width: thin; 
    }
    .suggestion .card-wrapper {
        display: table; 
    }
    .section-title {
        margin-left: 10px;
        margin-right: 10px;
    }
    .explore-box
    {
      border-bottom: 1px solid #13122010;
    }
}
.view-more {
   color:#F77F98;
   font-size: 14px;
   font-weight: 600;
}
.suggestions-bg {
  background: #E7E6E8; 
  margin: 20px 0 40px;
}
.explore-box .model-info .follow-btn{
    border: 2px solid #9759FF  !important;
    color: #9759FF !important;
}
.explore-box .model-info .btn-follow-loggedin{
    border: 2px solid #F77F98  !important;
    color: #F77F98 !important;
}
</style>
