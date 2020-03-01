<template>
<div>
    <order-list :orders='orders' ref='order-list'></order-list>
</div>
</template>

<script>
import OrderList from './OrderList'
export default {
    components: {
      OrderList
    },
    data () {
        return {
            orders: null
        }
    },
    mounted() {
        this.requestOrderData()
    },
    methods : {
        requestOrderData () {
            axios.get('/api/customers/' + this.$route.params.id + '/orders')
            .then(this.handleOrderData)
        },

        handleOrderData (res) {
            this.orders = res.data.data
            //this.totalPage = res.data.last_page
            //this.loading = false

        }
    }
    
}
</script>