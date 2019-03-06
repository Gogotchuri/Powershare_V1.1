import axios from "axios";
import JwtService from "./JwtService";

const API_PATH = 'api/';


export const Log = (msg) => {
    console.log(msg);
};

const ApiService = {

    setHeaderToken(){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + JwtService.getToken();
    },

    removeHeaderToken(){
        axios.defaults.headers.common['Authorization'] = 'Bearer Dummy';
    },

    init(){
        axios.defaults.headers.common['Content-Type'] = 'application/json';
        this.setHeader();
    }
};

export default ApiService;

export const post = (resource, props) => {
    return ApiService.post(resource, props);
};

export const get = (resource) => {
    return ApiService.get(resource);
};