<template>
    <div :style="{'background-image': 'url(https://img.youtube.com/vi/' + videoId + '/sddefault.jpg )'}">
        <mdb-btn class="gallery-btn" @click.native="modal = true"></mdb-btn>
        <mdb-modal :show="modal" @close="modal = false" class="modal-gallery-container">
        <mdb-modal-body  class="modal-gallery">
            <iframe :show="modal" @close="modal = false" :src="this.EmbdedLink"></iframe>
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
      mdbBtn,
      mdbModalFooter
    },
    data() {
      return {
        modal: false
      };
    },
    props: ["campaign_video_url"],
    computed: {
        videoId(){
            return this.campaign_video_url.substr(this.campaign_video_url.indexOf('v=')+2);
        },
        EmbdedLink(){
            console.log("http://www.youtube.com/embed/"+ this.videoId + "?autoplay=1");
            return "http://www.youtube.com/embed/"+ "S3h8sy9Yoik" + "?autoplay=1&fs=1";
        }
    }
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