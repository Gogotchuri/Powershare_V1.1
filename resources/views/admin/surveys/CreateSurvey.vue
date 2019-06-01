<template>
  <div class="test-survey-builder">
    <h2 class="text-center">Survey Builder</h2>
    <hr/>
    <div>
      <button type="button" v-on:click="storeSurvey">Store Survey</button>
    </div>
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
  name: 'TestSurveyBuilder',
  data() {
    return {
      surveyName: "",
      questionsList: [],
      addQuestion: false,
    };
  },
  mounted() {
    this.$root.$on('add-update-question', q => {
      this.updateQuestionsList(q);
      console.log(this.questionsList);
    });
  },
  components: { SurveyBuilder, QuestionsView },

  methods: {
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
    storeSurvey(){
      HTTP.POST("/admin/surveys", {
        "name" : this.surveyName,
        "json_body" : JSON.stringify(this.questionsList)
      }).then(value => {
        let returnedID = value.data.data.id;
        this.$router.push("/admin/surveys/"+returnedID);
        console.log(value.data);
      }).catch(reason => {
        console.log(this.surveyName);
        console.log(this.questionsList);
        console.log(reason.response.data);
      })
    }
  },
};
</script>

<style scoped>
.add_another_btn {
  font-size: 14px;
  background-color: transparent;
  border-color: #4c8ce4;
  color: #4c8ce4;
  padding: 8px;
  cursor: pointer;
}
.text-center {
  text-align: center;
}
</style>
