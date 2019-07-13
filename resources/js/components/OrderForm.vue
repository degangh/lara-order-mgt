<template>
<div>
<v-dialog v-model="dialog" width="800px" :fullscreen="$vuetify.breakpoint.smAndDown" persistent>
<v-card>
        <v-toolbar dark color="primary">
          
          <v-toolbar-title>Create Order</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn icon dark @click="emitCloseDialog('orderDialog')">
            <v-icon>close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-form v-model="valid" ref="OrderForm">
        <v-container grid-list-sm class="pa-4">

            <v-stepper v-model="e1">
    <v-stepper-header>
      <v-stepper-step :complete="e1 > 1" step="1">Choose Customer</v-stepper-step>

      <v-divider></v-divider>

      <v-stepper-step :complete="e1 > 2" step="2">Add Products</v-stepper-step>

      <v-divider></v-divider>

      <v-stepper-step step="3">Final Confirmation</v-stepper-step>
    </v-stepper-header>

    <v-stepper-items>
      <v-stepper-content step="1">
        <v-card
        min-height = "200px"

        >
         
        <v-autocomplete
        label = "Customer"
        prepend-icon = "contacts"
        :search-input.sync="customerSearch"
        :items="customers"
        :loading="isLoading"
        hide-no-data
        item-text="name"
        v-model='selectedCustomer'
        return-object
        :rules = "customerRules"
        >

        </v-autocomplete>
        <v-combobox
        label = "Address"
        prepend-icon = "business"
        :items = "addresses"
        v-model = "address"
        item-text = "address"
        return-object
        :rules = "addressRules"
        >

        </v-combobox>
        
        </v-card>

    


      </v-stepper-content>

      <v-stepper-content step="2">
        <v-card min-height = "200px">
        <v-autocomplete
        label = "Search Products"
        prepend-icon = "shopping_cart"
        :items = "products"
        v-model = "selectedProduct"
        :search-input.sync="productSearch"
        item-text = "name"
        hide-no-data
        return-object
        >
        </v-autocomplete>
        <order-detail></order-detail>
        </v-card>


      </v-stepper-content>

      <v-stepper-content step="3">
        <v-card
          class="mb-5"
          color="grey lighten-1"
          min-height = "200px"
        ></v-card>

      </v-stepper-content>
    </v-stepper-items>
  </v-stepper>
          
        </v-container>
        </v-form>
        <v-card-actions>
          <!--v-btn flat color="primary">More</v-btn-->
          <v-spacer></v-spacer>
          <v-btn flat  @click="emitCloseDialog('orderDialog')">Cancel</v-btn>
          <v-btn flat @click="prev(e1)" v-show="e1 > 1">Back</v-btn>
          <v-btn flat color="primary" @click="next(e1)" v-show = "e1 < 3">Continue</v-btn>
          <v-btn flat color="primary" @click="next(e1)" v-show="e1 == 3">Save</v-btn>
        </v-card-actions>
      </v-card></v-dialog>
</div>
</template>

<script>
import OrderDetail from './OrderDetail'
export default {
    name: "OrderForm",

    components: {
      OrderDetail
    },


    data() {
      return {
          valid: false,
          e1: 0,
          next_button_text: 'Continue',
          back_button_text: 'Back',
          isLoading: false,
          customerSearch: null,
          productSearch: null,
          selectedCustomer: null,
          selectedProduct: null,
          customers: [],
          addresses: [],
          products: [],
          selectedProducts: [],
          address: null,
          customerRules: [
          v => !!v || 'Customer must be selected'
          ],
          addressRules: [
          v => !!v || 'Address must be selected'
          ]

      }
    },

    watch: {
      customerSearch(v) {
        if ( v == null) return
        if (v.length > 0) this.isLoading = true
        if (v.length == 0) this.customers = []
        if (v.length < 2 ) return

        this.searchCustomer (v)
        this.address = null
        this.isLoading = false
      },

      productSearch (v)
      {
        if ( v == null) return
        if (v.length > 0) this.isLoading = true
        if (v.length == 0) this.customers = []
        if (v.length < 2 ) return
        this.searchProduct (v)
      },

      selectedCustomer (v)
      {
        
        if(v) this.addresses = v.addresses

      },

      selectedProduct (v)
      {
        v.num = 1
        this.selectedProducts.push(v)
        console.log(this.selectedProducts)
      }
    },

    props: {
        dialog: Boolean
    },

    methods: {
        emitCloseDialog (form) {
        this.e1 = 1
        this.$refs.OrderForm.reset()
        this.addresses = []
        this.customers = []
        this.products = []
        this.isLoading = false
        this.$emit("closeDialog", form)
      },

      next(){
          if (!this.$refs.OrderForm.validate()) return
          if (this.e1 < 3) this.e1 = parseInt(this.e1) + 1

      },

      prev() {
        this.e1 = parseInt(this.e1) - 1
      },

      searchCustomer (v) {

          axios.get('/api/customers', {
              params: {
                  keyword: v
              }
          })
          .then(res => {
            this.customers = res.data.data
          })
      },

      searchProduct (v) {
        axios.get('/api/products', {
              params: {
                  keyword: v
              }
          })
          .then(res => {
            this.products = res.data.data
          })
      }
    }
}
</script>