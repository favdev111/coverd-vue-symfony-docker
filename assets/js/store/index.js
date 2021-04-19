import Vue from 'vue';
import Vuex from 'vuex';
import products from './modules/products';
import storageLocations from './modules/storageLocations';
import suppliers from './modules/suppliers';
import clients from './modules/clients';
import attributeTypes from "./modules/attributeTypes";
import system from "./modules/system";

Vue.use(Vuex);


export default new Vuex.Store({
    modules: {
        products,
        storageLocations,
        suppliers,
        clients,
        attributeTypes,
        system,
    }
});