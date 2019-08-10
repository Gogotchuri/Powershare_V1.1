<template>
    <div class="landing-main-container">
        <div class="landing-illustration">
            <div class="landing-header">
               <h2 v-html="$t('texts.home.main')"></h2>
                <div class="header-links">
                    <router-link :to="{ name: 'Campaigns' }" class="landing-header-btn">{{$t("titles.free-crowdfunding")}}</router-link>
                    <br>
                    <router-link :to="{ name: 'User.Campaigns.Create' }" class="landing-header-btn">{{$t("titles.create-campaign")}}</router-link>
                </div>
            </div>
            <img src="img/landing.png">
        </div>
        <div class="landing-illustration-under"></div>

        <div class="landing-campaigns">
            <h2>{{$t("titles.campaigns")}}</h2>
            <div>
                <campaign-thumbnail
                  v-for="campaign in campaigns.slice(0, 5)"
                  :key="campaign.id"
                  :campaign="campaign"
                />
            </div>
            <router-link :to="{ name: 'Campaigns' }" class="landing-header-btn cp">{{$t("titles.see-more")}}</router-link>
        </div>
        <div class="landing-campaigns-under">
        </div>

        <div class="how-to">
          <h2 class="howtohead">{{$t("texts.home.how-to-fundrise")}}</h2>

          <div class="how-to-cards">
            <div>
              <img src="img/loop.png" alt="" class="loopl">
              <h3>{{$t("words.find")}}</h3>
              <p>{{$t("texts.home.find-desc")}}</p>
            </div>
            <img src="img/arrow.svg" alt="" class="arrow">
            <div>
              <img src="img/create.png" alt="" class="createl">
              <h3>{{$t("words.create")}}</h3>
              <p>{{$t("texts.home.create-desc")}}</p>
            </div>
            <img src="img/arrow.svg" alt="" class="arrow">
            <div>
              <img src="img/promote.png" alt="" class="promotel">
              <h3>{{$t("words.share")}}</h3>
              <p>{{$t("texts.home.share-desc")}}</p>
            </div>
            <img src="img/arrow.svg" alt="" class="arrow">
            <div>
              <img src="img/collect.png" alt="" class="collectl">
              <h3>{{$t("words.collect")}}</h3>
              <p>{{$t("texts.home.collect-desc")}}</p>
            </div>
            <img src="img/arrow.svg" alt="" class="arrow">
            <div>
              <img src="img/act.png" alt="" class="actl">
              <h3>{{$t("titles.take-action")}}</h3>
              <p>{{$t("texts.home.take-action-desc")}}</p>
            </div>
          </div>

          <div>
            <div>
              {{$t("texts.home.take-all")}}
              <div>
                  {{$t("texts.home.take-all-desc")}}
              </div>
            </div>
            <div>
                {{$t("texts.home.no-commission")}}
              <div>
                  {{$t("texts.home.no-commission-desc")}}
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
      //Setting fetched data to this component
      next(vm => {
        vm.lastPage = lastPage;
        vm.categories = categories;
        vm.campaigns = campaigns;
      })
    }).catch(err => {
      console.error(err);
      next();
    });
  },
}
</script>