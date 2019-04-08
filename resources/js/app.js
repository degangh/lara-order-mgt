import Vue from "vue";
import VueRouter from "vue-router";
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(VueRouter);
Vue.use(Vuetify)

import App from "./components/App";
import Welcome from "./components/Welcome";
import Login from "./components/Login";
import Customer from "./components/Customer";
import Order from "./components/Order";
import NotFound from "./components/NotFound"

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "home",
            component: Welcome
        },
        {
            path: "/login",
            name: "login",
            component: Login
        },
        {
            path: "/customers",
            name: "customer",
            component: Customer
        },
        {
            path: "/orders",
            name: "orders",
            component: Order
        },
        {
            path: "*",
            name: "NotFound",
            component: NotFound
        }
    ]
});

const app = new Vue({
    el: "#app",
    components: { App },
    router
});
