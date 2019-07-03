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
    <footer-main/>
  </div>
</template>

<script>
  import MainNav from "@views/public/partials/MainNav";
  import AdminNav from "@/views/admin/partials/AdminNav";
  import FooterMain from "@/views/public/partials/FooterMain";

  import {APP_URL} from "@js/Common/config";
  import {checkAdmin} from "@/js/Helpers/auth";
  import AdminIndex from "@views/admin/Index";
  import UserIndex from "@/views/user/Index";
  
  export default {
    components: {UserIndex, AdminIndex, AdminNav, MainNav, FooterMain},
    computed:{
      isAdminPanel(){
        return this.$route.matched.some(r => r.meta.adminRequired);
      },
      isUserManagement(){
        return this.$route.matched.some(r => r.meta.userManagement);
      }
    },
    metaInfo:{
      title: "",
      titleTemplate: "%sPowershare",
      meta: [
        {property: "og:title", content: "Powershare"},
        {property: "og:description", content: "Free Crowd-funding platform!"},
        {property: "og:image", content: "https://powershare.fund/img/landing.png"},
        {property: "og:url", content: APP_URL},
        {property: "og:type", content: "website"}
      ]
    },
    mounted() {
      if(this.isAdminPanel){
        checkAdmin().catch(() => this.$router.push({name:"Logout"}));
      }
    }
  };
</script>
