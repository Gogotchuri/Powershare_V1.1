<template>
  <div>
    <mdb-btn @click.native="modal = true">{{$t("words.register")}}</mdb-btn>
    <mdb-modal :show="modal" @close="modalOff">
      <mdb-modal-header>
        <mdb-modal-title></mdb-modal-title>
      </mdb-modal-header>
      <mdb-modal-body>
        <register v-on:modaloff="modal = false"/>
      </mdb-modal-body>
    </mdb-modal>
  </div>
</template>

<script>
  import register from "@views/auth/Register";
  import { mdbModal, mdbModalHeader, mdbModalTitle, mdbModalBody, mdbModalFooter, mdbBtn } from 'mdbvue';
  export default {
    components: {
      mdbModal,
      mdbModalHeader,
      mdbModalTitle,
      mdbModalBody,
      mdbModalFooter,
      mdbBtn,
      register
    },
    data() {
      return {
        modal: false
      };
    },
    beforeMount() {
      this.$root.$on("register-modal-on", () => this.modal = true);
    },
    methods: {
      modalOff(){
        if(this.$route.name === "Register")
          this.$router.push({name: 'Home'});
        this.modal = false;
      }
    }
  };
</script>
