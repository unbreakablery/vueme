import Vue from "vue";

import Router from "vue-router";

import User from "./views/User.vue";

import Category from "./views/Category.vue";

import HoroscopeSing from "./views/Horoscope.vue";

import UserHoroscope from "./views/UserHoroscope.vue";

import Service from "./views/Service.vue";

import Payout from "./views/Payout.vue";

import Review from "./views/Review.vue";

import Transaction from "./views/Transaction.vue";

import Analytic from "./views/Analytic.vue";

import Chat from "./views/Chat.vue";

import Promo from "./views/Promo.vue";

import Email from "./views/Email.vue";

import TopRated from "./components/Email/TopRated.vue";

import Featured from "./components/Email/Featured.vue";

import Horoscope from "./components/Email/Horoscope.vue";


Vue.use(Router);

export default new Router({
  mode: "history",
  base: "",
  scrollBehavior(to, from, savedPosition) {
    return { x: 0, y: 0 };
  },
  routes: [
    {
      
      path: "/agency/users",
      name: "users",
      component: User,
    },
    {
      
      path: "/admin/specialties",
      name: "specialties",
      component: Category,
    },
    {
      path: "/agency/HoroscopeSing",
      name: "HoroscopeSing",
      component: HoroscopeSing,
    },
    {
      
      path: "/agency/UserHoroscope",
      name: "UserHoroscope",
      component: UserHoroscope,
    },
    {
      
      path: '/agency/horoscope',
      name: 'horoscope',
      component: Horoscope
    },
    {
      
      path: "/admin/services",
      name: "services",
      component: Service,
    },
    {
      
      path: "/admin/payout",
      name: "payout",
      component: Payout,
    },
    {
      
      path: "/admin/review",
      name: "review",
      component: Review,
    },
    {
      
      path: "/admin/transaction",
      name: "transaction",
      component: Transaction,
    },
    {
      
      path: "/admin/analytic/:section",
      name: "analytic",
      component: Analytic,
    },
    {
      
      path: "/admin/chat",
      name: "chat",
      component: Chat,
    },    
    {
      
      path: '/admin/promo',
      name: 'promo',
      component: Promo
    },
    {
      
      path: "/admin/email",
      name: "email",
      component: Email,
      redirect: { name: "email" },
      children: [
          {
              name: "top-rated",
              path: "top-rated",
              component: TopRated
          },
          {
              name: "featured-psychic",
              path: "featured-psychic",
              component: Featured
          },
        
      ]
  },
  ],
});
