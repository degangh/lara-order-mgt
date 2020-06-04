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
                            Address
                            </th>
                            <th>
                            ID No
                            </th>
                        </tr>
                        <tbody>
                        <tr v-for = "(customer, index) of customers" :key="index" @click="gotoCustomerPage(customer.id)">
                            <td>{{customer.name}}</td>
                            <td>{{customer.mobile}}</td>
                            <td v-if = "customer.addresses.length > 0">{{customer.addresses[0].address}}</td>
                            <td v-else>N/A</td>
                            <td>{{customer.id_no}}</td>
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
      customers: [], 
      page: 1,
      totalPage: null,
      loading: true

    }
  },


  mounted () {

    this.page = this.$route.params.page * 1
    this.requestCustomerData();
  },

  watch: {
        '$route' (to, from){

            console.log(this.$router.currentRoute.path)
            if (this.$router.currentRoute.path == '/customers') this.page =1
            this.loading = true
            this.$router.push(this.$router.currentRoute.path + (this.$route.query.keyword !="undefined") ? '?keyword=' + this.$route.query.keyword : '')
            this.requestCustomerData();
        }
    },

  methods: {
      requestCustomerData () {
          let params = {page: this.page}
          if (this.$route.query.keyword != 'undefined') params.keyword = this.$route.query.keyword
          axios.get('/api/customers', {
              params: params
          })
          .then(this.handleResponse)
      },

      handleResponse(res) {
          this.customers = res.data.data
          this.page = res.data.current_page
          this.totalPage = res.data.last_page
          this.loading = false
      }, 

      onPageChange () {
          this.loading = true
          this.$router.push('/customers/p' + this.page)
      },

      gotoCustomerPage (id) {
          this.$router.push('/customer/'+id)
      }

  }
};
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
tr {
    cursor: hand
}
tr:hover {

    box-shadow: inset 0 -1px 0 0 rgba(100,121,143,0.122);
    cursor: pointer;

}
</style>