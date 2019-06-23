<template>
    <div :style="{'background-image': 'url(' + this.campaign_photo_url + ')'}">
        <mdb-btn class="gallery-btn" @click.native="modal = true"></mdb-btn>
        <mdb-modal :show="modal" @close="modal = false" class="modal-gallery-container">
        <mdb-modal-body  class="modal-gallery">
            <img :show="modal" @close="modal = false" :src="this.campaign_photo_url" alt="">
        </mdb-modal-body>
        <mdb-modal-footer>
            <mdb-btn color="secondary" @click.native="modal = false">Close</mdb-btn>
        </mdb-modal-footer>
        </mdb-modal>
    </div>
</template>

<script>
  import { mdbModal, mdbModalBody, mdbModalFooter, mdbBtn } from 'mdbvue';
  export default {
    components: {
      mdbModal,
      mdbModalBody,
      mdbBtn
    },
    data() {
      return {
        modal: false
      };
    },
    props: ["campaign_photo_url"]
  };
</script>

<style scoped>
    .gallery-btn{
        height: 100%;
        width: 100%;
    }
    .modal-gallery{
        width: auto;
        height: auto;
        margin: auto;
        padding: 0;
    }
    img{
        width: 80%;
        height: auto;
    }
</style>
