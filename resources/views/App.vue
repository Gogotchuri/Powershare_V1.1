<template>
  <div>
    <vue-progress-bar/>
    <main-nav/>
    <!-- Content -->
    <div class="main-container">
      <main>
        <router-view/>
      </main>
    </div>
  </div>
</template>

<script>
  import MainNav from "@views/public/partials/MainNav";
  import AdminNav from "@/views/admin/partials/AdminNav";

  import {checkAdmin} from "@/js/Helpers/auth";
  import AdminIndex from "@views/admin/Index";
  import UserIndex from "@/views/user/Index";

  export default {
    components: {UserIndex, AdminIndex, AdminNav, MainNav},
    computed:{
      isAdminPanel(){
        return this.$route.matched.some(r => r.meta.adminRequired);
      },
      isUserManagement(){
        return this.$route.matched.some(r => r.meta.userManagement);
      }
    },
    mounted() {
      if(this.isAdminPanel){
        checkAdmin().catch(() => this.$router.push({name:"Logout"}));
      }
    }
  };
</script>
