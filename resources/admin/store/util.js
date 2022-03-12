const state = {
    loading: false,
    mobile: window.innerWidth < 960,
    entrypoint: location.protocol.concat("//", window.location.hostname)
};

function loading(loading) {
    return {type: 'loading', loading};
}

function mobile(mobile) {
    return {type: 'mobile', mobile};
}
const getters = {
    loading: state => state.loading,
    mobile: state => state.mobile,
    entrypoint: state => state.entrypoint
};

const actions = {
    setLoading({commit}, increment = true) {
        if (increment == 0)
            commit(loading(0))
        else if (increment)
            commit(loading(state.loading + 1));
        else if (state.loading)
            commit(loading(state.loading - 1));
    },
    setMobile({commit}) {
        commit(mobile(window.innerWidth < 960));
    }
};

const mutations = {
    loading(state, payload) {
        state.loading = payload.loading;
    },
    mobile(state, payload) {
        state.mobile = payload.mobile;
    }
};

export default {
    namespaced: 'loading',
    state,
    getters,
    actions,
    mutations
}
