<template>
    <div class="campaignThumbnail">                                                                    
		<router-link class ="explore-card" :to="`/campaigns/${campaign.id}`">
            <!-- campaignis surati unda styleshi -->
            <div class="campaignThBackground" style="background-image: url(https://aquariusnation.com/wp-content/uploads/2019/05/clem-onojeghuo-110452-unsplash-300x208.jpg)"></div>
            <div class="campaignThText"></div>
            <!-- <img class="photo" :src="campaign.featured_image_thumbnail_url"> -->
                <!-- <div class="row explore-card-text">
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
                    <div class="col-sm-12 fillable-bar"> -->
                        <!-- <div class="filled-bar" style="width: {{
                            (campaign.required_funding == 0)? 0
                                :(campaign.realized_funding)*100/campaign.required_funding}}%"/> -->
                <!-- </div>
            </div> -->
		</router-link>
	</div>
</template>
<script>
export default {
    name: "CampaignThumbnail",
    props: ["campaign"],
}
</script>
