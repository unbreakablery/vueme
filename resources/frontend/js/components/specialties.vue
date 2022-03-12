<template>
  <div>
    <v-container v-if="mobile">
      <v-row justify="start" class="mb-6">
        <h1
          class="h3 mb-0 mt-1"
          style="color:#9759FF; padding-left: 15px;"
        >Browse Our Menu of Online Model Specialties</h1>
      </v-row>
      <!--Loading skeletor of mobile's version-->
      <v-row v-if="!categories.length">
        <v-col cols="12" class="pa-2">
          <v-sheet class="pa-3" color="grey lighten-4">
            <v-row>
              <v-col class="d-flex">
                <v-skeleton-loader width="35%" type="text"></v-skeleton-loader>
              </v-col>
            </v-row>
            <v-row class="mt-4">
              <v-col class="d-flex">
                <v-skeleton-loader type="avatar"></v-skeleton-loader>
                <v-skeleton-loader width="50%" type="text"></v-skeleton-loader>
              </v-col>
              <v-col class="d-flex">
                <v-skeleton-loader type="avatar"></v-skeleton-loader>
                <v-skeleton-loader width="50%" type="text"></v-skeleton-loader>
              </v-col>
            </v-row>
          </v-sheet>
        </v-col>
        <v-col cols="12">
          <ListItems :guest="guest" :category-slug="false" :cols="1" />
        </v-col>
      </v-row>

      <v-row v-else row v-for="item,index in categories" :key="index">
        <v-col cols="12">
          <SpecialtieCard :item="item" :color="colors[index]" />
        </v-col>
        <v-col cols="12">
          <ListItems :guest="guest" :category-slug="item.slug" :cols="1" />
        </v-col>

        <v-divider class="ma-12"></v-divider>
      </v-row>
    </v-container>

    <v-container v-else>
      <v-row justify="start" class="mb-6">
        <h1 class="h3 mb-0" style="color:#9759FF;">Browse Our Menu of Online Model Specialties</h1>
      </v-row>

      <v-row v-if="!categories.length">
        <v-col cols="3" class="pa-2" style="min-height: 430px;">
          <v-sheet color="grey lighten-4">
            <v-row class="h-50">
              <v-col class="h-100 d-flex justify-center big-avatar">
                <v-skeleton-loader width="100%" height="50%" type="image" tile></v-skeleton-loader>
                <v-skeleton-loader
                  style="top: 50%; position: absolute; margin-top: -60px;"
                  type="avatar"
                  tile
                ></v-skeleton-loader>
              </v-col>
            </v-row>
            <v-row class="mt-10">
              <v-col class="d-flex justify-center">
                <v-skeleton-loader width="30%" type="text"></v-skeleton-loader>
              </v-col>
            </v-row>
            <v-row class="mt-4">
              <v-col class="d-flex justify-center">
                <v-skeleton-loader width="30%" type="text"></v-skeleton-loader>
              </v-col>
            </v-row>
            <v-row class="mt-4">
              <v-col class="d-flex justify-center">
                <v-skeleton-loader width="30%" type="text"></v-skeleton-loader>
              </v-col>
            </v-row>
          </v-sheet>
        </v-col>
        <v-col cols="9">
          <ListItems :guest="guest" :category-slug="false" :cols="3" />
        </v-col>
      </v-row>
      <v-row v-else row v-for="item,index in categories" :key="index">
        <v-col cols="3" class="pa-2" style="min-height: 430px;">
          <SpecialtieCard v-if="!item.loading" :item="item" :color="colors[index]" />
        </v-col>
        <v-col cols="9">
          <ListItems :guest="guest" :category-slug="item.slug" :cols="3" />
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import ListItems from "./specialtie_user_list.vue";
import Search from "./specialtie_search.vue";
import SpecialtieCard from "./specialtie_card";

export default {
  props: ["guest", "user"], 
  components: {
    ListItems,
    Search,
    SpecialtieCard,
  },
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
      colors: "category/colors",
      categories: "category/all",
    }),
  },
  created() {
    this.$store.dispatch("category/getAll");

    this.$store.dispatch("util/setUser", this.user);
  },
};
</script>
