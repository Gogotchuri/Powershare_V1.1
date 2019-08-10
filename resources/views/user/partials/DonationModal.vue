<template>
    <span class="donate-span">
        <mdb-btn v-if="!is_logged_in" @click="redirect">{{$t("snippets.donate-for-free")}}</mdb-btn>
        <mdb-btn v-else @click.native="isActive = true" style="margin-right:0">{{$t("snippets.donate-for-free")}}</mdb-btn>
        <mdb-modal :show="isActive" @close="isActive = false">
            <mdb-modal-body class="donate-captcha">
                <div v-if="!verified">
                    <vue-recaptcha :sitekey="CAPTCHA_KEY" :loadRecaptchaScript="true" @verify="verifyToken"/>
                </div>
                <div v-else>
                    <input type="button" :value="$t('words.survey')" @click="goToSurvey">
                    <input type="button" :value="$t('words.video-ad')" @click="goToVideo">
                </div>
            </mdb-modal-body>
        </mdb-modal>
    </span>
</template>

<script>
    import {RECAPTCHA_KEY} from "@js/Common/config";

    import VueRecaptcha from 'vue-recaptcha';
    import { mdbModal,mdbModalBody, mdbBtn } from 'mdbvue';
    export default {
        name: "DonationModal",
        components: {
            mdbModal,
            mdbModalBody,
            mdbBtn,
            VueRecaptcha
        },
        data(){
            return {
                isActive: false,
                verified: false,
                CAPTCHA_KEY: RECAPTCHA_KEY,
                captcha_token: ""
            }
        },
        props: ["campaign_id", "is_logged_in"],
        methods: {
            goToSurvey(){
                this.isActive = false;
                this.verified = false;
                this.$router.push({name: 'User.Survey', query: {campaign_id : this.campaign_id, recaptcha_token: this.captcha_token}});
            },

            goToVideo(){
                this.isActive = false;
                this.verified = false;
                this.$router.push({name: 'User.videoAd', query: {campaign_id : this.campaign_id, recaptcha_token: this.captcha_token}});
            },

            redirect(){
                this.$router.push({name: "Login", query: {redirect: "/campaigns/"+this.campaign_id}});
            },

            verifyToken(res){
                this.verified = true;
                this.captcha_token = res;
            }
        }
    }
</script>