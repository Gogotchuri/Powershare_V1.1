import {destroyUser, getUser, storeUser} from "@/js/Common/Jwt.service";
import Http from "@js/Common/Http.service";
import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

const localUser = getUser();
//exports store
/*Store data.*/
const storeData = {
    state: {
        loading: false,

        user:{
            currentUser: localUser,
            loggedIn: !!localUser,
            authError: null,
        },
        
        campaigns: null

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
                Http.setJwtHeader(state.user.currentUser.token);
                storeUser(state.user.currentUser);
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
            Http.setJwtHeader(state.user.currentUser.token);
            storeUser(state.user.currentUser);
        },

        loginFailed(state, err){
            state.user.authError = err;
            state.user.loggedIn = false;
            state.loading = false;     
        },

        logout(state){
            Http.removeJwtHeader();
            state.user.currentUser = null;
            state.user.loggedIn = false;
            destroyUser();
        },

        setCampaigns(state, campaigns){
            state.campaigns = campaigns;
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
            return new Promise((resolve, reject) => {
                Http.GET('campaigns')
                    .then(response => {
                        let campaigns = response.data.data;
                        context.commit("setCampaigns", campaigns);
                        resolve("Campaigns Fetched successfully!");
                    })
                    .catch(reason => {
                        console.error(reason);
                        reject("Error while fetching campaigns!");
                    })
            });
        }


    }

};

const store = new Vuex.Store(storeData);
export default store;
