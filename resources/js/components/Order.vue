<template>
<div class="container-fluid">
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div  class="m-b-md">
                    <table class="table table-striped">
                        <tr>
                            <th>
                            Name
                            </th>
                            <th>
                            Mobile
                            </th>
                            <th>
                            Order Date
                            </th>
                            <th>
                            
                            </th>
                        </tr>
                        <tbody>
                        <tr v-for = "(order, index) of orders" :key="index">
                            <td>{{order.customer.name}}12</td>
                            <td>{{order.customer.mobile}}</td>
                            <td>{{order.created_at}}</td>
                        </tr>

                        
                        </tbody>



                    </table>
                    <h3>
                    </h3>
                </div>
            </div>
        </div>
</div>
</template>
<script>
export default {

    data () {
        return {
            orders: []
        }
    },

    mounted () {
        let token = localStorage.getItem('jwt')

        axios.defaults.headers.common['Content-Type'] = 'application/json'
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
        this.requestOrderData();
    }, 

    methods: {
        requestOrderData () {
            axios.get('./api/orders')
            .then(this.handleOrderData)
        },

        handleOrderData (res) {
            this.orders = res.data
        }
    }

}
</script>
<style>
</style>