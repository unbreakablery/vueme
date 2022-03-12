/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
// src/main.js

import VueTheMask from "vue-the-mask";
Vue.use(VueTheMask);

import Vue from "vue";
import vuetify from "../plugins/vuetify";

import VueWaveSurfer from "vue-wave-surfer";
Vue.use(VueWaveSurfer);

import VueGtag from "vue-gtag";

import numeral from 'numeral';
import numFormat from 'vue-filter-number-format';
 
Vue.filter('numFormat', numFormat(numeral));

Vue.filter('money', function (value) {
    return new Intl.NumberFormat([],{style: 'currency', currency: 'USD'}).format(value);
});

/*Vue.use(VueGtag, {
  config: { id: "GTM-WBT336Q" },
});*/


Vue.filter("truncate", (text, length, suffix) =>
  text.length > length ? text.substring(0, length) + suffix : text
);
window.EventBus = new Vue();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component(
  "example-component",
  require("./components/ExampleComponent.vue").default
);

Vue.component("clients", require("./components/passport/Clients.vue").default);

Vue.component("s-header", require("./components/header.vue").default);
Vue.component("s-header-2", require("./../../backend/js/components/header-2.vue").default);
Vue.component("header-info", require("./components/header_info.vue").default);
Vue.component("header-space", require("./components/header_space.vue").default);

Vue.component(
  "s-header-verification",
  require("./components/header_verification.vue").default
);

Vue.component("home-top", require("./components/home_top.vue").default);

Vue.component(
  "home-section-4",
  require("./components/home_section_4.vue").default
);

Vue.component(
  "home-section-6",
  require("./components/home_section_6.vue").default
);

Vue.component(
  "home-section-7",
  require("./components/home_section_7.vue").default
);

Vue.component(
  "splash-header",
  require("./components/splash_header.vue").default
);

Vue.component("splash-top", require("./components/splash_top.vue").default);

Vue.component(
  "splash-section-4",
  require("./components/splash_section_4.vue").default
);

Vue.component(
  "splash-section-6",
  require("./components/splash_section_6.vue").default
);

Vue.component(
  "splash-section-7",
  require("./components/splash_section_7.vue").default
);
Vue.component("h-search", require("./components/nav_search.vue").default);

Vue.component("p-footer", require("./components/footer.vue").default);
// Vue.component('chat', require('./../../backend/js/components/chat').default);
// Vue.component('file-upload', require('vue-upload-component'));
Vue.component(
  "text-chat-notifications",
  require("./../../backend/js/components/notifications/text_chat").default
);
Vue.component(
  "toxbox-chat-notifications-model-mobile",
  require("./../../backend/js/components/notifications/toxbox-chat-model-mobile.vue").default
);
Vue.component('standard-dialog', require('./../../backend/js/components/dialogs/standard_dialog.vue').default);

Vue.component("home-list", require("./components/home_list.vue").default);

Vue.component("myfeed-list", require("./components/myfeed_list.vue").default);

Vue.component("get-5-free", require("./components/get_5_free.vue").default);

Vue.component("specialties", require("./components/specialties.vue").default);


Vue.component(
  "specialtie-profile",
  require("./components/specialtie_profile.vue").default
);

Vue.component(
  "live-stream",
  require("./components/live_stream.vue").default
);

Vue.component(
  "toxbox-chat-notifications",
  require("./../../backend/js/components/notifications/toxbox-chat").default
);

Vue.component(
  "credits",
  require("./../../backend/js/components/user/credits.vue").default
);

Vue.component("specialtie", require("./components/specialtie.vue").default);
Vue.component(
  "c-message",
  require("./../../backend/js/components/dialogs/message.vue").default
);
Vue.component("verify-phone", require("./components/verify_phone.vue").default);
Vue.component("change-password", require("./components/change_password.vue").default);

Vue.component(
  "add-verify-phone",
  require("./components/add_verify_phone.vue").default
);
Vue.component("write-review", require("./components/write_review.vue").default);

Vue.component("search", require("./components/search.vue").default);

Vue.component("press", require("./components/press.vue").default);

Vue.component("horoscope", require("./components/horoscope.vue").default);
Vue.component("zodiac_sign", require("./components/zodiac_sign.vue").default);

Vue.component("horoscope_all", require("./components/horoscope_all.vue").default);
Vue.component("horoscope_abilities", require("./components/horoscope_abilities.vue").default);
Vue.component("horoscope_specialties", require("./components/horoscope_specialties.vue").default);


Vue.component("signuppage", require("./components/pagesignup.vue").default);

Vue.component("SearchInput", require("./components/specialtie_search.vue").default);

// Vue.component("SearchFilter", require("./components/search_filter.vue").default);

Vue.component("SearchInputHeader", require("./components/specialtie_search_header.vue").default);

// Vue.component("SearchFilterHeader", require("./components/search_filter_header.vue").default);

// Vue.component("SearchInputHeader1", require("./components/specialtie_search_header1.vue").default);

// Vue.component("SearchFilterHeader1", require("./components/search_filter_header1.vue").default);

Vue.component("blog-body", require("./components/blog_body.vue").default);

Vue.component("blog-arrows", require("./components/blog_arrows.vue").default);

Vue.component("models-list", require("./components/models_list.vue").default);
Vue.component("explore-list", require("./components/explore_list.vue").default);
Vue.component("how-it-works", require("./components/how_it_works.vue").default);
Vue.component("category-list", require("./components/category_list.vue").default);
Vue.component("category-spec", require("./components/category_spec.vue").default);
Vue.component("category-model", require("./components/category_model.vue").default);

Vue.component(
  "form_add_post",
  require("./components/blogetc/form_new_post.vue").default
);
Vue.component(
  "notifications",
  require("./../../backend/js/components/notifications/notifications.vue")
    .default
);

Vue.component("fan-signup", require("./components/fan_signup.vue").default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import store from "./store/store";
window.vue = {}
 vue = new Vue({
  vuetify,
  store,
  methods: {
    onResize() {
      this.$store.dispatch("util/setMobile");
    }
  },
}).$mount("#app");
