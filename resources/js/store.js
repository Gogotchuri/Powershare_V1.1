import {destroyUser, getUser, storeUser} from "@/js/Common/Jwt.service";
import PublicModule from "@js/Modules/Public/Store.module";
import AuthModule from "@js/Modules/Auth/Store.module";
import ManagementModule from "@js/Modules/Management/Store.module";

import Http from "@js/Common/Http.service";
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
