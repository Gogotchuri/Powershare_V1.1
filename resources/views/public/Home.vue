<template>
    <div class="landing-main-container">
        <div class="landing-illustration">
            <div class="landing-header">
               <h2> 
                    Support  <br>
                    important causes <br> 
                    without paying a penny
                </h2> 
                <div class="header-links">
                    <router-link :to="{ name: 'User.Campaigns.Create' }" class="landing-header-btn">Donate for free</router-link>
                    <router-link :to="{ name: 'Campaigns' }" class="landing-header-btn">Start fundrising</router-link>
                </div>
            </div>
            <img src="img/landing.png">
        </div>
        <div class="landing-illustration-under"></div>

        <div class="landing-campaigns">
            <h2>Campaigns</h2>
            <div>
                <campaign-thumbnail
              v-for="campaign in campaigns.slice(0, 5)"
              :key="campaign.id"
              :campaign="campaign"
            />  
            </div>
            <router-link :to="{ name: 'Campaigns' }" class="landing-header-btn cp">See all</router-link>
        </div>
        <div class="landing-campaigns-under">
        </div>

        <div class="how-to">
          <!-- <h2>How to fundraise</h2> -->
          <div>
            <div>
              Keep it all
              <div>
                At the testing stage, we offer keep it all policy to all fundraisers, meaning that you will receive every single donation even if you do not reach amount requested  
              </div>
            </div>
            <div>
              0% Platform fees
              <div>
                All of what you donate goes to the chosen cause
              </div>
            </div>
          </div>
        </div>
        <div class="how-to-under">

        </div>
    </div>
</template>

<script>
import CampaignThumbnail from "@views/public/partials/CampaignThumbnail";
import IntersectionObserver from "@views/public/partials/IntersectionObserver"
import HTTP from "@js/Common/Http.service";
export default {
    components: {
        CampaignThumbnail, IntersectionObserver
    },
    data(){
        return{
            campaigns: []
        }
    },
    beforeRouteEnter(to, from, next) {
    //Fetching promises
    let categoryFetch = HTTP.GET("/campaign-categories");
    let campaignFetch = HTTP.GET("/campaigns");
    Promise.all([categoryFetch, campaignFetch]).then(value => {
      let categories = value[0].data.data;
      let campaigns = value[1].data.data;
      let lastPage = value[1].data.meta.last_page;
      console.log(value[1]);
      //Setting fetched data to this component
      next(vm => {
        vm.lastPage = lastPage;
        vm.categories = categories;
        vm.campaigns = campaigns;
        console.log("campaigns: ");
        console.log(campaigns);
      })
    }).catch(err => {
      console.error(err);
      next();
    });
  },
}
</script>