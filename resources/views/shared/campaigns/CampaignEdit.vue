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
            <div>
                <button type="submit" @click="campaign.status_id=3">Save as Draft</button>
                <button type="submit" @click="campaign.status_id=2">Submit For review</button>
            </div>
        </form>
    </div>
</template>

<script>
    import HTTP from "@js/Common/Http.service";
    export default {
        name: "CampaignEdit",
        data(){
            return {
                campaign: null,
                categories: [],
            }
        },
        computed:{
            id(){
                return this.$route.params.id;
            }
        },
        beforeRouteEnter(to, from, next){
            let categoryFetch = HTTP.GET("/campaign-categories");
            let campaignFetch = HTTP.GET("/user/campaigns/"+to.params.id);
            Promise.all([categoryFetch, campaignFetch]).then(value => {
                let categories = value[0].data.data;
                let campaign = value[1].data.data;
                //Setting fetched data to this component
                next(vm => {
                    vm.categories = categories;
                    vm.campaign = campaign;
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
                let campaignPutUri = "/user/campaigns/" + this.campaign.id;
                HTTP.PUT(campaignPutUri, this.campaign)
                    .then(res => {
                        console.log(res);
                    })
                    .catch(reason => {
                        console.log(campaignPutUri);
                        console.error(reason.response);
                    });
            }
        }
    }
</script>
