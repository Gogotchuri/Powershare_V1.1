<template>
    <div class="sidebar-wrapper">
        <div class="logo">
            <router-link :to="{name: 'Home'}" class="simple-text">
                Powershare
            </router-link>
        </div>
        <ul class="nav">
            <li class="nav-item active">
                <router-link :to="{name: 'Admin.Dash'}" class="nav-link">
                    <p>Dashboard</p>
                </router-link>
            </li>
            <li>
                <router-link :to="{name: 'Admin.Campaigns'}" class="nav-link">
                    <p>Campaigns</p>
                </router-link>
            </li>
            <li>
                <router-link :to="{name: 'Admin.Users'}" class="nav-link">
                    <p>Users</p>
                </router-link>
            </li>
            <li>
                <router-link :to="{name: 'Admin.FAQ'}" class="nav-link" >
                    <p>FAQ</p>
                </router-link>
            </li>
            <li>
                <router-link :to="{name: 'Admin.Surveys'}" class="nav-link">
                    <p>Surveys</p>
                </router-link>
            </li>
            <li>
                <router-link :to="{name: 'Admin.CreateSurvey'}" class="nav-link">
                    <p>Create Survey</p>
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "AdminNav"
    }
</script>

<style scoped>

</style>