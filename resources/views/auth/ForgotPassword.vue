<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card card-default">
                    <div class="card-header">Reset Password</div>
                    <div class="card-body">
                        <form @submit.prevent="requestResetPassword">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control" placeholder="user@example.com" v-model="email" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
                        </form>
                    </div>
                    <div v-if="success === null"></div>
                    <div v-else-if="success">
                        Email Sent Successfully
                    </div>
                    <div v-else style="color:red">
                        Reset email can't be sent... please try again, or contact administration.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "ForgotPassword",
        data() {
            return {
                email: null,
                success: null
            }
        },
        methods: {
            requestResetPassword() {
                this.success = null;
                this.$http.POST("/send-password-reset", {email: this.email})
                    .then(() => this.success = true)
                    .catch(() => this.success = false)
            }
        }
    }
</script>