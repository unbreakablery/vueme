import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import util from './modules/util'

import favorite from './modules/favorite'
import helpfuls from './modules/helpfuls'

export default new Vuex.Store({
    modules: {
        util,
        favorite,
        helpfuls
    }
})
