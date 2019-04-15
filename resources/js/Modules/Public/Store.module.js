/**
 * This is a Vuex store module for public
 */
import Http from "@js/Common/Http.service";

/**
 * State for public module
 */
const state = {
    campaigns : []
};

/**
 * Getters for public module
 */
const getters = {
    campaigns(state){
        return state.campaigns;
    },

};

/**
 * Mutations for public module
 */
const mutations = {
    setCampaigns(state, campaigns){
        state.campaigns = campaigns;
    }
};

/**
 * Actions for public module
 */
const actions = {

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
    },

    postLetter(context, data){
        return new Promise((resolve, reject) => {
            Http.POST('contact', data)
                .then(value => {
                    resolve(value)
                })
                .catch(reason => {
                    reject(reason);
                })
        })
    }
};


/**
 * Exporting public module store
 */
export default {
    state,
    getters,
    mutations,
    actions
};
