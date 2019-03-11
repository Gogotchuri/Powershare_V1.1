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
                > </campaign-thumbnail>
                <!-- <campaign :campaign="C" \>
                <campaign v-for="campaign in campaigns" :key="campaign.id" :campaign="campaign"> </campaign> -->

            </div>
        </div>
    </div>
</template>

<script>

import campaignThumbnail from "./partials/CampaignThumbnail.vue";

export default {
    name: "Campaigns",
    components: {
        campaignThumbnail
    },
    data(){
        return {
            campaigns: [],
        }
    },
    created(){
        this.fetchCampaigns();
    },

    methods:{
        fetchCampaigns(){
            axios.get("api/campaigns")
            .then(res => {
                console.log(res);
                this.campaigns = res.data.data;
            })
            .catch(err => {

            });
        }
    }
}
</script>
