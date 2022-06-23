window.axios=require('axios');
// window.axios.defaults.headers.common['X-Reuested-With']='XMLHttpRequest';
window.Vue = require('vue');

Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');

import Vue from "vue";
import VueRouter from "vue-router";
import VueSweetalert2 from 'vue-sweetalert2';
import App from "./views/App";

Vue.use(VueRouter);
Vue.use(VueSweetalert2);

import Home from './pages/Home';
import Show from './pages/Show';
import Messages from './pages/Messages';
import ApartmentMessages from './pages/ApartmentMessages';
import ApartmentStatistics from './pages/ApartmentStatistics';
import AdvancedSearch from './pages/AdvancedSearch.vue';

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
        },
        {
            path:'/apartment/statistics/:id',
            name:'ApartmentStatistics',
            component:ApartmentStatistics
        },
        {
            path:'/apartments/search',
            name:'AdvancedSearch',
            component:AdvancedSearch
        },
]
})

const app = new Vue({
    el: '#root',
    render: h=>h(App),
    router,
});
