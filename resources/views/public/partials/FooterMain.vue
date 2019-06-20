<template>
    <div id="footer-main">
        <div class="footer-socials">
            <ul class="socials">
                <a href="#">
                    <img src="/img/footer-assets/twitter.png" class="twitter-1">
                </a>
                <a href="#">
                    <img src="/img/footer-assets/facebook.png" class="facebook-1">
                </a>
                <a href="#">
                    <img src="/img/footer-assets/medium.png" class="medium-1">
                </a>
                <a href="#">
                    <img src="/img/footer-assets/telegram.png" class="telegram-1">
                </a>
            </ul>
        </div>
        <div class="footer-menu">
            <ul class="footer-nav">
                <router-link :to="{ name: 'Articles'}">Blog</router-link>
                <router-link :to="{ name: 'Contact'}">Contact us</router-link>
                <router-link :to="{ path: '/#'}">Terms and conditions</router-link>
                <router-link :to="{ path: '/#'}">Privacy policy</router-link>
                <p>© 2019 | Powershare</p>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "FooterMain"
}
</script>
