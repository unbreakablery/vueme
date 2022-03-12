<template>
  <div class="category-container">
    <div class="row">
      <div class="category-box-container" 
        v-for="(item, index) in categories" 
        :key="index"
        :style="!mobile ? { 'margin-right': (index % 3 == 2) ? '0px': '' } : { 'margin-right': (index % 2 == 1) ? '0px': '' }"
      >
        <v-hover v-if="!item.loading">
          <a
            :href="'/category/' + item.slug"
            style="text-decoration: none"
          >
            <div class="category-box">
              <div class="image"> 
                <!-- <img src="images/category/model.png" class="w-100"/> -->
                <img :alt="item.name" v-bind:src="item.image.path" class="w-100"/>
              </div>
              <div class="text">
                <div class="meta">
                  <div class="row">
                    <div class="category-name">{{item.name}} 
                      <span class="category-subname">{{item.users_count}} </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </v-hover>
        <v-skeleton-loader
          v-else
          height="100"
          type="image"
          class="mx-auto"
        ></v-skeleton-loader>
      </div>
    </div>
  </div>
</template>


<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      categries: [
        {
          name: 'Asian',
          slug: 'asian',
          path: 'images/category/asian.png',
          count: 153
        },
        {
          name: 'BBW',
          slug: 'bbw',
          path: 'images/category/bbw.png',
          count: 234
        },
        {
          name: 'Blonde',
          slug: 'blonde',
          path: 'images/category/blonde.png',
          count: 342
        },
        {
          name: 'Brunette',
          slug: 'brunette',
          path: 'images/category/brunette.png',
          count: 342
        },
        {
          name: 'Actresses',
          slug: 'actresses',
          path: 'images/category/actresses.png',
          count: 342
        },
        {
          name: 'Instagram Models',
          slug: 'instagram-models',
          path: 'images/category/instagram-models.png',
          count: 342
        },
        {
          name: 'Female Models',
          slug: 'female-models',
          path: 'images/category/female-models.png',
          count: 153
        },
        {
          name: 'Male Models',
          slug: 'male-models',
          path: 'images/category/male-models.png',
          count: 234
        },
        {
          name: 'Fitness Models',
          slug: 'fitness-models',
          path: 'images/category/fitness-models.png',
          count: 342
        },
        {
          name: 'Redheads',
          slug: 'redheads',
          path: 'images/category/redheads.png',
          count: 153
        },
        {
          name: 'Ebony',
          slug: 'ebony',
          path: 'images/category/ebony.png',
          count: 234
        },
        {
          name: 'Foot Models',
          slug: 'foot-models',
          path: 'images/category/foot-models.png',
          count: 342
        },
        {
          name: 'Dancers',
          slug: 'dancers',
          path: 'images/category/dancers.png',
          count: 342
        },
        {
          name: 'Cosplay',
          slug: 'cosplay',
          path: 'images/category/cosplay.png',
          count: 342
        }

      ],
      categories: [],
      hover: false,
      showLoadMore: true,
      number: null,
      col: 2,
      window: 0,
      page: 1,
      init: true,
      perPage: 0,
    };
  },
  props: ["guest", "user"],

  computed: {
    ...mapGetters({
      mobile: "util/mobile",
      items: "category/items",
    }),
  },
  methods: {

    getParams() {
      return { cat: this.categorySlug, filters: this.filters };
    },
    
 
  },
  created() {
    const chunk = (arr, size) =>
      Array.from({ length: Math.ceil(arr.length / size) }, (v, i) =>
        arr.slice(i * size, i * size + size)
      );

    this.$store.dispatch("category/getItems").then(() => {
      // if (this.$vuetify.breakpoint.xsOnly) {
      //   this.specialties = chunk(this.paginate1.data, 3);
      // } 
      // else 
      this.categories = this.items.data;
    });
    this.$store.dispatch("util/setUser", this.user);
  },
  mounted() {
    //EventBus.$on(" open_login   ", () => (this.loginDialog = true));
  },
};
</script>



<style scoped>

.category-container {
  width: 1086px;
}
.category-box-container{
  margin-right: 21px;
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
.category-box
{
	margin-bottom:30px;
}

.category-box .category-name
{
	font-size:18px;
	font-weight:600;
	line-height:18px;
	color:#F77F98;
}

.category-box .category-subname
{
  font-size: 14px;
  font-weight: 500;
  color: #131220;
  line-height: 18px;
  margin-left: 10px;
}

.category-box .image
{
  width: 348px;
	height:300px; 
	overflow:hidden;
	border-radius: 40px;
  /* border: 1px solid #707070; */
}
.category-box .text
{
	margin-top:10px;
}
.category-box .text p
{
	font-size:16px;
	font-weight:600;
	color:#949498;
	line-height: 26px;

}
.category-box .text .meta a
{
	font-size:12px;
	line-height:17px;
	color:#131220;
}
.category-box .text .meta a i
{
	font-size:18px;
	color: #42424D;
}
.category-box .text .meta a:hover i
{
	color:#9759FF;
	
}
.category-box.lock .image
{
	position:relative;
}
.category-box.lock .lock-content
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
.category-box.lock .image .blur-img
{filter: blur(8px);
  -webkit-filter: blur(8px);
  }
.category-box.lock .lock-content .wrap
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
.category-box.lock .lock-content .wrap .icon
{
width: 100px;
margin: auto;
margin-bottom: 15px;
}
.category-box.lock .lock-content .wrap .text
{
	margin-top:0px;
	margin-bottom:20px;
	color:#FFF;
	font-size:14px;
	line-height:21px;
}
.category-box.lock .lock-content .wrap .button-box a 
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

@media only screen and (max-width: 960px){
  .category-container{
    width: auto;
  } 
  .category-container .row{
    justify-content: space-between;
    max-width: 340px;
  } 
  .category-box-container {
      display: flex;
      align-self: stretch;
      margin-right: 13px;
  }
  
  .category-box .image {
     height: 160px;
     width: 160px;
     border-radius: 30px;
   }
  .category-box .category-name {
     font-size: 14px;
   }
  .category-box .category-subname {
     font-size: 12px;
   }
  .category-box .text {
     margin-top: 8px;
   }
}

@media only screen and (min-width: 960px) and (max-width: 1024px) {
  .category-container{
    width: auto;
  } 
  .category-container .row{
    max-width: 514px;
  } 
  .category-box-container {
      display: flex;
      align-self: stretch;
      margin-right: 13px;
  }
  
  .category-box .image {
     height: 160px;
     width: 160px;
     border-radius: 30px;
   }
  .category-box .category-name {
     font-size: 14px;
   }
  .category-box .category-subname {
     font-size: 12px;
   }
  .category-box .text {
     margin-top: 8px;
   }
  
}
</style>
