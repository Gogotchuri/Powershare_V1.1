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

    fetchArticle(context, id){
        let uri = "articles/".concat(id);
        return new Promise((resolve, reject) => {
            Http.GET(uri)
                .then(res => {
                    resolve(res.data.data);
                }).catch(reason => {
                    console.error("Error during article fetch".concat(reason));
                    reject(reason);
            })
        })
    },

    fetchArticles(context){
        let uri = "articles";
        return new Promise((resolve, reject) => {
            Http.GET(uri)
                .then(res => {
                    resolve(res.data.data);
                }).catch(reason => {
                    console.error("Error during articles fetch".concat(reason));
                    reject(reason);
            })
        })
    },

    fetchCampaign(context, id){
        let uri = "campaigns/".concat(id);
        return new Promise((resolve, reject) => {
          Http.GET(uri)
              .then(res => {
                  resolve(res.data.data);
              }).catch(reason => {
                  console.error("Error during campaign fetch".concat(reason));
                  reject(reason);
              })
        })
    },
    fetchCampaigns(context){
        return new Promise((resolve, reject) => {
            Http.GET("campaigns")
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
            Http.POST("contact", data)
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
