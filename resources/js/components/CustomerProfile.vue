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
            </v-flex>
          </v-layout>
        </v-container>
</template>

<script>
export default {

    mounted() {
        console.log(this.$route.params.id)
    }

}
</script>