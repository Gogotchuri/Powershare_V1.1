 <template>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3>Welcome Back!</h3>
                            <p>Sign in to continue</p>
                        </div>

                        <div class="card-body">
                            <form @submit.prevent="authenticate">
                                <div class="form-group row">
                                    <label for="email" class="col-sm-12 col-form-label auth-label">E-Mail Address</label>

                                    <div class="col-md-12">
                                        <input id="email" type="email" class="form-control" v-model="credentials.email" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-12 col-form-label auth-label">Password</label>

                                    <div class="col-md-12">
                                        <input id="password" type="password" class="form-control" v-model="credentials.password" required>
                                    </div>
                                </div>

                                <div class="form-group row remember-check">
                                    

                                    <div>
                                        <input id="remember" type="checkbox" class="form-control">
                                    </div>
                                    <label for="remember" class="col-form-label  auth-label">Remember me</label>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-auth">
                                            Sign in
                                        </button>
                                        <a href="#" class="forgot" @click="passwordForgotten"> Forgot password?</a>
                                    </div>
                                </div>
                                <div class="form-group row" v-if="authErrors">
                                    <div class="error">
                                        {{authErrors}}
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
    export default {
        name: "Login",
        data(){
            return{
                credentials: {
                    email : "",
                    password : ""
                }
            }
        },
        methods: {
            authenticate(){
                this.$store.dispatch("login", this.credentials)
                    .then(() => {
                        this.$router.push({name : this.$route.query.redirect || "Home", query: this.$route.query})
                        this.$emit("modaloff");
                    })
                    .catch(error => console.error(error));
            },
            passwordForgotten(){
                this.$emit("modaloff");
                this.$router.push({name: 'ForgotPassword'});
            }

        },

        computed: {
            authErrors(){
                return this.$store.getters.authErrors;
            }
        }
    }

</script>

<style scoped>
    .error{
        color:red;
        text-align: center;
    }
</style>
