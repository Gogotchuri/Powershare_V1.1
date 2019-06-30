require('./Libraries/bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import VueProgressBar from 'vue-progressbar';
import HTTP from "@js/Common/Http.service";
import store from '@js/store';
import App from '@views/App';
import router from '@js/router';
import VueMeta from 'vue-meta';


Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(VueMeta);
Vue.use(VueProgressBar,
	{
		thickness: "4px",
		transition: {
			speed: '0.8s',
			opacity: '1s',
			termination: 300
		}
	});

export const app = new Vue({
	el: '#app',
	store,
	components: { App },
	router
});
HTTP.initializeInterceptors(store, router, app.$Progress);
