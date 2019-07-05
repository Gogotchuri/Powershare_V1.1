<template>
  <div class="test-survey-builder">
    <h2 class="text-center">Survey Builder</h2>
    <hr/>
    <div>
      <button type="button" v-on:click="storeSurvey">Store Survey</button>
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
    <br>
    <label>
      Unit price:
      <input type="number" v-model="unitPrice">
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
import CreateAdvertiser from "@views/admin/partials/CreateAdvertiser";
import QuestionsView from "@views/surveys/Survey";
import sampleQuestionObj from "@views/surveys/survey-structure.json"
import HTTP from "@js/Common/Http.service";

export default {
  name: 'CreateSurvey',
  data() {
    return {
      surveyName: "",
      unitPrice: 0,
      questionsList: [],
      addQuestion: false,
      addNewAdvertiser: false,
      advertiser_id : 1,
      advertisers: []
    };
  },

  components: {CreateAdvertiser, SurveyBuilder, QuestionsView },

  mounted() {
    this.fetchAdvertisers();
    this.$root.$on('add-update-question', q => {
      this.updateQuestionsList(q);
    });
  },

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
        "unit_price": this.unitPrice,
        "json_body" : JSON.stringify(this.questionsList),
        "advertiser_id" : this.advertiser_id
      }).then(value => {
        let returnedID = value.data.data.id;
        this.$router.push("/admin/surveys/"+returnedID);
      }).catch(reason => {
        console.error(reason.response.data);
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
