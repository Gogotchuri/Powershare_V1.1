import Vue from 'vue';
import VueI18n from 'vue-i18n';

import kaObject from "@lang/ka";
import enObject from "@lang/en";

Vue.use(VueI18n);

export default new VueI18n({
    locale: "ka",
    fallbackLocale: "en",
    messages : {
        en : enObject,
        ka: kaObject
    }
});