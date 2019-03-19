import Home from "../views/public/Home";
import Login from "../views/auth/Login";
import Register from "../views/auth/Register";
import Profile from "../views/management/Profile";
import Campaigns from "../views/public/Campaigns";
import Campaign from "../views/public/Campaign";
import Articles from "../views/public/Articles";
import Article from "../views/public/Article";
import Contact from "../views/public/Contact";
import About from "../views/public/About";
import Faq from "../views/public/Faq";
import PrivacyPolicy from "../views/public/PrivacyPolicy";
import TermsConditions from "../views/public/TermsConditions";

export const routes = [
    //public routes
    {
        path: "/",
        name: "Home",
        component: Home,
        meta: {
            authRequired: false
        }
    },
    {
        path: "/login",
        name: "Login",
        component: Login,
        meta: {
            authRequired: false
        }
    },
    {
        path: "/register",
        name: "Register",
        component: Register,
        meta: {
            authRequired: false
        }
    },
    {
        path: "/profile",
        name: "Profile",
        component: Profile,
        meta: {
            authRequired: true
        }
    },

    {
        path: "/campaigns",
        name: "Campaigns",
        component: Campaigns,
        meta: {
            authRequired: false
        },
    },
    
    {
        path: "/campaigns/:id",
        name: "Campaign",
        component: Campaign,
        meta: {
            authRequired: false
        },
    },

    {
        path: "/about",
        name: "About",
        component: About,
        meta: {
            authRequired: false
        },
    },
    
    {
        path: "/articles",
        name: "Articles",
        component: Articles,
        meta: {
            authRequired: false
        },
    },
    {
        path: "/articles/:id",
        name: "Article",
        component: Article,
        meta: {
            authRequired: false
        },
    },
    {
        path: "/contact",
        name: "Contact",
        component: Contact,
        meta: {
            authRequired: false
        },
    },
    {
        path: "/faq",
        name: "FAQ",
        component: Faq,
        meta: {
            authRequired: false
        },
    },
    {
        path: "/privacy-policy",
        name: "PrivacyPolicy",
        component: PrivacyPolicy,
        meta: {
            authRequired: false
        },
    },
    {
        path: "/terms-conditions",
        name: "TermsConditions",
        component: TermsConditions,
        meta: {
            authRequired: false
        },
    }
];