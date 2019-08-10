<template>
    <div class="profile-campaigns">
        <div v-if="!campaigns || campaigns.length == 0">
            <p>{{$t("snippets.no-campaigns")}}</p>
        </div>
        <div v-else> 
            <table style="width:100%">
                <tr>
                    <th>ID</th>
                    <th>{{$t("words.name")}}</th>
                    <th>{{$t("words.description")}}</th>
                    <th>{{$t("words.author")}}</th>
                    <th>{{$t("words.status")}}</th>
                    <th v-if="atAdmin">{{$t("snippets.realized-funding")}}</th>
                    <th>{{$t("words.action")}}</th>
                </tr>
                <tr v-for="campaign in campaigns">
                    <td>{{campaign.id}}</td>
                    <td>{{campaign.name}}</td>
                    <td>{{campaign.description.substr(0,50)}}</td>
                    <td>{{campaign.author_name}}</td>
                    <td v-if="campaign.status_id == 1">{{$t("words.approved")}}</td>
                    <td v-else-if="campaign.status_id == 2">{{$t("words.proposed")}}</td>
                    <td v-else>{{$t("words.drafted")}}</td>
                    <td v-if="atAdmin">{{campaign.realized_funding}}₾</td>
                    <td v-if="atAdmin">
                        <button style="color: yellow"
                                @click="adminEdit(campaign.id)">
                            {{$t("words.edit")}}
                        </button>
                        <button style="color: red"
                                @click="adminDelete(campaign.id)">{{$t("words.delete")}}</button>
                        <button v-if="campaign.status_id != 1" style="color: green"
                                @click="approveCampaign(campaign.id)">{{$t("words.approve")}}</button>
                        <button v-else style="color: blue"
                                @click="viewCampaign(campaign.id)">
                            {{$t("words.view")}}
                        </button>
                    </td>
                    <td v-if="campaign.status_id == 1 && !atAdmin">
                        <button style="color: green"
                                @click="viewCampaign(campaign.id)">
                            {{$t("words.view")}}
                        </button>
                    </td>
                    <td v-else-if="!atAdmin">
                        <button style="color: yellow"
                                @click="userEdit(campaign.id)">
                            {{$t("words.edit")}}
                        </button>
                        <button style="color: red"
                                @click="userDelete(campaign.id)">
                            {{$t("words.delete")}}
                        </button>
                    </td>
                </tr>
            </table>
            <intersection-observer v-if="curPage <= lastPage" v-on:intersected="loadCampaigns"/>
        </div>
    </div>
</template>

<script>
    import HTTP from "@js/Common/Http.service";
    import IntersectionObserver from "@views/public/partials/IntersectionObserver"

    export default {
        name: "Campaigns",
        data(){
            return{
                categories: [],
                campaigns: [],
                atAdmin: false,
                curPage: 1,
                lastPage: 1
            }
        },
        components: {IntersectionObserver},
        beforeRouteEnter(to, from, next) {
            let admin = to.name === "Admin.Campaigns";
            //Fetching promises
            let campFetchUri = admin ? "/admin/" : "/user/";
            campFetchUri += "campaigns?pagination=5";
            let campaignFetch = HTTP.GET(campFetchUri);
            let categoryFetch = HTTP.GET("/campaign-categories");
            Promise.all([categoryFetch, campaignFetch]).then(value => {
                let categories = value[0].data.data;
                let campaigns = value[1].data.data;
                let lastPage = value[1].data.meta.last_page;
                next(vm => {
                    vm.categories = categories;
                    vm.campaigns = campaigns;
                    vm.atAdmin = admin;
                    vm.lastPage = lastPage;
                })
            }).catch(err => {
                console.error(err.response);
                next();
            });
        },

        methods:{
            async approveCampaign(id){
                let campaignInArray = this.campaigns.find(value => value.id === id);
                let campaign = (await HTTP.GET("/admin/campaigns/"+id)).data.data;
                campaign.status_id = 1;
                let res = await this.$store.dispatch("patchCampaign", {campaign: campaign, isAdmin: true});
                campaignInArray.status_id = 1;
            },
            /**
             * Loads campaign on call, page is taken from local variable curr page
             * If current page is more than last page, nothing happens
             * If this function is called after search, it should get called with search parameter true
             * */
            loadCampaigns(){
                this.curPage++;
                let campFetchUri = this.atAdmin ? "/admin/" : "/user/";
                campFetchUri += "campaigns?pagination=5&page="+this.curPage;
                HTTP.GET(campFetchUri)
                    .then(value => {
                        let fetchedCampaigns = value.data.data;
                        let lastPage = value.data.meta.last_page;
                        this.campaigns = this.campaigns.concat(fetchedCampaigns);
                        this.lastPage = lastPage;
                    })
                    .catch(reason => {
                        console.error("Error while loading campaigns!");
                        console.error(reason);
                    });
            },

            adminDelete(id){
              HTTP.DELETE("/admin/campaigns/"+id)
                  .then(() => {
                    window.alert("Campaign has been deleted!");
                      this.campaigns = this.campaigns.filter((c) => {
                          return c.id !== id;
                      });
                  }).catch(r => console.error(r.response));
            },
            userDelete(id){
                HTTP.DELETE("/user/campaigns/"+id)
                    .then(() => {
                        window.alert("Campaign has been deleted!");
                        this.campaigns = this.campaigns.filter((c) => {
                           return c.id !== id;
                        });
                    }).catch(r => console.error(r.response));
            },
            adminEdit(id){
                this.$router.push('/admin/campaigns/'+id+'/edit')
            },
            viewCampaign(id){
                window.open('/campaigns/'+id, "_blank");
            },
            userEdit(id){
                this.$router.push('/user/campaigns/'+id+'/edit');
            }
        }
    }
</script>