require('./bootstrap');

import VueRouter from "vue-router";
import router from "./routes";
import Index from "./Index";
import moment from "moment";
import StarRating from "./shared/components/StarRating";
import FatalError from "./shared/components/FatalError";
import Success from "./shared/components/Success";
import ValidationErrors from "./shared/components/ValidationErrors";

import Vuex from 'vuex';
import storeDefiniton from './store';

window.Vue = require('vue');

Vue.use(VueRouter);
Vue.use(Vuex);

Vue.filter("fromNow", value => moment(value).fromNow());

Vue.component("star-rating", StarRating);
Vue.component("fatal-error", FatalError);
Vue.component("success", Success);
Vue.component("validation-errors", ValidationErrors);

const store = new Vuex.Store(storeDefiniton);

window.axios.interceptors.response.use(
    response => response,
    error => {
        if (401 === error.response.status) {
            store.dispatch('logout');
        }

        return Promise.reject(error);
    }
);

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        "index": Index
    },
    async beforeCreate() {
        this.$store.dispatch('loadStoredState');
        this.$store.dispatch('loadUser');
    }
});
