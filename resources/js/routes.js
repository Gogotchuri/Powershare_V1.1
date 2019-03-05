import Home from "../views/public/Home";
import Login from "../views/auth/Login";
import Register from "../views/auth/Register";
import Profile from "../views/management/Profile";


export const routes = [
    //public routes
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
    },
    {
        path: '/profile',
        name: 'Profile',
        component: Profile,
    }
];