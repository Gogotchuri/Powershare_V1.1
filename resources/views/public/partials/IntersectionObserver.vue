<template>
    <div class="öbserver"></div>
</template>

<script>
    export default {
        name: "IntersectionObserver",
        data(){
            return {
                observer:null
            }
        },
        mounted(){
            this.observer = new IntersectionObserver(([entry]) => {
                if(entry && entry.isIntersecting){
                    this.$emit("intersected");
                }
            });
            this.observer.observe(this.$el);
        }
    }
</script>

<style scoped>

</style>