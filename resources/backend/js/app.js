/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
// src/main.js

import Vue from "vue";
import vuetify from "../plugins/vuetify";

window.EventBus = new Vue();

import numeral from "numeral";
import numFormat from "vue-filter-number-format";

import VueGtag from "vue-gtag";

import VueWaveSurfer from "vue-wave-surfer";
Vue.use(VueWaveSurfer);

/*Vue.use(VueGtag, {
  config: { id: "GTM-WBT336Q" },
});*/

import { VueMaskDirective } from 'v-mask'
Vue.directive('mask', VueMaskDirective);

Vue.filter("numFormat", numFormat(numeral));

Vue.filter("money", function(value) {
  return new Intl.NumberFormat([], {
    style: "currency",
    currency: "USD",
  }).format(value);
});

Vue.filter("truncate", (text, length, suffix) => {
  if (typeof text != "undefined") {
    return text.length > length ? text.substring(0, length) + suffix : text;
  }
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

import VueTheMask from "vue-the-mask";
Vue.use(VueTheMask);

const VueUploadComponent = require("vue-upload-component");
Vue.component("file-upload", VueUploadComponent);

Vue.component("s-header-1", require("./components/header.vue").default);
Vue.component("s-header-2", require("./components/header-2.vue").default);
Vue.component("p-footer", require("./components/footer.vue").default);

Vue.component(
  "dashboard-sidebar-menu",
  require("./components/sidebar-menu.vue").default
);

Vue.component(
  "dashboard-mobile-sidebar-menu",
  require("./components/mobile-sidebar-menu.vue").default
);

Vue.component(
  "psychic-profile",
  require("./components/psychic_profile.vue").default
);


Vue.component(
  "psychic-payment",
  require("./components/psychic_payment.vue").default
);

Vue.component("user-profile", require("./components/user_profile.vue").default);

Vue.component(
  "user-schedule",
  require("./components/user_schedule.vue").default
);

Vue.component(
  "user-services",
  require("./components/user_services.vue").default
);

Vue.component(
  "rewards-overview",
  require("./components/psychic/rewards_overview.vue").default
);

Vue.component(
  "rewards-invite",
  require("./components/psychic/rewards_invite.vue").default
);

Vue.component(
  "rewards-referrals",
  require("./components/psychic/rewards_referrals.vue").default
);


Vue.component(
  "rewards-resume",
  require("./components/psychic/rewards_resume.vue").default
);


Vue.component(
  "payout-method",
  require("./components/psychic/payout_method.vue").default
);

Vue.component(
  "tax-forms",
  require("./components/psychic/tax_forms.vue").default
);

Vue.component(
  "box-rewards",
  require("./components/psychic/box_rewards.vue").default
);
Vue.component(
  "box-referral",
  require("./components/psychic/box_referral.vue").default
);

Vue.component(
  "box-download",
  require("./components/psychic/box_download.vue").default
);
Vue.component(
  "replays",
  require("./components/replays.vue").default
);




Vue.component("c-message", require("./components/dialogs/message.vue").default);

Vue.component("chat", require("./components/chat").default);
Vue.component(
  "text-chat-notifications",
  require("./components/notifications/text_chat.vue").default
);
Vue.component("credits", require("./components/user/credits.vue").default);

Vue.component(
  "toxbox-chat-notifications",
  require("./components/notifications/toxbox-chat").default
);

Vue.component(
  "toxbox-chat-notifications-model-mobile",
  require("./components/notifications/toxbox-chat-model-mobile.vue").default
);

Vue.component(
  "psychic-reviews",
  require("./components/psychic_reviews.vue").default
);

Vue.component(
  "model-replays",
  require("./components/model_replays.vue").default
);

Vue.component(
  "psychic-appointments",
  require("./components/psychic_appointments.vue").default
);

Vue.component(
  "private-schedule",
  require("./components/private_schedule.vue").default
);

Vue.component(
  "user-appointments",
  require("./components/user_appointments.vue").default
);

Vue.component("reviews", require("./components/reviews.vue").default);

Vue.component(
  "credit_logs",
  require("./components/user/credit_logs.vue").default
);

Vue.component("favorites", require("./components/favorites.vue").default);
Vue.component("payment", require("./components/user/payment").default);
Vue.component(
  "p-analytics",
  require("./components/psychic/analytics.vue").default
);
Vue.component(
  "p-analytics-overview",
  require("./components/psychic/analytics_overview.vue").default
);
Vue.component(
  "p-analytics-stream",
  require("./components/psychic/analystic_stream.vue").default
);
Vue.component(
  "p-analytics-fan-insight",
  require("./components/psychic/analytic_fan_insight.vue").default
);
Vue.component(
  "p-header-data",
  require("./components/psychic/header_data.vue").default
);
Vue.component(
  "mobile-navbar",
  require("./components/mobile-navbar.vue").default
);
Vue.component(
  "p-credit_logs",
  require("./components/psychic/credit_logs.vue").default
);


Vue.component(
  "p-payout-tab",
  require("./components/payout_tab.vue").default
);

Vue.component(
  "p-cosmic-rewards",
  require("./components/cosmic_rewards.vue").default
);

Vue.component(
  "p-subscribers",
  require("./components/subscribers.vue").default
);

Vue.component(
  "p-referrals",
  require("./components/referrals.vue").default
);

Vue.component(
  "p-referral-earnings",
  require("./components/referral_earnings.vue").default
);

Vue.component(
  "p-your-referrals",
  require("./components/your_referrals.vue").default
);

Vue.component(
  "p-payout-details",
  require("./components/psychic/payout_details").default
);
Vue.component(
  "p-payout-history",
  require("./components/psychic/payout_history.vue").default
);
Vue.component(
  "p-tax",
  require("./components/psychic/tax.vue").default
);

Vue.component("slider-banner", require("./components/slider_banner").default);
Vue.component('header-info', require('./../../frontend/js/components/header_info').default);
Vue.component("header-space", require("./../../frontend/js/components/header_space.vue").default);
Vue.component("header-space-2", require("./../../frontend/js/components/header_space_2.vue").default);
Vue.component(
  "notifications",
  require("./components/notifications/notifications.vue").default
);
Vue.component('standard-dialog', require('./components/dialogs/standard_dialog.vue').default);

Vue.component("SearchInputHeader", require("./../../frontend/js/components/specialtie_search_header.vue").default);
Vue.component("SearchFilterHeader", require("./../../frontend/js/components/search_filter_header.vue").default);
Vue.component("SearchInput", require("./../../frontend/js/components/specialtie_search.vue").default);

Vue.component("h-search", require("./components/nav_search.vue").default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import store from "./store/store";

new Vue({
  vuetify,
  store,
  methods: {
    onResize() {
      this.$store.dispatch("util/setMobile");
    },
  },
}).$mount("#app");
