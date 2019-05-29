<template>
    <div>
        <p>Please Fill in The Following survey</p>
        <br>
        <questions-view :questions="questionsList" :readOnly="false"
            :editable="false" :submitable="true"/>
    </div>
</template>

<script>
    import QuestionsView from "@views/surveys/Survey";

    export default {
        name: "ShowSurvey",
        data(){
            return {
                questionsList: JSON.parse('[{"id":"a136c244-2ae4-c13f-4c70-60dd9714fca8","question":null,"type":"BOOLEAN","multiSelect":false,"characterLimited":false,"hasMinMax":false,"allowDecimals":false,"sequence":null,"minValue":1,"maxValue":8,"labels":[],"dateFormat":"MM/DD/YYYY","timeFormat":"12","intervals":2,"textLimit":1024,"units":null,"options":[{"body":"Yes","sequence":1},{"body":"No","sequence":2}],"body":"This is the question?"},{"id":"958d1442-13bd-3f96-ea6f-d741b5e1d8d1","question":null,"type":"NUMBER","multiSelect":false,"characterLimited":false,"hasMinMax":false,"allowDecimals":false,"sequence":null,"minValue":1,"maxValue":8,"labels":[],"dateFormat":"MM/DD/YYYY","timeFormat":"12","intervals":2,"textLimit":1024,"units":null,"options":[{"body":null,"sequence":1},{"body":null,"sequence":2}],"body":"Year?"},{"id":"e073ef73-bee5-2ad7-fe25-cab73db5da29","question":null,"type":"TEXT","multiSelect":false,"characterLimited":false,"hasMinMax":false,"allowDecimals":false,"sequence":null,"minValue":1,"maxValue":8,"labels":[],"dateFormat":"MM/DD/YYYY","timeFormat":"12","intervals":2,"textLimit":1024,"units":null,"options":[{"body":null,"sequence":1},{"body":null,"sequence":2}],"body":"What about you?"}]'),
            }
        },
        components: {QuestionsView},
        computed: {
            id(){
                return this.$route.params.id;
            }
        },
        methods:{
            submitSurvey(data){
                console.log("Survey Submission isn't handled -- " + data);
                //TODO need to implement controllers and connect it to thoese
            }
        },

        mounted(){
            //TODO need to also implement random fetching logic in the backend
            this.$root.$on("survey-submitted", data => this.submitSurvey(data));
        }
}
</script>
