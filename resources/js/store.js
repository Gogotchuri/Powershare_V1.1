import { getLocalUser } from "./helpers/auth";
import ApiService from "./common/ApiService";
import JwtService from "./common/JwtService";
const localUser = getLocalUser();

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
            state.user.currentUser = res.data;

            localStorage.setItem("user", JSON.stringify(res.data));
        },

        loginFailed(state, err){
            state.user.authError = err;
            state.user.loggedIn = false;
            state.user.loading = false;            
        },

        logout(state){
            state.user.currentUser = null;
            state.user.loggedIn = false;
            localStorage.removeItem("user");
        }
    },

    actions: {
        login(context){
            context.commit("login");
        },

        logout(context){
            context.commit("logout");
        }
    }

};