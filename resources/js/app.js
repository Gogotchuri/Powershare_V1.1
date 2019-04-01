require('./libraries/bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import VueProgressBar from 'vue-progressbar';
import Http from "@js/common/Http.service";
import App from '@views/App';
import store from '@js/store';
import router from '@js/router';

Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(VueProgressBar);

export const app = new Vue({
	el: '#app',
	store,
	components: { App },
	router
});

Http.initializeInterceptors(store, router, app.$Progress);
