<template>
    <nav id="navigation-bar">
        <div class="nav-container">
            <!-- logo/brand -->
            <router-link :to="{name: 'Home'}" class="navigation-brand">
                <img src="/img/powershare_logo.svg" class="alpha" alt="">
            </router-link>
            <!-- side navbar toggler -->
            <span class="openNav" @click="changeWidth"><div class="burger"></div></span>

            <!-- right side of navbar -->
            <ul id="Sidenav" class="navbar-nav ml-auto sideNav navigation-menu" v-bind:class="{ visible : smallMedia }">
                <!-- Authentication Links -->
                <span class="closeNav" @click="changeWidth">&#10095;</span>
                <router-link :to="{ name: 'Home'}" class="nav-link">{{$t("titles.home")}}</router-link>
                <router-link :to="{ name: 'Campaigns' }" class="nav-link">{{$t("titles.campaign-explore")}}</router-link>
                <router-link :to="{ name: 'About'}" class="nav-link">{{$t("titles.about")}}</router-link>
                <router-link :to="{ name: 'User.Campaigns.Create' }" class="nav-link" id="create-link">{{$t("titles.create-campaign")}}</router-link>
                <router-link
                        :to="{ name: 'User.Campaigns' }"
                        class="nav-link"
                        v-if="currentUser"
                >{{currentUser.name.substr(0,20)}}</router-link>
                <login-modal v-if="!isLoggedIn"/>
                <register-modal v-if="!isLoggedIn"/>
                <a href="#" @click.prevent="logout" class="nav-link" v-if="isLoggedIn">
                    <img src="/img/log-out.svg" class="log-out-icon">
                    <div class="logout-on-phone">{{$t("words.logout")}}</div>
                </a>
                <a style="cursor: pointer" class="nav-link lang left" @click="changeLocale('en')">EN</a>
                <a style="cursor: pointer" class="nav-link lang" @click="changeLocale('ka')">KA</a>
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
                registerModalState: false,
                loginModalState: false
            };
        },
        components: {
            LoginModal,
            RegisterModal
        },
        watch:{
            $route(){
                this.smallMedia = false;
            }
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
            },
            changeLocale(loc) {
                if(loc !== "ka" && loc !== "en")
                    return;
                this.$i18n.locale = loc;
            }
        }
    };
</script>