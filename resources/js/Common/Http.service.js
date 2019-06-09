import Vue from "vue";
import Axios from "axios";
import {getToken} from "@js/Common/Jwt.service";
import {API_URL} from "@js/Common/config";

class HttpService {
    /**
     * Given base Url new http service instance
     * This class is wrapper of Axios
     * @ApiUrl base url of api
     */
    constructor(ApiUrl) {
        //Extracting csrf token from page head
        let csrfToken = document.head.querySelector('meta[name="csrf-token"]');
        if (!csrfToken)
            console.error("Csrf token not present please fix it!");

        this._axios = Axios.create({
            baseURL: ApiUrl,
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Access-Control-Allow-Origin": "*",
            },

        });
        this._axios.defaults.headers.common["X-CSRF-TOKEN"] = csrfToken;
        this._axios.defaults.headers.common["accept"] = "application/json";
        this.setExistingJwtHeader();
    }

    /**
     * Given a token, sets it in Axios default headers
     * as a Bearer authorization token
     *
     * @param token jwt access token
     */
    setJwtHeader(token) {
        this._axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
    }

    /**
     * Sets already existed token in local storage as Bearer access token
     */
    setExistingJwtHeader() {
        let token = getToken();
        this._axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
    }

    /**
     * Removes Bearer jwt token from Axios headers
     * Replaces it with a junk
     */
    removeJwtHeader() {
        this._axios.defaults.headers.common['Authorization'] = 'Bearer Dummy';
    }

    /**
     * Wrapper for Axios GET request
     * @uri relative path to api route
     * @urlParams Parameters that should be passed with get request
     *
     * @return Promise with either data or error
     */
    async GET(uri, urlParams = null) {
        return new Promise((resolve, reject) => {
            this._axios.get(uri, {params: urlParams})
                .then(value => {
                    resolve(value);
                })
                .catch(reason => {
                    reject(reason);
                })
        });
    }

    /**
     * Wrapper for Axios POST request
     * @uri relative path to api route
     * @baggage Data that should be sent with this request
     *
     * @return Promise with either data or error
     */
    async POST(uri, baggage = null) {
        return new Promise((resolve, reject) => {
            this._axios.post(uri, baggage)
                .then(value => {
                    resolve(value);
                })
                .catch(reason => {
                    reject(reason);
                })
        });
    }

    /**
     * Wrapper for Axios, DELETE request
     * @uri relative path to api route
     * @baggage Data that should be sent with this request
     * packs _method : delete as a hidden input to let laravel know true intention
     *
     * @return Promise with either data or error
     */
    async DELETE(uri, baggage = null) {
        if (!!baggage)
            baggage["_method"] = "DELETE";
        else
            baggage = {"_method": "DELETE"};

        return new Promise((resolve, reject) => {
            this._axios.delete(uri, baggage)
                .then(value => {
                    resolve(value);
                })
                .catch(reason => {
                    reject(reason);
                })
        });
    }

    /**
     * Wrapper for Axios, PUT request
     * @uri relative path to api route
     * @baggage Data that should be sent with this request
     * packs _method : put as a hidden input to let laravel know true intention
     *
     * @return Promise with either data or error
     */
    async PUT(uri, baggage) {
        if (!!baggage)
            baggage["_method"] = "PUT";
        else
            baggage = {"_method": "PUT"};

        return new Promise((resolve, reject) => {
            this._axios.post(uri, baggage)
                .then(value => {
                    resolve(value);
                })
                .catch(reason => {
                    reject(reason);
                })
        });
    }

    /**
     * Wrapper for Axios, PATCH request
     * @uri relative path to api route
     * @baggage Data that should be sent with this request
     * packs _method : put as a hidden input to let laravel know true intention
     *
     * @return Promise with either data or error
     */
    async PATCH(uri, baggage) {
        if (!!baggage)
            baggage["_method"] = "PATCH";
        else
            baggage = {"_method": "PATCH"};

        return new Promise((resolve, reject) => {
            this._axios.post(uri, baggage)
                .then(value => {
                    resolve(value);
                })
                .catch(reason => {
                    reject(reason);
                })
        });
    }

    initializeInterceptors(store, router, progressBar){

        progressBar.setTransition({
            call: "transition",
            modifier: "temp",
            argument: {
                speed: "0.6s",
                opacity: "0.6s",
                termination: 400
            }
        });
        /**
         * Is called before every call to api
         * If user doesn't have right to access resource or
         * bearer token has been expired, we log the user out
         */
        //Request intercept for starting progress bar
        this._axios.interceptors.request.use(value => {
            progressBar.start();
            return Promise.resolve(value);
        }, error => {
            progressBar.fail();
            return Promise.reject(error);
        });
        //Response intercept
        this._axios.interceptors.response.use((value) => {
            progressBar.finish();
            return Promise.resolve(value);
        }, (err) => {
            progressBar.fail();
            console.error(err);
            if(err.response.status === 401){
                store.commit("logout");
                router.push({name: "Login"});
            }
            return Promise.reject(err);
        });
    }
}

const httpInstance = new HttpService(API_URL);
Vue.prototype.$http = httpInstance;
export default httpInstance;
