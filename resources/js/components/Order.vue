<template>
<div class="container-fluid">
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div  class="m-b-md">
                    <div class="pagination-container">
                        <v-pagination
                        v-model="page"
                        :length="totalPage"
                        :total-visible = "7"
                        @input="onPageChange"
                        circle
                        ></v-pagination>
                    </div>
                    <div v-if="loading" class="loading-wrapper"> <v-progress-linear :indeterminate="true"></v-progress-linear></div>
                    <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th class="col1">
                            Name
                            </th>
                            <th class="col2">
                            Mobile
                            </th>
                            <th>
                            Order Sum
                            </th>
                            <th>
                            Order Date
                            </th>
                            <th>
                            
                            </th>
                        </tr>
                        <tbody>
                        <tr v-for = "(order, index) of orders" :key="index">
                            <td v-if="order.customer">{{order.customer.name}}</td>
                            <td v-else>N/A</td>
                            <td v-if="order.customer">{{order.customer.mobile}}</td>
                            <td v-else>N/A</td>
                            <td v-if="order.sum" class="text-right">{{order.sum}}</td>
                            <td v-else class="text-right">0.00</td>
                            <td>{{order.created_at}}</td>
                        </tr>

                        
                        </tbody>



                    </table>
                    </div>
                    <div class="pagination-container">
                        <v-pagination
                        v-model="page"
                        :length="totalPage"
                        :total-visible = "7"
                        @input="onPageChange"
                        circle
                        ></v-pagination>
                    </div>
                    
                </div>
            </div>
        </div>
</div>
</template>
<script>
export default {

    data () {
        return {
            orders: [],
            page: 1,
            totalPage: null,
            loading: true
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
            axios.get('/api/orders',{
                params: {
                  page: this.page
              }
            })
            .then(this.handleOrderData)
        },

        handleOrderData (res) {
            this.orders = res.data.data
            this.page = res.data.current_page
            this.totalPage = res.data.last_page
            this.loading = false

        },

        onPageChange () {
          this.loading = true
          this.$router.push('/orders/p' + this.page)
          this.requestOrderData();
      }
    }

}
</script>
<style scoped>
.pagination-container {
    float: right;
    padding: 0.3rem 1rem
}
.loading-wrapper{
    height: 2.4rem
}
.col1 {
    width: 20%
}
.col2 {
    width: 20%
}
</style>