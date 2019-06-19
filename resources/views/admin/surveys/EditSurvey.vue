<template>
    <div v-if="questionsList == null || notFound">Nothing fetched</div>
    <div v-else class="test-survey-builder">
        <h2 class="text-center">Survey Builder</h2>
        <hr/>
        <div>
            <button type="button" v-on:click="updateSurvey">Update Survey</button>
            <button type="button" v-on:click="deleteSurvey">Delete Survey</button>
        </div>
        <br>
        <label v-if="!addNewAdvertiser">
            Choose Advertiser
            <select type="text" class="category" v-model="advertiser_id">
                <option v-for="advertiser in advertisers" :value="advertiser.id">{{advertiser.name}}</option>
            </select>
            or
        </label>
        <input v-if="!addNewAdvertiser" type="button" value="Add new Advertiser" @click="addNewAdvertiser = true">
        <create-advertiser v-if="addNewAdvertiser" v-on:AdvertiserAdded="addAdvertiser"></create-advertiser>
        <br>
        <label>
            Survey Name:
            <input type="text" v-model="surveyName">
        </label>
        <questions-view :questions="questionsList" :readOnly="true" :editable="true"/>
        <div v-if="addQuestion">
            <survey-builder :options="sampleQuestion" />
        </div>
        <div class="pt-10">
            <button type="button" class="add_another_btn br-25" v-on:click="addNewQuestion()">Add question</button>
        </div>
    </div>
</template>

<script>
    import SurveyBuilder from "@views/surveys/SurveyBuilder";
    import QuestionsView from "@views/surveys/Survey";
    import sampleQuestionObj from "@views/surveys/survey-structure.json"
    import HTTP from "@js/Common/Http.service";

    export default {
        name: "EditSurvey",
        data(){
          return {
              notFound: true,
              surveyID: 0,
              advertiser_id: 0,
              surveyName: "",
              questionsList: [],
              addQuestion: false,
              addNewAdvertiser: false,
              advertisers: []
          };
        },
        components: {SurveyBuilder, QuestionsView},
        computed: {
            id(){
                return this.$route.params.id;
            }
        },
        mounted(){
            this.fetchAdvertisers();
            this.$root.$on('add-update-question', q => {
                this.updateQuestionsList(q);
            });
        },
        beforeRouteEnter(to, from, next){
            HTTP.GET("/admin/surveys/"+to.params.id)
                .then(value => {
                    let adv_id = value.data.data.advertiser.id;
                    let id = value.data.data.id;
                    let name = value.data.data.name;
                    let list = JSON.parse(value.data.data.json_body);
                    next(vm => {
                        vm.questionsList = list;
                        vm.surveyID = id;
                        vm.surveyName = name;
                        vm.notFound = false;
                        vm.advertiser_id = adv_id;
                    });
                }).catch((e) => {
                    console.error(e.response);
                    next();
                });
        },
        methods:{
            updateQuestionsList(question) {
                const questionIndex = this.questionsList.findIndex(x => x.id === question.id);
                if (questionIndex >= 0) {
                    this.questionsList.splice(questionIndex, 1, question);
                } else {
                    this.questionsList.push(JSON.parse(JSON.stringify(question)));
                }
                this.addQuestion = false;
                this.$root.$emit('selected-question', null);
            },

            addNewQuestion() {
                this.sampleQuestion = JSON.parse(JSON.stringify(sampleQuestionObj));
                this.addQuestion = true;
            },
            updateSurvey(){
                HTTP.PUT("/admin/surveys/" + this.surveyID, {
                    "name" : this.surveyName,
                    "json_body" : JSON.stringify(this.questionsList),
                    "advertiser_id": this.advertiser_id
                }).then(() => {
                    window.alert("Successfully updated!");
                }).catch(reason => {
                    window.alert("Couldn't update. We are sorry :(");
                    console.log(reason);
                })
            },
            deleteSurvey(){
                HTTP.DELETE("/admin/surveys/" + this.surveyID)
                    .then(() => {
                        window.alert("Successfully Deleted!");
                        this.$router.push({name: "Admin.Surveys"});
                    }).catch(reason => {
                        window.alert("Couldn't delete. We are sorry :(");
                        console.log(reason);
                    })
            },
            fetchAdvertisers(){
                HTTP.GET("/admin/advertisers")
                    .then(res => this.advertisers = res.data.data)
                    .catch(err => console.error(err));
            },
            addAdvertiser(advertiser){
                this.advertisers.push(advertiser);
                this.advertiser_id = advertiser.id;
                this.addNewAdvertiser = false;
            },
        }
    }
</script>

<style scoped>

</style>