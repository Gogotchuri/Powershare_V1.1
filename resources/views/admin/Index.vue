<template>
    <div class="row">
        <admin-nav class="col-3"/>
        <!-- Content of admin pages-->
        <div class="col-8">
            <router-view/>
        </div>
    </div>
</template>

<script>
    import AdminNav from "@/views/admin/partials/AdminNav";
    export default {
        name: "AdminIndex",
        components: {AdminNav}
    }
</script>