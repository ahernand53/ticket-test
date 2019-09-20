import Vuetify from "vuetify"
import VueRouter from "vue-router";
import store from './store'

import Home from "./views/Home";
import CreateTicket from "./views/CreateTicket";
import EditTicket from "./views/EditTicket";

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
        },
        {
            path: '/nuevo-ticket',
            name: 'new-ticket',
            component: CreateTicket
        },
        {
            path: '/editar/:id',
            name: 'edit-ticket',
            component: EditTicket
        },
        {
            path: '/*',
            component: Home
        }
    ]
})


const app = new Vue({
    el: '#app',
    router,
    vuetify,
    store
});
