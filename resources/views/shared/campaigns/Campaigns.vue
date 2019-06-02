<template>
    <div>
        <div>
            <table style="width:100%">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <tr v-for="campaign in campaigns">
                    <td>{{campaign.id}}</td>
                    <td>{{campaign.name}}</td>
                    <td>{{campaign.description}}</td>
                    <td>{{campaign.author_name}}</td>
                    <td v-if="campaign.status_id == 1">APPROVED</td>
                    <td v-else-if="campaign.status_id == 2">PROPOSED</td>
                    <td v-else>DRAFT</td>
                    <td v-if="atAdmin">
                        <button style="color: yellow">EDIT</button>
                        <button style="color: red">DELETE</button>
                        <button v-if="campaign.status_id != 1" style="color: green">APPROVE</button>
                        <button v-else style="color: blue">VIEW</button>
                    </td>
                    <td v-if="campaign.status_id == 1 && !atAdmin">
                        <button style="color: green">VIEW</button>
                    </td>
                    <td v-else-if="!atAdmin">
                        <button style="color: yellow">EDIT</button>
                        <button style="color: red">DELETE</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
    import HTTP from "@js/Common/Http.service";
    export default {
        name: "Campaigns",
        data(){
            return{
                categories: [],
                campaigns: [],
                atAdmin: false
            }
        },

        beforeRouteEnter(to, from, next) {
            let admin = to.name === "Admin.Campaigns";
            //Fetching promises
            let campaignFetch = admin ? HTTP.GET("/admin/campaigns") : HTTP.GET("/user/campaigns");
            let categoryFetch = HTTP.GET("/campaign-categories");
            Promise.all([categoryFetch, campaignFetch]).then(value => {
                let categories = value[0].data.data;
                let campaigns = value[1].data.data;
                next(vm => {
                    vm.categories = categories;
                    vm.campaigns = campaigns;
                    vm.atAdmin = admin;
                })
            }).catch(err => {
                console.error(err.response);
                next();
            });
        },

        methods:{

        }
    }
</script>