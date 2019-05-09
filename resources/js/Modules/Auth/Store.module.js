/**
 * This is a Vuex store module for auth
 * Managing registration and login currently
 */

import {destroyUser, getUser, storeUser} from "@js/Common/Jwt.service";
import Http from "@js/Common/Http.service";
/**
 * State for auth module
 */

const localUser = getUser();

const state = {
    currentUser : localUser,
    authErrors : null
};

/**
 * Getters for auth module
 */
const getters = {
    currentUser(state){
        return state.currentUser;
    },

    isAuthenticated(state){
        return !!state.currentUser;
    },

    authErrors(state){
        return state.authErrors;
    }
};

/**
 * Mutations for auth module
 */
const mutations = {
    login(state, user, errors){
        if(errors){
            state.authErrors = errors;
            state.currentUser = null;
        }else if(user){
            state.authErrors = null;
            state.currentUser = user;
            Http.setJwtHeader(user.token);
            storeUser(user);
        }else{
            console.error("Something went Wrong during authentication");
        }
    },

    logout(state){
        Http.removeJwtHeader();
        state.currentUser = null;
        destroyUser();
    }
};

/**
 * Actions for auth module
 */

const actions = {
    login(context, credentials) {
        return new Promise((resolve, reject) => {
            Http.POST("login", credentials)
            .then(value => {
                let user = value.data.data;
                context.commit("login", user, null);
                resolve();
            })
            .catch(reason => {
                context.commit("login", null, reason);
                reject();
            })
        });
    },

    logout(context){
        return new Promise((resolve, reject) => {
            Http.POST("logout")
                .then(() => {
                    context.commit("logout");
                    resolve("Logged out!");
                })
                .catch(reason => {
                    reject(reason);
                })
        });
    },

    /**
     *
     * @param context
     * @param {email, name, password} data
     */
    register(context, data) {
        return new Promise((resolve, reject) => {
            Http.POST("register", data)
                .then(() => resolve())
                .catch(reason => {
                    //just displays errors
                    context.commit("login", null, reason);
                    reject();
                })
        });
    },
};


/**
 * Exporting auth module store
 */
export default {
    state,
    getters,
    mutations,
    actions
};
