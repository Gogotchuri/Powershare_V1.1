<template>
    <div>
        <p v-if="verified">Email has been verified!</p>
        <p v-else-if="verified === null">Verification in progress</p>
        <p v-else>Couldn't verify try to contact administration or resend verification</p>
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
          console.log(confirmURL);
          if(confirmURL != null) {
              confirmURL = confirmURL.slice(API_URL.length, confirmURL.length);
              await this.verifyEmail(confirmURL);
          }else
              this.verified = false;
        },
        methods:{
            verifyEmail(verification_url){
                this.$store.dispatch("verifyEmail", verification_url)
                    .then(() => this.verified = true)
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