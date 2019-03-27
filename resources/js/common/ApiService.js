import axios from "axios";

const ApiService = {

    setDefaultHeader(){
        let token = JSON.parse(localStorage.getItem("user"));
        token = token ? token.token : ""
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
    },
    
    setHeaderToken(token){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
    },

    removeHeaderToken(){
        axios.defaults.headers.common['Authorization'] = 'Bearer Dummy';
    },

    init(){
        axios.defaults.headers.common['Content-Type'] = 'application/json';
        axios.defaults.baseURL = "http://127.0.0.1:8000"
        this.setDefaultHeader();        
    }
};

export default ApiService;