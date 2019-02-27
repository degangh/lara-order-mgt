<template>
<div class="container">
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
                            <td></td>
                            <td>{{customer.id_no}}</td>
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
      customers: []
    }
  },

  mounted () {
    let token = localStorage.getItem('jwt')

    axios.defaults.headers.common['Content-Type'] = 'application/json'
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
    this.requestCustomerData();
  },

  methods: {
      requestCustomerData () {
          console.log("ok")
          axios.get('./api/customer')
          .then(this.handleResponse)
      },

      handleResponse(res) {
          this.customers = res.data
      }

  }
};
</script>
