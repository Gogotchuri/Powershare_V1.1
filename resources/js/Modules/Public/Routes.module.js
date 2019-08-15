import Home from "@views/public/Home";
import Campaigns from "@views/public/Campaigns";
import Campaign from "@views/public/Campaign";
import Articles from "@views/public/Articles";
import Article from "@views/public/Article";
import Contact from "@views/public/Contact";
import About from "@views/public/About";
import Faq from "@views/public/Faq";
import PrivacyPolicy from "@views/public/PrivacyPolicy";
import TermsConditions from "@views/public/TermsConditions";
import Advertising from "@views/public/Advertising";

export default [
    {
        path: "/",
        name: "Home",
        component: Home
    },

    {
        path: "/campaigns",
        name: "Campaigns",
        component: Campaigns
    },
    {
        path: "/campaigns/:id",
        name: "Campaign",
        component: Campaign
    },
    {
        path: "/about",
        name: "About",
        component: About
    },
    {
        path: "/articles",
        name: "Articles",
        component: Articles
    },
    {
        path: "/articles/:id",
        name: "Article",
        component: Article
    },
    {
        path: "/contact",
        name: "Contact",
        component: Contact
    },
    {
        path: "/faq",
        name: "FAQ",
        component: Faq
    },
    {
        path: "/privacy-policy",
        name: "PrivacyPolicy",
        component: PrivacyPolicy
    },
    {
        path: "/terms-conditions",
        name: "TermsConditions",
        component: TermsConditions,
    },
    {
        path: "/advertising",
        name: "advertising",
        component: Advertising,
    }
];

