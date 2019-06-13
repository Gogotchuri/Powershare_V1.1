<template>
    <div>
        Name {{user.name}}
        <br>
        Email {{user.email}}
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