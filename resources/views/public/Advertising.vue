<template>
    <div class="advertising">
        <div class="advertising-header-upper"><p>{{$t("texts.advertising.header")}}</p></div>
        <div class="advertising-header-under"></div>
        <div class="advertising-form">
            <form @submit.prevent="send">
                <div>
                <label for="mail-ad">{{$t("words.email")}}</label>
                <input type="email" id="mail-ad" v-model="form.email" class="form-control" :placeholder="$t('snippets.type-here')" required>
                </div>
                <div>
                <label for="phone-ad">{{$t("snippets.contact-number")}}</label>
                <input type="tel" id="phone-ad" v-model="form.phone" class="form-control" :placeholder="$t('snippets.type-here')" required>
                </div>
                <div class="advertising-btn-container">
                    <button type="submit" class="btn advertising-submit">{{$t("words.send")}}</button>
                </div>
                <p>{{$t("texts.advertising.tip")}}</p>
            </form>
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
            }
        }
    };
</script>