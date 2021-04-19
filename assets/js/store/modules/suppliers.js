import axios from 'axios';

// initial state
const state = {
    all: []
};

// getters
const getters = {
    allSuppliers: state => {
        return state.all
    },
    allActiveSuppliers: state => {
        return state.all.filter(supplier => supplier.status === "ACTIVE")
    },
    getSupplierById: (state) => (id) => {
        return state.all.find(supplier => supplier.id == id);
    },
};

// actions
const actions = {
    loadSuppliers ({ commit }) {
        return new Promise((resolve, reject) => {
            axios
                .get('/api/suppliers',  {
                    params: { include: ['addresses']}
                })
                .then((response) => {
                    commit('setSuppliers', { list: response.data.data });
                    resolve(response);
                },
                    (err) => {
                    reject(err);
            });
        });
    }
};

// mutations
const mutations = {
    setSuppliers (state, { list }) {
        state.all = list;
    },
};

export default {
    state,
    getters,
    actions,
    mutations
};