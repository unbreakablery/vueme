<template>
  <div>
    <v-container class="pb-0" style="margin-bottom: 26px;">
      <v-row no-gutters class="d-flex justify-center">
        <v-col class="d-flex align-end" :sm="10" cols="10" :lg="6" :md="6">
          <label style="color: #43425D; font-size: 14px; font-weight: 600;" class="mb-0">Advisors Based On Your Search</label>
        </v-col>
        <v-col class="d-flex justify-end" :sm="2" cols="2" :lg="6" :md="6">
          <div v-if="!$vuetify.breakpoint.xsOnly" style="color: #43425D; font-size: 14px; font-weight: 600;" class="d-flex align-end">{{sort.name}}</div>
          <v-menu offset-y v-model="open">
            <template v-slot:activator="{ on }">
              <div v-on="on" style="cursor:pointer; width: 40px;">
                <v-img
                  width="40"
                  height="40"
                  contain
                  :src="'/images/icons/sort.png'"
                ></v-img>
              </div>
              
            </template>
            <v-list>
              <v-list-item
                class="px-0"
                v-for="(item, index) in sorts"
                :key="index"
                @click="sort = item;"
              >
                <v-list-item-content class="pb-0" style="color: #9759FF; text-align:center">
                  <v-list-item-title>
                    <label class="px-5">{{ item.name }}</label>
                  </v-list-item-title>
                  <v-divider
                    v-if="index + 1 != 5"
                    style="margin-top: 0.2rem; margin-bottom: 0.2rem;"
                  ></v-divider>
                </v-list-item-content>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-col>
      </v-row>
    </v-container>

    <v-container v-if="rows && items.length" class="pa-md-0 py-0">
      <v-row no-gutters class="d-flex justify-center">
        <v-col
          :class="`pa-0 pa-md-2 mb-5`"
          cols="12"
          :md="12/cols"
          v-for="(item, index) in items"
          :key="index"
        >
          <v-hover v-slot:default="{ hover }">
               <v-card
                v-if="!item.loading"
                style="min-height: 228px;border-radius: 20px!important;background: #EBF4FD;"
                :elevation="hover ? 12 : 2"
                class="mx-auto list_card"
              >
                <div>
                  <v-row class="m-0" style="height:118px;background: #EBF4FD;border-radius: 20px 20px 0 0;">
                    <a v-bind:href="'/'+ item.profile.profile_link">
                    <v-badge v-if="item.online" color="green" bottom>
                      <template v-slot:badge>{{''}}</template>

                      <div
                        :aria-label="item.profile.display_name"
                        class="user_avatar_lg"
                        :class="[item.online ?  'online' : 'offline']"
                        :style="{ 'background-image': 'url(' + item.profile.profile_headshot_url  + ')', 'margin-top': '18px', 'margin-left': '15px'}"
                      ></div>
                    </v-badge>
                    <v-badge v-else color="grey" bottom>
                      <template v-slot:badge>{{''}}</template>

                      <div
                        :aria-label="item.profile.display_name"
                        class="user_avatar_lg"
                        :class="[item.online ?  'online' : 'offline']"
                        :style="{ 'background-image': 'url(' + item.profile.profile_headshot_url  + ')', 'margin-top': '18px', 'margin-left': '15px'}"
                      ></div>
                    </v-badge>
                    <div
                      :aria-label="item.profile.display_name"
                      class="user_avatar_lg"
                      :class="[item.online ?  'online' : 'offline']"
                      v-else
                      :style="{ 'background-image': 'url(' + item.profile.profile_headshot_url  + ')', 'margin-top': '18px', 'margin-left': '15px' }"
                    ></div>

                 
                  </a>
                     <v-card-title class="justify-center  d-flex p-0" style="align-items: baseline !important;     margin-top: 39px;">
                  <div class="flex-row">
                    <div class="col-12 pr-0 pl-2 pl-lg-3" 
                        style=" margin-bottom: 10px;"
                          :style="{
                            'font-size': !$vuetify.breakpoint.xsOnly ? '15px' : '14px', 
                            'color':'#43425D', 
                            'width': $vuetify.breakpoint.xsOnly ? '202px': '238px',
                            'line-height': '1.5',
                             'word-break': 'break-word',
                            'overflow': 'hidden !important'}">
                      <a
                        v-bind:href="'/'+ item.profile.profile_link"
                        style="color: #43425D;font-weight: 600;"
                      >
                       <span>{{ item.profile.display_name }}</span>
                      </a>
                    </div>
                    <a
                      v-bind:href="'/'+ item.profile.profile_link + '#reviews'"
                      style="color: #A2A2A2; text-decoration: none; "
                      
                    >
                      
                          <v-rating
                           v-if = "item.reviews_rating"
                            :value="parseFloat(item.reviews_rating)"
                            color="amber"
                            dense
                            background-color="#C7C7C7"
                            empty-icon="mdi-star"
                            half-increments
                            readonly
                            size="16"
                            class="starBtn"
                            style="line-height: 0.5;"
                            :style="!$vuetify.breakpoint.xsOnly ? ' padding-left:10px' : ' padding-left:5px'"
                          ></v-rating>
                          <div v-else class="review-me" style="line-height: 1.5"  :style="!$vuetify.breakpoint.xsOnly ? ' padding-left:12px' : ' padding-left:9px'">
                                Be the first to <font style="text-decoration: underline;">review me</font>
                                </div>
                        
                    </a>
                  </div>

                    
                    </v-card-title>
                  </v-row>
                </div>
                <v-tooltip top v-if="!user || user.role_id != 1">
                  <template v-slot:activator="{ on }">
                    <v-icon v-if="item.favorite"
                      @click="saveFavorite(item)"
                      v-on="on"
                      size="35"
                      color="#43425D"
                      style="position: absolute; top: 5px; right: 13px;font-size:19px!important"
                      class="ma-1 cursor-pointer"
                    >mdi-heart</v-icon>
                    <v-icon v-else
                      @click="saveFavorite(item)"
                      v-on="on"
                      size="35"
                      
                      style="position: absolute; top: 5px; right: 13px;font-size:19px!important"
                      class="ma-1 cursor-pointer"
                    >mdi-heart-outline</v-icon>
                  </template>
                  <span>{{item.favorite?'Remove from favorites':'Add to favorites'}}</span>
                </v-tooltip>
                <v-row justify="space-around">
                
                </v-row>

                

                <v-card-text style="background:#ffffff;border-radius:20px;font-size:10px;padding:10px!important; position:absolute; bottom:0;">
                  <div class="row">
                    <div class="col-12 text-center tagline--text" style="min-height: 22px">
                      {{item.profile.tagline}}
                    </div>
                  </div>

                   <div class="row mt-2" style="font-size: 10px; padding:0px 20px"
                  
                  >
                    <div class="col p-0 grey--text"  v-if="item.reviews"
                    
                    :style="[!item.profile.years_experience ? {textAlign:'center'} : {textAlign:'left'}]"
                    
                    >
                      <b  style="color: #656B72; font-weight: 600;">{{ item.reviews }}</b>
                      <span v-if="item.reviews == 1"> Review</span>
                      <span v-else> Reviews</span>
                    </div>




                    <div
                      v-if="
                        item.profile.years_experience != null &&
                        item.profile.years_experience > 0
                      "
                      class="col p-0 grey--text" 
                      :style="[item.reviews ? {textAlign:'center',display:'inline-flex'} : {textAlign:'center'}]"
                    >
                      <b 
                       style="color: #656B72; font-weight: 600;"
                      :style="[item.reviews ? {display:'inline-flex'} : {textAlign:''}]"
                        >{{ item.profile.years_experience }}
                        <span v-if="item.profile.years_experience > 1"
                          :style="[item.reviews ? {padding:'0px 2px'} : {padding:'0px'}]"
                          >years</span
                        >
                        <span v-else>year</span></b
                      >
                      Experience
                    </div>
                  
                    <div class="col p-0 grey--text" 
                    :style="[!item.profile.years_experience || !item.reviews ? {textAlign:'center'} : {textAlign:'right'}]"
                    >
                      <span v-if="item.profile.t_clients == 0"
                        ><b  style="color: #656B72; font-weight: 600;">New</b> Model</span
                      >
                      <span v-else-if="item.profile.t_clients == 1"
                        ><b  style="color: #656B72; font-weight: 600;">{{ item.profile.t_clients }}</b> Client</span
                      >
                      <span v-else
                        ><b  style="color: #656B72; font-weight: 600;">{{ item.profile.t_clients }}</b> Clients</span
                      >
                    </div>
                  </div>

                  <div class="row mt-2">
                    <div class="col-6" style="padding: 0px 3px!important;">
                      <span v-for="(cat, index) in item.categories">
                       <img v-if="index < 4" :src="cat.path"/>
                      </span>
                    </div>
                    <div class="col-6 text-right">
                     <v-btn style="font-size:12px"
                      rounded
                      small
                      color="#8EbEF8"
                      height="30"
                      class="m-0 elevation-0 white--text pr-0 pl-3"
                      :href="'/'+ item.profile.profile_link"
                    > Profile <img src="/images/icons/chevron-right.svg"/>
                    </v-btn>
                    </div>
                    
                  </div>
                  
                </v-card-text>
              </v-card>
              <v-sheet v-else color="grey lighten-4" style="min-height: 240px; background-color: #EBF4FD !important;">
                <v-row>
                  <v-col class="d-flex justify-start big-avatar align-center">
                    <v-skeleton-loader type="avatar"></v-skeleton-loader>
                    <v-skeleton-loader width="50%" type="text" class="ml-3"></v-skeleton-loader>
                  </v-col>
                </v-row>
                <div style="background-color: white !important;" class="pb-3 pt-2">
                  <v-row class="mt-10">
                  <v-col class="d-flex justify-start">
                    <v-skeleton-loader width="50%" type="text" class="ml-2"></v-skeleton-loader>
                  </v-col>
                </v-row>
                <v-row class="mt-4">
                  <v-col class="d-flex justify-end">
                    <v-skeleton-loader class="ml-3" type="button" style="border-radius: 10%; width: 90px" width="90"></v-skeleton-loader>
                  </v-col>
                </v-row>
                </div>
              </v-sheet>
            </v-hover>
        </v-col>
      </v-row>

      <v-row v-if="showLoadMore && !loading" class="my-5">
        <v-col class="d-flex justify-center">
          <div @click="loadMore" style="color: #43425D; font-weight: 600; font-size: 14px; cursor: pointer;">Show More <img width="30" height="30" src="/images/icons/load_more.png"/></div>
        </v-col>
      </v-row>
    </v-container>
    <v-container v-if="!items.length" class="py-0">
      <v-row v-if="showLoadMore && !loading" class="my-5">
        <v-col class="d-flex justify-center">
          <div @click="loadMore" style="color: #43425D; font-weight: 600; font-size: 14px; cursor: pointer;">Show More <img width="30" height="30" src="/images/icons/load_more.png"/></div>          
        </v-col>
      </v-row>
    </v-container>
    <v-container class="pa-md-0 py-0">
      <v-alert v-if="items.length == 0 && !loading" color="#EAEAEF">
        <label style="color:#A2A2A2; font-size: 14px" class="mb-0">
          <v-icon color="#A2A2A2">mdi-alert-octagon-outline</v-icon>Oops, couldn’t find a match. Try another search!
        </label>
      </v-alert>
    </v-container>

    
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      open: false,
      sort: { name: "Sort By" },
      hover: false,
      item: {},

      showLoadMore: true,
      number: null,
      col: 2,
      items: [],
      page: 1,
      scrollControl: 0,
      init: true,
      sorts: [{name: 'All', value: 1, slug: 'all'}, {name: 'Online Now', value: 2, slug: 'online'}, {name: 'Top-Rated', value: 3, slug: 'rating'}, {name: 'Featured', value: 4, slug: 'featured'}, {name: 'Popular', value: 5, slug: 'popular'}]
    };
  },
  props: {
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
    guest: {
      default: true,
    },
    terms: {
      default: null,
      required: false,
    },
  },
  watch: {
    sort() {
      this.page = 1;
      this.$store.dispatch("search/page", this.page);
      this.items = this.rows
        ? this.getLoadingArray()
        : [this.getLoadingArray()];
      this.getItems();
    },
    mobile(val) {
      this.number = this.cols || (val ? 1 : 4);
    },
  },
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
      models: "search/items",
      loading: "search/loading",
      loadingFavorite: "favorite/loading",
      user: "util/user",
    }),
  },
  methods: {
    getItems() {
      let filters = Object.assign({}, this.filters);
      if (this.sort.value) {
        filters.sort = this.sort.value;
        filters.sortBy = this.sorts.filter(i => i.value == filters.sort)[0].slug;
      }
      this.$store.dispatch("search/getItems", filters).then(() => {
        this.items.splice(this.items.length - this.cols, this.items.length);

        this.items.push(...this.models.data);

        if (this.models.meta.last_page == this.page)
          this.showLoadMore = false;
      });
    },
    getCategories(item) {
      let html = "";
      let categories = item.categories;
      for (let i = 0; i < categories.length; i++) {
        html =
          html +
          `<a class="cursor-pointer" href="${categories[i].url}" style="text-decoration: none; color:#8EBEF8;"> ${categories[i].name} </a>`;
        break;
      }

      if (categories.length >= 1)
        html =
          html +
          `<a class="cursor-pointer" href="/${item.profile.profile_link}"
                            style="text-decoration: none; color: #8EBEF8"
                          ><span> • </span> +${categories.length - 1} more</a>`;

      return html;
    },
    async loadMore() {
      this.items.push(...this.getLoadingArray());

      this.$store.dispatch("search/page", ++this.page);

      await this.getItems();
    },
    saveFavorite(item) {
      if (this.guest) EventBus.$emit("open_login", { same_page_login: true });
      else if (!this.loadingFavorite)
        this.$store
          .dispatch("favorite/saveFavorite", {
            id: item.id,
            type: item.favorite ? "remove" : "save",
          })
          .then(() => (item.favorite = !item.favorite));
    },
    getLoadingArray() {
      let array = [];
      for (let i = 0; i < this.number; i++) array.push({ loading: true });
      return array;
    },
  },
  created() {
    this.number = this.cols || (this.mobile ? 1 : 4);

    this.items = this.rows ? this.getLoadingArray() : [this.getLoadingArray()];

    if (this.rows)
      this.$store.dispatch("search/perPage", this.rows * this.cols);
    else this.$store.dispatch("search/perPage", this.number);

    if (this.terms.sortBy) {
      if (this.terms.sortBy == "online") {
        this.sort = { name: "Online Now", value: 2 };
      } else if (this.terms.sortBy == "featured") {
        this.sort = { name: "Featured", value: 4 };
      } else if (this.terms.sortBy == "rating") {
        this.sort = { name: "Top-Rated", value: 3 };
      }
      else if (this.terms.sortBy == "popular") {
        this.sort = { name: "Popular", value: 5 };
      }
    } else if (!this.skeletor) {
      this.page = 1;
      this.$store.dispatch("search/page", this.page);
      this.$store.dispatch("search/getItems", this.filters).then(() => {
        if (this.models.meta.last_page == this.page)
          this.showLoadMore = false;

        if (this.rows) {
          this.items = this.models.data;
        } else {
          this.$store.dispatch("search/perPage", this.number);

          this.items = [this.models.data];

          if (this.models.meta.current_page < this.models.meta.last_page)
            this.items.push(this.getLoadingArray());
        }

        this.init = false;
      });
    }
  },
  mounted() {
    //EventBus.$on(" open_login   ", () => (this.loginDialog = true));
  },
};
</script>
<style>
/* width */
::-webkit-scrollbar {
  width: 5px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #888;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555;
}

/* .v-window__next,
.v-window__prev {
  background: transparent !important;
  border: 2px solid #9759FF;
  margin: 0 -4px !important;
}

.v-window__next,
.v-window__prev {
  margin: 0 -4px !important;
} */

.big-avatar .v-skeleton-loader__avatar {
  width: 120px;
  height: 120px;
}
</style>
