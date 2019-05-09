<template>
  <div v-if="campaign != null">
    <div class="details-main">
      <div class="photo"></div>
      <div class="details-main-right">
        <div class="owner">
          <div class="hidden-subject">Subject</div>
          <div class="owner-name">{{campaign.author_name}}</div>
        </div>
      </div>
    </div>
    <div class="hidden-donate">Donate</div>
    <div class="details-header">
      <span class="subject">{{campaign.name}}</span>
      <span class="social">^^^social icons^^^</span>
    </div>
    <div class="details-secondary">
      <Tabs></Tabs>
    </div>
  </div>
  <div v-else>
    We are fetching Campaign please wait... (Notifying with this ugly message!)
  </div>
</template>

<script>
import Tabs from "./partials/Tab";
import store from "@js/store";

export default {
  components: {
    Tabs
  },
  data() {
    return {
      campaign: null
    };
  },
  beforeRouteEnter(to, from, next) {
    store.dispatch("fetchCampaign", to.params.id)
            .then((campaign) => {
              console.log(campaign);
              next(vm => vm.setCampaign(campaign));
            }).catch(() => next());
  },
  computed: {
    id() {
      return this.$route.params.id;
    }
  },
  methods:{
    setCampaign(campaign){
      this.campaign = campaign;
    }
  }
};
</script>