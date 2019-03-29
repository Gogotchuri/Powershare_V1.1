import VueRouter from "vue-router";
import store from "@js/store";
import PublicRoutes from "@js/modules/public/routes.js";
import Login from "../views/auth/Login";
import Register from "../views/auth/Register";
import Profile from "../views/management/Profile";
import CampaignCreate from "../views/management/CampaignCreate";
import CampaignEdit from "../views/management/CampaignEdit";

let routes = [
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
        path: "/user/campaigns/create",
        name: "CampaignCreate",
        component: CampaignCreate,
        meta: {
            authRequired: true
        }
    },
    {
        path: "/user/campaigns/:id/edit",
        name: "CampaignEdit",
        component: CampaignEdit,
        meta: {
            authRequired: true
        }
    },
];

/**
 * Concatenating routes from different modules
 */
routes = routes.concat(PublicRoutes);

export const router = new VueRouter({
    mode:"history",
    routes
});
/**
 * Getting auth required property and redirecting user properly
 */
router.beforeEach((to, from, next) => {
    const authRequired = to.matched.some(record => record.meta.authRequired);
    const user = store.state.user.currentUser;

    if(authRequired && !user){
        router.push({name : "Login", query : {redirect : to.name}});
    }else if((to.path === "/login" || to.path === "/register")&& !!user){
        next("/");
    }else{
        next();
    }

});

export default router;
