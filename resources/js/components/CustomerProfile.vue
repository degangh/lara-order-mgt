<template>
<div>
  <div v-if="loading" class="loading-wrapper"> <v-progress-linear :indeterminate="true"></v-progress-linear></div>
  <v-scroll-x-transition>
  <v-container grid-list-sm class="pa-4 title grey--text text-lighten-1" v-if="customerProfile">
          <v-layout row wrap>

            <v-flex xs12  justify-space-between>
              <v-layout>
                
                <v-flex xs1 mb-4 text-xs-right pr-2>
                
                <v-icon class="mr-3"  align-top>contacts</v-icon>
                </v-flex>
                <v-flex xs11 mb-4>
                <span>{{ customer.name }}</span>
                </v-flex>
                
              </v-layout>
            </v-flex>

            <v-flex xs12  justify-space-between>
              <v-layout>
                
                <v-flex xs1 mb-4 text-xs-right pr-2>
                
                <v-icon class="mr-3"  align-top>business</v-icon>
                </v-flex>
                <v-flex xs11 mb-4>
                <span v-if="customer.addresses">{{ customer.addresses[0].address}}</span>
                <span v-else>N/A</span>
                </v-flex>
                
              </v-layout>
            </v-flex>

            <v-flex xs12  justify-space-between>
              <v-layout>
                
                <v-flex xs1 mb-4 text-xs-right pr-2>
                
                <v-icon class="mr-3"  align-top>picture_in_picture</v-icon>
                </v-flex>
                <v-flex xs11 mb-4>
                  <span>{{customer.id_no}}</span>
                </v-flex>
                
              </v-layout>
            </v-flex>

            <v-flex xs12  justify-space-between>
              <v-layout>
                
                <v-flex xs1 mb-4 text-xs-center pr-2>
                
                <v-icon class="mr-3"  align-top>phonelink_ring</v-icon>
                </v-flex>
                <v-flex xs11 mb-4>
                  <span>{{customer.mobile}}</span>
                </v-flex>
                
              </v-layout>
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