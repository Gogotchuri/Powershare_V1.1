<template>
    <div></div>
</template>

<script>
    import {app} from "@js/app";
    export default {
        name: "LoginModalOn",
        data(){
          return {
              modalOn: false
          }
        },
        beforeRouteEnter(to, from, next){
            if(app != null) {
                //App could be null when going straight to the path
                app.$root.$emit("login-modal-on");
                setTimeout(() => next(vm => vm.modalOn = true), 350);
            }else
                next();
        },

        beforeMount(){
            if(!this.modalOn)
                this.$root.$emit("login-modal-on");
        }
    }
</script>