<template>
  <div class="center-campaigns">
    <div class="explore-input">
      <input type="text" :placeholder="$t('words.search') + '...'" class="search" v-model="searchKey" @keyup="loadMore(search=true)">
      <select type="text" class="category" v-on:change="loadCampaigns(search=true)" v-model="curCategory">
        <option value="0">{{$t("titles.all-categories")}}</option>
        <option v-for="category in categories" :value="category.id">{{category.name}}</option>
      </select>
    </div>
    
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
      curCategory: 0,
      curPage: 1,
      lastPage: 1,
      searchKey: "",
      debounceTimeout : null
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
      })
    }).catch(err => {
      console.error(err);
      next();
    });
  },

  methods:{
    loadMore(search=true){
      let debFunc = this.debounce(this.loadCampaigns, 500);
      debFunc(search);
    },

    debounce(callback, wait) {
      return (...args) => {
        const context = this;
        clearTimeout(this.debounceTimeout);
        this.debounceTimeout = setTimeout(() => callback.apply(context, args), wait);
      };
    },
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

      let fetchUri = "/campaigns?name=" + this.searchKey + "&page="+this.curPage + "&category_id="+this.curCategory;
      HTTP.GET(fetchUri)
              .then(value => {
                let fetchedCampaigns = value.data.data;
                let lastPage = value.data.meta.last_page;
                if(search){
                  this.campaigns = fetchedCampaigns;
                  this.lastPage = lastPage;
                }else{
                  this.campaigns = this.campaigns.concat(fetchedCampaigns);
                  this.lastPage = lastPage;
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
