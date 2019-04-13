<template>
    <div id="container">
        <div v-if="success">
            Mail has been sent, Thanks!
        </div>
        <div class="contact-form">
            <form @submit.prevent="send">
                <input type="text" v-model="form.name" class="form-control" placeholder="Enter your Name" required>

                <br>

                <input type="email" v-model="form.email" class="form-control" placeholder="Enter email address" required>

                <br>

                <input type="text" v-model="form.subject" class="form-control" placeholder="Enter Subject">

                <br>

                <textarea v-model="form.text" class="form-control" rows="5" placeholder="Enter letter text here" required></textarea>

                <br>

                <button type="submit" class="btn contact-submit">Send</button>
            </form>
        </div>
        <div v-if="errors !== null && errors.length !== 0">
            {{errors}}
        </div>
    </div>
</template>

<script>
    export default {
        name: "Contact",
        data(){
            return {
                form:{
                    name : "",
                    email : "",
                    subject: "",
                    text: ""
                },
                errors : [],
                success : false
            }
        },
        methods: {
            send(){
                this.$store.dispatch("postLetter", this.form)
                    .then(() => this.success = true)
                    .catch((errors) => {this.errors = errors});
            }
        }
    }
</script>
