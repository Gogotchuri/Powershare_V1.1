<template>
    <div v-if="surveyLimit">You can't have anymore surveys for today, come back tomorrow.</div>
    <div v-else-if="noMoreSurveys">There are no more surveys available, you have filled all! come back later!</div>
    <div v-else>
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
                surveyLimit: false,
                noMoreSurveys: false,
                questionsList: null
            }
        },
        components: {QuestionsView},
        beforeRouteEnter(to, from, next) {
            HTTP.GET("/user/survey")
                .then(value => {
                    let questions = value.data.data.json_body;
                    let survey_id = value.data.data.id;
                    console.log("survey:");
                    console.log(value.data);
                    next(vm => {
                        vm.surveyID = survey_id;
                        vm.questionsList = JSON.parse(questions);
                    });
                })
                .catch(reason => {
                    console.error("something went wrong during survey fetch!");
                    console.error(reason.response.data.errors);
                    next(vm => {
                        if (reason.response.status === 404)
                            vm.noMoreSurveys = true;
                    });
                });
        },
        methods:{
            submitSurvey(data){
                let campaign_id = this.$route.query.campaign_id;
                if(campaign_id == null)
                    campaign_id = "0";
                HTTP.POST("/campaigns/"+ campaign_id +"/survey", {
                    "survey_id" : this.surveyID,
                    "survey_data" : data,
                }).then(() => {
                        window.alert("Survey Submitted, thank you for helping!");
                        this.$router.push("/campaigns/"+campaign_id);
                    })
                    .catch(reason => {
                        console.error("error while submitting survey!");
                        console.error(reason);
                    });
            }
        }
}
</script>
