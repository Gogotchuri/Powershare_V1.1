import Http from "@js/common/Http.service";

export function login(credentials) {
    return new Promise((resolve, reject) => {
        Http.POST('login', credentials)
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
        Http.POST('register', information)
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
        Http.POST('logout')
        .then(response => {
            resolve(response.data);
        })
        .catch(err => {
            console.error("Logout error" + err);
            reject("Couldn't logout");

        });
    });
};
