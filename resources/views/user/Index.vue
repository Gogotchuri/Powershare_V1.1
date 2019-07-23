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
                        <h3 class="user-header-profile">Description, short summary</h3>
                        <router-link v-if="user.role_id == 1" :to="{name: 'Admin.Dash'}">Admin Panel</router-link>
                    </div>
                    <div class="profile-tabs">
                        <router-link :to="{name: 'User.Campaigns'}" class="nav-link">Created</router-link>
                        <router-link :to="{name: 'User.SavedCampaigns'}" class="nav-link">Saved</router-link>
                        <router-link :to="{name: 'User.DonatedCampaigns'}" class="nav-link">Donated</router-link>
                        <router-link v-if="false" :to="{name: 'User.'}" class="nav-link">Statistics</router-link>
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