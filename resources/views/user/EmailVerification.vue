<template>
    <div>
        <p v-if="verified">{{$t("messages.email-verified")}}</p>
        <p v-else-if="verified === null">{{$t("messages.verification-prog")}}</p>
        <p v-else>{{$t("messages.email-not-verified")}}</p>
    </div>
</template>

<script>
    import {API_URL} from "@js/Common/config";
    export default {
        name: "EmailVerification",
        data(){
            return{
                verified: null
            }
        },
        beforeMount(){
            if(this.$store.getters.currentUser.is_verified)
                this.$router.push("/");
        },
        async mounted(){
          let {confirmURL} = this.$route.query;
          if(confirmURL != null) {
              confirmURL = confirmURL.slice(API_URL.length, confirmURL.length);
              await this.verifyEmail(confirmURL);
          }else
              this.verified = false;
        },
        methods:{
            verifyEmail(verification_url){
                this.$store.dispatch("verifyEmail", verification_url)
                    .then(() => {
                        this.verified = true;
                        window.alert("Confirmation was a success, please, sign in again with verified account.");
                        this.$router.push({name: "Logout"});
                    })
                    .catch(reason => {
                        this.verified = false;
                        console.error(reason);
                    });
            }
        }
    }
</script>

<style scoped>

</style>