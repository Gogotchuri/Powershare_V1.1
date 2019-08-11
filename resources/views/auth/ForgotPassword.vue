<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card card-default">
                    <div class="card-header">{{$t("snippets.reset-password")}}</div>
                    <div class="card-body">
                        <form @submit.prevent="requestResetPassword">
                            <div class="form-group">
                                <label for="email">{{$t("words.email")}}</label>
                                <input id="email" type="email" class="form-control" placeholder="user@example.com" v-model="email" required>
                            </div>
                            <button type="submit" class="btn btn-primary">{{$t("send-reset-link")}}</button>
                        </form>
                    </div>
                    <div v-if="success === null"></div>
                    <div v-else-if="success">
                        {{$t("messages.sent-successfully")}}
                    </div>
                    <div v-else style="color:red">
                        {{$t("messages.couldn't-be-sent") + "... " + $t("messages.try-later")}}
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