<template>
<v-app id="inspire">
  <v-navigation-drawer
      fixed
      :clipped="$vuetify.breakpoint.mdAndUp"
      app
      v-model="drawer"
      :width='260'
      v-if = "isLogin()"
    >
      <v-list dense>
        <template v-for="item in items">
          <v-layout
            row
            v-if="item.heading"
            align-center
            :key="item.heading"
          >
            <v-flex xs6>
              <v-subheader v-if="item.heading">
                {{ item.heading }}
              </v-subheader>
            </v-flex>
            <v-flex xs6 class="text-xs-center">
              <a href="#!" class="body-2 black--text">EDIT</a>
            </v-flex>
          </v-layout>
          <v-list-group
            v-else-if="item.children"
            v-model="item.model"
            :key="item.text"
            :prepend-icon="item.model ? item.icon : item['icon-alt']"
            append-icon=""
          >
            <v-list-tile slot="activator">
              <v-list-tile-content>
                <router-link to="item.path" class="tile-link">
                <v-list-tile-title>
                  {{ item.text }}
                </v-list-tile-title>
                </router-link>
              </v-list-tile-content>
            </v-list-tile>
            <v-list-tile
              v-for="(child, i) in item.children"
              :key="i"
              @click=""
            >
              <v-list-tile-action v-if="child.icon">
                <v-icon>{{ child.icon }}</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                <v-list-tile-title>
                  {{ child.text }}
                </v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
          </v-list-group>
          <v-list-tile v-else @click="" :key="item.text" :to="item.path" class="tile-link">
            <v-list-tile-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                {{ item.text }}
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </template>
      </v-list>
    </v-navigation-drawer>

    <v-toolbar
      color="blue darken-3"
      dark
      app
      :clipped-left="$vuetify.breakpoint.mdAndUp"
      fixed
    >
      <v-toolbar-title  class="ml-0 pl-3">
        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
        <span class="hidden-sm-and-down">My CRM</span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-text-field
        flat
        solo-inverted
        append-icon="search"
        label="Search"
        ml-3
        v-if = "isLogin()"
      ></v-text-field>
      <v-spacer></v-spacer>
      
      <v-btn icon v-if = "isLogin()" class="hidden-sm-and-down">
        <v-icon>apps</v-icon>
      </v-btn>
      <v-btn icon v-if = "isLogin()" class="hidden-sm-and-down">
        <v-icon>notifications</v-icon>
      </v-btn>
      <v-menu offset-y v-if = "isLogin()">
        <template v-slot:activator="{ on }">
          <v-btn icon large v-on="on">
            <v-avatar size="32px" tile>
              <img
                src="https://cdn.vuetifyjs.com/images/logos/logo.svg"
                alt="Vuetify"
              >
            </v-avatar>
          </v-btn>
        </template>
      <v-list>
        <v-list-tile
        v-for="(item, index) in userItems"
        :key="index"
        @click="apply_func(item.func)"
        >
        <v-list-tile-title>{{ item.title }}</v-list-tile-title>
        </v-list-tile>
      </v-list>
      </v-menu>
    </v-toolbar>
    <v-content>
      <router-view></router-view>
    </v-content>


    <floating-button 
    @popupFormDialog="openFormDialog"
    v-show="isLogin()"></floating-button>

    <!--v-btn
      fab
      bottom
      right
      color="pink"
      dark
      fixed
      @click.stop="dialog = !dialog"
    >
      <v-icon>add</v-icon>
    </v-btn-->
    <contact-form  :dialog="contactDialog"  @closeDialog="closeFormDialog"></contact-form>
    <product-form  :dialog="productDialog" @closeDialog="closeFormDialog"></product-form>
    <address-form  :dialog="addressDialog" @closeDialog="closeFormDialog"></address-form>
    <order-form  :dialog="orderDialog" @closeDialog="closeFormDialog"></order-form>
</v-app>

</template>

<script>
import FloatingButton from './FAB'
import ContactForm from "./ContactForm"
import ProductForm from "./ProductForm"
import AddressForm from "./AddressForm"
import OrderForm from "./OrderForm"
export default {
     data: () => ({
        contactDialog: false,
        addressDialog: false,
        productDialog: false,
        orderDialog:false,
        formAction:null,
        formAction0: null,
        formAction1: null,
        formAction2:null,
        formAction3:null,
        drawer: null,
        items: [
          { icon: 'dashboard', text: 'Dashboard' , path: '/dashboard'},
          { icon: 'contacts', text: 'Customers' , path: '/customers'},
          { icon: 'history', text: 'Orders', path: '/orders' },
          { icon: 'shopping_cart', text: 'Products', path: '/products' },
          
        ],
        userItems: [
          {title: 'Logout', func: 'logout'},
          {title: 'Help', func: ''}
        ],
        direction: 'top',
        fab: false,
        fling: false,
        hover: false,
        tabs: null,
        top: false,
        right: true,
        bottom: true,
        left: false,
        transition: 'slide-y-reverse-transition'
      }),
      props: {
        source: String
      },
      components: {
        FloatingButton,
        ContactForm,
        ProductForm,
        AddressForm,
        OrderForm
      },
    methods: {

      isLogin () {
        return localStorage.getItem("jwt") != null
      },
      
      logout () {
        localStorage.removeItem('jwt');
        this.$forceUpdate();
        this.$router.push("/login");
        
      },
      apply_func(func_name) {
        if (func_name) this[func_name]()
      },
      
      openFormDialog (payload){
        this[payload.form] = true
        this[formAction] = payload.action
      },
      closeFormDialog (form) {
        this[form] = false
        this.formAction = null
      }
      

    }
};
</script>

<style>
.tile-link a {
    text-decoration: none;
    }
</style>