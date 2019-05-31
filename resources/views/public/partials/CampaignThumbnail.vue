<template>
    <div class="campaignThumbnail">                                                                    
		<router-link class ="explore-card" :to="`/campaigns/${campaign.id}`">
            <!-- campaignis surati unda styleshi -->
            <img class="campaignThBackground" :src="campaign.featured_image_thumbnail_url" alt="Campaign Image">
            <div class="campaignThText">
                <div class="row explore-card-text">
                        <div class="col-sm-12 campaign-holder-left">
                            {{campaign.name}}
                        </div>
                        <div class="col-sm-12 campaigns-important">
                            <h6>Category:<span style="font-weight:200"> {{campaign.category_name}}</span></h6>
                        </div>
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
