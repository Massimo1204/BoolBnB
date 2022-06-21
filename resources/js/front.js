window.axios=require('axios');
// window.axios.defaults.headers.common['X-Reuested-With']='XMLHttpRequest';
window.Vue = require('vue');
// Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');

import Vue from "vue";
import VueRouter from "vue-router";
import App from "./views/App";

Vue.use(VueRouter);

import Home from './pages/Home';
import Show from './pages/Show';
import Messages from './pages/Messages';
import ApartmentMessages from './pages/ApartmentMessages';

const router = new VueRouter({
    mode:'history',
    routes:[
        {
            path:'/',
            name:'Home',
            component:Home
        },
        {
            path:'/apartment/:id',
            name:'Show',
            component:Show
        },
        {
            path:'/messages/:id',
            name:'Messages',
            component:Messages
        },
        {
            path:'/apartment/messages/:id',
            name:'ApartmentMessages',
            component:ApartmentMessages
        }
]
})

const app = new Vue({
    el: '#root',
    render: h=>h(App),
    router,
});
