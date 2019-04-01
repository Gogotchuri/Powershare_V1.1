<template>
  <div>
    <div class="details-main">
      <div class="photo"></div>
      <div class="details-main-right">
        <div class="owner"></div>
        <div class="mining"></div>
      </div>
    </div>
    <div class="details-header">
      <h2>This is a campaign! {{id}}</h2>
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