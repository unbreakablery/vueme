import Vue from 'vue'

import Vuex from 'vuex'

Vue.use(Vuex)



import VueTheMask from "vue-the-mask";
Vue.use(VueTheMask);
window.axios = require('axios');

import util from './store/util'

import user from './store/user'

import category from './store/category'

import horoscopesign from './store/horoscopesign'
import horoscopeuser from './store/horoscopeuser'

import service from './store/service'

import payout from './store/payout'

import review from './store/review'

import transaction from './store/transaction'

import analytic from './store/analytic'

import chat from './store/chat'



export default new Vuex.Store({
  modules: {
    util,
    user,
    category,
    horoscopesign,
    horoscopeuser,
    service,
    payout,
    review,
    transaction,
    analytic,
    chat
  }
})
