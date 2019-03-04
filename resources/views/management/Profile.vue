<template>
    <div>
        <li v-on:click="getProfile">Profile</li>
    </div>
</template>

<script>
    import ApiService from "../../js/common/ApiService.js";

    export default {
        methods: {
            getProfile(){
                ApiService.get("user")
                .then(response => {
                    console.log(response);
                });
            },
        }
    }
</script>