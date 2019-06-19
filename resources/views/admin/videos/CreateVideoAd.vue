<template>
    <div>
        <p v-if="!isEdit">Create Video Ad</p>
        <p v-else>Edit Video Ad</p>

        <form @submit.prevent="saveVideoAd">
            <label v-if="!addNewAdvertiser">
                Choose Advertiser
                <select type="text" class="category" v-model="VideoAd.advertiser_id">
                    <option v-for="advertiser in advertisers" :value="advertiser.id">{{advertiser.name}}</option>
                </select>
                or
            </label>
            <input v-if="!addNewAdvertiser" type="button" value="Add new Advertiser" @click="addNewAdvertiser = true">
            <create-advertiser v-if="addNewAdvertiser" v-on:AdvertiserAdded="addAdvertiser"/>
            <br>
            <label>
                Name:
                <input type="text" v-model="VideoAd.name" required>
            </label>
            <br>
            <label>
                Video URL:
                <input type="text" v-model="VideoAd.video_url" required>
            </label>
            <br>
            <label>
                Forward URL:
                <input type="url" v-model="VideoAd.forward_url" required>
            </label>
            <br>
            <label>
                Required duration:
                <input type="number" v-model="VideoAd.required_duration" required>
            </label>
            <br>
            <button v-if="!isEdit" type="submit">Create Video Ad</button>
            <button v-else type="submit">Update Video Ad</button>
        </form>
    </div>
</template>

<script>
    import HTTP from "@js/Common/Http.service";
    import CreateAdvertiser from "@views/admin/partials/CreateAdvertiser";

    export default {
        name: "CreateVideoAd",
        components: {CreateAdvertiser},
        data(){
            return {
                VideoAd : {},
                advertisers: [],
                addNewAdvertiser: false
            }
        },
        computed:{
            isEdit(){
                return this.$route.name === "Admin.VideoAds.Edit";
            }
        },
        beforeRouteEnter(to, from, next){
            let isEdit = to.name === "Admin.VideoAds.Edit";
            if(!isEdit){
                next();
                return;
            }
            HTTP.GET("/admin/video-ads/"+to.params.id)
                .then(res => {
                    let ad = res.data.data;
                    ad.advertiser_id = ad.advertiser.id;
                    next(vm => vm.VideoAd = ad);
                }).catch(err => {
                    console.error(err);
                    console.error(err.response);
                    next();
                })
        },
        mounted(){
            this.fetchAdvertisers();
        },
        methods: {
            saveVideoAd(){
                let videoStore = (!this.isEdit) ? HTTP.POST("/admin/video-ads", this.VideoAd)
                    : HTTP.PUT("/admin/video-ads/"+this.$route.params.id, this.VideoAd);
                videoStore.then(res => {
                    let ad = res.data.data;
                    if(!this.isEdit){
                        window.alert("Video ad Successfully created!");
                        this.$router.push("/admin/video-ads/"+ad.id);
                    }else{
                        window.alert("Video ad Successfully updated!");
                    }
                }).catch(err => console.error(err.response));
            },
            addAdvertiser(advertiser){
                this.advertisers.push(advertiser);
                this.addNewAdvertiser = false;
            },
            fetchAdvertisers(){
                HTTP.GET("/admin/advertisers")
                    .then(res => this.advertisers = res.data.data)
                    .catch(err => console.error(err));
            }
        }
    }
</script>

<style scoped>

</style>