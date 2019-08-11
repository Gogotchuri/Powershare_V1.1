require('./Libraries/bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import VueProgressBar from 'vue-progressbar';
import VueI18n from 'vue-i18n';
import VueMeta from 'vue-meta';

import HTTP from '@js/Common/Http.service';
import store from '@js/store';
import App from '@views/App';
import router from '@js/router';
import i18n from "@js/locale";

Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(VueMeta);
Vue.use(VueI18n);
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
	router,
	i18n
});

HTTP.initializeInterceptors(store, router, app.$Progress);

//Google analytics initial loads
ga('set', 'page', router.currentRoute.path);
ga('send', 'pageview');