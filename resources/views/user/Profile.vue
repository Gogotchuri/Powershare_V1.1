<template>
    <div>
        {{$t("words.name")}} {{user.name}}
        <br>
        {{$t("words.email")}} {{user.email}}
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