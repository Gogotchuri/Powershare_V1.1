<template>
  <div>
    <mdb-btn @click.native="modal = true"> Login</mdb-btn>
    <mdb-modal :show="modal" @close="modal = false">
      <mdb-modal-body>
          <login v-on:modaloff="modal = false"/>
      </mdb-modal-body>
    </mdb-modal>
  </div>
</template>

<script>
    import login from "@views/auth/Login";
    import { mdbModal, mdbModalHeader, mdbModalTitle, mdbModalBody, mdbModalFooter, mdbBtn } from 'mdbvue';
    export default {
        components: {
          mdbModal,
          mdbModalHeader,
          mdbModalTitle,
          mdbModalBody,
          mdbModalFooter,
          mdbBtn,
          login
        },
        data() {
          return {
              modal: false
          };
        }
    };
</script>
