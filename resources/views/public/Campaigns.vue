<template>
  <div class="center-campaigns">
    <div class="exploreIllustration">
    </div>
    <div class="exploreIllUnder">
      <h3 class="col-5 col-lg-3">User Experience by the Numbers: Hurting the Ones We Love</h3>
    </div>
    <div class="explore-input">
      <label>
        <input type="text" placeholder="Search.." class="search" v-model="searchKey" @keyup="loadCampaigns(search=true)">
      </label>
      <div>
        <label>
          <select class="category">
            <option value="1">Category</option>
          </select>
        </label>
        <label>
          <select type="text" placeholder="Collection" class="collection">
            <option value="1">Collection</option>
          </select>
        </label>
      </div>
    </div>

    <h3 class="header-explore">More to explore</h3>
    <div class="campaigns">
      <campaign-thumbnail
              v-for="campaign in campaigns"
              :key="campaign.id"
              :campaign="campaign"
      />
    </div>
    <intersection-observer v-if="curPage <= lastPage" v-on:intersected="loadCampaigns"/>
  </div>
</template>

<script>
import CampaignThumbnail from "@views/public/partials/CampaignThumbnail";
import IntersectionObserver from "@views/public/partials/IntersectionObserver"
import HTTP from "@js/Common/Http.service";

export default {
  name: "Campaigns",
  components: {
    CampaignThumbnail, IntersectionObserver
  },
  data(){
    return{
      categories: [],
      campaigns: [],
      curPage: 1,
      lastPage: 1,
      searchKey: ""
    }
  },
  /*
   * Components fetches campaigns and Categories
   *  Categories are being saved locally.
   *  before fetching campaigns it checks if we have previously fetched ones
   *  and uses those before refetch for snappy experience.
   *  */
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
        console.log("categories: ");
        console.log(categories);
        console.log("campaigns: ");
        console.log(campaigns);
      })
    }).catch(err => {
      console.error(err);
      next();
    });
  },

  methods:{
    /**
     * Loads campaign on call, page is taken from local variable curr page
     * If current page is more than last page, nothing happens
     * If this function is called after search, it should get called with search parameter true
     * */
    loadCampaigns(search=false){
      if(search)
        this.curPage = 1;
      else
        this.curPage++;

      let fetchUri = "/campaigns?name=" + this.searchKey + "&page="+this.curPage;

      HTTP.GET(fetchUri)
              .then(value => {
                let fetchedCampaigns = value.data.data;
                let lastPage = value.data.meta.last_page;
                if(search){
                  console.log("fetching for search! replacing campaigns.");
                  this.campaigns = fetchedCampaigns;
                  this.lastPage = lastPage;
                  console.log(this.campaigns);
                }else{
                  console.log("fetching after search! concatenating campaigns.");
                  console.log(fetchedCampaigns);
                  this.campaigns = this.campaigns.concat(fetchedCampaigns);
                  this.lastPage = lastPage;
                  console.log((this.campaigns));
                }
              })
              .catch(reason => {
                console.error("Error while loading campaigns!");
                console.error(reason);
              });
    }
  }
};
</script>
