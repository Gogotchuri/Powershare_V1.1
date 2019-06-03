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
                questionsList:{}
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
