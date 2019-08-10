<template>
    <div>
        <p v-if="errors === null">{{$t("messages.logout-success")}}!</p>
        <p v-else>{{$t("messages.logout-fail")}}</p>
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