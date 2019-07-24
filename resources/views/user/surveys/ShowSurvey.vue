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
            let token = to.query.recaptcha_token;
            HTTP.GET("/user/survey", {token})
                .then(value => {
                    let questions = value.data.data.json_body;
                    let survey_id = value.data.data.id;
                    next(vm => {
                        vm.surveyID = survey_id;
                        vm.questionsList = JSON.parse(questions);
                    });
                })
                .catch(reason => {
                    const status = reason.response.status;
                    let msg = "";
                    switch (status) {
                        case 400:
                            msg = "Captcha validation has failed, refresh and try again...";
                            break;
                        case 404:
                            msg = "No surveys are available for now";
                            break;
                    }

                    window.alert(msg);
                    //if user wasn't navigating using router links
                    if(from.name == null)
                        next({name: "Home"});
                    else
                        next(false);
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
