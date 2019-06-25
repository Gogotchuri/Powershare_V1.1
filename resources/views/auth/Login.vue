 <template>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3>კეთილი იყოს უკან დაბრუნება!</h3>
                            <p>შედით პროფილზე გასაგრძელებლად</p>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="authenticate">
                                <div class="form-group row">
                                    <label for="email" class="col-sm-12 col-form-label auth-label">ელ. ფოსტა</label>

                                    <div class="col-md-12">
                                        <input id="email" type="email" class="form-control" v-model="credentials.email" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-12 col-form-label auth-label">პაროლი</label>

                                    <div class="col-md-12">
                                        <input id="password" type="password" class="form-control" v-model="credentials.password" required>
                                    </div>
                                </div>

                                <div class="form-group row remember-check">
                                    <div>
                                        <input id="remember" type="checkbox" class="form-control">
                                    </div>
                                    <label for="remember" class="col-form-label  auth-label">დამიმახსოვრე</label>
                                </div>
                                <div class="form-group row" v-if="error">
                                    <div class="error">
                                        Wrong Credentials.
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-auth">
                                            შესვლა
                                        </button>
                                        <a href="#" class="forgot" @click="passwordForgotten"> დაგავიწყდა პაროლი?</a>
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
                        this.$router.push({path : redirectionUrl || "Home", query: this.$route.query});
                        this.$emit("modaloff");
                    })
                    .catch(() => this.error = true);
            },
            passwordForgotten(){
                this.$emit("modaloff");
                this.$router.push({name: 'ForgotPassword'});
            }

        },
        components: {
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
