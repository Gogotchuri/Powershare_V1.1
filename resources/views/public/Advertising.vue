<template>
    <div class="advertising">
        <div class="advertising-header-upper"><p>{{$t("texts.advertising.header")}}</p></div>
        <div class="advertising-header-under"></div>
        <div class="advertising-form">
            <form @submit.prevent="send" v-if="state!=2">
                <div>
                <label for="mail-ad">{{$t("words.email")}}</label>
                <input type="email" id="mail-ad" v-model="form.email" class="form-control" :placeholder="$t('snippets.type-here')" required>
                </div>
                <div>
                <label for="phone-ad">{{$t("snippets.contact-number")}}</label>
                <input type="tel" id="phone-ad" v-model="form.phone" class="form-control" :placeholder="$t('snippets.type-here')" required>
                </div>
                <div class="advertising-btn-container">
                    <button type="submit" class="btn advertising-submit" v-bind:class="getClass(state)">
                        <div v-if="state == 0">{{$t("words.send")}}</div>
                        <div v-else><div class="lds-ring"><div></div><div></div><div></div><div></div></div>{{$t("words.sending")}}</div>
                    </button>
                </div>
                <p>{{$t("texts.advertising.tip")}}</p>
            </form>
            <div v-else>
                <p v-bind:class="getClass(state)">{{$t("texts.advertising.success")}}</p>
            </div>
        </div>
        <div class="advertising-boxes">
            <div>
                <img src="img/play.png" class="play-icon" alt="">
                <br/>
                {{$t("texts.advertising.effect.first")}}<br/>
                {{$t("texts.advertising.effect.second")}}<br/>
                {{$t("texts.advertising.effect.third")}}</div>
            <div>
                <img src="img/magnifier.svg" class="magnifier"><br/>
                {{$t("texts.advertising.inovation.first")}}<br/>
                {{$t("texts.advertising.inovation.second")}}
            </div>
            <div>
                <img src="img/puzzle-pieces.svg" class="puzzle-pieces"><br/>
                {{$t("texts.advertising.campaign.first")}}<br/>
                {{$t("texts.advertising.campaign.second")}}
            </div>
            <div>
                <img src="img/add-group.svg" class="add-group"><br/>
                {{$t("texts.advertising.visitors.first")}}<br/>
                {{$t("texts.advertising.visitors.second")}}
            </div>
            <div>
                <img src="img/hand.png" class="hand"><br/>
                {{$t("texts.advertising.costs.first")}}<br/>
                {{$t("texts.advertising.costs.second")}}
            </div>
        </div>
    </div>
</template>

<script>
    import HTTP from "@js/Common/Http.service";
    export default {
        name: "Advertising",
        data(){
            return{
                form:{
                    email: "",
                    phone: ""
                },
                //0 - starting, 1 - sending, 2 - sent, 3 - error occurred
                state : 0
            }
        },

        methods: {
            send(){
                this.state = 1;
                HTTP.POST("/advertising-request", this.form)
                    .then(() => this.state = 2)
                    .catch(() => this.state = 3);
            },
            getClass(state){
                return state == 0 ? 'before' : state == 1 ? 'sent' : 'loading';
            }
        }
    };
</script>

<style scoped>
    button > div{
        color: #fff!important;
    }
    .lds-ring {
        display: inline-block;
        position: relative;
        width: 40px;
        height: 20px;
        margin-top: -30px;
    }
    .lds-ring div {
        box-sizing: border-box;
        display: block;
        position: absolute;
        width: 20px;
        height: 20px;
        margin: 3px;
        border: 3px solid #fff;
        border-radius: 50%;
        animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        border-color: #fff transparent transparent transparent;
    }
    .lds-ring div:nth-child(1) {
        animation-delay: -0.45s;
    }
    .lds-ring div:nth-child(2) {
        animation-delay: -0.3s;
    }
    .lds-ring div:nth-child(3) {
        animation-delay: -0.15s;
    }
    @keyframes lds-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    .loading{
        padding: 0.375rem 0.75rem;
    }
    .sent{
        font-size: 20px;
        color: #662f92;
        border-bottom: 1px solid #f4f4f4;
    }
</style>