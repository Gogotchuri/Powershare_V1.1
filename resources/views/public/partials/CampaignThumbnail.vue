<template>
    <div class="campaignThumbnail">                                                                    
		<router-link class ="explore-card" :to="`/campaigns/${campaign.id}`">
            <!-- campaignis surati unda styleshi -->
            <div class="campaignThBackground" :style="{'background-image': 'url(' + campaign.featured_image_url + ')'}">
            </div>
            <div class="campaignThText">
                <div class="explore-card-text">
                        <div class="campaign-holder-left">
                            {{campaign.name}}
                        </div>
                        <div class="campaign-desc">
                            {{campaign.description | subStr}}
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
    filters: {
  	subStr: function(string) {
    	return string.substring(0,50) + '...';
        }
  
  }
}
</script>
