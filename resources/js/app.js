require('./libraries/bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import App from '../views/App';
import storeData from './store';
import { routes } from './routes';
import { initialize } from './common/General';

Vue.use(VueRouter);
Vue.use(Vuex);

const store = new Vuex.Store(storeData);

const router = new VueRouter({
	mode: 'history',
	routes
});

initialize(router, store);

const app = new Vue({
	el: '#app',
	store,
	components: { App },
	router
});
