 <template>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-default">
                        <div class="card-header">Login</div>

                        <div class="card-body">
                            <form @submit.prevent="authenticate">
                                <div class="form-group row">
                                    <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" v-model="credentials.email" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" v-model="credentials.password" required>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <router-link :to="{name: 'ForgotPassword'}"> Forgot password?</router-link>
                                        <button type="submit" class="btn btn-primary">
                                            Login
                                        </button>
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
                    .then(() => this.$router.push({name : this.$route.query.redirect || "Home"}))
                    .catch(error => console.error(error));
            },

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
