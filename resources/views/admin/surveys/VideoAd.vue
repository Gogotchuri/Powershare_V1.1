<template>
    <div @click="goToPage" style="cursor: pointer">
        <p>
            {{counter}} seconds
        </p>
        <video width="600" height="400" @canplay="updatePaused" @playing="updatePaused" @pause="updatePaused" autoplay>
            <source src="/videos/TheLKing.mp4" type="video/mp4">
            ??
        </video>
    </div>
</template>

<script>
    export default {
        name: "VideoAd",
        data(){
            return {
                focused: false,
                interval: null,
                counter: 0,
                videoElement: null,
                paused: null
            }
        },
        mounted(){
            if(this.interval == null && document.hasFocus()) this.timerOn();
            window.addEventListener("focus", this.timerOn);
            window.addEventListener("blur", this.timerOff);
        },
        watch: {
          paused(){
              if(this.paused) this.timerOff();
          }
        },
        methods: {
            updatePaused(event) {
                this.videoElement = event.target;
                this.paused = event.target.paused;
            },
            timerOn(){
                this.interval = setInterval(() => this.counter++, 1000);
                if(this.videoElement != null)
                    this.videoElement.play();
            },

            timerOff(){
                clearInterval(this.interval);
                if(this.videoElement != null)
                    this.videoElement.pause();
            },
            goToPage(){
                window.open("https://www.youtube.com", "_blank");
            }
        }
    }
</script>