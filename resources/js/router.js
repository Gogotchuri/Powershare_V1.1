import VueRouter from "vue-router";
import store from "@js/store";
import {checkAdmin} from "@js/Helpers/auth";

//Module routes
import PublicRoutes from "@js/Modules/Public/Routes.module";
import AuthRoutes from "@js/Modules/Auth/Routes.module";
import ManagementRoutes from "@js/Modules/Management/Routes.module";
import AdminRoutes from "@js/Modules/Admin/Routes.module";

    /**
 * Concatenating routes from different modules
 */
let routes = []
    .concat(PublicRoutes)
    .concat(AuthRoutes)
    .concat(ManagementRoutes)
        .concat(AdminRoutes);

//Creating and exporting Vue router instance
export const router = new VueRouter({
    mode:"history",
    routes
});

/**
 * Getting auth required property and redirecting user properly
 */
router.beforeEach((to, from, next) => {
    const authRequired = to.matched.some(record => record.meta.authRequired);
    const adminRequired = to.matched.some(record => record.meta.adminRequired);
    let isAdmin = false;
    const user = store.getters.currentUser;
    if(adminRequired) {
        checkAdmin()
            .then(() => isAdmin = true)
            .catch(() => isAdmin = false);
    }
    if(adminRequired && !isAdmin){
        //TODO Need to create router router which dispatches logout and says logout successfully
        //then call is here and logout if someone goes for admin route before enter, also change it in App.vue

        router.push({name : "Login", query : {redirect : to.name}});
    }else if(authRequired && !user){
        //Using Get request query param to redirect after
        // Redirection to login cause of unauthorized request
        router.push({name : "Login", query : {redirect : to.name}});
    }else if((to.path === "/login" || to.path === "/register")&& !!user){
        next("/");
    }else{
        next();
    }

});

export default router;
