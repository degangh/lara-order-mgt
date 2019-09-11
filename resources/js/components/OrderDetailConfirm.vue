<template>
  <div>
    <v-container>
      <table class="table">
      <tr v-for="(item, index) of products" :key="index" align-center wrap>
        <td>{{item.name}}</td>
        <td class="text-right">
          {{item.ref_price_aud}}
        </td>
        <td class="text-right">
          {{item.rrp_cny}}
        </td>
        <td class="text-right">
          {{item.num}}
        </td>
        <td class="text-right">
          {{item.num * item.rrp_cny}}
        </td>
      </tr>
      <tr>
        <td colspan="5" class="text-right">{{this.calculateTotalPrice()}}</td>
      </tr>
      </table>
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
    calculateTotalPrice(){
      let total = 0
      this.products.map((product) => {
        total += product.num * product.rrp_cny
      })
      return total
    }
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