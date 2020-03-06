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
                    <order-list :orders="orders"></order-list>
                    
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
import OrderList from './OrderList'
export default {
    components: {
        OrderList
    },
    data () {
        return {
            orders: [],
            page: 1,
            totalPage: null,
            loading: true
        }
    },

    mounted () {

        this.requestOrderData();
    }, 

    watch: {
        '$route' (to, from){

            if (this.$router.currentRoute.path == '/orders') this.page =1
            this.loading = true
            this.$router.push(this.$router.currentRoute.path)
            this.requestOrderData();
        }
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
            this.totalPage = res.data.last_page
            this.loading = false

        },

        onPageChange () {
          this.loading = true
          this.$router.push('/orders/p' + this.page)
        },

        gotoOrderPage (id) {
          this.$router.push('/orders/'+id)
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