/**
 * This is a Vuex store module for management
 */
import Http from "@js/Common/Http.service";

/**
 * State for management module
 */
const state = {

};

/**
 * Getters for management module
 */
const getters = {

};

/**
 * Mutations for management module
 */
const mutations = {
    setEmailVerified(state){
        state.currentUser.is_verified = true;
    }
};

/**
 * Actions for management module
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
 * Exporting management module store
 */
export default {
    state,
    getters,
    mutations,
    actions
};
