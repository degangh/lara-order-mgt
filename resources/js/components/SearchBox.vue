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
              keyword: ''
          }
      },

      props : {
          isLogin: Boolean
      },

      methods: {
          search (keyword) {
            this.$router.push("/products" + '?keyword=' + this.keyword);
          }
      }
}
</script>