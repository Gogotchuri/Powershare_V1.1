<template>
  <div>
    <div class="details-main">
      <div class="photo"></div>
      <div class="details-main-right">
        <div class="owner">
          <div class="hidden-subject">Subject</div>
          <div class="owner-name">owner</div>
        </div>
        <div class="mining"></div>
      </div>
    </div>
    <div class="hidden-donate">Donate</div>
    <div class="details-header">
      <span class="subject">This is a campaign! {{id}}</span>
      <span class="social">social icons</span>
    </div>
    <div class="details-secondary">
      <Tabs></Tabs>
    </div>
  </div>
</template>

<script>
import Tabs from "./partials/Tab";
export default {
  components: {
    Tabs
  },
  date() {
    return {
      id: -1
    };
  },
  beforeMount() {
    this.id = this.$route.params.id;
  }
};
</script>