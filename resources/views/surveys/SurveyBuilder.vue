<template>
  <div>
    <select v-model="selectedType" v-on:change="questionTypeChanged(selectedType)">
      <option v-for="(questionType, index) in questionTypes" :value="questionType.value" :key="index" :disabled="questionType.value === 'DEFAULT'" :selected="questionType.value === 'DEFAULT'">{{questionType.label}}</option>
    </select>
    <div v-if="selectedType !== 'DEFAULT'">
      <div>
        <div>Question</div>
        <input type="text" placeholder="Enter question text" v-model="question.body">
      </div>
      <div v-if="selectedType === 'BOOLEAN'">
        <div>Answer Choices</div>
        <div v-for="(option, index) in question.options" :key="index">
          <div>
            <input type="text" placeholder="Enter an answer choice" v-model="option.body">
            <button v-on:click="deleteQuestionOptionItem(question.options, index)" v-if="index > 1">Remove</button>
          </div>
        </div>
      </div>
      <div v-if="selectedType === 'DATE'">
        <div>
          <label><input type="radio" v-model="question.dateFormat" value="MM/DD/YY"> MM/DD/YY</label>
          <label><input type="radio" v-model="question.dateFormat" value="DD/MM/YY"> DD/MM/YY</label>
          <label><input type="radio" v-model="question.dateFormat" value="MM/DD/YYYY"> MM/DD/YYYY</label>
          <label><input type="radio" v-model="question.dateFormat" value="DD/MM/YYYY"> DD/MM/YYYY</label>
        </div>
      </div>
      <div v-if="selectedType === 'MULTI_CHOICE'">
        <div>Answer Choices</div>
        <div v-for="(option, index) in question.options" :key="index">
          <div>
            <input type="text" placeholder="Enter an answer choice" v-model="option.body">
            <button v-on:click="deleteQuestionOptionItem(question.options, index)" v-if="index > 1">Remove</button>
          </div>
        </div>
        <div>
          <button v-on:click="addAnotherAnswer()">Add another answer</button>
        </div>
      </div>

      <div v-if="selectedType === 'NUMBER'">
        <label>
          <input type="checkbox" v-model="question.hasUnits" name="hasUnits" />
          <span>Answer label <input type="text" placeholder="ex. mins, lbs, days" v-model="question.units" :disabled="!question.hasUnits"></span>
        </label>
        <label>
          <input type="checkbox" v-model="question.hasMinMax" name="subType" />
          <span>Min/max value
            <input type="number" v-model="question.minValue" placeholder="min" min="1" max="2048" :disabled="!question.hasMinMax">
            <span>to</span>
            <input type="number" v-model="question.maxValue" placeholder="max" min="1" max="2048" :disabled="!question.hasMinMax">
          </span>
        </label>
        <label>
          <input type="checkbox" v-model="question.allowDecimals" value="Single" name="subType" />
          <span>Allow decimals</span>
        </label>
      </div>
      <div v-if="selectedType === 'SINGLE_CHOICE'">
        <div>Answer Choices</div>
        <div v-for="(option, index) in question.options" :key="index">
          <div>
            <input type="text" placeholder="Enter an answer choice" v-model="option.body">
            <button v-on:click="deleteQuestionOptionItem(question.options, index)" v-if="index > 1">Remove</button>
          </div>
        </div>
        <div>
          <button v-on:click="addAnotherAnswer()">Add another answer</button>
        </div>
      </div>
      <div v-if="selectedType === 'TEXT'">
        <label>
          <input type="checkbox" v-model="question.characterLimited" name="characterLimited" />
          <span>Character limit <input type="number" v-model="question.textLimit" placeholder="" min="1" max="2048" :disabled="!question.characterLimited"></span>
        </label>
      </div>
      <div v-if="selectedType === 'TIME'">
        <div>
          <label><input type="radio" v-model="question.timeFormat" value="12" v-on:click="timeFormatModified(question.timeFormat)"> 12 hrs</label>
          <label><input type="radio" v-model="question.timeFormat" value="24" v-on:click="timeFormatModified(question.timeFormat)"> 24 hrs</label>
        </div>
      </div>
      <div>
        <button type="button" @click="saveQuestion(question)">Save</button>
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
        { value: 'BOOLEAN', label: 'Yes or No' },
        { value: 'DATE', label: 'Date' },
        { value: 'MULTI_CHOICE', label: 'Multiple Choice' },
        { value: 'NUMBER', label: 'Number' },
        { value: 'SINGLE_CHOICE', label: 'Single Choice' },
        { value: 'TEXT', label: 'Text' },
        { value: 'TIME', label: 'Time' },
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
      switch (type) {
        case 'BOOLEAN':
          this.question.options = [{ body: 'Yes', sequence: 1 }, { body: 'No', sequence: 2 }];
          break;
        default:
          break;
      }
    },

    /**
     * @param {String} format
     * @return {null}
     */
    timeFormatModified(format) {
      window.console.log(format);
    },

    /**
     * @param {null}
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
     * @param {null}
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
    },

    /**
     * @param {Number} intervals
     * @return {null}
     */
    changeLabelsLength(intervals) {
      this.question.labels.length = intervals;
    },
  },
};
</script>
