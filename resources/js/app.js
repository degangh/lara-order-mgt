import Vue from "vue";
import VueRouter from "vue-router";
import Vuetify from 'vuetify'
import Vuex from 'vuex';
import 'vuetify/dist/vuetify.min.css'

Vue.use(VueRouter);
Vue.use(Vuetify)
Vue.use(Vuex)

import App from "./components/App";
import Welcome from "./components/Welcome";
import Login from "./components/Login";
import Customer from "./components/Customer";
import Order from "./components/Order";
import Product from "./components/Product";
import CustomerInfo from "./components/CustomerInfo";
import NotFound from "./components/NotFound";


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
            name: "customers",
            component: Customer
        },
        {
            path: "/customer/:id",
            name: "customerInfo",
            component: CustomerInfo
        },
        {
            path: "/customers/p:page",
            name: "customer",
            component: Customer
        },
        {
            path: "/orders",
            name: "orders",
            component: Order
        },
        {
            path: "/orders/p:page",
            name: "ordersPage",
            component: Order
        },
        {
            path: "/products/p:page",
            name: "productsPage",
            component: Product
        },

        {
            path: "/products",
            name: "productsPage",
            component: Product
        },
        {
            path: "*",
            name: "NotFound",
            component: NotFound
        }
    ]
});

window.axios.interceptors.response.use(response => {
    return response;
 }, error => {
   if (error.response.status === 401) {
    //place your reentry code
    //router.go("/login");
    location.href="/login"
   }
   /*
   if (error.response.status === 404) {
    //place your reentry code
    //router.go("/NotFound");
    console.log('not found')
   }*/
   return Promise.reject(error.response);
 });

const app = new Vue({
    el: "#app",
    components: { App },
    router
});
