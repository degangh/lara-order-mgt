<template>
<div>
<v-dialog v-model="dialog" width="800px" :fullscreen="$vuetify.breakpoint.smAndDown" persistent>
      <v-card>
        <v-toolbar dark color="primary">
          
          <v-toolbar-title>{{form_title}}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn icon dark @click="emitCloseDialog('addressDialog')">
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
                :rules = "addressRules"
              ></v-text-field>
            </v-flex>
            
            <v-flex xs12>
              <v-text-field
                type="tel"
                prepend-icon="phonelink_ring"
                placeholder="1388888888"
                v-model = "mobile"
                :rules  = "mobileRules"
                
              ></v-text-field>
            </v-flex>

            <v-flex xs12>
              <v-text-field
                prepend-icon="room"
                placeholder="Postcode: etc. 100010"
                v-model = "postcode"
                
                
              ></v-text-field>
            </v-flex>
        </v-container>
        </v-form>
        <v-card-actions>
          <!--v-btn flat color="primary">More</v-btn-->
          <v-spacer></v-spacer>
          <v-btn flat color="primary" @click="emitCloseDialog('addressDialog')">Cancel</v-btn>
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
        dialog: Boolean,
        selectedAddress: {
          type: [Object, null]
        }
    },

    watch: {
      selectedAddress(a) {
        if (a == null) return;
        this.address = a.address
        this.mobile = a.mobile
        this.postcode = a.postcode
        this.is_edit = true
        this.form_title = "Edit Address"
      }
    },

    data() {
        return {
            form_title: 'Add Address',
            is_edit: false,
            address: '',
            mobile: '',
            postcode: '',
            valid: false,
            snackbar: false,
            snackbarText: '',
            mobileRules: [
              v => !!v || 'Phone number is required',
              v => /^\d+$/.test(v) || 'Phone number must contain digit only'
            ],
            addressRules: [
              v => !!v || 'Address is required',
              
            ],
        }
    },
    methods: {
        emitCloseDialog (form) {
            this.$refs.AddressForm.reset()
            this.$emit("closeDialog", form)
        },
        saveAddress () {
          if (!this.$refs.AddressForm.validate()) return
          let formAction = (this.is_edit) ? 'patch' : 'post'
          let url = '/api/addresses' + ((this.is_edit) ? '/' + this.selectedAddress.id : '' )
          axios({
            method: formAction,
            url: url,
            data: {
                  customer_id: this.$route.params.id,
                  address: this.address,
                  mobile: this.mobile,
                  postcode: this.postcode
            }
          })
          .then(this.handleResponse)
          .catch(function (err) {
            alert (err)
          })
          
        },

        handleResponse(res) {
          //this.$root.$emit('addNewAddress', res.data)
          this.emitCloseDialog('addressDialog')
        }
    }
}
</script>
