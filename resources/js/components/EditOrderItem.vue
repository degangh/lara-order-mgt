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
            <v-card>
                
                <v-autocomplete
                prepend-icon = "shopping_cart"
                v-model="select"
                :items="products"
                :search-input.sync="search"
                cache-items
                class="mx-4"
                hide-no-data
                hide-details
                label="search product name"
                @change="productSearch=null"
                ></v-autocomplete>
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
            products: ["SA", "NSW" , "VIC"],
            select: null,
            valid: true,
            productSearch: null,
        }
    },
    watch: {
      productSearch (val) {
        val && val !== this.select && this.querySelections(val)
      },
    },
    methods : {
        querySelections(val) {
            console.log("test")
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