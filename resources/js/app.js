require('./bootstrap');

import VueRouter from "vue-router";
import router from "./routes";
import Index from "./Index";

window.Vue = require('vue');
Vue.use(VueRouter);

const app = new Vue({
    el: '#app',
    router,
    components: {
        "index": Index
    }
});
