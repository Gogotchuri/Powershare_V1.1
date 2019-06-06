<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card card-default">
                    <div class="card-header">
                        <h3>Welcome!</h3>
                        <p>Sign up to continue</p>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="register">
                            <div class="form-group row">
                                <label for="name" class="col-md-12 col-form-label auth-label">Name</label>
                                <div class="col-md-12">
                                    <input id="name" type="text" class="form-control" v-model="form.name" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-12 col-form-label auth-label">E-Mail Address</label>
                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control" v-model="form.email" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-12 col-form-label auth-label">Password</label>
                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control" v-model="form.password" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-12 col-form-label auth-label">Confirm Password</label>
                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control" v-model="password_confirmation" required>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-auth">
                                        sign up
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
        name: "Register",
        data(){
            return {
                form :{
                    name : "",
                    email : "",
                    password : "",
                },
                password_confirmation : ""
            }
        },
        methods : {
            //Handle validation, Please!
            register(){
                this.$store.dispatch("register", this.form)
                .then( () => {
                    window.alert("Registered successfully! Please Sign in and confirm email.")
                    this.$emit("modaloff");
                    this.$router.push({name: "Login"})
                });
            },
        },
        computed: {
            authErrors(){
                return this.$store.getters.authErrors;
            }
        }
    }
</script>
