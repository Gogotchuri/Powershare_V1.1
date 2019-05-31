<template>
    <div>
        <questions-view :questions="questionsList" :readOnly="false"
            :editable="false" :submittable="true" v-on:submitted="submitSurvey"/>
    </div>
</template>

<script>
    import QuestionsView from "@views/surveys/Survey";
    import HTTP from "@js/Common/Http.service";
    export default {
        name: "ShowSurvey",
        data(){
            return {
                surveyID: 0,
                questionsList: JSON.parse('[{"id":"2b48ce74-88a1-2de9-2bf9-16fc94d2bfdf","type":"NUMBER","characterLimited":false,"hasMinMax":true,"allowDecimals":false,"minValue":1,"maxValue":"15","textLimit":1024,"units":"days","options":[{"body":null,"sequence":1},{"body":null,"sequence":2}],"body":"How many days?","hasUnits":true},{"id":"a35be5b0-d67d-5895-f118-8bbfd3689d22","type":"MULTI_CHOICE","characterLimited":false,"hasMinMax":false,"allowDecimals":false,"minValue":1,"maxValue":8,"textLimit":1024,"units":null,"options":[{"body":"first option!","sequence":1},{"body":"second one","sequence":2}],"body":"Second question!"},{"id":"d6730c57-6e19-d575-f1aa-486995ebc94e","type":"SINGLE_CHOICE","characterLimited":false,"hasMinMax":false,"allowDecimals":false,"minValue":1,"maxValue":8,"textLimit":1024,"units":null,"options":[{"body":"red","sequence":1},{"body":"BLUE","sequence":2}],"body":"you can only choose one, be wise"},{"id":"06b7bad5-1882-997f-ceba-dbe9bc4881d5","type":"TEXT","characterLimited":true,"hasMinMax":false,"allowDecimals":false,"minValue":1,"maxValue":8,"textLimit":1024,"units":null,"options":[{"body":null,"sequence":1},{"body":null,"sequence":2}],"body":"Here you are supposed to enter text, but be limited!"}]'),
            }
        },
        components: {QuestionsView},
        computed: {
            id(){
                return this.$route.params.id;
            }
        },
        beforeRouteEnter(to, from, next) {
            HTTP.GET("/user/survey")
                .then(value => {
                    let questions = value.data.data.survey.json_body;
                    console.log("survey:");
                    console.log(value.data);
                    next(vm => {
                        vm.questionsList = JSON.parse(questions);
                    });
                })
                .catch(reason => {
                    console.error("something went wrong during survey fetch!");
                    console.error(reason);
                    next();
                });
        },
        methods:{
            submitSurvey(data){
                let campaign_id = this.$route.query.campaign_id;
                console.log(this.$route.params);
                if(campaign_id == null)
                    campaign_id = "0";
                console.log(data);
                HTTP.POST("/campaigns/"+ campaign_id +"/survey", {
                    "name" : "Doesn't matter at all!",
                    "survey_data" : JSON.stringify(this.questionsList),
                })
                    .then(() => {
                        console.log("survey submitted");
                    })
                    .catch(reason => {
                        console.error("error while submitting survey!");
                        console.error(reason);
                    });
            }
        }
}
</script>
