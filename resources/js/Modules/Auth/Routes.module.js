import Login from "@views/auth/Login";
import Register from "@views/auth/Register";
import Logout from "@views/auth/Logout"
export default [
    {
      path: "/logout",
      name: "Logout",
      component: Logout,
      meta: {
          authRequired: true
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
];

