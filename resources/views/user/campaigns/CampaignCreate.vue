<template>
    <div class="create-campaign">
        <h2>{{$t("snippets.create-campaign")}}</h2>
        <form @submit.prevent="storeCampaign">
            <div>
                <label for = "campaign-name">{{$t("snippets.campaign-name")}} <br> ({{$t("snippets.max-chars", ["30"])}})</label>
                <input id = "campaign-name"
                       type = "text" 
                       v-model="campaignName"
                       :placeholder = "$t('snippets.fill-form')"
                       maxlength = "30"
                       required
                />
            </div>
            <div>
                <label for="category-select">{{$t("snippets.choose-category")}}</label>
                <select id="category-select" type="text" class="category" v-model="curCategory">
                    <option value="0" disabled>{{$t("titles.all-categories")}}</option>
                    <option v-for="category in categories" :value="category.id">{{category.name}}</option>
                </select>
            </div>
            <div>
                <label for="short-description">{{$t("snippets.description")}} ({{$t("snippets.max-chars", ["200"])}})</label>
                <br>
                <textarea id="short-description"
                          :placeholder="$t('snippets.about-campaign')"
                          v-model="campaignDesc"
                          maxlength="200"
                          rows="5"
                          required>
                </textarea>
            </div>
            <button type="submit" @click="continueEdit=true">{{$t("snippets.continue")}}</button>
            <button type="submit">{{$t("snippets.save-draft")}}</button>
        </form>
    </div>
</template>

<script>
    import HTTP from "@js/Common/Http.service"
    export default {
        name: "CampaignCreate",
        data(){
            return {
                categories: [],
                curCategory: 0,
                campaignName: "",
                campaignDesc: "",
                continueEdit: false
            }
        },
        beforeRouteEnter(to, from, next){
            HTTP.GET("/campaign-categories")
                .then(value => next(vm => vm.categories = value.data.data))
                .catch(err => {
                    console.error(err.response);
                    next();
                })
        },
        methods:{
            storeCampaign(){
                let catId = this.curCategory ? this.curCategory : 1;
                var campaign_id = 0;
                HTTP.POST("/user/campaigns", {
                    "name": this.campaignName,
                    "category_id": catId,
                    "description": this.campaignDesc
                }).then(res => campaign_id = res.data.data.id).catch(r => {
                    console.error("Error Submitting campaign!");
                    console.error(r.response);
                }).finally(() => {
                    if (this.continueEdit)
                        this.$router.push("/user/campaigns/" + campaign_id + "/edit");
                    else
                        this.$router.push({name: "User.Campaigns"});
                });
            }
        }
    }
</script>

<style scoped>
    form{
        width: 100%;
    }
    form > div{
        width: 100%;
    }
    form > div > input{
        width: 70%;
    }
</style>
