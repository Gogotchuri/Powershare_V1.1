<template>
    <span class="donate-span">
        <mdb-btn v-if="!is_logged_in" @click="redirect">დაეხმარე უფასოდ</mdb-btn>
        <mdb-btn v-else @click.native="isActive = true" style="margin-right:0">დაეხმარე უფასოდ</mdb-btn>
        <mdb-modal :show="isActive" @close="isActive = false">
            <mdb-modal-body>
                <input type="button" value="Survey" @click="goToSurvey">
                <input type="button" value="Video Ad" @click="goToVideo">
            </mdb-modal-body>
        </mdb-modal>
    </span>
</template>

<script>
    import { mdbModal,mdbModalBody, mdbBtn } from 'mdbvue';
    export default {
        name: "DonationModal",
        components: {
            mdbModal,
            mdbModalBody,
            mdbBtn
        },
        data(){
            return {
                isActive: false
            }
        },
        props: ["campaign_id", "is_logged_in"],
        methods: {
            goToSurvey(){
                this.isActive = false;
                this.$router.push({name: 'User.Survey', query: {campaign_id : this.campaign_id}});
            },
            goToVideo(){
                this.isActive = false;
                this.$router.push({name: 'User.videoAd', query: {campaign_id : this.campaign_id}});
            },
            redirect(){
                this.$router.push({name: "Login", query: {redirect: "/campaigns/"+this.campaign_id}});
            }
        }
    }
</script>

<style scoped>

</style>