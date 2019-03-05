<template>
    <div>
        Name {{name}}
        <br>
        Email {{email}}
    </div>
</template>

<script>
    import ApiService from "../../js/common/ApiService.js";
    import {get} from "../../js/common/ApiService.js";

    export default {
        name: "Profile",
        data() {
            return {
                email: "",
                name: ""
            }
        },

        mounted() {
            get("user")
            .then(response => {
                this.name = response.data.success.name;
                this.email = response.data.success.email;
            });
        }
    }
</script>