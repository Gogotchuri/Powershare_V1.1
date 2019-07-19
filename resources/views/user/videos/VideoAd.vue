<template>
    <div v-if="videoAd">
        <p v-if="counter < videoAd.required_duration">
            {{counter}} seconds
        </p>
        <p v-else>
            <input type="button" value="submit!" @click="submitWatched">
        </p>
        <video id="player" @click="goToPage" style="cursor: pointer" width="600" height="400">
            <source :src="videoAd.video_url" type="video/mp4">
            Video player isn't supported
        </video>
    </div>
    <div v-else>No ad found...</div>
</template>

<script>
    import HTTP from "@js/Common/Http.service";

    export default {
        name: "VideoAd",
        data(){
            return {
                interval: null,
                videoAd: null,
                counter: 0,
                videoElement: null,
                ended: false
            }
        },
        beforeRouteEnter(to, from, next){
            HTTP.GET("/user/video-ad")
                .then(res => {
                    let video = res.data.data.video;
                    next(vm => vm.videoAd = video);
                }).catch(err => {
                    console.error(err);
                    console.error(err.response);
                    next();
                })
        },
        mounted(){
            this.initPlay();
            this.timerOff();
            setTimeout(() => {
                window.addEventListener("focus", this.timerOn);
                window.addEventListener("blur", this.timerOff);
                this.timerOn();
            }, 1000);
        },

        beforeDestroy(){
          this.timerOff();
          this.ended = true;
        },

        methods: {
            timerOn(){
                if(this.ended) return;
                if(this.videoElement == null) this.videoElement = document.getElementById("player");
                this.interval = setInterval(() => this.counter++, 1000);
                if(this.videoElement != null)
                    this.videoElement.play()
                        .catch(() => {
                            this.timerOff()
                        });
            },

            timerOff(){
                if(this.ended) return;
                clearInterval(this.interval);
                if(this.videoElement != null)
                    this.videoElement.pause();
            },

            goToPage(){
                window.open(this.videoAd.forward_url, "_blank");
            },

            initPlay(){
                if(this.videoElement == null) this.videoElement = document.getElementById("player");
                if(this.interval == null && document.hasFocus()) this.timerOn();
            },

            submitWatched(){
                let campaign_id = this.$route.query.campaign_id;
                // campaign_id = !campaign_id ?? 1;
                HTTP.POST("/campaigns/"+campaign_id+"/video-ad", {video_id : this.videoAd.id})
                    .then(() => {
                        window.alert("Watched video has been submitted!");
                        this.$router.push("/campaigns/"+campaign_id);
                    }).catch(err => {
                        window.alert("Something went wrong during submitting!");
                        this.$router.push("/campaigns/"+campaign_id);
                        console.error(err);
                        console.error(err.response);
                    }).finally(() => {
                        this.videoElement.pause();
                        this.ended = true;
                    });
            }
        }
    }
</script>