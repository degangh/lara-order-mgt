<template>
    <v-text-field
        flat
        solo-inverted
        append-icon="search"
        label="Search Product"
        ml-3
        v-if = "isLogin"
        v-model = 'keyword'
        @click:append="search"
      ></v-text-field>
</template>

<script>
export default {
      data () {
          return {
              keyword: '',
              searchPath: 'products'
          }
      },

      props : {
          isLogin: Boolean
      },

      methods: {
          search (keyword) {
            this.$router.push("/" + this.searchPath + '?keyword=' + this.keyword);
          }
      }
}
</script>