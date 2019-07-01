<template>
<div v-if="ready">
  <div v-if="loading" class="loading-wrapper"> <v-progress-linear :indeterminate="true"></v-progress-linear></div>

  <v-container grid-list-sm fluid class="pa-4 title grey--text text-lighten-1" v-if="customerProfile">
          <v-layout row wrap>

            <v-flex xs12  justify-space-between>
              <v-layout>
                
                <v-flex xs2 sm1 mb-4 text-xs-left text-sm-right pr-2>
                
                <v-icon class="mr-3"  align-top>contacts</v-icon>
                </v-flex>
                <v-flex xs10 sm11 mb-4>
                <span>{{ customer.name }}</span>
                </v-flex>
                
              </v-layout>
            </v-flex>

            <v-flex xs12  justify-space-between>
              <v-layout>
                
                <v-flex xs2 sm1 mb-4 text-xs-left text-sm-right pr-2>
                
                <v-icon class="mr-3"  align-top>business</v-icon>
                </v-flex>
                <v-flex xs10 sm11 mb-4>
                <span v-if="customer.addresses.length > 0">{{ customer.addresses[0].address}}</span>
                <span v-else>N/A</span>
                </v-flex>
                
              </v-layout>
            </v-flex>

            <v-flex xs12  justify-space-between>
              <v-layout>
                
                <v-flex xs2 sm1 mb-4 text-xs-left text-sm-right pr-2>
                
                <v-icon class="mr-3"  align-top>picture_in_picture</v-icon>
                </v-flex>
                <v-flex xs10 sm11 mb-4>
                  <span>{{customer.id_no}}</span>
                </v-flex>
                
              </v-layout>
            </v-flex>

            <v-flex xs12  justify-space-between>
              <v-layout>
                
                <v-flex xs2 sm1 mb-4 text-xs-left text-sm-right pr-2>
                
                <v-icon class="mr-3"  align-top>phonelink_ring</v-icon>
                </v-flex>
                <v-flex xs10 sm11 mb-4>
                  <span>{{customer.mobile}}</span>
                </v-flex>
                
              </v-layout>
            </v-flex>
            
          </v-layout>
        </v-container>
<div v-if = "addresses">
<v-divider :inset="$vuetify.breakpoint.mdAndUp" ></v-divider>

<v-subheader :inset="$vuetify.breakpoint.mdAndUp" >Other Addresses</v-subheader>
<v-container grid-list-sm fluid class="pa-4  grey--text text-lighten-1" v-if="addresses.length > 0">
  <v-flex xs12  
  justify-space-between 
  v-for = "(a, index) in addresses" 
  :key="index"
  @click = "setDefaultAddress(a)">
              <v-layout class="address-wrapper">
                
                <v-flex xs2 sm1 mb-4 text-xs-left text-sm-right pr-2>
                
                <v-icon v-if = "!Boolean(a.is_default*1)">check_box_outline_blank</v-icon>
                <v-icon v-else  color="blue darken-2">check_box</v-icon>
                </v-flex>
                <v-flex xs10 sm11 mb-4 body-2>
                {{a.address}} {{a.mobile}}
                </v-flex>
                
              </v-layout>
            </v-flex>
</v-container>
<v-container grid-list-sm fluid class="pa-4  grey--text text-lighten-1" v-if="addresses.length === 0">
  <v-layout
      row wrap inset
    >
      <v-flex
        xs12
        md4
        justify-space-between
      >
      <v-layout>
        <v-alert
      :value="true"
      color="error"
      icon="warning"
      outline
      
    >
      There is no address available for this customer.
    </v-alert>
      </v-layout>
      </v-flex>
  </v-layout>
</v-container>
</div>

<div>
  
</div>
<v-container  fluid class="pa-4  grey--text text-lighten-1" v-if="!customer">
  <v-layout
      row wrap 
    >


        <v-alert
      :value="true"
      color="error"
      icon="warning"
      outline
      
    >
      Customer Not Found
    </v-alert>


  </v-layout>
</v-container>
<v-snackbar v-model="snackbar">
      {{snackbarText}}
</v-snackbar>
</div>
</template>


<script>
export default {

    data () {
      return {
        customer: false,
        customerProfile: false,
        loading: true,
        addresses: false,
        ready: false,
        snackbar: false,
        snackbarText: "Address is set successfully"
        

      }
    },

    mounted() {
       this.requestCustomerInfo();

       this.$root.$on("addNewAddress", (address) => {
         this.addresses.push(address)
         if (this.customer.addresses.length == 0) this.customer.addresses.push(address)
         })

    },

    methods: {
      requestCustomerInfo () {
        axios.get('/api/customers/' + this.$route.params.id)
          .then(this.handleResponse)
          .catch(this.handleError)
      },

      handleResponse (res) {
        console.log(res.data)
        if (res.data)
        {
          this.customer = res.data[0]
          this.loading = false
          this.customerProfile = true
          this.addresses = res.data[0].addresses
          this.ready = true

        }  
      },
      handleError(error) {
        this.ready = true
        this.loading = false
      },
      setDefaultAddress(address) {
        axios.patch('/api/addresses/default', {
          id: address.id,
          customer_id: address.customer_id
        })
          .then(this.requestCustomerInfo).then(this.showSnackbar)
      },
      showSnackbar(){
        this.snackbar = true
      }

    }

}
</script>

<style scoped>
.address-wrapper {
  vertical-align: bottom;
  font-size: 1.3rem;
  cursor: pointer
}
</style>