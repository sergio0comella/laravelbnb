import VueRouter from "vue-router";
import BookablesListItem from "./bookables/BookableListItem";
import Bookables from './bookables/Bookables';
import Bookable from './bookable/Bookable';
import Review from "./review/Review";
import Basket from "./basket/Basket";
import Login from "./auth/Login";
import Register from "./auth/Register";

const routes = [
    {
        path: "/",
        component: Bookables,
        name: "home",
    },
    {
        path: "/bookable/:id",
        component: Bookable,
        name: "bookable",
    },
    {
        path: "/review/:id",
        component: Review,
        name: "review",
    },
    {
        path: "/basket",
        component: Basket,
        name: "basket",
    },
    {
        path: "/auth/login",
        component: Login,
        name: "login",
    },
    {
        path: "/auth/signup",
        component: Register,
        name: "register",
    },
];

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
});

export default router;
