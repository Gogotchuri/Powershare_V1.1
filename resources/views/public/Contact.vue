<template>
    <div id="container" class="contact-container contact-us-container">
        <div class="contact-header">
            <h3>Contact us</h3>
            <p>We are always ready to answer</p>
        </div>
        <div v-if="success">
            Mail has been sent, Thanks!
        </div>
        <div class="contact-form">
            <form @submit.prevent="send">
                <label for="name-surname" class="contact-us-label">Name, Surname</label>
                <input type="text" id="name-surname" v-model="form.name" class="form-control" placeholder="Type here" required>

                <br>

                <label for="contact-us-mail" class="contact-us-label">E-mail address</label>
                <input type="email" id="contact-us-mail" v-model="form.email" class="form-control" placeholder="Enter email address" required>

                <br>

                <label for="contact-us-subject" class="contact-us-label">Subject</label>
                <input type="text" id="contact-us-subject" v-model="form.subject" class="form-control" placeholder="Enter Subject">

                <br>

                <label for="contact-us-text" class="contact-us-label">Letter</label>
                <textarea v-model="form.text" id="contact-us-text" class="form-control" rows="5" placeholder="Enter letter text here" required></textarea>

                <div class="contact-btn-container">
                <button type="submit" class="btn contact-submit">Send</button>
                </div>
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
                    .catch(errors => this.errors = errors);
            }
        }
    }
</script>
