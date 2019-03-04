import axios from "axios";
import JwtService from "./JwtService";

const API_PATH = 'api/';

const ApiService = {
    
    __handleCatch(err){
        console.log("ApiError");
        console.log(err);
    },

    setHeader(){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + JwtService.getToken();
    },

    init(){
        axios.defaults.headers.common['Content-Type'] = 'application/json';
        this.setHeader();
    },

    get(resource) {
        return axios.get(API_PATH +`${resource}`).catch(error => __handleCatch(error));
    },
    
    getWithSlug(resource, slug = "") {
        return axios.get(API_PATH +`${resource}/${slug}`).catch(error => __handleCatch(error));
    },

    
    post(resource, props) {
        return axios.post(API_PATH + `${resource}`, props).catch(error => __handleCatch(error));
    },
    
    update(resource, slug, props) {
        return axios.put(`${resource}/${slug}`, props);
    },
    
    put(resource, props) {
        return axios.put(`${resource}`, props);
    },
    
    delete(resource, slug) {
        return axios.delete(`${resource}/${slug}`).catch(error => __handleCatch(error));
    }
};

export default ApiService;