<template>
  <div class="row">
    <!-- <div class="col-md-6 col-lg-4">
        <div class="explore-box lock">
          <div class="model-info">
              <div class="row">
                <div class="col-8">
                    <div class="profile-pic"><img src="/images/models/model.jpg" class="w-100"/></div>
                    <div class="name">Sophie Asveld</div>
                </div>
                <div class="col-4"><a class="follow-btn">Following</a></div>
              </div>
          </div>
          <div class="image">
              <div class="lock-content">
                <div class="wrap">
                    <div class="icon"><img src="/images/models/padlock.svg" class="w-100"/></div>
                    <div class="text">$50 to unlock this media</div>
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
    </div> -->
    <div class="myfeed">
        <div class="col-md-6 col-lg-4 myfeed-padding" v-for="(item, index) in items" :key="index">
            <div v-if="index < 3" class="explore-box">
                <div class="model-info">
                <div class="row">
                    <div div class="col-8">
                    <div class="profile-pic"><img src="images/models/model.jpg" class="w-100"/></div>
                    <div class="name">{{item.profile.display_name.charAt(0).toUpperCase() + item.profile.display_name.slice(1, 8).concat('...')}}</div>
                    </div>
                    <div class="col-4"><a class="follow-btn">Following</a></div>
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
    <section class="suggestion cards pb-5" style="background: #E7E6E8; margin: 20px 0 40px;" >
        <div class="container">
  			<div class="d-flex justify-content-between mt-6 mb-3 section-title">
  				<h4 class="mb-0" style="color: #131220;font-size: 18px;font-weight: 600;">Suggestions For You</h4>
  				<a class="mb-0 view-more"   href="/explore">View more</a>
  			</div>
        <ListItems 
            ref="listitems"
            :guest= false
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
                    <div class="col-4"><a class="follow-btn">Following</a></div>
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
                    <div class="col-4"><a class="follow-btn">Following</a></div>
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
                    <div class="col-4"><a class="follow-btn">Following</a></div>
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
    <section class="suggestion-bottom pb-5" style="background: #E7E6E8; margin-bottom: 50px" >
        <div class="caught">
            <h4>All Caught Up</h4>
            <h5>Explore our selected featured models</h5>
            <v-btn><span>Explore</span></v-btn>
        </div>
    </section>
   <!-- <div class="col-md-6 col-lg-4">
      <div class="explore-box lock">
         <div class="model-info">
            <div class="row">
               <div class="col-8">
                  <div class="profile-pic border-0"><img src="images/models/model.jpg" class="w-100"/></div>
                  <div class="name">Annie Brown</div>
               </div>
               <div class="col-4"><a class="follow-btn">Follow</a></div>
            </div>
         </div>
         <div class="heigh-440-overhidden">
            <div class="ex-instagram d-none d-md-inline-block">
               <div style="position:relative;max-width:100%;min-width:330px;"><blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/p/CJlxiWPMp9n/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="13" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:400px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:16px;"> <a href="https://www.instagram.com/p/CJlxiWPMp9n/?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank"> <div style=" display: flex; flex-direction: row; align-items: center;"> <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div></div></div><div style="padding: 19% 0;"></div> <div style="display:block; height:50px; margin:0 auto 12px; width:50px;"><svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-511.000000, -20.000000)" fill="#000000"><g><path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path></g></g></g></svg></div><div style="padding-top: 8px;"> <div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;"> View this post on Instagram</div></div><div style="padding: 12.5% 0;"></div> <div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;"><div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div> <div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div></div><div style="margin-left: 8px;"> <div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div> <div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div></div><div style="margin-left: auto;"> <div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div> <div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div> <div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div></div></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;"></div></div></a><p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"><a href="https://www.instagram.com/p/CJlxiWPMp9n/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;" target="_blank">A post shared by Instagram (@instagram)</a></p></div></blockquote><div style="position: absolute;width: 80%;bottom:2px;left: 0;right: 0;margin-left: auto;margin-right: auto;color: #000;text-align: center;"><small style="line-height:1.8;font-size:2px;background:transparent;">Powered by <a href="https://embedinstagramfeed.com/">embedinstagramfeed</a> &amp; <a href="https://embedfbvideo.com">Embed facebook video</a></small>
                  </div>
               </div>
            </div>
            <div class="ex-twitter">
               <div align="center"><a class="twitter-timeline" data-width="600" data-dnt="true"  data-tweet-limit="1" href="https://twitter.com/Microsoft?ref_src=twsrc%5Etfw">Tweets by Microsoft</a>
               
               </div>
            </div>
         </div>
      </div>
   </div> -->

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
    
 
  },
  created() {
    let params = this.getParams();

    this.$store.dispatch("psychic/getItems", params).then(() => {
        this.items = this.psychics;
      });
  },
  mounted() {
    //EventBus.$on(" open_login   ", () => (this.loginDialog = true));
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
	width:100px;
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
</style>
