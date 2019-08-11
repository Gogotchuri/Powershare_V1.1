<template>
    <div class="profile-donated">
        <div v-if="!campaigns || campaigns.length == 0">
                <p>{{$t("snippets.no-campaigns")}}</p>
        </div>
        <div v-else> 
            <table>
                <tr>
                    <th>ID</th>
                    <th>{{$t("words.name")}}</th>
                    <th>{{$t("words.description")}}</th>
                    <th>{{$t("words.author")}}</th>
                    <th>{{$t("words.donations")}}</th>
                    <th>{{$t("words.action")}}</th>
                </tr>
                <tr v-for="campaign in campaigns">
                    <td>{{campaign.id}}</td>
                    <td>{{campaign.name}}</td>
                    <td>{{campaign.description.substr(0,50)}}</td>
                    <td>{{campaign.author_name}}</td>
                    <td>{{campaign.num_donated}}</td>
                    <td>
                        <input type="button" :value="$t('words.view')" @click="viewCampaign(campaign.id)">
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