import axios from "axios";

export function login(credentials) {
    return new Promise((resolve, reject) => {
        axios.post('api/login', credentials)
        .then(response => {
            resolve(response.data);
        })
        .catch(err => {
            console.error("Login error" + err);
            reject("Wrong Credentials");

        });
    });
};

/**
 * 
 * @param {email, name, password} information 
 */
export function register(information) {
    return new Promise((resolve, reject) => {
        axios.post('api/register', information)
        .then(response => {
            resolve(response.data);
        })
        .catch(err => {
            console.error("Register error" + err);
            reject("Something went wrong");

        });
    });
};

export function logout() {
    return new Promise((resolve, reject) => {
        axios.post('api/logout')
        .then(response => {
            resolve(response.data);
        })
        .catch(err => {
            console.error("Logout error" + err);
            reject("Couldn't logout");

        });
    });
};

export function getLocalUser(){
    const user = localStorage.getItem("user");

    if(!user)
        return null;
        
    return JSON.parse(user);
}