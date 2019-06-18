<template>
    <div v-if="surveys">
        <input type="button" value="Create Survey" @click="$router.push({name: 'Admin.CreateSurvey'})">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Advertiser</th>
                <th>Date</th>
                <th>Filled</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <tr v-for="survey in surveys">
                <td>{{survey.id}}</td>
                <td>{{survey.name}}</td>
                <td>{{survey.advertiser.name}}</td>
                <td>{{survey.creation_date}}</td>
                <td>{{survey.num_filled}}</td>
                <td>
                    <p v-if="survey.is_active" style="color: green">Active</p>
                    <p v-else style="color: red">Completed</p>
                </td>
                <td>
                    <input @click="deleteSurvey(survey.id)" type="button" value="DELETE" style="color: red">
                    <input @click="goToEdit(survey.id)" type="button" value="EDIT" style="color: yellow">
                    <input @click="changeSurveyStatus(survey)" type="button"
                           :value="survey.is_active ? 'Complete' : 'Activate'" style="color: deeppink">
                </td>
            </tr>
        </table>
    </div>
    <div v-else>
        No Surveys yet
        <router-link :to="{name: 'Admin.Surveys.Create'}">Create Survey</router-link>
    </div>
</template>

<script>
    import HTTP from "@js/Common/Http.service";
    export default {
        name: "Surveys",
        data(){
          return {
            surveys: null
          };
        },
        beforeRouteEnter(to, from, next){
            HTTP.GET("/admin/surveys")
                .then(res => {
                    let surveys = res.data.data;
                    next(vm => vm.surveys = surveys);
                }).catch(err => {
                    console.error(err.response);
                    next();
                })
        },
        methods: {
            deleteSurvey(id){
                HTTP.DELETE("/admin/surveys/"+id)
                    .then(() => {
                        window.alert("Survey Deleted!");
                        this.surveys = this.surveys.filter(s => s.id !== id);
                    })
                    .catch(err => {
                        console.error(err);
                        console.error(err.response);
                        window.alert("Survey couldn't be deleted!");
                    })
            },
            goToEdit(id){
               this.$router.push("/admin/surveys/"+id);
            },
            changeSurveyStatus(survey){
                HTTP.POST("/admin/surveys/"+survey.id+"/change-status")
                    .then(() => {
                        window.alert("Survey status changes");
                        survey.is_active = !survey.is_active;
                    }).catch(err => {
                        console.error(err);
                        console.error(err.response);
                        window.alert("Survey status couldn't be changed!");
                    })
            }
        }
    }
</script>

<style scoped>

</style>