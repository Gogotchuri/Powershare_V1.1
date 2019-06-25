<template>
    <div v-if="campaign" class="edit-campaign">
        <h2>კამპანიის შეცვლა</h2>
        <form @submit.prevent="updateCampaign">
            <div>
                <label for="edit-name">სახელი:</label>
                <input id="edit-name" type="text" v-model="campaign.name" required>
            </div>
            <br>
            <div>
                <label for="edit-category">კატეგორია:</label>
                <select id="edit-category" type="text" class="category" v-model="campaign.category_id">
                    <option v-for="category in categories" :value="category.id">{{category.name}}</option>
                </select>
            </div>
            <br>
            <div>
                <label for="edit-desc">მოკლე აღწერა (მაქსიმუმ 200 სიმბოლო)</label>
                <textarea id="edit-desc" type="text" v-model="campaign.description" maxlength="200" required></textarea>
            </div>
            <br>
            <div>
                <label for="edit-ldesc">აღწერა (მაქსიმუმ 3000 სიმბოლო):</label>
                <textarea id="edit-ldesc" type="text" v-model="campaign.details" maxlength="3000" required></textarea>
            </div>
            <br>
            <div>
                <label for="req-fund">საჭირო დაფინანსება:</label>
                <input type="number" id="req-fund" v-model="campaign.required_funding" required>
            </div>
            <br>
            <div>
                <label for="vid-url">ვიდეოს მისამართი:</label>
                <input type="url" id="vid-url" v-model="campaign.video_url">
            </div>
            <br>
            <div>
                <label for="due-date">ვადა:</label>
                <input id="due-date" type="date" v-model="campaign.due_date">
            </div>
            <photo-upload v-on:ImageCropped="featuredImage" :image-src="campaign.featured_image_url"/>
            <br>
            <gallery-upload :isAdmin="isAdmin" :campaign="campaign"/>
            <br>
            <button type="submit" @click="campaign.status_id=3">შენახვა</button>
            <button type="submit" @click="campaign.status_id=2">დადასტურება განსახილველად</button>
            <button v-if="isAdmin" type="submit" @click="campaign.status_id=1">გამოქვეყნება</button>
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
                    .then((res) => {
                        console.log(res);
                        switch (this.campaign.status_id) {
                            case 1: window.alert("პროექტი წარმატებით გამოქვეყნდა!");
                                break;
                            case 2: window.alert("გმადლობთ, თქვენი პროექტი გაგზავნილია განსახილველად!");
                                break;
                            case 3: window.alert("თქვენი პროექტი შენახულია შემდგომი შესწორებებისთვის," +
                                " იხილეთ საკუთარ კამპანიებში!");
                                break;
                        }
                    })
                    .catch(reason => console.error(reason.response.errors));
            },

            featuredImage(base64){
                this.campaign.base64_featured_image = base64;
            }

        }
    }
</script>
