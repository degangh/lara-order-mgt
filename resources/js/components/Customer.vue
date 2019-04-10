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
                    <table class="table table-striped">
                        <tr>
                            <th>
                            Name
                            </th>
                            <th>
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
                        <tr v-for = "(customer, index) of customers" :key="index">
                            <td>{{customer.name}}</td>
                            <td>{{customer.mobile}}</td>
                            <td v-if = "customer.addresses.length > 0">{{customer.addresses[0].address}}</td>
                            <td v-else>N/A</td>
                            <td>{{customer.id_no}}</td>
                        </tr>

                        
                        </tbody>



                    </table>
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
      totalPage: null

    }
  },


  mounted () {
    let token = localStorage.getItem('jwt')

    this.page = this.$route.params.page * 1

    axios.defaults.headers.common['Content-Type'] = 'application/json'
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
    this.requestCustomerData();
  },

  methods: {
      requestCustomerData () {
          axios.get('/api/customers', {
              params: {
                  page: this.page
              }
          })
          .then(this.handleResponse)
      },

      handleResponse(res) {
          console.log(this.$route.params.page)
          this.customers = res.data.data
          this.page = res.data.current_page
          this.totalPage = res.data.last_page
      }, 

      onPageChange () {
          this.$router.push('/customers/p' + this.page)
          this.requestCustomerData();
      }

  }
};
</script>

<style scoped>
.pagination-container {
    float: right;
    padding: 0.3rem 1rem
}
</style>