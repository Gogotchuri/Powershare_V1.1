import { getLocalUser } from "./helpers/auth";

const localUser = getLocalUser;

export default {
    state: {
        user:{
            currentUser: localUser,
            loggedIn: !!localUser,
            authError: null,
            loading: false,
        },

    },
    getters: {
        currentUser(state){
            return state.user.currentUser;
        },
        isAuthenticated(state){
            return state.user.loggedIn;
        },
        authError(state){
            return state.user.authError;
        },
        isLoading(state){
            return state.user.loading;
        }
    },
    mutations: {
        login(state){
            state.user.loading = true;
            state.user.authError = null;
        },

        loginSuccessful(state, res){
            state.user.authError = null;
            state.user.loggedIn = true;
            state.user.loading = false;
        },

        loginFailed(state, err){
            state.user.authError = err;
            state.user.loggedIn = false;
            state.user.loading = false;            
        }
    }

};