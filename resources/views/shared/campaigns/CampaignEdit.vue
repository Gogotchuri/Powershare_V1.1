<template>
    <div v-if="campaign">
        <form @submit.prevent="updateCampaign">
            <div>
                <p>Name:</p>
                <input type="text" v-model="campaign.name" required>
            </div>
            <br>
            <div>
                <select type="text" class="category" v-model="campaign.category_id">
                    <option v-for="category in categories" :value="category.id">{{category.name}}</option>
                </select>
            </div>
            <br>
            <div>
                <p>Short Description (Maximum of 200 characters)</p>
                <textarea type="text" v-model="campaign.description" maxlength="200" required></textarea>
            </div>
            <br>
            <div>
                <p>Details (Maximum of 3000 characters):</p>
                <textarea type="text" v-model="campaign.details" maxlength="3000" required></textarea>
            </div>
            <br>
            <div>
                <p>Required funding:</p>
                <input type="number" v-model="campaign.required_funding" required>
            </div>
            <br>
            <div>
                <p>Video url:</p>
                <input type="url" v-model="campaign.video_url">
            </div>
            <br>
            <div>
                <p>Due Date:</p>
                <input type="date" v-model="campaign.due_date">
            </div>
            <photo-upload v-on:ImageCropped="featuredImage" :image-src="campaign.featured_image_url"/>
            <br>
            <gallery-upload :isAdmin="isAdmin" :campaign="campaign"/>
            <br>
            <div>
                <button type="submit" @click="campaign.status_id=3">Save as Draft</button>
                <button type="submit" @click="campaign.status_id=2">Submit For review</button>
                <button v-if="isAdmin" type="submit" @click="campaign.status_id=1">Publish</button>
            </div>
        </form>
    </div>
</template>

<script>
    import HTTP from "@js/Common/Http.service";
    import store from "@js/store";

    import PhotoUpload from "@views/shared/campaigns/PhotoUpload";
    import GalleryUpload from "@views/shared/campaigns/GalleryUpload";

    export default {
        name: "CampaignEdit",
        components: {GalleryUpload, PhotoUpload},
        data(){
            return {
                campaign: null,
                categories: [],
                isAdmin: false
            }
        },
        computed:{
            id(){
                return this.$route.params.id;
            }
        },
        beforeRouteEnter(to, from, next){
            let isAdmin = store.getters.isAdmin;
            let categoryFetch = HTTP.GET("/campaign-categories");
            let campaignFetch = isAdmin ? HTTP.GET("/admin/campaigns/"+to.params.id)
                                            : HTTP.GET("/user/campaigns/"+to.params.id);
            Promise.all([categoryFetch, campaignFetch]).then(value => {
                let categories = value[0].data.data;
                let campaign = value[1].data.data;
                //Setting fetched data to this component
                next(vm => {
                    vm.categories = categories;
                    vm.campaign = campaign;
                    vm.isAdmin = isAdmin;
                })
            }).catch(reason => {
                console.error("Error while fetching campaign");
                console.error(reason.response);
                if(reason.response.status === 404)
                    next("/404");
                else
                    next();
            });
        },
        methods: {
            updateCampaign(){
                this.$store.dispatch("patchCampaign", { campaign :this.campaign, isAdmin: this.isAdmin})
                    .then((res) => console.log(res))
                    .catch(reason => console.error(reason.response.errors));
            },

            featuredImage(base64){
                this.campaign.base64_featured_image = base64;
            }

        }
    }
</script>
