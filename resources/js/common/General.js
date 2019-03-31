import Axios from "axios";
import ApiService from "./ApiService"

export function initialize(router, store){

    /**
     * Appending headers and token (if exists) to api calls
     */
    ApiService.init();

    /**
     * Is called before every call to api
     * If user doesn't have right to access resource or
     * bearer token has been expired, we log the user out
     */
    Axios.interceptors.response.use(null, err => {
        if(err.response.status === 401){
            store.commit("logout");
            router.push({name: "Login"});
        }

        return Promise.reject(err);
    });
}