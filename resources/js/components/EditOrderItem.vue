<template>
<div>
<v-dialog v-model="dialog" width="800px" :fullscreen="$vuetify.breakpoint.smAndDown" persistent>
    <v-card>
        <v-toolbar dark color="primary">
          
          <v-toolbar-title>{{form_title}}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn icon dark @click="emitCloseDialog('orderDetailDialogue', null, null)">
            <v-icon>close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-form v-model="valid" ref="OrderDetailForm">
        <v-container grid-list-sm class="pa-4">
            
                
                <v-autocomplete
                prepend-icon = "shopping_cart"
                v-model="selectedProduct"
                :items="products"
                :search-input.sync="productSearch"
                :loading="isLoading"
                item-text="name"
                hide-no-data
                return-object
                label="search product name"
                >
                
                </v-autocomplete>
                <v-text-field
                type="number"
                prepend-icon="attach_money"
                label = "Purchased Price in AUD"
                v-model = "ref_price_aud">
                </v-text-field>

                <v-text-field
                type="number"
                prepend-icon="attach_money"
                label = "Selling Price in CNY"
                v-model = "rrp_cny">
                </v-text-field>
                
                <v-text-field
                type="number"
                prepend-icon = "library_add"
                label = "Quantity"
                v-model = "quantity">
                </v-text-field>

                <v-text-field
                type="number"
                prepend-icon = "money"
                label = "Exchange Rate"
                v-model = "exchange_rate">
                </v-text-field>
                <span class="text-field-footer grey--text text--lighten-1" >Real-time exchange rate from EU central bank</span>
                
               
           
        </v-container>
        </v-form>

        <v-card-actions>
          
          <v-spacer></v-spacer>
          <v-btn flat color="primary" @click="emitCloseDialog('orderDetailDialogue')">Cancel</v-btn>
          <v-btn flat @click="saveOrderItem">Save</v-btn>
        </v-card-actions>

  </v-card>
</v-dialog>
</div>
</template>

<script>


export default {
    name: "EditOrderItem",
    
    
    data () {
        return {
            products: [],
            isLoading: false,
            selectedProduct: null,
            valid: true,
            productSearch: null,
            ref_price_aud: 0,
            quantity: 0,
            rrp_cny: 0,
            exchange_rate : null,
            form_title: "Add Product",
            is_edit: false

        }
    },
    mounted () {
      this.getCurrencyRate('AUD', 'CNY')
    },
    watch: {
      productSearch (v) {
        if ( v == null) return
        if (v.length > 0) this.isLoading = true
        if (v.length == 0) this.products = []
        if (v.length < 2 ) return
        this.searchProduct (v)
        this.isLoading = false
      },
      selectedProduct (v) {
        if (v == null) return
        this.ref_price_aud = v.ref_price_aud
        this.rrp_cny = v.rrp_cny
        this.quantity = 1

      },
      item(i) { 
          if (i == null) 
          {
            this.form_title = "Add Product",
            this.is_edit = false
            return
          }
          let initSelectedProduct = new Promise((resolve, reject)=>{
          this.form_title = "Edit Product",
          this.is_edit = true
          this.products = [i.product]
          this.selectedProduct = i.product
          resolve()
        })
        initSelectedProduct.then(()=>{
          this.rrp_cny = i.unit_price_cny
          this.quantity = i.quantity
          this.exchange_rate = i.exchange_rate
        })
      }
    },
    methods : {
        searchProduct(v) {
            axios.get('/api/products', {
              params: {
                  keyword: v
              }
          })
          .then(res => {
            this.products = res.data.data
          })
        },
        emitCloseDialog(form, status, message)
        {
            //this.$refs.OrderDetailForm.reset()
            this.selectedProduct = null
            this.products = []
            this.ref_price_aud = null
            this.quantity = null
            this.rrp_cny = null
            this.$emit("closeDialog", form, status, message)
        },
        search(v) {
            console.log(v)
        },
        saveOrderItem()
        {
          let formAction = (this.is_edit) ? 'patch' : 'post'
          let url = '/api/order/' + + this.$route.params.id + "/items" + ((this.is_edit) ? '/' + this.item.id : '' )
          axios({
            method: formAction,
            url: url,
            data: {
                  product_id : this.selectedProduct.id,
                  unit_price_cny : this.rrp_cny,
                  purchase_price_aud : this.ref_price_aud,
                  quantity: this.quantity,
                  exchange_rate: this.exchange_rate
            }
          })
          .then(() => {this.emitCloseDialog('orderDetailDialogue', 'success', (this.is_edit) ? 'The item is updated successfully' : 'The item is added to the order')})
          .catch( (err) => {
            this.emitCloseDialog('orderDetailDialogue', 'failed', (err.data.message) ? err.data.message : "Unkown Server Error")
          })
          
        },

        handleOrderItemResponse()
        {
          this.emitCloseDialog('orderDetailDialogue')
        },
        getCurrencyRate(base, target){
          fetch('https://api.exchangeratesapi.io/latest?base='+base+'&symbols=' + target).then(function(response){
          return response.json()
          }).then(data => this.exchange_rate = parseFloat(parseFloat(data.rates[target]).toFixed(2)))
      },
    },
    props: {
        dialog: Boolean,
        item: {
          type: [Object, null]
        }
    },
}
</script>