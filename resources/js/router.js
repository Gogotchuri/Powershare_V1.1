import VueRouter from "vue-router";
import store from "@js/store";
import {checkAdmin} from "@js/Helpers/auth";

//Module routes
import PublicRoutes from "@js/Modules/Public/Routes.module";
import AuthRoutes from "@js/Modules/Auth/Routes.module";
import ManagementRoutes from "@js/Modules/User/Routes.module";
import AdminRoutes from "@js/Modules/Admin/Routes.module";
import PageNotFound from "@views/public/errors/PageNotFound";

//Error pages routes
let errors = [
    {
        path: "/404",
        name: "404",
        component: PageNotFound
    },
    {
        path: "*",
        name: "NotFound",
        component: PageNotFound
    }
];

/**
 * Concatenating routes from different modules
 */
let routes = []
    .concat(PublicRoutes)
    .concat(AuthRoutes)
    .concat(ManagementRoutes)
        .concat(AdminRoutes)
        .concat(errors);

//Creating and exporting Vue router instance
export const router = new VueRouter({
    mode:"history",
    routes
});

/**
 * Getting auth required property and redirecting user properly
 */
router.beforeEach(async (to, from, next) => {
    const authRequired = to.matched.some(record => record.meta.authRequired);
    const adminRequired = to.matched.some(record => record.meta.adminRequired);
    const user = store.getters.currentUser;
    let isAdmin = !!user && user.role_id == 1;

    if(adminRequired){
        if(!isAdmin){
            console.error("Admin Required! Not an admin!");
            if(!!user)
                next("/");
            else
                router.push({name: "Login", query: {redirect: to.name}});
        }else{
            next();
        }
        return;
    }


     if (authRequired && !user) {
        //Using Get request query param to redirect after
        // Redirection to login cause of unauthorized request
        router.push({name: "Login", query: {redirect: to.name}});
    } else if ((to.path === "/login" || to.path === "/register") && !!user) {
        next("/");
    } else {
        next();
    }

});

export default router;
