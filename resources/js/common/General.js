import Axios from "axios";
import ApiService from "./ApiService"

export function initialize(router, store){

    ApiService.init();

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

    Axios.interceptors.request.use(null, err => {
        if(err.response.status == 401){
            store.commit("logout");
            router.push({name: "Login"});
        }
    });
}