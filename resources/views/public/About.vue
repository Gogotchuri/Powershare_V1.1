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
                <p class="name">BEKA DALAQISHVILI</p>
                <p class="position">The Founder and Chairman</p>
            </div>
            <div class="team-card">
                <img src="img/TEAM_photos/david-svimonishvili.png">
                <p class="name">DAVID SVIMONISHVILI</p>
                <p class="position">The Founder and CEO</p>
            </div>
            <div class="team-card">
                <img src="img/TEAM_photos/ana-mikatadze_2.png">
                <p class="name">ANA MIKATADZE</p>
                <p class="position">Co-Founder, COO, Head of Research</p>
            </div>
            <div class="team-card">
                <img src="img/TEAM_photos/sophio-chkhenkeli.png">
                <p class="name">SOPHIO CHKHENKELI</p>
                <p class="position">Board member, Art Director</p>
            </div>
            <div class="team-card">
                <img src="img/TEAM_photos/gega-abashidze.png">
                <p class="name">GEGA ABASHIDZE</p>
                <p class="position">Legal Counsil</p>
            </div>
            <div class="team-card">
                <img src="img/TEAM_photos/misho_300x300.png">
                <p class="name">MIKHEIL ZGHULADZE</p>
                <p class="position">Research Fellow, Blogger</p>
            </div>
            <div class="team-card">
                <img src="img/TEAM_photos/Ilia.png">
                <p class="name">ILIA GOGOTCHURI</p>
                <p class="position">Tech Lead, Developer</p>
            </div>
            <div class="team-card">
                <img src="img/TEAM_photos/lasha">
                <p class="name">LASHA LOLADZE</p>
                <p class="position">Front-End Developer</p>
            </div>
            <div class="team-card">
                <img src="img/TEAM_photos/qeti.png">
                <p class="name">QETEVAN PAGAVA</p>
                <p class="position">UI/UX Designer</p>
            </div>
            <div class="team-card">
                <img src="img/TEAM_photos/shota-chinchaladze.png">
                <p class="name">SHOTA CHINCHALADZE</p>
                <p class="position">Chief Branding Consultant</p>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "About"
}
</script>