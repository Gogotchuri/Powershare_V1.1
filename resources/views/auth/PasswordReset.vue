<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <div v-if="success === null" class="card card-default">
                    <div class="card-header">New Password</div>
                    <div class="card-body">
                        <form autocomplete="off" @submit.prevent="resetPassword">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Password</label>
                                <input type="password" id="password" class="form-control" placeholder="" v-model="password" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Confirm Password</label>
                                <input type="password" id="password_confirmation" class="form-control" placeholder="" v-model="password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>

                <div v-else-if="success">
                    Password Has been updated, you can login now.
                </div>

                <div v-else>
                    Password couldn't be updated, please try again, or contact the administration.
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
                setTimeout(next,1500);
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