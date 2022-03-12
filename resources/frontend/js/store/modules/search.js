import axios from "axios";
import { isArray } from "lodash";

const state = {
  loading: false,
  error: "",
  items: [],
  per_page: 6,
  page: 1,
};

function error(error) {
  return { type: "error", error };
}

function loading(loading) {
  return { type: "loading", loading };
}

function success(items) {
  return { type: "list", items };
}

function page(page) {
  return { type: "page", page };
}

function per_page(per_page) {
  return { type: "per_page", per_page };
}
const getters = {
  error: (state) => state.error,
  items: (state) => state.items,
  loading: (state) => state.loading,
  per_page: (state) => state.per_page,
  page: (state) => state.page,
};

const actions = {
  getItems({ commit, rootState }, param) {
    let url = "", cont = 0;
    for (const prop in param) {
      if ((param[prop] && !Array.isArray(param[prop])) || (Array.isArray(param[prop]) && param[prop].length)) { 
          if(cont) url += `&${prop}=${param[prop]}`;
          else url += `${prop}=${param[prop]}`;
          cont++;
      }
    }
    
    if(url)history.pushState({id: 'search'}, 'Search', url ? `search?${url}` : 'search');
    else{
     history.pushState({id: 'search'}, 'Search', 'search');
    }

    commit(loading(true));
    return axios
      .post(
        rootState.util.entrypoint +
          "/api/v1/search/home?page=" +
          state.page +
          "&per_page=" +
          state.per_page,
        param
      )
      .then((response) => {
        commit(loading(false));
        commit(success(response.data));
        return true;
      })
      .catch((e) => {
        commit(loading(false));
        commit(error(e.messages));
      });
  },
  page({ commit }, val = false) {
    commit(page(val || state.page + 1));
  },
  perPage({ commit }, val) {
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
  list(state, payload) {
    state.items = payload.items;
  },
  page(state, payload) {
    state.page = payload.page;
  },
  per_page(state, payload) {
    state.per_page = payload.per_page;
  },
};

export default {
  namespaced: "index",
  state,
  getters,
  actions,
  mutations,
};
