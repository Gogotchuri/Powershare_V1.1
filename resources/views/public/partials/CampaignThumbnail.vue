<template>
    <div>
        <p>{{campaign.name}}</p>                                                                     
		<router-link class ="explore-card" :to="`/campaigns/${campaign.id}`">
            <!-- <img class="photo" :src="campaign.featured_image_thumbnail_url"> -->
                <div class="row explore-card-text">
                    <div class="col-sm-12 campaign-holder-left">
                        {{campaign.name}}
                    </div>
                    <div class="col-sm-12 campaigns-important">
                        <h6>Important For:<span style="font-weight:200"> {{campaign.category}}</span></h6>
                    </div>
                    <div class="col-sm-12 campaign-holder-right">
                        <span class="funded" style="float:left">Funded {{campaign.realized_funding +"$"}}
                        </span>
                        <span class="goal" style="float:right">Goal {{campaign.required_funding + "$"}}
                        </span>
                    </div>
                    <div class="col-sm-12 fillable-bar">
                        <!-- <div class="filled-bar" style="width: {{
                            (campaign.required_funding == 0)? 0
                                :(campaign.realized_funding)*100/campaign.required_funding}}%"/> -->
                </div>
            </div>
		</router-link>
	</div>
</template>
<script>
export default {
    name: "CampaignThumbnail",
    props: ["campaign"],
}
</script>
