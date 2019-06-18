<template>
    <div>
        <input type="button" value="Create Video Ad" @click="$router.push({name: 'Admin.VideoAds.Create'})">
        <p v-if="videos != null && videos.length > 0">Video ads</p>
        <p v-else>No Ad Found</p>
        <table v-if="videos != null && videos.length > 0">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Video</th>
                <th>Forward</th>
                <th>Duration</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <tr v-for="video in videos">
                <td>{{video.id}}</td>
                <td>{{video.name}}</td>
                <td>{{video.video_url}}</td>
                <td>{{video.forward_url}}</td>
                <td>{{video.required_duration}} sec</td>
                <td>
                    <p v-if="video.is_active" style="color: green">Active</p>
                    <p v-else style="color: red">Completed</p>
                </td>
                <td>
                    <input type="button" value="DELETE" style="color: red" @click="deleteVideo(video.id)">
                    <input type="button" value="EDIT" style="color: yellow"
                           @click="$router.push('/admin/video-ads/' + video.id)">
                    <input @click="changeVideoStatus(video)" type="button"
                           :value="video.is_active ? 'Complete' : 'Activate'" style="color: deeppink">
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
    import HTTP from "@js/Common/Http.service";
    export default {
        name: "VideoAds",
        data(){
            return {
                videos: null
            }
        },
        beforeRouteEnter(to, from, next){
            HTTP.GET("/admin/video-ads")
                .then(res => {
                    let videos = res.data.data;
                    next(vm => vm.videos = videos);
                }).catch(err =>{
                    console.error(err);
                    console.error(err.response);
                    next();
            })
        },
        methods:{
            deleteVideo(id){
                HTTP.DELETE("/admin/video-ads/"+id)
                    .then(() => {
                        window.alert("Ad successfully Deleted!");
                        this.videos = this.videos.filter(v => v.id != id);
                    }).catch(err => {
                        window.alert("Ad couldn't be deleted!");
                        console.error(err);
                    })
            },
            changeVideoStatus(video){
                HTTP.POST("/admin/video-ads/"+video.id+"/change-status")
                    .then(() => {
                        window.alert("Video status changed!");
                        video.is_active = !video.is_active;
                    }).catch(err => {
                        console.error(err);
                        console.error(err.response);
                        window.alert("Video status couldn't be changed!");
                    })
            }
        }
    }
</script>

<style scoped>

</style>