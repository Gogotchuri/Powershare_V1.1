<template>
    <div class="profile-donated">
        <div v-if="!campaigns || campaigns.length == 0">
                <p>No Campaigns To display!</p>
        </div>
        <div v-else> 
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Author name</th>
                    <th>Donation count</th>
                    <th>Actions</th>
                </tr>
                <tr v-for="campaign in campaigns">
                    <td>{{campaign.id}}</td>
                    <td>{{campaign.name}}</td>
                    <td>{{campaign.description.substr(0,50)}}</td>
                    <td>{{campaign.author_name}}</td>
                    <td>{{campaign.num_donated}}</td>
                    <td>
                        <input type="button" value="VIEW" @click="viewCampaign(campaign.id)">
                    </td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
    import HTTP from "@js/Common/Http.service";

    export default {
        name: "DonatedCampaigns",
        data(){
            return {
                campaigns:null
            }
        },
        beforeRouteEnter(to, from, next){
            HTTP.GET("/user/donated-campaigns")
                .then(res => {
                    let campaigns = res.data.data;
                    next(vm => vm.campaigns = campaigns);
                }).catch(err => {
                    console.error(err.response);
                    next();
            })
        },
        methods: {
            viewCampaign(id){
                window.open("/campaigns/"+id, "_blank");
            }
        }
    }
</script>

<style scoped>

</style>