require("./libraries/bootstrap");

import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import ApiService from "./common/ApiService"
import App from "../views/App";
import storeData from "./store";
import {routes} from "./routes";

ApiService.init();

Vue.use(VueRouter);
Vue.use(Vuex);

const store = new Vuex.Store(storeData);

const router = new VueRouter({
    mode: 'history',
    routes
});

router.beforeEach((to, from, next) => {
    const authRequired = to.matched.some(record => record.meta.authRequired);
    const user = store.state.user.currentUser;

    if(authRequired && !user){
        next('/login');
    }else if((to.path == "/login" || to.path == "/register")&& !!user){
        next('/');
    }else{
        next();
    }

});

const app = new Vue({
    el: '#app',
    store,
    components: { App },
    router,
});
