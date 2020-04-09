<template>
<div class="table-responsive">
    <table class="table table-striped">
        <tr>
            <th class="col1">
            Name
            </th>
            <th class="col2">
            Mobile
            </th>
            <th class="col3">
            Order Sum
            </th>
            <th>
            Order Date
            </th>
            <th>
            Delivery Status
            </th>
            <th>
            Payment Status
            </th>
        </tr>
        <tbody>
        <tr v-for = "(order, index) of orders" :key="index" @click="gotoOrderPage(order.id)">
            <td v-if="order.customer">{{order.customer.name}}</td>
            <td v-else>N/A</td>
            <td v-if="order.customer">{{order.customer.mobile}}</td>
            <td v-else>N/A</td>
            <td v-if="order.sum" class="text-right">{{order.sum}}</td>
            <td v-else class="text-right">0.00</td>
            <td>{{order.created_at}}</td>
            <td>{{(order.sent == 0 ) ? "Pending" : "Sent"}}</td>
            <td>{{(order.paid == 0) ? "Pending" : "Paid"}}</td>
        </tr>

        
        </tbody>



    </table>
    </div>
</template>
<script>
export default {
    name: 'OrderList',
    props: {
        orders: Array|null
    },
    methods: {
        gotoOrderPage(id) {
            this.$router.push('/orders/'+id)
        }
    }
}
</script>

<style scoped>

.col1 {
    width: 20%
}
.col2 {
    width: 20%
}
.col3{
    width: 10%
}
</style>