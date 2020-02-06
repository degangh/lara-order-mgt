<template>
<div>
<v-dialog v-model="dialog" width="800px" :fullscreen="$vuetify.breakpoint.smAndDown" persistent>
    <v-card>
        <v-toolbar dark color="primary">
          
          <v-toolbar-title>Add Product</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn icon dark @click="emitCloseDialog('contactDialog')">
            <v-icon>close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-form v-model="valid" ref="ContactForm">
        <v-container grid-list-sm class="pa-4">
            <v-toolbar

            >
                <v-toolbar-title>Product Search</v-toolbar-title>
                <v-autocomplete
                v-model="select"
                :loading="loading"
                :items="products"
                :search-input.sync="search"
                cache-items
                class="mx-4"
                flat
                hide-no-data
                hide-details
                label="search product name"
                solo-inverted
                ></v-autocomplete>
                <v-btn icon>
                <v-icon>mdi-dots-vertical</v-icon>
                </v-btn>
            </v-toolbar>
        </v-container>
        </v-form>

        <v-card-actions>
          
          <v-spacer></v-spacer>
          <v-btn flat color="primary" @click="emitCloseDialog('contactDialog')">Cancel</v-btn>
          <v-btn flat @click="saveContact">Save</v-btn>
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
        }
    },
    watch: {
      search (val) {
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
        }
    },
    props: {
        dialog: Boolean
    },
}
</script>