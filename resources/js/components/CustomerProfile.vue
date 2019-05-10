<template>
<v-container grid-list-sm class="pa-4">
          <v-layout row wrap>
            <v-flex xs12 align-center justify-space-between>
              <v-layout align-center>
                
                <v-flex xs9>
                <v-icon>contacts</v-icon>
             
                Jonh Doe
                </v-flex>
                <v-flex xs3>
                sss
                </v-flex>
              </v-layout>
            </v-flex>
            
            
            <v-flex xs12>
            <v-icon>business</v-icon>
            Address address address
            </v-flex>

            <v-flex xs12>
            <v-icon>picture_in_picture</v-icon>
            
            </v-flex>
            
            <v-flex xs12>
              <v-icon>notes</v-icon>
            </v-flex>
          </v-layout>
        </v-container>
</template>

<script>
export default {

    mounted() {
        console.log(this.$route.params.id)


        let token = localStorage.getItem('jwt')

        this.page = this.$route.params.page * 1

        axios.defaults.headers.common['Content-Type'] = 'application/json'
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
        this.requestCustomerInfo();

    },

    methods: {
      requestCustomerInfo () {
        axios.get('/api/customers/' + this.$route.params.id)
          .then(this.handleResponse)
      },

      handleResponse (res) {
        console.log(res)
      }

    }

}
</script>