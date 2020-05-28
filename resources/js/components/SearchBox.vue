<template>
    <v-text-field
        flat
        solo-inverted
        append-icon="search"
        :label="searchLabel"
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
          }
      },

      props : {
          isLogin: Boolean,
          searchLabel: String,
          searchPath: String
      },

      methods: {
          search (keyword) {
            this.$router.push("/" + this.searchPath + '?keyword=' + this.keyword);
          }
      }
}
</script>