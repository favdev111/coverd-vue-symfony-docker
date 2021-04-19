
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');
require('bootstrap');
require('bootstrap-tooltip');
require('admin-lte');
require('chosen-js');
require('eonasdan-bootstrap-datetimepicker');
window.fileDownload = require('js-file-download');
window.tinycolor = require('tinycolor2');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

import Vue from 'vue';
import VueEvents from 'vue-events';
import VueRouter from 'vue-router';
import Vuelidate from 'vuelidate';
import Vuetable from 'vuetable-2';
import axios from 'axios';
import moment from 'moment-timezone';

window.Vue = Vue;
Vue.use(VueRouter);
Vue.use(Vuelidate);
Vue.use(Vuetable);
Vue.use(VueEvents);

window.axios = axios;
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'Accept': 'application/json'
};

window.axios.interceptors.response.use(function (response) {
    // Do something with response data
    return response;
}, function (error) {
    // Redirect the user to the login if we get a 401
    if (error.response.status == 401) {
        window.location.replace("/login");
    }
    App.exceptions.push(error.response.data);
    return Promise.reject(error);
});

window.moment = moment;
