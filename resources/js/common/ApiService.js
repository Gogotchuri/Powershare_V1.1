import axios from "axios";

const ApiService = {

    setDefaultHeader(){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + JSON.parse(localStorage.getItem("user")).token;
    },
    
    setHeaderToken(token){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
    },

    removeHeaderToken(){
        axios.defaults.headers.common['Authorization'] = 'Bearer Dummy';
    },

    init(){
        axios.defaults.headers.common['Content-Type'] = 'application/json';
        this.setDefaultHeader();        
    }
};

export default ApiService;