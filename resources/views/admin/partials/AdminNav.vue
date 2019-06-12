<template>
    <div class="nav flex-column nav-pills adminNav" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <div class="logo">
            <router-link :to="{name: 'Home'}" class="simple-text">
                Powershare
            </router-link>
        </div>
        <router-link :to="{name: 'Admin.Dash'}"  class="nav-link">
            <p>Dashboard</p>
        </router-link>
        <router-link :to="{name: 'Admin.Campaigns'}" class="nav-link">
            <p>Campaigns</p>
        </router-link>
        <router-link :to="{name: 'Admin.FAQ'}" class="nav-link" >
            <p>FAQ</p>
        </router-link>
        <router-link :to="{name: 'Admin.Surveys'}" class="nav-link">
            <p>Surveys</p>
        </router-link>
        <router-link :to="{name: 'Admin.Users'}" class="nav-link">
            <p>Users</p>
        </router-link>
        <router-link :to="{name: 'Admin.CreateSurvey'}" class="nav-link">
            <p>Create Survey</p>
        </router-link>
    </div>
</template>

<script>
    export default {
        name: "AdminNav"
    }
</script>

<style scoped>

</style>