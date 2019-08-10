<template>
  <div>
    <select v-model="selectedType" v-on:change="questionTypeChanged(selectedType)">
      <option v-for="(questionType, index) in questionTypes" :value="questionType.value" :key="index" :disabled="questionType.value === 'DEFAULT'" :selected="questionType.value === 'DEFAULT'">{{questionType.label}}</option>
    </select>
    <div v-if="selectedType !== 'DEFAULT'">
      <div>
        <div>{{$t("words.question")}}</div>
        <input type="text" placeholder="Enter question text" v-model="question.body">
      </div>
      <div class="" v-if="selectedType === 'NUMBER'">
        <label>
          <input type="checkbox" v-model="question.hasUnits" name="hasUnits" />
          <span>{{$t("texts.surveybuilder.answer-lb")}}<input type="text" class="width-10" placeholder="ex. mins, lbs, days" v-model="question.units" :disabled="!question.hasUnits"></span>
        </label>
        <label>
          <input type="checkbox" v-model="question.hasMinMax" name="subType" />
          <span>{{$t("texts.surveybuilder.min-max")}}
            <input type="number" class="width-10" v-model="question.minValue" placeholder="min" min="1" max="2048" :disabled="!question.hasMinMax">
            <span class="width-10">to</span>
            <input type="number" class="width-10" v-model="question.maxValue" placeholder="max" min="1" max="2048" :disabled="!question.hasMinMax">
          </span>
        </label>
        <label>
          <input type="checkbox" v-model="question.allowDecimals" value="Single" name="subType" />
          <span class="">{{$t("texts.surveybuilder.allow-dc")}}</span>
        </label>
        <label>
          <input type="checkbox" v-model="question.required" value="Single" name="subType" />
          <span class="">{{$t("words.required")}}</span>
        </label>
      </div>
      <div v-if="selectedType === 'MULTI_CHOICE'">
        <div>{{$t("texts.surveybuilder.answer-choice")}}</div>
        <div v-for="(option, index) in question.options" :key="index">
          <div>
            <input type="text" placeholder="Enter an answer choice" v-model="option.body">
            <button v-on:click="deleteQuestionOptionItem(question.options, index)" v-if="index > 1">{{$t("words.remove")}}</button>
          </div>
        </div>
        <div>
          <button v-on:click="addAnotherAnswer()">{{$t("texts.surveybuilder.add-answer")}}</button>
        </div>
        <label>
          <input type="checkbox" v-model="question.required" value="Single" name="subType" />
          <span class="">{{$t("words.required")}}</span>
        </label>
      </div>
      <div v-if="selectedType === 'SINGLE_CHOICE'">
        <div>{{$t("texts.surveybuilder.answer-choice")}}</div>
        <div v-for="(option, index) in question.options" :key="index">
          <div>
            <input type="text" placeholder="Enter an answer choice" v-model="option.body">
            <button v-on:click="deleteQuestionOptionItem(question.options, index)" v-if="index > 1">{{$t("words.remove")}}</button>
          </div>
        </div>
        <div>
          <button v-on:click="addAnotherAnswer()">{{$t("texts.surveybuilder.add-answer")}}</button>
        </div>
        <label>
          <input type="checkbox" v-model="question.required" value="Single" name="subType" />
          <span class="">{{$t("words.required")}}</span>
        </label>
      </div>
      <div v-if="selectedType === 'TEXT'">
        <label>
          <input type="checkbox" v-model="question.characterLimited" name="characterLimited" />
          <span>{{$t("snippets.char-limit")}} <input type="number" v-model="question.textLimit" placeholder="" min="1" max="2048" :disabled="!question.characterLimited"></span>
        </label>
        <label>
          <input type="checkbox" v-model="question.required" value="Single" name="subType" />
          <span class="">{{$t("words.required")}}</span>
        </label>
      </div>
      <div>
        <button type="button" @click="saveQuestion(question)">{{$t("words.save")}}</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SurveyBuilder',
  data() {
    return {
      questionTypes: [
        { value: 'DEFAULT', label: '- Select a question type -' },
        { value: 'NUMBER', label: 'Number' },
        { value: 'MULTI_CHOICE', label: 'Multiple Choice' },
        { value: 'SINGLE_CHOICE', label: 'Single Choice' },
        { value: 'TEXT', label: 'Text' },
      ],
      question: this.options,
      selectedType: null,
    };
  },
  props: ['options'],
  
  mounted() {
    this.question.type = this.question.type ? this.question.type : 'DEFAULT';
    this.selectedType = this.question.type;
  },

  methods: {
    /**
     * @desc {String} type
     * @param {String} type
     * @return {null}
     */
    questionTypeChanged(type) {
      this.question.type = this.selectedType;
    },

    /**
     * @return {null}
     */
    addAnotherAnswer() {
      if (!this.question.options) {
        this.question.options = [];
      }
      let maxSequence = Number(Math.max(...this.question.options.map(x => x.sequence)));
      if (!maxSequence) {
        maxSequence = this.question.options.length;
      }
      this.question.options.push({ body: null, sequence: maxSequence + 1, nextQuestion: null, imageUrl: null }); // eslint-disable-line
      this.$forceUpdate();
    },

    /**
     * @param {Object, Number}  options, index
     * @return {null}
     */
    deleteQuestionOptionItem(options, index) {
      this.question.options.splice(index, 1);
    },

    /**
     * @return {String} guid
     */
    getGUID() {
      function s4() {
        return Math.floor((1 + Math.random()) * 0x10000)
          .toString(16)
          .substring(1);
      }
      return `${s4() + s4()}-${s4()}-${s4()}-${s4()}-${s4() + s4() + s4()}`;
    },

    /**
     * @param {Object} question
     * @return {null}
     */
    saveQuestion(question) {
      question.id = question.id ? question.id : this.getGUID(); // eslint-disable-line
      this.$root.$emit('add-update-question', question);
      this.question = { type: 'DEFAULT' };
    }
  },
};
</script>
