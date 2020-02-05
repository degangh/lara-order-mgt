<template>
  <v-container grid-list-sm fluid  v-if="order">
          <v-layout row>
              <v-flex xs12 class="title">
                  Customer Infomration
              </v-flex>
          </v-layout>
          <v-layout row wrap>
              <v-flex xs4>
                  Customer Name:
              </v-flex>
              <v-flex xs8>
                   {{order.customer.name}}
              </v-flex>
              
          </v-layout>
          <v-layout row >

              <v-flex xs4>
                  Address: 
              </v-flex>
              <v-flex xs8 v-if="order.address">
                  {{order.address.address}}
              </v-flex>
              <v-flex xs8 v-else>
                  Address Missing
              </v-flex>

          </v-layout>

          <v-layout row>

              <v-flex xs4>
                  Phone: 
              </v-flex>
              <v-flex xs8 v-if="order.address">
                  {{order.address.mobile}}
              </v-flex>
              <v-flex v-else>
                  Mobile is missing
              </v-flex>

          </v-layout>
          <v-divider></v-divider>
          <v-layout row >
              <v-flex xs12 class="title">
                  Order Detail
              </v-flex>
          </v-layout>
          <div v-if="order.items.length > 0">
          <v-layout  class="font-weight-black" >
            <v-flex xs4>
                Product
            </v-flex>
            <v-flex xs2 text-right>
                Quantity
            </v-flex>
            
            <v-flex xs2 text-right>
                Purchase Price AUD
            </v-flex>
            <v-flex xs2 text-right>
                Unit Sale Price CNY
            </v-flex>
            
            <v-flex xs2 text-right>
                Sub Total
            </v-flex>

            
        </v-layout>
        <v-layout v-for = "(item, index) of order.items" :key="index" class="caption text-lighten-2" >
            <v-flex xs4>
                {{item.product.name}}
            </v-flex>
            <v-flex xs2 text-right>
                {{item.quantity}}
            </v-flex>
            <v-flex xs2 text-right>
                AUD{{item.purchase_price_aud}}
            </v-flex>
            <v-flex xs2 text-right>
                CNY{{item.unit_price_cny}}
            </v-flex>
            <v-flex xs2 text-right>
                {{parseFloat(item.quantity * item.unit_price_cny).toFixed(2)}}
            </v-flex>

            
        </v-layout>
        
        <v-layout>
            
            <v-flex xs12 text-right class="body-2">
                {{orderSum}}
            </v-flex>
        </v-layout>

        <v-layout >
            <v-flex xs12 text-right class="caption text-lighten-2">
                Exchange Rate: {{order.items[0].exchange_rate}}
            </v-flex>
        </v-layout>
        </div>
        <div text-center v-else>
            No items in the order
        </div>
        <v-layout>
            <v-flex xs12 md4>
                <v-btn color="blue" dark>
                    <v-icon>add</v-icon>Add item
                </v-btn>
            </v-flex>

            <v-flex xs12 md4>
                <v-btn color="blue" dark>
                    Mark as Sent
                </v-btn>
            </v-flex>

            <v-flex xs12 md4>
                <v-btn color="blue" dark>
                    Mark as Paid
                </v-btn>
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