<template>
  <div>
    <mdb-btn @click.native="modal = true">Login</mdb-btn>
    <mdb-modal :show="modal" @close="modal = false">
      <mdb-modal-header>
        <mdb-modal-title>Modal title</mdb-modal-title>
      </mdb-modal-header>
      <mdb-modal-body>
          <login/>
      </mdb-modal-body>
      <mdb-modal-footer>
        <mdb-btn color="secondary" @click.native="modal = false">Close</mdb-btn>
        <mdb-btn color="primary">Save changes</mdb-btn>
      </mdb-modal-footer>
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
