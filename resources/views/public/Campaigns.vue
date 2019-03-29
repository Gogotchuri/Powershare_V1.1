<template>
    <div id="explore" class="container campaigns-page">
        <div class="explore-container">
            <div class="row" style="justify-content: space-around">
                <h1 class="col-sm-8 main-heading main-heading-campaigns">campaigns</h1>
            </div>
            <div class="row center-campaigns">
                <template v-if="!campaigns.length">
                    <div>
                        No Campaigns To see!
                    </div>
                </template>
                <campaign-thumbnail v-else 
                    v-for="campaign in campaigns"
                    :key="campaign.id"
                    :campaign="campaign" 
                />
            </div>
        </div>
    </div>
</template>

<script>
import campaignThumbnail from "@views/public/partials/CampaignThumbnail.vue";
import store from "@js/store";
import {app} from "@js/app";

export default {
    name: "Campaigns",
    components: {
        campaignThumbnail
    },

    /*
    * Components fetches campaign and gives a progress indicator
    * once campaigns are fetched progress is fulfilled
    */
    beforeRouteEnter(to, from, next){
        app.$Progress.start();
        store.dispatch("fetchCampaigns")
            .then(() => {
                app.$Progress.finish();
                next();
            })
            .catch(reason => {
                app.$Progress.fail();
                console.error(reason);
                next();
            })
    },
    computed: {
        campaigns(){
            return this.$store.getters.campaigns;
        }
    }
}
</script>
