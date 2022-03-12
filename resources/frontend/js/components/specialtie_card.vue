<template>
  <a :href="item.url" style="text-decoration: none">
    <div v-if="mobile">
      <v-row no-gutters>
        <v-col cols="12" v-bind:style="{color: item.color}">{{item.name}}</v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-icon :color="item.color" size="40">mdi-account-circle</v-icon>
          <label v-bind:style="{color: item.color}">{{item.users_count}} Total</label>
        </v-col>
        <v-col>
          <v-icon :color="item.color" size="40">mdi-account-circle</v-icon>
          <label v-bind:style="{color: item.color}">{{item.online}} Online</label>
        </v-col>
      </v-row>
    </div>
    <v-hover v-else v-slot:default="{ hover }">
      <v-card :elevation="hover ? 12 : 2" class="mx-auto" height="100%">
        <v-row wrap row style="height: 50%; margin: 0px">
          <v-flex
            xs12
            class="headline d-flex align-sm-center justify-sm-center"
            style="background-color: rgba(236, 236, 236, 0.51)"
          >
            <img v-if="item.image" :alt="item.image.name" :src="`/files/${item.image.path}`" />
            <v-avatar v-else color="grey lighten-2" size="120" tile>
              <v-icon size="80" dark>mdi-account-circle</v-icon>
            </v-avatar>
          </v-flex>
        </v-row>

        <v-card-title
          class="text-center d-block grey--text;"
          v-bind:style="{color: item.color}"
        >{{item.name}}</v-card-title>

        <v-card-text>
          <v-col class="offset-md-3">
            <v-row class="d-flex align-center">
              <v-icon :color="item.color" size="35">mdi-account-circle</v-icon>
              <div class="ml-3" v-bind:style="{color: item.color}">{{item.users_count}} Total</div>
            </v-row>
            <v-row class="d-flex align-center">
              <v-icon :color="item.color" size="35">mdi-account-circle</v-icon>
              <div class="ml-3" v-bind:style="{color: item.color}">{{item.online}} Online</div>
            </v-row>
          </v-col>
        </v-card-text>
      </v-card>
    </v-hover>
  </a>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  props: {
    item: {
      require: true,
    },
    color: {
      type: String,
    },
  },
  computed: {
    ...mapGetters({
      mobile: "util/mobile",
    }),
  },
};
</script>

<style>
.specialtie-badge span {
  min-width: 4px;
  font-size: 9px;
  height: 18px;
  top: 15px !important;
  right: -10px;
  width: 18px;
  padding-top: 1.5px;
}
</style>
