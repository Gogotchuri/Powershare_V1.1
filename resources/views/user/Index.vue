<template>
    <div class="profile-main-class">
        <div class="user-header">
            <div class="user-header-content">
                <div class="user-header-content-container">    
                    <div class="profile-photo-container">
                        <div class="profile-photo">
                            <img src="/img/default-profile.png" alt="">
                        </div>
                    </div>
                    <div class="profile-header-container">
                        <h3 class="user-name">{{user.name}}</h3>
                        <h3 class="user-header-profile">{{$t("snippets.desc-short")}}</h3>
                        <router-link v-if="user.role_id == 1" :to="{name: 'Admin.Dash'}">{{$t("snippets.admin-panel")}}</router-link>
                    </div>
                    <div class="profile-tabs">
                        <router-link :to="{name: 'User.Campaigns'}" class="nav-link">{{$t("words.created")}}</router-link>
                        <router-link :to="{name: 'User.SavedCampaigns'}" class="nav-link">{{$t("words.saved")}}</router-link>
                        <router-link :to="{name: 'User.DonatedCampaigns'}" class="nav-link">{{$t("words.donated")}}</router-link>
                        <router-link v-if="false" :to="{name: 'User.'}" class="nav-link">{{$t("words.statistics")}}</router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="user-header-under">
            <router-view/>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UserIndex",
        computed: {
            user(){
                return this.$store.getters.currentUser;
            }
        }
    }
</script>