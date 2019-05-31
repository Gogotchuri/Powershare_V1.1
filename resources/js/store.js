import PublicModule from "@js/Modules/Public/Store.module";
import AuthModule from "@js/Modules/Auth/Store.module";
import ManagementModule from "@js/Modules/User/Store.module";

import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);


//exports store
/*Store data.*/
const storeData = {
    modules : {
        PublicModule,
        AuthModule,
        ManagementModule
    }
};

const store = new Vuex.Store(storeData);
export default store;
