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

export default {
  name: "Campaigns",
  components: {
    campaignThumbnail
  },

  /*
   * Components fetches campaign and gives a progress indicator
   * once campaigns are fetched progress is fulfilled
   */
  beforeRouteEnter(to, from, next) {
    let campaigns = store.getters.campaigns;
    let campaignsExist = campaigns !== null && campaigns.length !== 0;

    if (!campaignsExist) {
      store
        .dispatch("fetchCampaigns")
        .then(() => {
          next();
        })
        .catch(reason => {
          console.error(reason);
          next();
        });
    } else {
      store
        .dispatch("fetchCampaigns")
        .catch(err => console.error("Error while fetching campaigns: " + err));
      next();
    }
  },
  computed: {
    campaigns() {
      return this.$store.getters.campaigns;
    }
  }
};
</script>
