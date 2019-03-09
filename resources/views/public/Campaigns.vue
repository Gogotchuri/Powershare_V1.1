<template>
<div id="explore" class="container campaigns-page">
	<div class="explore-container">
		<div class="row" style="justify-content: space-around">
			<h1 class="col-sm-8 main-heading main-heading-campaigns">campaigns</h1>
		</div>
		<div class="row center-campaigns">
            <campaign v-for="campaign in campaigns" v-bind:key="campaign.id"> </campaign>
		</div>
	</div>
</div>
</template>

<script>
import campaign from "./partials/Campaign.vue";
export default {
    name: "Campaigns",
    components: {
        campaign
    },
    data(){
        return {
            campaigns: [],
        }
    },
    beforeMount(){
        this.fetchCampaigns();
    },

    methods:{
        fetchCampaigns(){
            axios.get("api/campaigns")
            .then(res => {
                console.log(res);
                this.campaigns = res.data.campaigns;
            })
            .catch(err => {

            });
        }
    }
}
</script>
