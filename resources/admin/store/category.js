
import axios from 'axios';

const state = {
    loading: false,
    error: '',
    items: [],
    view: []
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

const getters = {
    error: state => state.error,
    items: state => state.items,
    loading: state => state.loading,
    view: state => state.view
};

const actions = {
    getItems({ commit, rootState }, param = null) {
        commit(loading(true));

        let endpoint = rootState.util.entrypoint + '/api/v1/search/categories';
        if (param) {
            if (param.slug)
                endpoint = endpoint + '/' + param.slug;
        }

        return axios.get(endpoint)
            .then(response => {
                commit(loading(false));
                commit(success(response.data.data));
                return true
            })
            .catch(e => {
                commit(loading(false));
                commit(error(e.messages));
            });
    },
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
    update({ commit, rootState }, values) {console.log(values)
        commit(loading(true));
        return axios.put( rootState.util.entrypoint + '/api/admin/update-category/' + values.id, values).then((response) => {
            commit(loading(false));
            return response;
        }).catch(e => {
            commit(loading(false));
            commit(error(e.messages));
        });
    },
    delete({ commit, rootState }, values) {
        commit(loading(true));
        return axios.put( rootState.util.entrypoint + '/api/admin/update-category/' + values.id, values).then((response) => {
            commit(loading(false));
            return response;
        }).catch(e => {
            commit(loading(false));
            commit(error(e.messages));
        });
    }
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
};

export default {
    namespaced: 'index',
    state,
    getters,
    actions,
    mutations
}
