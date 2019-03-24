import { getLocalUser } from "./helpers/auth";
import ApiService from "./common/ApiService";
import axios from "axios";
const localUser = getLocalUser();

export default {
    state: {
        loading: false,

        user:{
            currentUser: localUser,
            loggedIn: !!localUser,
            authError: null,
        },
        
        campaigns:[]

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
            return state.loading;
        },
        campaigns(state){
            return state.campaigns;
        }
    },
    
    mutations: {
        register(state, res, error)
        {
            state.loading = true;
            if(error){
                state.user.authError = error;
                state.user.currentUser = null;
                state.user.loggedIn = false;
            }else if(res){
                state.user.authError = null;
                state.user.currentUser = res.data;
                state.user.loggedIn = true;
                ApiService.setHeaderToken(state.user.currentUser.token);
                localStorage.setItem("user", JSON.stringify(res.data));
            }else{
                console.error("Something went Wrong during registration");
            }
            state.loading = false;
        },


        login(state){
            state.loading = true;
            state.user.authError = null;
        },

        loginSuccessful(state, res){
            state.user.authError = null;
            state.user.loggedIn = true;
            state.loading = false;
            state.user.currentUser = res.data;
            
            ApiService.setHeaderToken(state.user.currentUser.token);
            localStorage.setItem("user", JSON.stringify(res.data));
        },

        loginFailed(state, err){
            state.user.authError = err;
            state.user.loggedIn = false;
            state.loading = false;     
        },

        logout(state){
            ApiService.removeHeaderToken();
            state.user.currentUser = null;
            state.user.loggedIn = false;
            localStorage.removeItem("user");
        },

        fetchCampaigns(state){
            axios.get("api/campaigns")
                .then(res => {
                    state.campaigns = res.data.data;
                })
                .catch(err => {
                    console.error(err);
                });
        }
    },

    actions: {
        login(context){
            context.commit("login");
        },

        logout(context){
            context.commit("logout");
        },

        register(context, res, error){
            context.commit("register", res, error);
        },
        fetchCampaigns(context){
            context.commit("fetchCampaigns");
        }


    }

};