<template>
    <div>
        This is a campaign! {{id}}
    </div>
</template>

<script>
export default {
    date(){
        return {
            id : -1
        };
    },
    beforeMount(){
        this.id = this.$route.params.id;
    }
}
</script>