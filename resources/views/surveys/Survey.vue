<template>
  <div>
    <div v-for="(question, index) in questions" :key="index">
      <div v-if="selectedQuestion.id === question.id">
        <SurveyBuilder :options="selectedQuestion"></SurveyBuilder>
      </div>
      <div v-if="selectedQuestion.id !== question.id">
        <div>
          <div>
            <div>
              <p>Question
                <span class="">{{ index + 1 }}:</span>
              </p>
              <p>{{question.body}}</p>
            </div>
            <div>
              <div v-if="question.type === 'BOOLEAN'">
                <div class="" v-for='(option, index) in question.options' :key="index">
                  <p>
                    <input type="radio" name="boolean_type" :disabled="readOnly">
                    <label>{{option.body}}</label>
                  </p>
                </div>
              </div>
              <div v-if="question.type === 'TEXT'">
                <input type="text" placeholder="" :readonly="readOnly" />
              </div>
              <div v-if="question.type === 'DATE'">
                <div>
                  <input type="text" placeholder="" v-model="question.dateFormat" :readonly="readOnly">
                </div>
              </div>
              <div v-if="question.type === 'TIME'">
                <div>
                  <input type="text" placeholder="" :value="question.timeFormat === '12' ? 'HH:MM AM/PM':'HH:MM'" :readonly="readOnly">
                </div>
              </div>
              <div v-if="question.type === 'NUMBER'">
                <div class="">
                  <input type="text" placeholder="" :readonly="readOnly">
                  <span v-if="question.hasUnits">{{question.units}}</span>
                </div>
              </div>
              <div v-if="question.type === 'SINGLE_CHOICE'">
                <div v-for='(option, index) in question.options' :key="index">
                  <label>
                    <input type="radio" name="single" :disabled="readOnly">&nbsp;{{option.body}}
                  </label>
                  <div class="" v-if="option.imageUrl">
                    <img :src="option.imageUrl" alt="" class="">
                  </div>
                </div>
              </div>
              <div v-if="question.type === 'MULTI_CHOICE'">
                <div v-for='(option, index) in question.options' :key="index">
                  <label>
                    <input type="checkbox" :disabled="readOnly">&nbsp;{{option.body}}
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div>
            <button type="button" v-on:click="editQuestion(question, index)">Edit</button>
            <button type="button" v-on:click="deleteQuestion(question, index)">Delete</button>
          </div>
        </div>
      </div>
      <br>
    </div>
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

        props: ['questions', 'readOnly'],
        
        components: { SurveyBuilder},

        mounted() {
            this.$root.$on('selected-question', obj => {
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
        },
    };
</script>

