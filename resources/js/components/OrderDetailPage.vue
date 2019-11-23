<template>
  <v-container grid-list-sm fluid class="pa-4 title grey--text text-lighten-1" v-if="order">
          <v-layout row wrap>
              <v-flex xs4>
                  Customer Name:
              </v-flex>
              <v-flex xs8>
                   {{order.customer.name}}
              </v-flex>
              
          </v-layout>
          <v-layout row>

              <v-flex xs4>
                  Address: 
              </v-flex>
              <v-flex xs8>
                  {{order.address.address}}
              </v-flex>

          </v-layout>

          <v-layout row>

              <v-flex xs4>
                  PHone: 
              </v-flex>
              <v-flex xs8>
                  {{order.address.mobile}}
              </v-flex>

          </v-layout>
          <v-divider></v-divider>
        <v-layout v-for = "(item, index) of order.items" :key="index">
            <v-flex xs3>
                {{item.product.name}}
            </v-flex>
            <v-flex xs3>
                {{item.quantity}}
            </v-flex>
            <v-flex xs3>
                {{item.unit_price_cny}}
            </v-flex>
            <v-flex xs3>
                {{item.quantity * item.unit_price_cny}}
            </v-flex>
        </v-layout>
  </v-container>
</template>

<script>
export default {
    data () {
        return {
            order: false
        }
    },

    mounted () {
        this.requestOrderDetailData()
    },

    methods: {
        requestOrderDetailData() {
            axios.get('/api/orders/' + this.$route.params.id)
            .then(this.handleResponse)
            .catch(this.handleError)
        },
        handleResponse (res) {
            console.log(res.data[0])
            this.order = res.data[0]
            this.ready = true
            this.loading = false
        },
        handleError (error) {
            alert (error)
            this.ready = true
            this.loading = false
        }
    }
}
</script>