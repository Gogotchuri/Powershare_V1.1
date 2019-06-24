<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card card-default">
                    <div class="card-header">
                        <h3>კეთილი იყოს თქვენი მობრძანება!</h3>
                        <p>დარეგისტრირდით რათA გააგრძელოთ</p>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="register">
                            <div class="form-group row">
                                <label for="name" class="col-md-12 col-form-label auth-label">სახელი</label>
                                <div class="col-md-12">
                                    <input id="name" type="text" class="form-control" v-model="form.name" required autofocus>
                                </div>
                                <p v-if="authErrors && authErrors['name']" style="color: red;">{{authErrors['name'][0]}}</p>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-12 col-form-label auth-label">ელ. ფოსტა</label>
                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control" v-model="form.email" required>
                                </div>
                                <p v-if="authErrors && authErrors['email']" style="color: red;">{{authErrors['email'][0]}}</p>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-12 col-form-label auth-label">პაროლი</label>
                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control" v-model="form.password" required>
                                </div>
                                <p v-if="authErrors && authErrors['password']" style="color: red;">{{authErrors['password'][0]}}</p>
                            </div>
                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-12 col-form-label auth-label">პაროლის დადასტურება</label>
                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control" v-model="password_confirmation" required>
                                </div>
                                <label v-if="noMatch" style="color: red">პაროლი არ ემთხვევა</label>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-auth">
                                        რეგისტრაცია
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
    export default {
        name: "Register",
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
