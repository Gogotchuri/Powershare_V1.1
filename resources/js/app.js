import Vue from 'vue';
import VueRouter from 'vue-router';
import ApiService from "./common/ApiService.js"


Vue.use(VueRouter);
ApiService.init();


import App from "../views/App";
import Home from "../views/public/Home";
import Login from "../views/auth/Login";
import Register from "../views/auth/Register";
import Profile from "../views/management/Profile";


const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'Home',
            component: Home
        },
        {
            path: '/login',
            name: 'Login',
            component: Login,
        },
        {
            path: '/register',
            name: 'Register',
            component: Register,
        },
        {
            path: '/profile',
            name: 'Profile',
            component: Profile,
        }
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
