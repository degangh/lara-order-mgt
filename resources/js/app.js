import Vue from "vue";
import VueRouter from "vue-router";
import Vuetify from 'vuetify'
import Vuex from 'vuex';
import 'vuetify/dist/vuetify.min.css'
import vueNumeralFilterInstaller from 'vue-numeral-filter';
Vue.use(vueNumeralFilterInstaller);

Vue.use(VueRouter);
Vue.use(Vuetify)
Vue.use(Vuex)

import App from "./components/App";
import Login from "./components/Login";
import Customer from "./components/Customer";
import Order from "./components/Order";
import OrderDetailPage from "./components/OrderDetailPage";
import Product from "./components/Product";
import CustomerInfo from "./components/CustomerInfo";
import NotFound from "./components/NotFound";
import Dashboard from "./components/Dashboard";
import Playground from "./components/Playground";


const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/dashboard",
            name: "dashboard",
            component: Dashboard
        },
        {
            path: "/",
            name: "dashboard",
            component: Dashboard
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
            path: "/orders/:id",
            name: "orderDetailPage",
            component: OrderDetailPage
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
            path: "/test",
            name: "productsPage",
            component: Playground
        },
        {
            path: "*",
            name: "NotFound",
            component: NotFound
        }
    ],
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
     }
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
