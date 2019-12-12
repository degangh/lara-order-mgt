<template>
  <v-container grid-list-sm fluid  v-if="order">
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
                  Phone: 
              </v-flex>
              <v-flex xs8>
                  {{order.address.mobile}}
              </v-flex>

          </v-layout>
          <v-divider></v-divider>
        <v-layout v-for = "(item, index) of order.items" :key="index" class="body-2 grey--text text-darken-3" >
            <v-flex xs3>
                {{item.product.name}}
            </v-flex>
            <v-flex xs3 text-right>
                {{item.quantity}}
            </v-flex>
            <v-flex xs3 text-right>
                {{item.unit_price_cny}}
            </v-flex>
            <v-flex xs3 text-right>
                {{parseFloat(item.quantity * item.unit_price_cny).toFixed(2)}}
            </v-flex>

            
        </v-layout>
        <v-layout>
            <v-flex xs12 text-right>
                {{orderSum}}
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

    computed:{
        orderSum: function()
        {
            let sum = 0.00
            this.order.items.map(function(item){
                sum += item.quantity * item.unit_price_cny
            })
            return parseFloat(sum).toFixed(2)
        }
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