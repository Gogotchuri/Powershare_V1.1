<template>
  <div>
    <vue-progress-bar/>
    <div v-if="!isAdminPanel">
      <main-nav/>
      <!-- Content -->
      <main>
        <router-view/>
      </main>
    </div>
    <div v-else>
      <admin-nav class="sidebar"/>
    </div>
  </div>
</template>

<script>
  import MainNav from "@views/public/partials/MainNav";
  import AdminNav from "@/views/admin/partials/AdminNav";

  import {checkAdmin} from "@/js/Helpers/auth";

  export default {
    components: {AdminNav, MainNav},
    computed:{
      isAdminPanel(){
        return this.$route.meta.adminRequired;
      }
    },
    mounted() {
      if(this.isAdminPanel){
        checkAdmin().catch(() => this.$router.push({name:"Logout"}));
      }
    }
  };
</script>
