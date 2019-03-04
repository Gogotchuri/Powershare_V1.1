 <template>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-default">
                        <div class="card-header">Login</div>

                        <div class="card-body">
                            <form method="POST" action="/login">
                                <div class="form-group row">
                                    <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" v-model="email" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" v-model="password" required>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary" @click="handleLogin">
                                            Login
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

    export default {
        data(){
            return {
                email : "",
                password : ""
            }
        },
        methods : {
            handleLogin(e){
                e.preventDefault();
                if (this.password.length > 0) {
                    ApiService.post('login', 
                    {
                        email: this.email,
                        password: this.password
                    })
                    .then(response => {
                        JwtService.saveToken(response.data.success.token);
                        localStorage.setItem('name', response.data.success.name);
                        ApiService.setHeader();
                        if (JwtService.getToken() != null){
                            this.$router.push({name: 'Home'});
                        }
                    });

                }
            }
        },
        beforeRouteEnter (to, from, next) { 
            if (JwtService.getToken() != null) {
                return next({name: 'Home'});
            }
            next();
        }
    }
</script>