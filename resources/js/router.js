import VueRouter from "vue-router";
import store from "@js/store";

//Module routes
import PublicRoutes from "@js/Modules/Public/Routes.module";
import AuthRoutes from "@js/Modules/Auth/Routes.module";
import ManagementRoutes from "@js/Modules/Management/Routes.module";

/**
 * Concatenating routes from different modules
 */
let routes = []
    .concat(PublicRoutes)
    .concat(AuthRoutes)
    .concat(ManagementRoutes);

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
    const user = store.state.user.currentUser;

    if(authRequired && !user){
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
