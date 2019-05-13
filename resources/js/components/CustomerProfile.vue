<template>
<v-container grid-list-sm class="pa-4 title grey-text">
          <v-layout row wrap>
            <v-flex xs12 align-center justify-space-between>
              <v-layout align-center>
                
                <v-flex xs12 mb-3>
                
                <v-icon class="mr-3">contacts</v-icon>
                
             
                Jonh Doe
                </v-flex>
                
              </v-layout>
            </v-flex>
            
            
            <v-flex xs12 mb-3>
            <v-icon class="mr-3">business</v-icon>
            Address address address
            </v-flex>

            <v-flex xs12>
            <v-icon class="mr-3">picture_in_picture</v-icon>
            11011110124324312432
            </v-flex>
            
            <v-flex xs12 mb-3>
              <v-icon>notes</v-icon>
            </v-flex>
          </v-layout>
        </v-container>
</template>

<script>
export default {

    mounted() {
        console.log(this.$route.params.id)

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