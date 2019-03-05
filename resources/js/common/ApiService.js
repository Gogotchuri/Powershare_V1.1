import axios from "axios";
import JwtService from "./JwtService";

const API_PATH = 'api/';


export const Log = (msg) => {
    console.log(msg);
};

const ApiService = {

    setHeader(){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + JwtService.getToken();
    },

    init(){
        axios.defaults.headers.common['Content-Type'] = 'application/json';
        this.setHeader();
    },

    get(resource) {
        return axios.get(API_PATH +`${resource}`).catch(Log);
    },
    
    getWithSlug(resource, slug = "") {
        return axios.get(API_PATH +`${resource}/${slug}`).catch(Log);
    },

    
    post(resource, props) {
        return axios.post(API_PATH + `${resource}`, props).catch(Log);
    },
    
    update(resource, slug, props) {
        return axios.put(`${resource}/${slug}`, props);
    },
    
    put(resource, props) {
        return axios.put(`${resource}`, props);
    },
    
    delete(resource, slug) {
        return axios.delete(`${resource}/${slug}`).catch(Log);
    }
};

export default ApiService;

export const post = (resource, props) => {
    return ApiService.post(resource, props);
};

export const get = (resource) => {
    return ApiService.get(resource);
};