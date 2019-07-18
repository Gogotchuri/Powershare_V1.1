<template>
    <div>
        <button v-if="provider.toLowerCase() === 'facebook'" @click="login('facebook')">Login with Facebook</button>
        <button v-if="provider.toLowerCase() === 'google'" @click="login('google')">Login With Google</button>
    </div>

</template>

<script>
    import HTTP from "@js/Common/Http.service";
    export default {
        name: "SocialAuthButton",
        props: ["provider"],
        mounted(){
            //Add websocket message listener to wait for message from social auth window
            window.addEventListener("message", this.onMessage, false);
        },

        beforeDestroy(){
            //remove websocket message listener
            window.removeEventListener("message", this.onMessage);
        },

        methods: {
            async login(provider){
                try{
                    //Open empty window for starters
                    const authWindow = openWindow("","Login with "+provider);
                    let providerUrl = await HTTP.POST("/oauth/"+provider);
                    providerUrl = providerUrl.data.data.url;
                    console.log(providerUrl);
                    //Push provider redirect url into opened window
                    authWindow.location.href = providerUrl;
                }catch (reason) {
                    console.error(reason);
                }
            },

            onMessage(message) {
                if (message.origin !== window.origin || !message.data.token) {
                    console.log("Origin doesn't match or token isn't present");
                    return;
                }
                console.log(message.data.token);
                this.$store.dispatch("loginWithToken", message.data.token).catch(reason => console.error(reason));
                this.$store.push({name: "HOME"});
            }
        }
    }
    /**
     * @param url
     * @param title
     * @param  {Object} options
     * @return {Window}
     */
    function openWindow (url, title, options = {}) {
        if (typeof url === 'object') {
            options = url;
            url = '';
        }
        options = { url, title, width: 600, height: 720, ...options };
        const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screen.left;
        const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screen.top;
        const width = window.innerWidth || document.documentElement.clientWidth || window.screen.width;
        const height = window.innerHeight || document.documentElement.clientHeight || window.screen.height;
        options.left = ((width / 2) - (options.width / 2)) + dualScreenLeft;
        options.top = ((height / 2) - (options.height / 2)) + dualScreenTop;
        const optionsStr = Object.keys(options).reduce((acc, key) => {
            acc.push(`${key}=${options[key]}`);
            return acc;
        }, []).join(',');
        const newWindow = window.open(url, title, optionsStr);
        if (window.focus)
            newWindow.focus();

        return newWindow;
    }
</script>