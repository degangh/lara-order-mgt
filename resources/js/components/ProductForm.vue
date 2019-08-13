<template>
<div>
<v-dialog v-model="dialog" width="800px" :fullscreen="$vuetify.breakpoint.smAndDown" persistent>
      <v-card>
        <v-toolbar dark color="primary">
          
          <v-toolbar-title>Add Product</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn icon dark @click="emitCloseDialog('productDialog')">
            <v-icon>close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-form v-model="valid" ref="ProductForm">
        <v-container grid-list-sm class="pa-4">
            <v-flex xs12>
              <v-text-field
                prepend-icon="shopping_cart"
                placeholder="Product Name"
                v-model = "name"
                :rules="nameRules"
              ></v-text-field>
            </v-flex>
            
            <v-flex xs12>
              <v-text-field
                type="number"
                prepend-icon="money"
                placeholder="Product Price in AUD"
                v-model = "ref_price_aud"
                :rules="priceRules"
              ></v-text-field>
            </v-flex>

            <v-flex xs12>
              <v-text-field
                type="number"
                prepend-icon="money"
                placeholder="Sale Price in CNY"
                v-model = "rrp_cny"
                :rules="priceRules"
              ></v-text-field>
            </v-flex>
        </v-container>
        </v-form>
        <v-card-actions>
          <!--v-btn flat color="primary">More</v-btn-->
          <v-spacer></v-spacer>
          <v-btn flat color="primary" @click="emitCloseDialog('productDialog')">Cancel</v-btn>
          <v-btn flat @click="saveProduct">Save</v-btn>
        </v-card-actions>
        </v-card>
    </v-dialog>
    <v-snackbar v-model="snackbar">
      {{snackbarText}}
    </v-snackbar>
    </div>
</template>

<script>
export default {
    name: "ProductForm" , 

    props: {
        dialog: Boolean
    },

    data() {
        return {
            name: '',
            ref_price_aud: '',
            rrp_cny: '',
            valid: false,
            snackbar: false,
            snackbarText: 'Saving Product ...',
            nameRules: [
              v => !!v || 'Product Name is required',
            ],
            priceRules:[
              v => !isNaN(v) || 'Price must be a number',
              v => v > 0 || 'Price must be greater than 0'
            ]
        }
    },
    methods: {
        emitCloseDialog (form) {
            this.$refs.ProductForm.reset()
            this.$emit("closeDialog", form)
        },
        saveProduct () {
          if (!this.$refs.ProductForm.validate()) return
          this.snackbar = true
          axios.post('/api/products', {
     
                  name: this.name,
                  ref_price_aud: this.ref_price_aud,
                  rrp_cny: this.rrp_cny
     
          })
          .then(this.handleResponse)
          .catch(function (err) {
            alert (err)
          })
        },
        handleResponse () {
          this.snackbar = false
          this.emitCloseDialog('productDialog')
          this.snackbarText = "New Product Saved"
          this.snackbar = true
          /*
          if (res.data.id) this.$router.push("/customer/" + res.data.id);
          console.log (res.data.id)*/
        }
    }
}
</script>
