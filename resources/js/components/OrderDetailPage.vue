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
          <div v-if="order.items.length > 0" fill-height>
          <v-layout  class="font-weight-black" >
            <v-flex xs3>
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
            <v-flex text-center>
                Action
            </v-flex>

            
        </v-layout>
        <v-layout v-for = "(item, index) of order.items" :key="index" class="caption text-lighten-2 align-center" >
            <v-flex xs3>
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
            <v-flex xs1 text-center sm="3">
                <v-btn icon x-small >
                    <v-icon color="blue-grey" 
        
                    @click="confirmDeleteDialog('Delete item', 'Confirm to delete the selected order item?', {}, item.id)">
                    delete
                    </v-icon>
                </v-btn>
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
        <v-layout wrap>
            <v-flex xs12 md4 text-center>
                <v-btn color="blue" dark @click="popupFormDialog('orderDetailDialogue')" block>
                    <v-icon left>add</v-icon>Add item
                </v-btn>
            </v-flex>

            <v-flex xs12 md4 text-center>
                <v-btn color="blue" dark  block 
                @click="confirmDialog('Confirm','Confirm to mark the order as `SENT`?', {}, 'sent')">
                    <v-icon left>local_shipping</v-icon>Mark as Sent
                </v-btn>
            </v-flex>

            <v-flex xs12 md4 text-center>
                <v-btn color="blue" dark block 
                @click="confirmDialog('Confirm','Only confirm to the order as `PAID` after the money is collected', {}, 'paid')">
                    <v-icon left>local_atm</v-icon>Mark as Paid
                </v-btn>
            </v-flex>
        </v-layout>

        <edit-order-item :dialog="orderDetailDialogue" @closeDialog="closeFormDialog"></edit-order-item>    
        <confirm ref="confirm"></confirm>
        <message ref="message"></message>
  </v-container>
</template>

<script>
import EditOrderItem from './EditOrderItem'
import Message from './Message'
import Confirm from './Confirm'
export default {
    components: {
        EditOrderItem,
        Confirm,
        Message
    },
    data () {
        return {
            order: false,
            orderDetailDialogue: false,
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
        },
        popupFormDialog (form, address = null) {
            this[form] =  true
        
        },
        closeFormDialog (form, status, message) {
        this[form] = false
        if (status == "success") this.messageDialog('Success','The item has been added to the order',{})
        if (status == "failed") this.messageDialog('Error',message,{})
        this.requestOrderDetailData()
        },

        confirmDialog(title, message, options, operation)
        {
            this.$refs.confirm.open(title, message, options).then((confirm) => {
                axios.patch('/api/order/' + this.$route.params.id + '/' + operation)
                .then(()=>{this.requestOrderDetailData();this.messageDialog('Success','The order status is updated',{})})
                .catch((e)=>{console.log(e)})
            }).catch((e)=>{
                console.log(e)
            })
        },

        confirmDeleteDialog(title, message, options, itemId)
        {
            this.$refs.confirm.open(title, message, options).then((confirm) => {
                axios.delete('/api/orderItems/' + itemId)
                .then(()=>{this.requestOrderDetailData()})
                .catch((e)=>{console.log(e); this.messageDialog('Error',e.data.message,{})})
            }).catch((e)=>{
                console.log(e)
            })
        }, 

        messageDialog(title, message, options)
        {
            this.$refs.message.open(title, message, options)
        }




    },
    filters: {
        uppercase: function (value) {
            if (!value) return ''
            value = value.toString()
            return value.toUpperCase()
        }

    }
}
</script>