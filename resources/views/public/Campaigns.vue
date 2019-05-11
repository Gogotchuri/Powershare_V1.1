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
import HTTP from "@js/Common/Http.service";

export default {
  name: "Campaigns",
  components: {
    campaignThumbnail
  },
  data(){
    return{
      categories: [],
      campaigns: []
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
      next(vm => {
        vm.setCategories(categories);
        vm.setCampaigns(campaigns);
      })
    }).catch(err => {
      console.error(err);
      next();
    });
  },

  methods:{
    setCategories(categories){
      console.log("categories: ");
      console.log(categories);
      this.categories = categories;
    },

    setCampaigns(campaigns){
      console.log("campaigns: ");
      console.log(campaigns);
      this.campaigns = campaigns;
    }
  }
};
</script>
