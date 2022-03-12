import axios from 'axios';
import {objectToGetParameters} from '../util';
import { AbilityBuilder, Ability } from "@casl/ability";

function getAbilityRule(user) {

    const { can, cannot, rules } = new AbilityBuilder(Ability);

    switch (user.role_id) {
        case 3: {
            can("manage", "all");
            break;
        }
        case 5: {
            can('list', 'users');
            cannot("edit", "all");
            can('edit', 'email');
            can('edit', 'phone');
            can("edit", "note");
            can('edit', 'something');
            can('list', 'chat');
            break;
        }
        case 6: {
            can("manage", "all");
            cannot("list", "payout");
            cannot("edit", "all");
            can('edit', 'something')
            can("edit", "priority");
            can("edit", "note");
            break;
        }
        case 4: {
            can("list", "blog");
            can("list", "email");
            can("manage", "horoscope");
            can("list", "HoroscopeSing");
            can("manage", "HoroscopeSing");
            can("manage", "UserHoroscope");
            break;
        }
        case 7: {
            can("list", "email");
            can("manage", "horoscope");
            can("list", "HoroscopeSing");
            can("manage", "HoroscopeSing");
            can("manage", "UserHoroscope");
            break;
        }
    }

    // cannot('delete', 'Post', { published: true });

    return rules;
}

const state = {
    loading: false,
    error: '',
    items: {meta: {}},
    view: [],
    per_page: 25,
    page: 1,
    roles: [],
    ability: new Ability()
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
    roles: state => state.roles
};

const actions = {
    getItems({commit, rootState}, param) {
        commit(loading(true));
        param.page = state.page;
        param.per_page = state.per_page;
        let endpoint = rootState.util.entrypoint + '/api/agency/users' + '?' + objectToGetParameters(param);

        return axios.get(endpoint)
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
    getItem({commit, rootState}, id) {
        commit(loading(true));
        let endpoint = rootState.util.entrypoint + '/api/agency/users' + '?id=' + id;
        return axios.get(endpoint)//rootState.util.entrypoint + '/api/v1/search/psychic/profile/' + id)
            .then(response => {
                commit(loading(false));
                commit(view(response.data.data));

                state.ability.update(getAbilityRule(response.data.data));

                return true
            })
            .catch(e => {
                commit(loading(false));
                commit(error(e.messages));
            });
    },
    getRoles({commit, rootState}) {
        commit(loading(true));
        return axios.get(rootState.util.entrypoint + '/api/admin/roles')
            .then(response => {
                commit(loading(false));
                commit(roles(response.data.data));
                return true
            })
            .catch(e => {
                commit(loading(false));
                commit(error(e.messages));
            });
    },
    store({commit}, values) {
        commit(loading(true));
        return axios.post(endpoint, values).then((response) => {
            commit(loading(false));
            return response;
        }).catch(e => {
            commit(loading(false));
            commit(error(e.messages));
        });
    },
    update({commit, rootState}, values) {
        if (typeof values.noLoading == typeof undefined) {
            commit(loading(true));
        }
        else {
            delete values.noLoading
        }
            

        return axios.put(rootState.util.entrypoint + '/api/admin/update-user/' + values.id, values).then((response) => {
            commit(loading(false));
            return response;
        }).catch(e => {
            commit(loading(false));
            commit(error(e.messages));
        });
    },
    delete({commit, rootState}, id) {
        commit(loading(true));
        return axios.delete(rootState.util.entrypoint + '/api/admin/user/' + id).then((response) => {
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
