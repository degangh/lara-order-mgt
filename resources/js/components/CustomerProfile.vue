<template>
<div>
  <div v-if="loading" class="loading-wrapper"> <v-progress-linear :indeterminate="true"></v-progress-linear></div>
  <v-scroll-x-transition>
  <v-container grid-list-sm class="pa-4 title grey--text text-lighten-1" v-if="customerProfile">
          <v-layout row wrap>
            <v-flex xs12 align-center justify-space-between>
              <v-layout align-center>
                
                <v-flex xs12 mb-4>
                
                <v-icon class="mr-3">contacts</v-icon>
                {{ customer.name }}
                </v-flex>
                
              </v-layout>
            </v-flex>
            
            
            <v-flex xs12 mb-4>
            <v-icon class="mr-3">business</v-icon>
            <span v-if="customer.addresses">{{ customer.addresses[0].address}}</span>
            <span v-else>N/A</span>
            </v-flex>

            <v-flex xs12 mb-4>
            <v-icon class="mr-3">picture_in_picture</v-icon>
            {{ customer.id_no}}
            </v-flex>
            
            <v-flex xs12 mb-4>
              <v-icon class="mr-3">phonelink_ring</v-icon>
              {{ customer.mobile}}
            </v-flex>
          </v-layout>
        </v-container>
</v-scroll-x-transition>
</div>
</template>


<script>
export default {

    data () {
      return {
        customer: {},
        customerProfile: false,
        loading: true
        

      }
    },

    mounted() {
        console.log(this.$route.params.id)

        this.requestCustomerInfo();

    },

    methods: {
      requestCustomerInfo () {
        axios.get('/api/customers/' + this.$route.params.id)
          .then(this.handleResponse)
      },

      handleResponse (res) {
        console.log(res)
        this.customer = res.data[0]
        this.loading = false
        this.customerProfile = true
      }

    }

}
</script>