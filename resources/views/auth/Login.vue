 <template>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3>{{$t("snippets.welcome-back")}}</h3>
                            <p>{{$t("words.sign-in")}}</p>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="authenticate">
                                <div class="form-group row">
                                    <label for="email" class="col-sm-12 col-form-label auth-label">{{$t("words.email")}}</label>

                                    <div class="col-md-12">
                                        <input id="email" type="email" class="form-control" v-model="credentials.email" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-12 col-form-label auth-label">{{$t("words.password")}}</label>

                                    <div class="col-md-12">
                                        <input id="password" type="password" class="form-control" v-model="credentials.password" required>
                                    </div>
                                </div>

                                <div class="form-group row remember-check">
                                    <div>
                                        <input id="remember" type="checkbox" class="form-control">
                                    </div>
                                    <label for="remember" class="col-form-label  auth-label">{{$t("words.remember-me")}}</label>
                                </div>
                                <div class="form-group row" v-if="error">
                                    <div class="error">
                                        {{$t("messages.wrong-credentials")}}.
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-auth">
                                            {{$t("words.login")}}
                                        </button>
                                        <a style="cursor: pointer" class="forgot" @click="passwordForgotten">{{$t("snippets.forgot-password?")}}</a>
                                        <div>
                                            <social-auth-button provider="facebook" class="social-login fb-login"></social-auth-button>
                                            <social-auth-button provider="google" class="social-login g-login"></social-auth-button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

<script>
    import RegisterModal from "@views/auth/RegisterModal";
    import SocialAuthButton from "@views/auth/SocialAuthButton";
    export default {
        name: "Login",
        data(){
            return{
                credentials: {
                    email : "",
                    password : ""
                },
                error: false
            }
        },
        methods: {
            authenticate(){
                this.$store.dispatch("login", this.credentials)
                    .then(() => {
                        let redirectionUrl = this.$route.query.redirect;
                        this.$router.push({path : redirectionUrl || "/", query: this.$route.query});
                        this.$emit("modalOff");
                    })
                    .catch(() => this.error = true);
            },
            passwordForgotten(){
                this.$emit("modalOff");
                this.$router.push({name: 'ForgotPassword'});
            }

        },
        components: {
            SocialAuthButton,
            RegisterModal
        }
    }

</script>

<style scoped>
    .error{
        color:red;
        text-align: center;
    }
</style>
