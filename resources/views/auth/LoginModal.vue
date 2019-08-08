<template>
  <div>
    <mdb-btn @click.native="modal = true"> შესვლა</mdb-btn>
    <mdb-modal  :show="modal" @close="modalOff">
      <mdb-modal-header>
        <mdb-modal-title></mdb-modal-title>
      </mdb-modal-header>
      <mdb-modal-body>
        <login v-on:modalOff="modal = false"/>
      </mdb-modal-body>
    </mdb-modal>
  </div>
</template>

<script>
    import login from "@views/auth/Login";
    import { mdbModal, mdbModalHeader, mdbModalTitle, mdbModalBody, mdbModalFooter, mdbBtn } from 'mdbvue';
    export default {
      name: "LoginModal",
      components:{
        mdbModal,
        mdbModalHeader,
        mdbModalTitle,
        mdbModalBody,
        mdbModalFooter,
        mdbBtn,
        login
      },
      data(){
        return {
          modal: false
        }
      },
      beforeMount() {
        this.$root.$on("login-modal-on", () => this.modal = true);
      },
      methods: {
        modalOff(){
          if(this.$route.name === "Login")
            this.$router.push({name: 'Home'});
          this.modal = false;
        }
      }

    }

</script>
