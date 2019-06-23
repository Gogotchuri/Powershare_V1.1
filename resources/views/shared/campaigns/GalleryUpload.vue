<template>
    <div>
        <p>გალერია</p>
        <table>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            <tr v-for="image in gallery" v-bind:key="image.id">
                <td>{{image.id}}</td>
                <td><img :src="image.thumbnail_url" alt=""></td>
                <td><a target="_blank" :href="image.url">{{image.name.substr(0,50)}}</a></td>
                <td>
                    <input type="button" value="DELETE" style="color:red" @click="deleteImage(image.id)">
                    <input type="button" value="VIEW" style="color:grey" @click="viewImage(image.url)">
                </td>
            </tr>
        </table>
        <form @submit.prevent="uploadImage">
            <input type="file" name="image" accept="image/*" @change="setImage" style="font-size: 1.2em; padding: 10px 0;"/>
            <button v-if="curImage" type="submit">Upload</button>
        </form>
    </div>
</template>

<script>
    import HTTP from "@js/Common/Http.service";

    export default {
        name: "GalleryUpload",
        props: ["isAdmin", "campaign"],
        data(){
            return {
                gallery: null,
                curImage: null
            };
        },
        beforeMount(){
            this.fetchGallery();
        },
        methods: {
            fetchGallery(){
                let galleryFetchUri = "/campaigns/" +this.campaign.id+"/gallery";
                HTTP.GET(galleryFetchUri)
                    .then(data => this.gallery = data.data.data)
                    .catch(reason => console.log(reason.response));
            },
            viewImage(url){
                window.open(url, "_blank");
            },
            deleteImage(imageId){
                let imageDeleteUri = this.isAdmin ? "/admin" : "/user";
                imageDeleteUri += "/campaigns/" + this.campaign.id + "/gallery/" + imageId;
                HTTP.DELETE(imageDeleteUri)
                    .then(() => this.fetchGallery())
                    .catch((err) => console.log(err.response));
            },
            setImage(inp){
                const file = inp.target.files[0];

                if (!file.type.includes('image/')) {
                    alert('Please select an image file');
                    return;
                }
                console.log(file);
                this.curImage = file;
            },
            uploadImage(){
                let formData = new FormData();
                formData.append('file', this.curImage);
                let imageUploadUri = this.isAdmin ? "/admin" : "/user";
                imageUploadUri += "/campaigns/"+this.campaign.id+"/gallery";
                HTTP.POST(imageUploadUri,
                    formData, {"Content-Type": "multipart/form-data"})
                    .then(() => this.fetchGallery())
                    .catch(reason => {
                        //TODO errorcode 403 means limit excceeded
                        //Need to handle limiting on frontend
                        console.error(reason);
                    });
            }
        }
    }
</script>