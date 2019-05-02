<template>
  <div>
    <vue-progress-bar></vue-progress-bar>
    <nav class="navbar navbar-expand-md">
      <div class="container">
        <!-- logo/brand -->
        <router-link :to="{name: 'Home'}" class="navbar-brand">Powershare</router-link>
        <!-- side navbar toggler -->
        <span class="openNav" @click="changeWidth">&#10094;</span>

        <!-- right side of navbar -->
        <ul id="Sidenav" class="navbar-nav ml-auto sideNav" v-bind:class="{ visible : smallMedia }">
          <!-- Authentication Links -->
          <span class="closeNav" @click="changeWidth">&#10095;</span>
          <router-link :to="{ name: 'Campaigns' }" class="nav-link">Campaigns</router-link>
          <router-link :to="{ name: 'CampaignCreate' }" class="nav-link">Create Campaign</router-link>
          <router-link :to="{ name: 'Articles' }" class="nav-link">Articles</router-link>
          <router-link :to="{ name: 'Login' }" class="nav-link" v-if="!isLoggedIn">Login</router-link>
          <router-link :to="{ name: 'Register' }" class="nav-link" v-if="!isLoggedIn">Register</router-link>
          <router-link
            :to="{ name: 'Profile' }"
            class="nav-link"
            v-if="currentUser"
          >Profile of {{currentUser.name}}</router-link>
          <a href="#" @click.prevent="logout" class="nav-link" v-if="isLoggedIn">LogOut</a>
        </ul>
      </div>
    </nav>
    <!-- Content -->
    <main>
      <router-view></router-view>
    </main>
  </div>
</template>

<script>
export default {
  data() {
    return {
      smallMedia: false
    };
  },
  computed: {
    isLoggedIn() {
      return this.$store.getters.isAuthenticated;
    },
    currentUser() {
      return this.$store.getters.currentUser;
    }
  },
  methods: {
    logout() {
      this.$router.push({name: "Logout"});
    },

    changeWidth() {
      this.smallMedia = !this.smallMedia;
    }
  }
};
</script>
