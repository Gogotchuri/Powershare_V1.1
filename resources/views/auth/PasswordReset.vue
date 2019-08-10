<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <div v-if="success === null" class="card card-default">
                    <div class="card-header">{{$t("words.new") + " " + $t("words.password")}}</div>
                    <div class="card-body">
                        <form autocomplete="off" @submit.prevent="resetPassword">
                            <div class="form-group">
                                <label for="email">{{$t("words.email")}}</label>
                                <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">{{$t("words.password")}}</label>
                                <input type="password" id="password" class="form-control" placeholder="" v-model="password" required>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">{{$t("snippets.confirm-password")}}</label>
                                <input type="password" id="password_confirmation" class="form-control" placeholder="" v-model="password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-primary">{{$t("words.update")}}</button>
                        </form>
                    </div>
                </div>

                <div v-else-if="success">
                    {{$t("messages.password-reset-s")}}
                </div>

                <div v-else>
                    {{$t("messages.password-reset-f")}}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import store from "@js/store";
    import router from "@js/router";
    export default {
        name: "PasswordReset",
        beforeRouteEnter(to,from,next){
            if(store.getters.isAuthenticated){
                router.push({name: "Logout"});
                next();
            }
            next();
        },
        data() {
            return {
                token: null,
                email: null,
                password: null,
                password_confirmation: null,
                success:null
            }
        },
        methods: {
            resetPassword() {
                let baggage = {
                    token: this.$route.params.token,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                };

                this.$http.POST("/reset-password", baggage)
                    .then(() =>{
                        this.success = true;
                        let redirect = () => this.$router.push({name: "Login"});
                        setTimeout(redirect, 3000);
                    })
                    .catch(() => this.success = false)

            }
        }
    }
</script>