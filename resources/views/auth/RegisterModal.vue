<template>
  <div>
    <mdb-btn @click.native="modal = true">რეგისტრაცია</mdb-btn>
    <mdb-modal :show="modal" @close="modal = false">
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
    }
  };
</script>
