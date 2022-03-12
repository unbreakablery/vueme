<template>
  <div class="category-container">
      <category-model :cat="cat" :guest="guest"></category-model>
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
          path: 'images/category/model_1.png',
          count: 153
        },
        {
          name: 'BBW',
          slug: 'bbw',
          path: 'images/category/model_2.png',
          count: 234
        },
        {
          name: 'Blonde',
          slug: 'blonde',
          path: 'images/category/model_3.png',
          count: 342
        },
        {
          name: 'Female Models',
          slug: 'female-models',
          path: 'images/category/model_4.png',
          count: 153
        },
        {
          name: 'Male Models',
          slug: 'male-models',
          path: 'images/category/model_5.png',
          count: 234
        },
        {
          name: 'Fitness Models',
          slug: 'fitness-models',
          path: 'images/category/model_6.png',
          count: 342
        },
        {
          name: 'Redheads',
          slug: 'redheads',
          path: 'images/category/model_7.png',
          count: 153
        },
        {
          name: 'Ebony',
          slug: 'ebony',
          path: 'images/category/model_8.png',
          count: 234
        },
        {
          name: 'Foot Models',
          slug: 'foot-models',
          path: 'images/category/model_9.png',
          count: 342
        },
        {
          name: 'Dancers',
          slug: 'dancers',
          path: 'images/category/model_10.png',
          count: 342
        },
        {
          name: 'Cosplay',
          slug: 'cosplay',
          path: 'images/category/model_11.png',
          count: 342
        }

      ],
      specialties: [],
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
  props: ["guest", "user", "cat"],

  computed: {
    ...mapGetters({
      mobile: "util/mobile",
      paginate: "category/items",
      paginate1: "specialty/items",
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

    this.$store.dispatch("specialty/getItems").then(() => {
      if (this.$vuetify.breakpoint.xsOnly) {
        this.specialties = chunk(this.paginate1.data, 3);
      } 
      else this.specialties = this.paginate1.data;
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
	line-height:40px;
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

@media only screen and (max-width: 600px) {
  .category-container{
    width: auto;
  } 
  .category-container .row{
    justify-content: center;
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
