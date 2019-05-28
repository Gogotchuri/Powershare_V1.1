<template>
    <p>edit survey ID: {{id}}</p>
</template>

<script>
    export default {
        name: "EditSurvey",
        computed: {
            id(){
                return this.$route.params.id;
            }
        }
    }
</script>

<style scoped>

</style>