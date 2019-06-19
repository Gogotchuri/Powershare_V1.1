<template>
    <span>
        <mdb-btn @click.native="isActive = true" class="donate-button">Donate for free</mdb-btn>
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
        props: ["campaign_id"],
        methods: {
            goToSurvey(){
                this.isActive = false;
                this.$router.push({name: 'User.Survey', query: {campaign_id : this.campaign_id}});
            },
            goToVideo(){
                this.isActive = false;
                this.$router.push({name: 'User.VideoAd', query: {campaign_id : this.campaign_id}});
            }
        }
    }
</script>

<style scoped>

</style>