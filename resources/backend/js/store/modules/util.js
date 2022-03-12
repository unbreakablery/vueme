const state = {
    loading: false,
    mobile: window.innerWidth < 960,
    entrypoint: location.protocol.concat("//", window.location.hostname),
    space: 60,
};

function loading(loading) {
    return {type: 'loading', loading};
}

function mobile(mobile) {
    return {type: 'mobile', mobile};
}
function space(space) {
    return {type: 'space', space};
}
const getters = {
    loading: state => state.loading,
    mobile: state => state.mobile,
    entrypoint: state => state.entrypoint,
    space: state => state.space
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
    },
    setSpace({commit}){
        let value = !state.mobile ? 118 : 60;
        commit(space(value)); 
    },
    getTableList({ rootState, state }, params){
        let endpoint = "/generic/list",
            query;
            // page,
            // perPage,
            // saveState;
    
        ({ query } = params);
        // ({ query, saveState } = params);
    
        let uri = rootState.util.entrypoint + endpoint;
    
        return axios
            .post(uri, query)
            .then(response => {
                return response;
                // if (!saveState) return response;
    
                // if (!(page && perPage)) {
                //     state.items = response.data.data;
                //     return response;
                // }
    
                // state.items = response.data.data;
    
                // if (response.data.meta && response.data.meta.total) {
                //     if (response.data.meta.total > state.perPage)
                //         state.pages = Math.ceil(
                //             parseFloat(response.data.meta.total / state.perPage)
                //         );
                //     else state.pages = 0;
    
                //     state.total = response.data.meta.total;
    
                //     return response.data.meta.total;
                // }
            })
            .catch(e => {
                console.log(e);
            });
    }
    
};

const mutations = {
    loading(state, payload) {
        state.loading = payload.loading;
    },
    mobile(state, payload) {
        state.mobile = payload.mobile;
    },
    space(state,payload){
        state.space = payload.space;
    }
};

export default {
    namespaced: 'loading',
    state,
    getters,
    actions,
    mutations,
}
