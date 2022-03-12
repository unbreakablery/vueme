import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';

import vuetify from './vuetify';

import { abilitiesPlugin } from '@casl/vue'

Vue.use(abilitiesPlugin, store.state.user.ability)

Vue.config.productionTip = false;

import numeral from 'numeral';
import numFormat from 'vue-filter-number-format';
 
Vue.filter('numFormat', numFormat(numeral));

Vue.filter('money', function (value) {
    return new Intl.NumberFormat([],{style: 'currency', currency: 'USD'}).format(value);
});



import axios from 'axios';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrfToken
};

axios.interceptors.response.use((response) => { // intercept the global error
    return response;
}, function (error) {
    if (error.response && (error.response.status === 401 || error.response.status === 419)) {
        location.reload();
    }
    // Do something with response error
    return Promise.reject(error)
});

Vue.mixin({
    methods: {
        is(user, role) {
            switch (role) {
                case "psychic": {
                    return user.role_id == 1;
                }
                case "user": {
                    return user.role_id == 2;
                }
                case "admin": {
                    return user.role_id == 3;
                }
                case "blog": {
                    return user.role_id == 4;
                }
                case "horoscope": {
                    return user.role_id == 7;
                }
                default: {
                    return false;
                }
            }
        }
    }
});

new Vue({
    vuetify,
    router,
    store,
    render: h => h(App)
}).$mount('#app');