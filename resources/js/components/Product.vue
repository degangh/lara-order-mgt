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
                                <v-btn  text icon small color="primary" @click="popupFormDialog('productDialog', product)">
                                    <v-icon small>
                                        edit 
                                    </v-icon>
                                </v-btn>

                                <v-btn  text icon small color="primary" @click="deleteProduct(product.id)">
                                    <v-icon small>
                                        delete 
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
        <product-form 
        :dialog="productDialog" 
        @closeDialog="closeFormDialog"
        :product = "selectedProduct"
        ></product-form>
        <confirm ref="confirm"></confirm>
        <message ref="message"></message>

</div>
</template>

<script>
import ProductForm from "./ProductForm"
import Confirm from './Confirm'
import Message from './Message'
export default {
  data () {
    return {
      products: [], 
      page: 1,
      totalPage: null,
      loading: true,
      productDialog: false,
      selectedProduct: null,

    }
  },
  components: {
      ProductForm,
      Confirm,
      Message
  },


  mounted () {

    this.page = this.$route.params.page * 1
    this.requestProductData();
  },

  watch: {
        '$route' (to, from){

            console.log(this.$route.query.keyword)
            if (this.$router.currentRoute.path == '/products') this.page =1
            this.loading = true
            this.$router.push(this.$router.currentRoute.path + (this.$route.query.keyword !="undefined") ? '?keyword=' + this.$route.query.keyword : '')
            this.requestProductData();
        }
    },

  methods: {
      requestProductData () {
          if (this.$route.query.keyword == 'undefined') console.log('axios keyword')

          let params = {page: this.page}
          if (this.$route.query.keyword != 'undefined') params.keyword = this.$route.query.keyword
          axios.get('/api/products', {
              params: params
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
          this.$router.push('/products/p' + this.page +  '?keyword=' + this.$route.query.keyword )
      },

      popupFormDialog (form, product = null) {
            this[form] =  true
            this.selectedProduct = product
      },
      closeFormDialog (form) {
        this[form] = false
        this.formAction = null
        this.requestProductData();
      },
      deleteProduct(productId)
        {
            this.$refs.confirm.open('Confirm', 'Delete this product?', {}).then((confirm) => {
                axios.delete('/api/products/' + productId)
                .then(()=>{
                    this.$refs.message.open('Success', 'Product Deleted', {})
                    this.requestProductData()
                    }
                )
                .catch((e)=>{console.log(e); this.messageDialog('Error',e.data.message,{})})
            }).catch((e)=>{
                console.log(e)
            })
        },

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