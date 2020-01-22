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
                            Ref Price AUD
                            </th>
                            <th class="col2">
                            RRP CNY
                            </th>

                            <th class="col2"> 
                                Edit
                            </th>
                            
                        </tr>
                        <tbody>
                        <tr v-for = "(product, index) of products" :key="index" >
                            <td>{{product.name}}</td>
                            <td>{{product.ref_price_aud}}</td>
                            <td>{{product.rrp_cny}}</td>
                            <td>
                                <v-btn  text icon color="primary">
                                    <v-icon>
                                        edit 
                                    </v-icon>
                                </v-btn>
                            </td>
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
      products: [], 
      page: 1,
      totalPage: null,
      loading: true

    }
  },


  mounted () {

    this.page = this.$route.params.page * 1
    this.requestProductData();
  },

  watch: {
        '$route' (to, from){

            console.log(this.$router.currentRoute.path)
            if (this.$router.currentRoute.path == '/products') this.page =1
            this.loading = true
            this.$router.push(this.$router.currentRoute.path)
            this.requestProductData();
        }
    },

  methods: {
      requestProductData () {
          axios.get('/api/products', {
              params: {
                  page: this.page
              }
          })
          .then(this.handleResponse)
      },

      handleResponse(res) {
          this.products = res.data.data
          this.page = res.data.current_page
          this.totalPage = res.data.last_page
          this.loading = false
      }, 

      onPageChange () {
          this.loading = true
          this.$router.push('/products/p' + this.page)
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
}
</style>