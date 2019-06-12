<template>
    <div>
        <input type="file" name="image" accept="image/*" @change="setImage" style="font-size: 1.2em; padding: 10px 0;"/>
        <br>
        <div v-if="imgSrc">
            <vue-cropper
                v-if="imgSrc"
                ref="cropper"
                :src="imgSrc"
                :aspect-ratio="43/60"
                alt="Source Image"
                style="width: 500px; height:281px;"
            />
            <input type="button" value="crop" @click="cropImage" style="margin-right: 40px;">
            <br>
            <img v-if="cropImg" :src="cropImg" alt="" style="width: 250px; height: 350px;">
        </div>
    </div>
</template>

<script>

    import VueCropper from 'vue-cropperjs';
    import 'cropperjs/dist/cropper.css';

    export default {
        name: "PhotoUpload",
        components: { VueCropper},
        props:["imageSrc"],
        data(){
            return {
                imgSrc: null,
                cropImg: null
            }
        },
        mounted(){
          this.imgSrc = this.imageSrc ? this.imageSrc : null;
        },
        methods:{
            setImage(e) {
                const file = e.target.files[0];

                if (!file.type.includes('image/')) {
                    alert('Please select an image file');
                    return;
                }

                if (typeof FileReader === 'function') {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        this.imgSrc = event.target.result;
                        this.$refs.cropper.replace(event.target.result);
                    };
                    reader.readAsDataURL(file);
                } else {
                    alert('Sorry, FileReader API not supported');
                }
            },

            cropImage(){
                this.cropImg = this.$refs.cropper.getCroppedCanvas().toDataURL();
                this.$emit("ImageCropped", this.cropImg);
            }
        }
    }

</script>