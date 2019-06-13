<template>
    <div v-if="savedCampaigns != null">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Author name</th>
                <th>Actions</th>
            </tr>
            <tr v-for="saved in savedCampaigns">
                <td>{{saved.campaign.id}}</td>
                <td>{{saved.campaign.name}}</td>
                <td>{{saved.campaign.description.substr(0,50)}}</td>
                <td>{{saved.campaign.author_name}}</td>
                <td>
                    <input type="button" value="VIEW" @click="viewCampaign(saved.campaign.id)">
                    <input type="button" value="DELETE" style="color: red" @click="deleteCampaign(saved.campaign.id)">
                </td>
            </tr>
        </table>
    </div>
    <div v-else>
        <p>No Campaign is saved yet!</p>
    </div>
</template>

<script>
    import HTTP from "@js/Common/Http.service";

    export default {
        name: "SavedCampaigns",
        data(){
          return {
              savedCampaigns: null
          }
        },
        beforeRouteEnter(to, from, next){
            HTTP.GET("/user/favourite-campaigns")
                .then(res => {
                    let campaigns = res.data.data;
                    next(vm => vm.savedCampaigns = campaigns);
                })
                .catch(() => next());
        },
        methods: {
            viewCampaign(id){
                window.open("/campaigns/"+id, "_blank");
            },
            deleteCampaign(id){
                HTTP.DELETE("/user/favourite-campaigns/"+id)
                    .then(() => {
                        window.alert("Campaign Deleted from favourites!");
                        this.savedCampaigns = this.savedCampaigns.filter(c => c.campaign.id != id);
                    }).catch(() => window.alert("Campaign couldn't be removed!"));
            }
        }
    }
</script>

<style scoped>

</style>