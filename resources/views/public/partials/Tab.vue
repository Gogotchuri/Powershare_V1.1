<template>
  <div class="tabs">
    <div class="tabs-header">
      <button
        v-for="(tab, index) in tabs"
        :class="{active : currentTab === index }"
        @click="currentTab = index"
      >{{tab}}</button>
    </div>
    <div class="tab-content">
      <div v-show="currentTab === 0">
        <h3>Tab1 content</h3>
      </div>
      <div v-show="currentTab === 1">
        <h3>Tab2 content</h3>
      </div>
      <div v-show="currentTab === 2">
        <h3>Tab3 content</h3>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "tabs",
  data() {
    return {
      currentTab: 0,
      tabs: ["Tab1", "Tab2", "Tab3"]
    };
  }
};
</script>

<style scoped>
button {
  width: 100%;
  background-color: lightgray;
  border: none;
  border-left: 1px solid lightslategray;
  border-right: 1px solid lightslategray;
  outline: none;
}
button.active {
  background-color: white;
}
.tabs-header {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
}
.tab-content div {
  padding: 30px;
  background-color: white;
  width: 100%;
  margin: 0 auto;
}
</style>