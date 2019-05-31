/**
 * This is a Vuex store module for user
 */
import Http from "@js/Common/Http.service";

/**
 * State for user module
 */
const state = {

};

/**
 * Getters for user module
 */
const getters = {

};

/**
 * Mutations for user module
 */
const mutations = {
    setEmailVerified(state){
        state.currentUser.is_verified = true;
    }
};

/**
 * Actions for user module
 */
const actions = {
    verifyEmail(context, verification_url){
        return new Promise((resolve, reject) => {
            Http.POST(verification_url)
                .then(() => {
                    resolve();
                    context.commit("setEmailVerified");
                })
                .catch(error => reject(error))
        });
    }
};


/**
 * Exporting user module store
 */
export default {
    state,
    getters,
    mutations,
    actions
};
