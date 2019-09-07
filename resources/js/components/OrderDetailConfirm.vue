<template>
  <div>
    <v-container>
      <v-flex row v-for="(item, index) of products" :key="index" align-center wrap>
        <v-flex  class="flex-cell">{{item.name}}</v-flex>
        <v-flex >
          {{item.ref_price_aud}}
        </v-flex>
        <v-flex >
          {{item.rrp_cny}}
        </v-flex>
        <v-flex >
          {{item.num}}
        </v-flex>
        <v-flex>
          {{item.num * item.rrp_cny}}
        </v-flex>
      </v-flex>
      <v-flex>
        {{totalPrice}}
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
    
  },
  mounted() {
    console.log(this.products)
  },
  computed: {
    totalPrice: function(){
      let total = 0
      this.products.map((product) => {
        total += product.num * product.rrp_cny
      })
      return total
    }
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