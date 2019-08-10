<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card card-default">
                    <div class="card-header">
                        <h3>{{$t("words.welcome")}}!</h3>
                        <p>{{$t("snippets.register-to-continue")}}</p>
                    </div>
                    <div class="card-body">
                        <social-auth-button provider="facebook" class="social-login fb-login"></social-auth-button>
                        <social-auth-button provider="google" class="social-login g-login"></social-auth-button>
                        <p>{{$t("words.or")}}</p>
                        {{$t("snippets.fill-form")}}
                        <form @submit.prevent="register">
                            <div class="form-group row">
                                <label for="name" class="col-md-12 col-form-label auth-label">{{$t("words.name")}}</label>
                                <div class="col-md-12">
                                    <input id="name" type="text" class="form-control" v-model="form.name" required autofocus>
                                </div>
                                <p v-if="authErrors && authErrors['name']" style="color: red;">{{authErrors['name'][0]}}</p>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-12 col-form-label auth-label">{{$t("words.email")}}</label>
                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control" v-model="form.email" required>
                                </div>
                                <p v-if="authErrors && authErrors['email']" style="color: red;">{{authErrors['email'][0]}}</p>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-12 col-form-label auth-label">{{$t("words.password")}}</label>
                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control" v-model="form.password" required>
                                </div>
                                <p v-if="authErrors && authErrors['password']" style="color: red;">{{authErrors['password'][0]}}</p>
                            </div>
                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-12 col-form-label auth-label">{{$t("snippets.confirm-password")}}</label>
                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control" v-model="password_confirmation" required>
                                </div>
                                <label v-if="noMatch" style="color: red">{{$t("snippets.password-mismatch")}}</label>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-auth">
                                        {{$t("words.register")}}
                                    </button>

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
    import SocialAuthButton from "@views/auth/SocialAuthButton";
    export default {
        name: "Register",
        components: {SocialAuthButton},
        data(){
            return {
                form :{
                    name : "",
                    email : "",
                    password : "",
                    //TODO match password confirmation
                },
                password_confirmation : "",
                authErrors: null

            }
        },
        methods : {
            //Handle validation, Please!
            register(){
                if(this.noMatch){
                    window.alert("Please enter a matching password first!");
                    return;
                }
                this.$store.dispatch("register", this.form)
                .then( () => {
                    window.alert("Registered successfully! Please Sign in and confirm email.")
                    this.$emit("modaloff");
                    this.$router.push({name: "Login"})
                }).catch(reason => {
                    let errors = reason.response.data.errors;
                    console.error(reason.response.data.errors);
                    this.authErrors = errors;
                });
            },
        },
        computed: {
            noMatch(){
                return this.form.password !== this.password_confirmation;
            }
        }
    }
</script>
