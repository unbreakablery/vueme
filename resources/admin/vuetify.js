import Vue from "vue";
import Vuetify from "vuetify/lib";
import "@mdi/font/css/materialdesignicons.css";
import "./css/app.css";

Vue.use(Vuetify);

export default new Vuetify({
  icons: {
    iconfont: "mdi",
  },
  theme: {
    themes: {
      light: {
        purple: "#9759FF",
      },
    },
  },
});
