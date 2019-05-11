<template>
    <div id="container">
        This is a FAQ page!
    </div>
</template>

<script>
    import HTTP from "@js/Common/Http.service";
    export default {
        name: "Faq",
        data(){
            return {
                QNA: []
            }
        },

        async beforeRouteEnter(to, from, next){
            try {
                let qnaRes = await HTTP.GET("/faq");
                next(vm => vm.setQNA(qnaRes.data.data));
            }catch (e) {
                console.error(e);
                next();
            }
        },

        methods: {
            setQNA(QNA){
                console.log(QNA);
                this.QNA = QNA;
            }
        }
    }
</script>
