<template>
  <div>
    <v-container>
      <v-flex row v-for="(item, index) of products" :key="index" align-center wrap>
        <v-flex md3 sm12 xs12 class="flex-cell">{{item.name}}</v-flex>
        <v-flex md3 sm4 xs4>
          {{item.ref_price_aud}}
        </v-flex>
        <v-flex md3 sm4 xs4>
          {{item.rrp_cny}}
        </v-flex>
        <v-flex md3 sm4 xs4>
          {{item.num}}
        </v-flex>
      </v-flex>
    </v-container>
  </div>
</template>
<script>
export default {
  name: "OrderDetailConfirm",
  props: {
    products: Array
  },
  methods: {
    
  }
};
</script>

<style scoped>
.flex-cell {
  margin: 0px;
}

.table-cell-input {
  font-size: 0.9rem;
  margin-left: 0.5rem;
}

.table-cell-input input {
  text-align: center;
}
</style>