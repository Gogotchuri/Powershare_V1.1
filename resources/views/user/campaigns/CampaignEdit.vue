<template>
    <div>
        Campaign Edit form
    </div>
</template>

<script>
    export default {
        name: "CampaignEdit",
        computed:{
            id(){
                return this.$route.params.id;
            }
        }
    }
</script>
