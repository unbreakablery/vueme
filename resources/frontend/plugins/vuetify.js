// src/plugins/vuetify.js
//import 'babel-polyfill'
import Vue from "vue";
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";
// import "material-design-icons-iconfont/dist/material-design-icons.css";
// import '@mdi/font/css/materialdesignicons.css'

Vue.use(Vuetify);

export default new Vuetify({
  // icons: {
  //   iconfont: "mdi",
  // },
  theme: {
    themes: {
      light: {
        primary: "#9759FF",
        secondary: "#b0bec5",
        accent: "#8c9eff",
        error: "#b71c1c",
        purple: "#9759FF",
        blue: "#8EBEF8",
      },
    },
  },
});
