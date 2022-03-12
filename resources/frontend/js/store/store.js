import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import util from './modules/util'

import category from './modules/category'

import psychic from './modules/psychic'

import search from './modules/search'

import favorite from '../../../backend/js/store/modules/favorite'
import helpfuls from '../../../backend/js/store/modules/helpfuls'
import horoscope from './modules/horoscope'
import zodiac_sign from './modules/zodiac_sign'
import specialty from './modules/specialty'


export default new Vuex.Store({
    modules: {
        util,
        category,
        psychic,
        favorite,
        helpfuls,
        search,
        specialty,
        horoscope,
        zodiac_sign
    }
})
