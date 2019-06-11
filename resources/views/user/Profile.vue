<template>
    <div class="user-header">
        <div class="user-header-content">
            <div class="profile-photo-container">
                <div class="profile-photo"></div>
            </div>
            <div class="profile-header-container">
                <h3 class="user-name">{{user.name}}</h3>
                <h3 class="user-header-profile">Description, short summary</h3>
            </div>
            <div class="profile-tabs">
                <a href="#" class="nav-link">Created</a>
                <a href="#" class="nav-link">Saved</a>
                <a href="#" class="nav-link">Donated</a>
                <a href="#" class="nav-link">Statistics</a>
            </div>
        </div>
        <div class="user-header-under">

            <!-- <ul class="nav">asdsadasdasdas
                <li class="nav-item active">
                    <router-link :to="{name: 'User.Profile'}" class="nav-link">
                        <p>Profile</p>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{name: 'User.Campaigns'}" class="nav-link">
                        <p>Campaigns</p>
                    </router-link>
                </li>
            </ul> -->
        </div>
        <div>
            Name {{user.name}}
            <br>
            Email {{user.email}}
        </div>
    </div>
</template>

<script>
    export default {
        name: "Profile",
        computed: {
            user(){
                return this.$store.getters.currentUser;
            }
        }

    }
</script>