<template>
    <div>
        <h3 class="about-header">{{$t("titles.about")}}</h3>
        <br/>
        <p class="about-text">
            {{$t("texts.about.description")}}
        </p>
        <br/>
        <h3 class="about-header">{{$t("titles.our-team")}}</h3>
        <div class="about-team">
            <div class="team-card">
                <img src="img/TEAM_photos/beka-dalakishvili.png">
                <p class="name">{{$t("texts.about.team.beka")}}</p>
                <p class="position">{{$t("texts.about.team.beka-desc")}}</p>
            </div>
            <div class="team-card">
                <img src="img/TEAM_photos/david-svimonishvili.png">
                <p class="name">{{$t("texts.about.team.david")}}</p>
                <p class="position">{{$t("texts.about.team.david-desc")}}</p>
            </div>
            <div class="team-card">
                <img src="img/TEAM_photos/ana-mikatadze_2.png">
                <p class="name">{{$t("texts.about.team.ana")}}</p>
                <p class="position">{{$t("texts.about.team.ana-desc")}}</p>
            </div>
            <div class="team-card">
                <img src="img/TEAM_photos/sophio-chkhenkeli.png">
                <p class="name">{{$t("texts.about.team.sophio")}}</p>
                <p class="position">{{$t("texts.about.team.sophio-desc")}}</p>
            </div>
            <div class="team-card">
                <img src="img/TEAM_photos/gega-abashidze.png">
                <p class="name">{{$t("texts.about.team.gega")}}</p>
                <p class="position">{{$t("texts.about.team.gega-desc")}}</p>
            </div>
            <div class="team-card">
                <img src="img/TEAM_photos/misho_300x300.png">
                <p class="name">{{$t("texts.about.team.mikheil")}}</p>
                <p class="position">{{$t("texts.about.team.mikheil-desc")}}</p>
            </div>
            <div class="team-card">
                <img src="img/TEAM_photos/Ilia.png">
                <p class="name">{{$t("texts.about.team.ilia")}}</p>
                <p class="position">{{$t("texts.about.team.ilia-desc")}}</p>
            </div>
            <div class="team-card">
                <img src="img/TEAM_photos/lasha">
                <p class="name">{{$t("texts.about.team.lasha")}}</p>
                <p class="position">{{$t("texts.about.team.lasha-desc")}}</p>
            </div>
            <div class="team-card">
                <img src="img/TEAM_photos/qeti.png">
                <p class="name">{{$t("texts.about.team.qetevan")}}</p>
                <p class="position">{{$t("texts.about.team.qetevan-desc")}}</p>
            </div>
            <div class="team-card">
                <img src="img/TEAM_photos/shota-chinchaladze.png">
                <p class="name">{{$t("texts.about.team.shota")}}</p>
                <p class="position">{{$t("texts.about.team.shota-desc")}}</p>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "About"
}
</script>