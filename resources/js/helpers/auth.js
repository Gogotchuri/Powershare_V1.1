import axios from "axios";

export function login(credentials) {
    return new Promise((resolve, reject) => {
        axios.post('api/login', credentials)
        .then(response => {
            resolve(response);
        })
        .catch(err => {
            reject("Wrong Credentials");
        });
    });
};

export function register(information) {

};

export function logout() {

};

export function getLocalUser(){
    const user = localStorage.getItem("user");

    if(!user)
        return null;
        
    return JSON.parse(user);
}