<template>
    <div>
        <mdb-modal :show="modal" @close="modal = false,changeState()">
            <mdb-modal-header>
                <mdb-modal-title></mdb-modal-title>
            </mdb-modal-header>
            <mdb-modal-body class="thank-you">{{$t("texts.advertising.success")}}<br> 😜</mdb-modal-body>
        </mdb-modal>
    </div>
</template>

<script>
    import { mdbModal, mdbModalHeader, mdbModalTitle, mdbModalBody, mdbModalFooter, mdbBtn } from 'mdbvue';
    export default {
        components: {
            mdbModal,
            mdbModalHeader,
            mdbModalTitle,
            mdbModalBody,
            mdbModalFooter,
            mdbBtn
        },
        data() {
            return {
                modal: true
            };
        },
        methods: {
            changeState(){
                let form = this.$parent.form;
                this.$parent.state = 0;
                form.email = "";
                form.phone = "";
            }
        }
    };
</script>

<style scoped>
    .thank-you{
        margin-top: -15px;
        color: #662f92;
        font-size: 20px;
    }
</style>