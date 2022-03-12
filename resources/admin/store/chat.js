import axios from 'axios';
import {objectToGetParameters} from '../util';

const state = {
    loading: false,
    error: '',
    items: {meta: {}},
    view: [],
    per_page: 25,
    page: 1,
    roles: [],
    chatData: []
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

function chatData(items) {
    return {type: 'chatData', items};
}

function view(items) {
    return {type: 'view', items};
}

function page(page) {
    return {type: 'page', page};
}

function per_page(per_page) {
    return {type: 'per_page', per_page};
}

function roles(roles) {
    return {type: 'roles', roles};
}

const getters = {
    error: state => state.error,
    items: state => state.items,
    loading: state => state.loading,
    view: state => state.view,
    per_page: state => state.per_page,
    page: state => state.page,
    roles: state => state.roles,
    chatData: state => state.chatData
};

const actions = {
    getItems({ commit, rootState }, param) {
        commit(loading(true));
        param.page = state.page;
        param.per_page = state.per_page;
        let endpoint = rootState.util.entrypoint + '/api/admin/chat' + '?' + objectToGetParameters(param);

        return axios.get(endpoint)
            .then(response => {
                commit(success(response.data));
                commit(loading(false));
                return true
            })
            .catch(e => {
                commit(loading(false));
                commit(error(e.chatData));
            });
    },
    getChatData({ commit, rootState }, param) {
    
        if(!param.noLoading)
         commit(loading(true));
        // param.page = state.page;
        // param.per_page = state.per_page;
        let endpoint = rootState.util.entrypoint + '/api/admin/chat-messages/' + param.user_id + '/' + param.receiver_id + '?' + objectToGetParameters(param);

        return axios.get(endpoint)
            .then(response => {
                commit(chatData(response.data));
                commit(loading(false));
                return true
            })
            .catch(e => {
                commit(loading(false));
                commit(error(e.messages));
            });
    },
    page({commit}, val) {
        commit(page(val));
    },
    perPage({commit}, val) {
        commit(per_page(val));
    },
};

const mutations = {
    error(state, payload) {
        state.error = payload.error;
    },
    loading(state, payload) {
        state.loading = payload.loading;
    },
    view(state, payload) {
        state.view = payload.items;
    },
    list(state, payload) {
        state.items = payload.items;
    },
    chatData(state, payload) {
        state.chatData = payload.items;
    },
    page(state, payload) {
        state.page = payload.page;
    },
    per_page(state, payload) {
        state.per_page = payload.per_page;
    },
    roles(state, payload) {
        state.roles = payload.roles;
    }
};

export default {
    namespaced: 'index',
    state,
    getters,
    actions,
    mutations
}
