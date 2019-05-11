<template>
  <div class="center-campaigns">
    <div class="search">Search</div>
    <div class="sort">
      <div>Category</div>
      <div>Sorted by</div>
    </div>

    <div class="campaigns">
      <campaign-thumbnail
              v-for="campaign in campaigns"
              :key="campaign.id"
              :campaign="campaign"
      />
    </div>

  </div>
</template>

<script>
import campaignThumbnail from "@views/public/partials/CampaignThumbnail.vue";
import store from "@js/store";
import HTTP from "@js/Common/Http.service";

export default {
  name: "Campaigns",
  components: {
    campaignThumbnail
  },
  data(){
    return{
      categories: []
    }
  },
  /*
   * Components fetches campaigns and Categories
   *  Categories are being saved locally.
   *  before fetching campaigns it checks if we have previously fetched ones
   *  and uses those before refetch for snappy experience.
   *  */
  beforeRouteEnter(to, from, next) {
    let campaigns = store.getters.campaigns;
    let campaignsExist = campaigns !== null && campaigns.length !== 0;
    //Fetching promises
    let categoryFetch = HTTP.GET("/campaign-categories");
    let campaignFetch = store.dispatch("fetchCampaigns");

    //if we already have fetched them previously let's load page with those and fetch during process
    if (!campaignsExist) {
      Promise.all([categoryFetch, campaignFetch]).then(value => {
        let categories = value[0].data.data;
        next(vm => vm.setCategories(categories));
      }).catch(err => console.error(err));
    } else {
      campaignFetch.catch(err => console.error("Error while fetching campaigns: " + err));
      categoryFetch.then(value => {
        let categories = value.data.data;
        next(vm => vm.setCategories(categories))
      }).catch(reason => {
        console.error(reason);
        next();
      })
    }
  },
  computed: {
    campaigns() {
      return this.$store.getters.campaigns;
    },
  },

  methods:{
    setCategories(categories){
      console.log(categories);
      this.categories = categories;
    }
  }
};
</script>
