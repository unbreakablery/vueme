import axios from 'axios';
import {objectToGetParameters} from '../util';

const state = {
    loading: false,
    error: '',
    items: [],
    services: [],
    payouts: [],
    transactions: []
};

function error(error) {
    return {type: 'error', error};
}

function loading(loading) {
    return {type: 'loading', loading};
}

function success(items) {
    return {type: 'list', items};
}

function services(items) {
    return {type: 'listServices', items};
}

function payouts(items) {
    return {type: 'payouts', items};
}

function transactions(items) {
    return {type: 'transactions', items};
}

const getters = {
    error: state => state.error,
    items: state => state.items,
    services: state => state.services,
    payouts: state => state.payouts,
    transactions: state => state.transactions,
    loading: state => state.loading,
};

const actions = {
    getItems({commit, rootState}, param) {
        commit(loading(true));
        let endpoint = rootState.util.entrypoint + '/api/admin/analytic/sign-up';
        return axios.post(endpoint, param)
            .then(response => {                
                commit(success(response.data));
                commit(loading(false));
                return true
            })
            .catch(e => {
                commit(loading(false));
                commit(error(e.messages));
            });
    },

    getUserStatus({commit, rootState}, param) {
        commit(loading(true));
        let endpoint = rootState.util.entrypoint + '/api/admin/analytic/user-status';
        return axios.post(endpoint, param)
            .then(response => {                
                commit(success(response.data));
                commit(loading(false));
                return true
            })
            .catch(e => {
                commit(loading(false));
                commit(error(e.messages));
            });
    },

    services({ commit, rootState }, param) {
        commit(loading(true));
        let endpoint = rootState.util.entrypoint + '/api/admin/analytic/services';
        return axios.post(endpoint, param)
            .then(response => {
                commit(services(response.data));
                commit(loading(false));
                return true
            })
            .catch(e => {
                commit(loading(false));
                commit(error(e.messages));
            });
    },

    payouts({commit, rootState}, param) {
        commit(loading(true));
        let endpoint = rootState.util.entrypoint + '/api/admin/analytic/payouts';
        return axios.post(endpoint, param)
            .then(response => {
                commit(payouts(response.data));
                commit(loading(false));
                return true
            })
            .catch(e => {
                commit(loading(false));
                commit(error(e.messages));
            });
    },
    transactions({commit, rootState}, param) {
        commit(loading(true));
        let endpoint = rootState.util.entrypoint + '/api/admin/analytic/transactions';
        return axios.post(endpoint, param)
            .then(response => {
                commit(transactions(response.data));
                commit(loading(false));
                return true
            })
            .catch(e => {
                commit(loading(false));
                commit(error(e.messages));
            });
    },
};

const mutations = {
    error(state, payload) {
        state.error = payload.error;
    },
    loading(state, payload) {
        state.loading = payload.loading;
    },
    list(state, payload) {
        state.items = payload.items;
    },
    listServices(state, payload) {
        state.services = payload.items;
    },
    payouts(state, payload) {
        state.payouts = payload.items;
    },
    transactions(state, payload) {
        state.transactions = payload.items;
    },
};

export default {
    namespaced: 'index',
    state,
    getters,
    actions,
    mutations
}
