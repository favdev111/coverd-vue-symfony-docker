import axios from 'axios';

// initial state
const state = {
    all: []
};

// getters
const getters = {
    allTypes: state => {
        return state.all
    },
    getTypeById: (state) => (id) => {
        if (!id) return null;

        return state.all.find(type => type.id === id);
    }
};

// actions
const actions = {
    loadTypes ({ commit }) {
        return new Promise((resolve, reject) => {
            axios
                .get('/api/system/attribute-types')
                .then((response) => {
                    commit('setTypes', { list: response.data.data });
                    resolve(response);
                },
                (err) => {
                    reject(err);
                }
            );
        });
    }
};

// mutations
const mutations = {
    setTypes (state, { list }) {
        state.all = list;
    },
};

export default {
    state,
    getters,
    actions,
    mutations
};