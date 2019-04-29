<template>
<v-dialog v-model="dialog" width="800px">
      <v-card>
        <v-card-title
          class="grey lighten-4 py-4 title"
        >
          Create contact
        </v-card-title>
        <v-container grid-list-sm class="pa-4">
          <v-layout row wrap>
            <v-flex xs12 align-center justify-space-between>
              <v-layout align-center>
                
                <v-flex xs9>
                <v-text-field
                  placeholder="Name"
                  prepend-icon="contacts"
                  v-model = "name"
                ></v-text-field>
                </v-flex>
                <v-flex xs3>
                  <v-text-field
                  placeholder="Initial"
                  v-model = "name_py"
                ></v-text-field>
                </v-flex>
              </v-layout>
            </v-flex>
            <v-text-field
                prepend-icon="business"
                placeholder="Address"
                v-model = "default_address"
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
        <v-card-actions>
          <!--v-btn flat color="primary">More</v-btn-->
          <v-spacer></v-spacer>
          <v-btn flat color="primary" @click="emitCloseDialog">Cancel</v-btn>
          <v-btn flat @click="saveContact">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    </template>

<script>
export default {
    name: "ContactForm",

    data() {
      return {
        name: '',
        name_py: '',
        mobile: '',
        id_no: '',
        default_address: ''
      }
    }, 

    props: {
        dialog: Boolean
    },

    methods : {
      emitCloseDialog () {
        this.$emit("closeContactDialog")
      },

      saveContact () {
        console.log("save button clicked")
        console.log(this.name, this.name_py, this.mobile, this.id_no, this.default_address)

        let token = localStorage.getItem('jwt')
        axios.defaults.headers.common['Content-Type'] = 'application/json'
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token

        axios.post('/api/customers', {
              params: {
                  name: this.name,
                  name_py: this.name_py,
                  mobile: this.mobile,
                  id_no: this.id_no,
                  default_address: this.default_address
              }
          })
          .then(this.handleResponse)


      },

      handleResponse (res) {
        console.log (res)
      }
    }
}
</script>

<style>
</style>