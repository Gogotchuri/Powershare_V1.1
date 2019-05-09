<template>
    <div class="sidebar-wrapper">
        <div class="logo">
            <router-link :to="{name: 'Home'}" class="simple-text">
                Powershare
            </router-link>
        </div>
        <ul class="nav">
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
        </ul>
    </div>
</template>

<script>
    export default {
        name: "UserNav"
    }
</script>