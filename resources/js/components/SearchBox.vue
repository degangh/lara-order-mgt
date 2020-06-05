<template>
    <v-text-field
        flat
        solo-inverted
        append-icon="search"
        :label="textLabel"
        ml-3
        v-if = "isLogin"
        v-model = 'keyword'
        @click:append="search"
        @keydown.enter="search"
        clearable
      >
        <template v-slot:prepend-inner>
            <v-menu
                style="top: -12px"
                offset-y
            >
                <template v-slot:activator="{ on }">
                <v-btn text icon small v-on="on">
                    <v-icon>expand_more</v-icon>
                </v-btn>
                </template>
                <v-list>
                    <v-list-tile @click="setupSearchBox('customers')">
                        <v-list-tile-title >Search Customer</v-list-tile-title>
                    </v-list-tile>
                    <v-list-tile @click="setupSearchBox('products')">
                        <v-list-tile-title>Search Products</v-list-tile-title>
                    </v-list-tile>
                    <v-list-tile @click="setupSearchBox('orders')">
                        <v-list-tile-title>Search Orders</v-list-tile-title>
                    </v-list-tile>
                </v-list>
            </v-menu>
        </template>
      </v-text-field>
</template>

<script>
export default {
      data () {
          return {
              keyword: '',
              textLabel: 'Search Product',
              resourcePath: 'products'
          }
      },

      props : {
          isLogin: Boolean,
          searchLabel: String,
          searchPath: String,
          currentPath: String
      },

      methods: {
          search (keyword) {
            console.log('search: ', this.resourcePath)
            this.$router.push("/" + this.resourcePath + '?keyword=' + this.keyword);
          },

          setupSearchBox(path){
              console.log(path)
              switch(path) {
                  case 'customers':
                      this.textLabel = 'Search Customer';
                      this.resourcePath =  path;
                  break;

                  case 'orders':
                      this.textLabel = 'Search Order';
                      this.resourcePath =  path;
                  break;

                  case 'products':
                      this.textLabel = 'Search Product';
                      this.resourcePath =  path;
                  break;

                  default:
                      this.textLabel = 'Search Product';
                      this.resourcePath = 'products';
                  break;

                  
              }

          }
      },
/**     
      watch: {
          $route (to, from){
            console.log('searchbox: ', this.$router.currentRoute.path)
        }
      }, 
*/
      mounted() {
          console.log('searchbox mounted: ', this.$router.currentRoute.path)
      }
}
</script>

<style scoped>
.v-text-field--solo-inverted.v-input--is-focused  .v-icon{
  color: #1976d2 !important
}

</style>