require('./libraries/bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import VueProgressBar from 'vue-progressbar';
import App from '@views/App';
import store from '@js/store';
import router from '@js/router';
import { initialize } from '@js/common/General';

Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(VueProgressBar);

initialize(router, store);

export const app = new Vue({
	el: '#app',
	store,
	components: { App },
	router
});
