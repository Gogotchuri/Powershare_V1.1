<template>
    <div>
        <user-nav/>
        <!--Content-->
        <div>
            <router-view/>
        </div>
    </div>
</template>

<script>
    import UserNav from "@/views/user/partials/UserNav";
    export default {
        name: "UserIndex",
        components: {UserNav}
    }
</script>

<style scoped>

</style>