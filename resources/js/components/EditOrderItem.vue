<template>
<div>
<v-dialog v-model="dialog" width="800px" :fullscreen="$vuetify.breakpoint.smAndDown" persistent>
    <v-card>
        <v-toolbar dark color="primary">
          
          <v-toolbar-title>Add Product</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn icon dark @click="emitCloseDialog('orderDetailDialogue')">
            <v-icon>close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-form v-model="valid" ref="OrderDetailForm">
        <v-container grid-list-sm class="pa-4">
            <v-card min-height = "200px">
                
                <v-autocomplete
                prepend-icon = "shopping_cart"
                v-model="select"
                :items="products"
                :search-input.sync="productSearch"
                :loading="isLoading"
                item-text="name"
                hide-no-data
                return-object
                label="search product name"
                >
                
                </v-autocomplete>
            </v-card>    
           
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
            select: null,
            valid: true,
            productSearch: null,
        }
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
            console.log(this.products)
          })
        },
        emitCloseDialog(form)
        {
            this.$emit("closeDialog", form)
        },
        search(v) {
            console.log(v)
        },
        saveOrderItem()
        {
            console.log("save order")
        }
    },
    props: {
        dialog: Boolean
    },
}
</script>