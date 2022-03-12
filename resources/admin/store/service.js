
import axios from 'axios';
import {objectToGetParameters} from '../util';

const state = {
    loading: false,
    error: '',
    items: {meta: {}},
    view: [],
    per_page: 25,
    page: 1,
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

function view(items) {
    return { type: 'view', items};
}

function page(page) {
    return {type: 'page', page};
}

function per_page(per_page) {
    return {type: 'per_page', per_page};
}

const getters = {
    error: state => state.error,
    items: state => state.items,
    loading: state => state.loading,
    per_page: state => state.per_page,
    page: state => state.page,
    view: state => state.view
};

const actions = {
    getItems({commit, rootState}, param) {
        commit(loading(true));
        // param.page = state.page;
        // param.per_page = state.per_page;
        let endpoint = rootState.util.entrypoint + '/api/admin/services-list';// + '?' + objectToGetParameters(param);

        return axios.get(endpoint)
            .then(response => {
                // commit(success(response.data));
                commit(loading(false));
                return response
            })
            .catch(e => {
                commit(loading(false));
                commit(error(e.messages));
            });
    },
    // getItems({ commit, rootState }, param = null) {
    //     commit(loading(true));

    //     return axios.get(rootState.util.entrypoint + '/api/admin/services-list')
    //         .then(response => {
    //             commit(loading(false));
    //             commit(success(response.data));
    //             return true
    //         })
    //         .catch(e => {
    //             commit(loading(false));
    //             commit(error(e.messages));
    //         });
    // },
    store({ commit }, values) {
        commit(loading(true));
        return axios.post( endpoint, values).then((response) => {
            commit(loading(false));
            return response;
        }).catch(e => {
            commit(loading(false));
            commit(error(e.messages));
        });
    },
    update({ commit, rootState }, values) {
        commit(loading(true));
        return axios.put( rootState.util.entrypoint + '/api/admin/update-service/' + values.id, values.data).then((response) => {
            commit(loading(false));
            return response;
        }).catch(e => {
            commit(loading(false));
            commit(error(e.messages));
        });
    },
    delete({ commit }, id) {
        commit(loading(true));
        return axios.delete( endpoint + '/' + id).then((response) => {
            commit(loading(false));
            return response;
        }).catch(e => {
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
    page(state, payload) {
        state.page = payload.page;
    },
    per_page(state, payload) {
        state.per_page = payload.per_page;
    }
};

export default {
    namespaced: 'index',
    state,
    getters,
    actions,
    mutations
}
