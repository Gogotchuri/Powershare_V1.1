import Login from "@views/auth/Login";
import Register from "@views/auth/Register";

export default [
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
];

