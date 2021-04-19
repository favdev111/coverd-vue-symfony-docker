import axios from 'axios';

// initial state
const state = {
    all: []
};

// getters
const getters = {
    allClients: state => {
        return state.all
    },
    allActiveClients: state => {
        return state.all.filter(client => client.status == "ACTIVE")
    },
    getClientById: (state) => (id) => {
        return state.all.find(client => client.id == id);
    },
};

// actions
const actions = {
    loadClients ({ commit }) {
        return new Promise((resolve, reject) => {
            axios
                .get('/api/clients',  {
                    params: {per_page: -1}
                })
                .then((response) => {
                    commit('setClients', { list: response.data.data });
                    resolve(response);
                },
                    (err) => {
                    reject(err);
            });
        });
    },
    loadPartnerClients ({ commit }, partnerId) {
        return new Promise((resolve, reject) => {
            axios
                .get('/api/partners/' + partnerId + '/clients')
                .then((response) => {
                    commit('setClients', { list: response.data.data });
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
    setClients (state, { list }) {
        state.all = list;
    },
};

export default {
    state,
    getters,
    actions,
    mutations
};