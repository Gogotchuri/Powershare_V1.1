<template>
    <div class="advertising">
        <div class="advertising-header-upper"><p>{{$t("texts.advertising.header")}}</p></div>
        <div class="advertising-header-under"></div>
        <div class="advertising-form">
            <form @submit.prevent="send">
                <div>
                <label for="mail-ad">{{$t("words.email")}}</label>
                <input type="text" id="mail-ad" v-model="form.name" class="form-control" placeholder="Type here" required>
                </div>
                <div>
                <label for="mail-ad">{{$t("snippets.contact-number")}}</label>
                <input type="text" id="mail-ad" v-model="form.name" class="form-control" placeholder="Type here" required>
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
    export default {
        name: "Advertising",
        data(){
            return{
                form:{
                    email: "",
                    contact: ""
                }
            }
        },
        methods: {
            send(){
                this.$store.dispatch("postLetter", this.form)
                    .then(() => this.success = true)
                    .catch(errors => this.errors = errors);
            }
        }
    };
</script>