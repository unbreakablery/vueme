<template>
  <div :style="{ marginTop: $vuetify.breakpoint.mdAndUp ? '116px': '0px' }">
    <div class="pa-0">
      <v-img
        alt="Home Banner Image"
        style="z-index: 6"
        :src="
          $vuetify.breakpoint.mdAndUp 
            ? '/images/Banner-imgs/search_page_banner.png'
            : '/images/Banner-imgs/search_page_banner_mobile.png'
        "
        aspect-ratio="1"
        :max-height="mobile ? 295 : 362"
        class="align-sm-center justify-sm-center home_hero"
      >
      
      </v-img>
    </div>
    <v-container>
      

      <!--Loading skeletor of mobile's version-->
      <v-row v-if="mobile && loading2">
        <v-col cols="12">
          <ListItems :guest="guest" :skeletor="true" :cols="1" :filters="{ }"/>
        </v-col>
      </v-row>
      <!--Loading skeletor of desktop's version-->
      <v-row v-else-if="!mobile && loading2 ">
        <v-col cols="12">
          <ListItems :guest="guest" :skeletor="true" :rows="rows" :cols="3" :filters="{ rating: true }"  />
        </v-col>
      </v-row>
      <v-row v-else row>
        <v-col cols="12">
          
      <ListItems
            :filters="{}"
            :guest="guest"
            :rows="rows"
            :cols="cols"
            :category-slug="item.slug"
            :perPageProp="10"
          />
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import ListItems from "./specialtie_user_list.vue";

export default {
  data() {
    return {
      selected: null,
      rows: null,
      cols: null,
      loading2: false
      // online: null,
      // rating: null,
      // featured: null,
      // filters: {},
      // refresh: false,
    };
  },
  props: ["guest", "slug", "user"],
  components: {
    ListItems,
  },
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
      categories: "category/all",
      item: "category/view",
      loading: "category/loading",
    }),
  },
  watch: {
    // online(val) {
    //   this.$store.dispatch("psychic/page", 1);
    //   this.filters.online = val;
    //   this.refresh = !this.refresh;
    // },
    // featured(val) {
    //   this.$store.dispatch("psychic/page", 1);
    //   this.filters.featured = val;
    //   this.refresh = !this.refresh;
    // },
    // rating(val) {
    //   this.$store.dispatch("psychic/page", 1);
    //   this.filters.rating = val;
    //   this.refresh = !this.refresh;
    // },
    // selected(slug) {
    //   this.$store.dispatch("category/getItem", slug).then(() => {
    //     this.refresh = !this.refresh;
    //   });
    // },
  },
  async created() {
    if (this.mobile) {
      this.rows = 16;
      this.cols = 1;
    } else {
      this.rows = 4;
      this.cols = 4;
    }
    
    this.loading2 = false;
    await this.$store.dispatch("category/getItem", this.slug).then(() => {
      this.loading2 = false;
          this.refresh = !this.refresh;
        });
    
    // await this.$store.dispatch("category/getAll").then(() => {
    //   if (this.slug == "online") this.online = true;
    //   else if (this.slug == "featured") this.featured = true;
    //   else if (this.slug == "rating") this.rating = true;
    //   else {
    //     this.selected =
    //       this.categories.filter((item) => item.slug == this.slug)[0].slug ||
    //       null;
    //     this.$store.dispatch("category/getItem", this.selected).then(() => {
    //       this.refresh = !this.refresh;
    //     });
    //   }
    // });

    this.$store.dispatch("util/setUser", this.user);
  },
};
</script>
