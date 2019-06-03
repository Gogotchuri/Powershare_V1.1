<template>
    <div class="observer"></div>
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
    .observer{
        width: 1px;
        height: 1px;
    }
</style>