<template>
    <div id="footer-main">
        <div class="footer-socials">
            <ul class="socials">
                <a href="https://twitter.com/pwrshr">
                    <img src="/img/footer-assets/twitter.png" class="twitter-1">
                </a>
                <a href="https://facebook.com/POWERSHARE.FUND">
                    <img src="/img/footer-assets/facebook.png" class="facebook-1">
                </a>
                <a href="https://medium.com/powershare">
                    <img src="/img/footer-assets/medium.png" class="medium-1">
                </a>
                <a href="https://t.me/joinchat/Hao74QxTfNa_tFLGJvFjpQ">
                    <img src="/img/footer-assets/telegram.png" class="telegram-1">
                </a>
            </ul>
        </div>
        <div class="footer-menu">
            <ul class="footer-nav">
                <a href="/articles" target="_blank">{{$t("words.blog")}}</a>
                <a href="/contact" target="_blank">{{$t("words.contact")}}</a>
                <a href="/terms-conditions" target="_blank">{{$t("snippets.terms-conditions")}}</a>
                <a href="/privacy-policy" target="_blank">{{$t("snippets.privacy-policy")}}</a>
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
