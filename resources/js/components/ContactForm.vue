<template>
<div>
<v-dialog v-model="dialog" width="800px" :fullscreen="$vuetify.breakpoint.smAndDown" persistent>
      <v-card>
        <v-toolbar dark color="primary">
          
          <v-toolbar-title>Create Contact</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn icon dark @click="emitCloseDialog('contactDialog')">
            <v-icon>close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-form v-model="valid" ref="ContactForm">
        <v-container grid-list-sm class="pa-4">
          <v-layout row wrap>
            <v-flex xs12 align-center justify-space-between>
              <v-layout align-center>
                
                <v-flex xs9>
                <v-text-field
                  placeholder="Name"
                  prepend-icon="contacts"
                  v-model = "name"
                  :rules="nameRules"
                ></v-text-field>
                </v-flex>
                <v-flex xs3>
                  <v-text-field
                  placeholder="Initial"
                  v-model = "name_py"
                  :rules = "pyRules"
                ></v-text-field>
                </v-flex>
              </v-layout>
            </v-flex>
            <v-text-field
                prepend-icon="business"
                placeholder="Address"
                v-model = "default_address"
                :rules = "addressRules"
              ></v-text-field>
            
            
            <v-flex xs12>
              <v-text-field
                prepend-icon="picture_in_picture"
                placeholder="ID No#"
                v-model = "id_no"
              ></v-text-field>
            </v-flex>
            <v-flex xs12>
              <v-text-field
                type="tel"
                prepend-icon="phonelink_ring"
                placeholder="13888888888"
                v-model = "mobile"
                :rules = "mobileRules"
              ></v-text-field>
            </v-flex>
            <v-flex xs12>
              <v-text-field
                prepend-icon="notes"
                placeholder="Notes"
              ></v-text-field>
            </v-flex>
          </v-layout>
        </v-container>
        </v-form>
        <v-card-actions>
          <!--v-btn flat color="primary">More</v-btn-->
          <v-spacer></v-spacer>
          <v-btn flat color="primary" @click="emitCloseDialog('contactDialog')">Cancel</v-btn>
          <v-btn flat @click="saveContact">Save</v-btn>
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
    name: "ContactForm",

    data() {
      return {
        valid: false,
        name: '',
        name_py: '',
        mobile: '',
        id_no: '',
        default_address: '',
        postcode: '',
        nameRules: [
            v => !!v || 'Customer Name is required'
        ], 
        pyRules:[
          v => !!v || 'Name Initial is required'
        ],
        addressRules:[
          v => !!v || 'Address is required'
        ],
        mobileRules: [
          v => !!v || 'Phone number is required',
          v => /^\d+$/.test(v) || 'Phone number must contain digit only'
        ],
        snackbar: false,
        snackbarText: "Saving contact information"
      }
    }, 

    props: {
        dialog: Boolean
    },

    methods : {
      emitCloseDialog (form) {
        this.$refs.ContactForm.reset()
        this.$emit("closeDialog", form)
      },

      saveContact () {
        
        if (!this.$refs.ContactForm.validate()) return
        this.snackbar = true


        axios.post('/api/customers', {
     
                  name: this.name,
                  name_py: this.name_py,
                  mobile: this.mobile,
                  id_no: this.id_no,
                  address: this.default_address,
                  postcode: this.postcode
     
          })
          .then(this.handleResponse)
          .catch(function (err) {
            alert (err)
          })


      },

      handleResponse (res) {
        this.snackbar = false
        this.emitCloseDialog('contactDialog')
        if (res.data.id) this.$router.push("/customer/" + res.data.id);
      }
    }
}
</script>

<style>
</style>