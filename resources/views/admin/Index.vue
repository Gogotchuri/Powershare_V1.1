<template>
    <div>
        <admin-nav/>
        <!-- Content of admin pages-->
        <div>
            <router-view/>
        </div>
    </div>
</template>

<script>
    import AdminNav from "@/views/admin/partials/AdminNav";
    export default {
        name: "Index",
        components: {AdminNav}
    }
</script>