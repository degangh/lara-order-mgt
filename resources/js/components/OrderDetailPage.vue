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

          <v-layout row>

              <v-flex xs4>
                  Order Date: 
              </v-flex>
              <v-flex xs8 >
                  {{order.order_date}}
              </v-flex>

          </v-layout>

          <v-layout row>

              <v-flex xs4>
                  Delivery Status: 
              </v-flex>
              <v-flex xs8 class="font-weight-medium">
                  <span class="green--text" v-if="order.sent == 1">Sent</span>
                  <span class="red--text" v-else>Pending</span>
              </v-flex>

          </v-layout>

          <v-layout row>

              <v-flex xs4>
                  Payment Status: 
              </v-flex>
              <v-flex xs8 class="font-weight-medium">
                  <span class="green--text" v-if="order.paid == 1">Paid</span>
                  <span class="red--text" v-else>Pending</span>
              </v-flex>

          </v-layout>
          <v-divider></v-divider>
          <v-layout row class="title-row">
              <v-flex xs12 class="title">
                  Order Detail
              </v-flex>
          </v-layout>
          <div v-if="order.items.length > 0" fill-height>
          <v-layout  class="font-weight-black" v-if="$vuetify.breakpoint.smAndUp">
            <v-flex md4>
                Product
            </v-flex>
            <v-flex md6>
                <v-layout row wrap>
                    <v-flex sm4 text-right>
                        Unit
                    </v-flex>
                    
                    <v-flex sm4 text-right>
                        Purchase AUD
                    </v-flex>
                    <v-flex sm4 text-right>
                        Unit Sale CNY
                    </v-flex>
                </v-layout>
            </v-flex>
            
            
            <v-flex sm2 text-center>
                Action
            </v-flex>

            
        </v-layout>
        <v-layout row wrap v-for = "(item, index) of order.items" :key="index" 
        class="caption text-lighten-2 align-start order-item-row" 
        :class="{'light-grey-row': index % 2 === 0, '': index % 2 !== 0 }">
            <v-flex md4 sm4 xs6 class="product-name">
                {{item.product.name}}
            </v-flex>
            <v-flex md6 sm6 xs4 text-right>
                <v-layout row wrap>
                    <v-flex md4 sm4 xs12>
                        <span class="currency-symbol">x</span>
                        <span class="currency">{{item.quantity}}</span></v-flex>
                
                    <v-flex md4 sm4 xs12>
                        <span class="currency-symbol">AUD</span>
                        <span class="currency">{{item.purchase_price_aud}}</span>
                    </v-flex>
                    <v-flex md4 sm4 xs12>
                        <span class="currency-symbol">CNY</span>
                        <span class="currency">{{item.unit_price_cny}}</span></v-flex>
                </v-layout>
                
            </v-flex>
            
            <!--v-flex xs2 text-right>
                {{parseFloat(item.quantity * item.unit_price_cny).toFixed(2)}}
            </v-flex-->
            <v-flex md2 sm2 xs2 sm="3" align-start text-center>
                <v-btn icon x-small class="delete-btn">
                    <v-icon color="blue-grey" 
        
                    @click="confirmDeleteDialog('Delete item', 'Confirm to delete the selected order item?', {}, item.id)">
                    delete
                    </v-icon>

                    
                </v-btn>

                <v-btn icon x-small class="delete-btn">
                    <v-icon color="blue-grey" 
        
                    @click="popupFormDialog('orderDetailDialogue', item)">
                    edit
                    </v-icon>

                    
                </v-btn>
            </v-flex>

            
        </v-layout>
        
        <v-layout>
            
            <v-flex xs12 text-right class="total-amount">
                <span>Total: </span>
                <span class="currency-symbol">CNY</span>
                <span class="total-amount">{{orderSum}}</span>
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
            <v-flex xs12 sm4 text-center>
                <v-btn color="blue" 
                :dark ="order.paid == 0 && order.sent==0"
                :disabled="order.paid == 1 || order.sent ==1"
                @click="popupFormDialog('orderDetailDialogue')" block>
                    <v-icon left>add</v-icon>Add item
                </v-btn>
            </v-flex>

            <v-flex xs12 sm4 text-center>
                <v-btn color="blue" :dark="order.sent == 0"  block 
                :disabled="order.sent == 1"
                @click="confirmDialog('Confirm','Confirm to mark the order as `SENT`?', {}, 'sent')">
                    <v-icon left>local_shipping</v-icon>Mark as Sent
                </v-btn>
            </v-flex>

            <v-flex xs12 sm4 text-center>
                <v-btn color="blue" :dark="order.paid == 0" block 
                :disabled="order.paid == 1"
                @click="confirmDialog('Confirm','Only confirm to the order as `PAID` after the money is collected', {}, 'paid')">
                    <v-icon left>local_atm</v-icon>Mark as Paid
                </v-btn>
            </v-flex>
        </v-layout>

        <edit-order-item 
        :dialog="orderDetailDialogue" 
        @closeDialog="closeFormDialog"
        :item="selectedItem"></edit-order-item>    
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
            selectedItem: null
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
        popupFormDialog (form, item = null) {
            this[form] =  true
            this.selectedItem = item
        },
        closeFormDialog (form, status, message) {
        this[form] = false
        if (status == "success") this.messageDialog('Success',message,{})
        if (status == "failed") this.messageDialog('Error',message,{})
        this.requestOrderDetailData()
        },

        confirmDialog(title, message, options, operation)
        {
            this.$refs.confirm.open(title, message, options).then((confirm) => {
                axios.patch('/api/order/' + this.$route.params.id + '/' + operation)
                .then(()=>{this.requestOrderDetailData();this.messageDialog('Success','The order status is updated',{})})
                .catch((e)=>{
                    this.messageDialog('Error',e.data.message,{})
                })
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

<style scoped>
.product-name {
    font-size: 1.2rem;
    font-weight: 200
}
.order-item-row {
    margin-bottom: 0.4rem !important;
}
.order-item-row:nth-child(even) {
  background-color: rgba(0,0,0,0.05)
}


.total-amount {
    font-weight: 400;
    font-size: 1.6rem
}
.currency-symbol{
    font-size: 0.7rem
}
.currency{
    font-size: 1.1rem
}
.delete-btn{
    margin-top: -4px !important
}
.title-row {
    margin-bottom: 1.8rem !important
}
</style>