<template>
    <nav id="navigation-bar">
        <div class="nav-container">
            <!-- logo/brand -->
            <router-link :to="{name: 'Home'}" class="navigation-brand">
                <img src="img/alpha.png" class="alpha">
            </router-link>
            <!-- side navbar toggler -->
            <span class="openNav" @click="changeWidth"><div class="burger"></div></span>

            <!-- right side of navbar -->
            <ul id="Sidenav" class="navbar-nav ml-auto sideNav navigation-menu" v-bind:class="{ visible : smallMedia }">
                <!-- Authentication Links -->
                <span class="closeNav" @click="changeWidth">&#10095;</span>
                <router-link :to="{ name: 'Campaigns' }" class="nav-link">Campaigns</router-link>
                <router-link :to="{ name: 'User.Campaigns.Create' }" class="nav-link">Create Campaign</router-link>
                <router-link :to="{ name: 'Articles' }" class="nav-link">Articles</router-link>
                <login-modal v-if="!isLoggedIn"/>
                <register-modal v-if="!isLoggedIn"/>
                <router-link
                        :to="{ name: 'User.Profile' }"
                        class="nav-link"
                        v-if="currentUser"
                >Profile of {{currentUser.name}}</router-link>
                <a href="#" @click.prevent="logout" class="nav-link" v-if="isLoggedIn">LogOut</a>
            </ul>
        </div>
    </nav>
</template>

<script>
    import LoginModal from "@views/auth/LoginModal";
    import RegisterModal from "@views/auth/RegisterModal";
    export default {
        name: "MainNav",
        data() {
            return {
                smallMedia: false,
                //TODO should implement logic behind global opening and closing modals
                registerModalState: false,
                loginModalState: false
            };
        },
        components: {
            LoginModal,
            RegisterModal
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