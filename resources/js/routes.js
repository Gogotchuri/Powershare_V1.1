import Home from "../views/public/Home";
import Login from "../views/auth/Login";
import Register from "../views/auth/Register";
import Profile from "../views/management/Profile";
import Campaigns from "../views/public/Campaigns";


export const routes = [
    //public routes
    {
        path: '/',
        name: 'Home',
        component: Home,
        meta: {
            authRequired: false
        }
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: {
            authRequired: false
        }
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
        meta: {
            authRequired: false
        }
    },
    {
        path: '/profile',
        name: 'Profile',
        component: Profile,
        meta: {
            authRequired: true
        }
    },
    {
        path: '/campaigns',
        name: 'Campaigns',
        component: Campaigns,
        meta: {
            authRequired: false
        }
    },
];