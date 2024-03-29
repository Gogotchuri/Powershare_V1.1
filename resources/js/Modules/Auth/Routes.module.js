import Login from "@views/auth/Login";
import Register from "@views/auth/Register";
import Logout from "@views/auth/Logout"
import ForgotPassword from "@/views/auth/ForgotPassword";
import PasswordReset from "@/views/auth/PasswordReset";
import LoginModalOn from "@views/auth/LoginModalOn";
import RegisterModalOn from "@views/auth/RegisterModalOn";
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
        component: LoginModalOn,
        meta: {
            authRequired: false
        }
    },
    {
        path: "/register",
        name: "Register",
        component: RegisterModalOn,
        meta: {
            authRequired: false
        }
    },
    {
        path: "/reset-password",
        name: "ForgotPassword",
        component: ForgotPassword,
        meta:{
            authRequired: false
        }
    },
    {
        path: "/reset-password/:token",
        name: "ResetPassword",
        component: PasswordReset,
        meta:{
            authRequired: false
        }
    }

];

