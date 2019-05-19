<template>
<div>
<v-dialog v-model="dialog" width="800px" :fullscreen="$vuetify.breakpoint.smAndDown" persistent>
      <v-card>
        <v-toolbar dark color="primary">
          
          <v-toolbar-title>Add Address</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn icon dark @click="emitCloseDialog">
            <v-icon>close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-form v-model="valid" ref="AddressForm">
        <v-container grid-list-sm class="pa-4">
            <v-flex xs12>
              <v-text-field
                prepend-icon="business"
                placeholder="Address"
                v-model = "address"
              ></v-text-field>
            </v-flex>
            
            <v-flex xs12>
              <v-text-field
                type="tel"
                prepend-icon="phonelink_ring"
                placeholder="1388888888"
                v-model = "mobile"
                
              ></v-text-field>
            </v-flex>
        </v-container>
        </v-form>
        <v-card-actions>
          <!--v-btn flat color="primary">More</v-btn-->
          <v-spacer></v-spacer>
          <v-btn flat color="primary" @click="emitCloseDialog">Cancel</v-btn>
          <v-btn flat @click="saveAddress">Save</v-btn>
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
    name: "AddressForm" , 

    props: {
        dialog: Boolean
    },

    data() {
        return {
            address: '',
            mobile: '',
            postcode: '',
            valid: false,
            snackbar: false,
            snackbarText: ''
        }
    },
    methods: {
        emitCloseDialog () {
            this.$refs.AddressForm.reset()
            this.$emit("closeAddressDialog")
        },
        saveAddress () {

        }
    }
}
</script>
