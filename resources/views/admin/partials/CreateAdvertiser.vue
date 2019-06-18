<template>
    <div>
        <form @submit.prevent="addAdvertiser">
            <label>
                Advertiser name:
                <input type="text" v-model="advertiser.name" required>
            </label>
            <br>
            <label>
                Advertiser email:
                <input type="email" v-model="advertiser.email">
            </label>
            <br>
            <label>
                Advertiser phone number:
                <input type="text" v-model="advertiser.phone_number">
            </label>
            <br>
            <button type="submit">Store Advertiser</button>
        </form>
    </div>
</template>

<script>
    import HTTP from "@js/Common/Http.service";

    export default {
        name: "CreateAdvertiser",
        data(){
            return {
                advertiser: {"kkk" : "Adver"}
            }
        },
        methods: {
            addAdvertiser(){
                HTTP.POST("/admin/advertisers", this.advertiser)
                    .then(res => {
                        let advertiser = res.data.data;
                        window.alert("Advertiser added to list, you can choose now!");
                        this.$emit("AdvertiserAdded", advertiser);
                    }).catch(err => console.error(err));
            }
        }
    }
</script>

<style scoped>

</style>