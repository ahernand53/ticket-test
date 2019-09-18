import Vuetify from "vuetify"
import VueRouter from "vue-router";

import Home from "./views/Home";

require('./bootstrap');
window.Vue = require('vue');

Vue.use(Vuetify)
Vue.use(VueRouter)

const vuetify = new Vuetify({
    icons: {
        iconfont: 'mdi',
    },
})

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        }
    ]
})


const app = new Vue({
    el: '#app',
    router,
    vuetify
});
