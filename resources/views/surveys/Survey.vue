<template>
  <div>
    <form @submit.prevent="submitSurvey">
    <div v-for="(question, index) in questions" :key="index">
      <div v-if="selectedQuestion.id === question.id">
        <SurveyBuilder :options="selectedQuestion"></SurveyBuilder>
      </div>
      <div v-if="selectedQuestion.id !== question.id">
        <div>
          <div>
            <div>
              <p>Question
                <span>{{ index + 1 }}:</span>
              </p>
              <p>{{question.body}}</p>
            </div>
            <div>
              <div v-if="question.type === 'TEXT'">
                <input type="text" v-model="question.answer" placeholder="" :readonly="readOnly" :required="question.required"/>
              </div>
              <div v-if="question.type === 'NUMBER'">
                <div>
                  <input type="number" v-model="question.answer" placeholder="" :readonly="readOnly" :required="question.required">
                  <span v-if="question.hasUnits">{{question.units}}</span>
                </div>
              </div>
              <div v-if="question.type === 'SINGLE_CHOICE'">
                <div v-for='(option, index) in question.options' :key="index">
                  <label>
                    <input type="radio" v-bind:value="option.body" v-model="question.answer"
                           v-on:change="" v-bind:name="question.id" :disabled="readOnly" :required="question.required">
                    &nbsp;{{option.body}}
                  </label>
                  <div class="" v-if="option.imageUrl">
                    <img :src="option.imageUrl" alt="" class="">
                  </div>
                </div>
              </div>
              <div v-if="question.type === 'MULTI_CHOICE'">
                <div v-for='(option, index) in question.options' :key="index">
                  <label>
                    <input type="checkbox" v-model="option.answer" :disabled="readOnly">&nbsp;
                      {{option.body}}
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div v-if="editable">
            <button type="button" v-on:click="editQuestion(question, index)">{{$t("words.edit")}}</button>
            <button type="button" v-on:click="deleteQuestion(question, index)">{{$t("words.delete")}}</button>
          </div>
        </div>
      </div>
      <br>
    </div>
    <input v-if="submittable" type="submit">
    </form>
  </div>
</template>

<script>
    import SurveyBuilder from '@views/surveys/SurveyBuilder';

    export default {
        name: 'Survey',
        data() {
            return {
                selectedQuestion: { id: null },
            };
        },

        props: ['questions', 'readOnly', 'editable', 'submittable'],

        components: { SurveyBuilder},

        mounted() {
            this.$root.$on('selected-question', () => {
                this.selectedQuestion = { id: null };
            });
        },
        methods: {
            editQuestion(question, index) {
                this.selectedQuestion = JSON.parse(JSON.stringify(question));
                this.selectedQuestion.questionNumber = index + 1;
            },
            deleteQuestion(question, index) {
                this.questions.splice(index, 1);
            },
            submitSurvey(){
                this.$emit("submitted", JSON.stringify(this.questions));
            }
        },
    };
</script>

