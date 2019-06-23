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
                    <router-link :to="{ name: 'Campaigns' }" class="landing-header-btn">Donate for free</router-link>
                    <router-link :to="{ name: 'User.Campaigns.Create' }" class="landing-header-btn">Start fundrising</router-link>
                </div>
            </div>
            <img src="img/landing.png">
        </div>
        <div class="landing-illustration-under"></div>

        <div class="landing-campaigns">
            <h2>პროექტები</h2>
            <div>
                <campaign-thumbnail
              v-for="campaign in campaigns.slice(0, 5)"
              :key="campaign.id"
              :campaign="campaign"
            />  
            </div>
            <router-link :to="{ name: 'Campaigns' }" class="landing-header-btn cp">სრულად ნახვა</router-link>
        </div>
        <div class="landing-campaigns-under">
        </div>

        <div class="how-to">
          <!-- <h2>როგორ მოვიზიდოთ ფული ჩვენი მიზნის დასაფინანსებლად:</h2> -->
          <div>
            <div>
              დაიტოვე ყველაფერი
              <div>
                მაშინაც კი, თუ ვერ მიაღწევთ სასურველ მიზანს, თქვენ მთლიანად მიიღებთ იმ თანხას, რასაც თქვენი პროექტით მოაგორვებთ.  
              </div>
            </div>
            <div>
              არანაირი საკომისიო
              <div>
              პლატფორმა არ იტოვებს სერვისის საკომისიოს, პროექტებს სრულად ერიცხებათ ის თანხა, რომელიც მათთვისაა განკუთვნილი.
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