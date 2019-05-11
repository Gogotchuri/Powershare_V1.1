<template>
    <div>
        campaigns!
    </div>
</template>

<script>
    import HTTP from "@js/Common/Http.service";

    export default {
        name: "Campaigns",

        data(){
            return{
                categories: [],
                campaigns: []
            }
        },

        beforeRouteEnter(to, from, next) {
            //Fetching promises
            let categoryFetch = HTTP.GET("/campaign-categories");
            let campaignFetch = HTTP.GET("/admin/campaigns");
            Promise.all([categoryFetch, campaignFetch]).then(value => {
                let categories = value[0].data.data;
                let campaigns = value[1].data.data;
                next(vm => {
                    vm.setCategories(categories);
                    vm.setCampaigns(campaigns);
                })
            }).catch(err => {
                console.error(err);
                next();
            });
        },

        methods:{
            setCategories(categories){
                console.log("categories: ");
                console.log(categories);
                this.categories = categories;
            },

            setCampaigns(campaigns){
                console.log("campaigns: ");
                console.log(campaigns);
                this.campaigns = campaigns;
            }
        }
    }
</script>