<template>
    <div>
        <p v-if="errors === null">You have been successfully logged out!</p>
        <p v-else>There was a problem during logout <br> {{errors}}</p>
    </div>
</template>

<script>
    import store from "@js/store";
    export default {
        name: "Logout",
        data() {
          return {
              errors: null,
          };
        },

        beforeRouteEnter(to, from, next){
            const Auth = store.getters.isAuthenticated;
            if(!Auth){
                next("/");
            }else{
                next();
            }
        },

        beforeMount() {
            this.logout();
        },

        mounted(){
            const redirect = () => this.$router.push({name: "Home"});
            setTimeout(redirect, 5);
        },
        methods: {
            logout(){
                this.$store.dispatch("logout")
                    .catch(err => {
                        this.errors = err;
                        console.error(err.response);
                    });
            }
        }

    }
</script>

<style scoped>

</style>