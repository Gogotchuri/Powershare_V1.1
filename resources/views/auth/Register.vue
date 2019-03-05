<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form method="POST" action="/register">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" v-model="name" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-model="email" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="password" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" v-model="password_confirmation" required>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary" @click="handleSubmit">
                                        Register
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
    import JwtService from "../../js/common/JwtService.js";
    import ApiService from "../../js/common/ApiService.js";
    import {post} from "../../js/common/ApiService.js";

    export default {
        name: "Register",
        data(){
            return {
                name : "",
                email : "",
                password : "",
                password_confirmation : ""
            }
        },
        methods : {
            handleSubmit(e) {
                e.preventDefault();
                if (this.password === this.password_confirmation && this.password.length > 0)
                {
                    post('register', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        c_password : this.password_confirmation
                    })
                    .then(response => {
                        localStorage.setItem('name',response.data.success.name);
                        JwtService.saveToken(response.data.success.token);
                        ApiService.setHeader();
                        if (JwtService.getToken()){
                            this.$router.push({name: 'Home'});
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
                } else {
                    this.password = "";
                    this.passwordConfirm = "";
                    return alert('Passwords do not match');
                }
            }
        },
        beforeRouteEnter (to, from, next) { 
            if (JwtService.getToken()) {
                return next({name: 'Home'});
            }
            next();
        }
    }
</script>