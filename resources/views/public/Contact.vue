<template>
    <div id="container" class="contact-container contact-us-container">
        <div class="contact-header">
            <h3>{{$t("titles.contact")}}</h3>
            <p>{{$t("texts.contact.we-ready")}}</p>
        </div>
        <div v-if="success">
            {{$t("texts.contact.success")}}
        </div>
        <div class="contact-form">
            <form @submit.prevent="send">
                <label for="name-surname" class="contact-us-label">{{$t("snippets.name")}}</label>
                <input type="text" id="name-surname" v-model="form.name" class="form-control" placeholder="Type here" required>

                <br>

                <label for="contact-us-mail" class="contact-us-label">{{$t("snippets.email")}}</label>
                <input type="email" id="contact-us-mail" v-model="form.email" class="form-control" placeholder="Enter email address" required>

                <br>

                <label for="contact-us-subject" class="contact-us-label">{{$t("snippets.subject")}}</label>
                <input type="text" id="contact-us-subject" v-model="form.subject" class="form-control" placeholder="Enter Subject">

                <br>

                <label for="contact-us-text" class="contact-us-label">{{$t("snippets.letter")}}</label>
                <textarea v-model="form.text" id="contact-us-text" class="form-control" rows="5" placeholder="Enter letter text here" required></textarea>

                <div class="contact-btn-container">
                <button type="submit" class="btn contact-submit">{{$t("snippets.send")}}</button>
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
