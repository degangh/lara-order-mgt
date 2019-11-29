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
      <v-text-field
       label="Exchange Rate AUD/CNY"
       v-model="exchange_rate">
      </v-text-field>
    </v-container>
  </div>
</template>
<script>
export default {
  data() {
    return {
      exchange_rate: 5
    }
  },
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
    },
    getCurrencyRate(base, target){
      axios.get('https://api.exchangeratesapi.io/latest?base='+base+'&symbols=' + target)
      .then(function(res){
        console.log(res)
      })
      return 4.81
    }
  },
  mounted() {
    this.exchange_rate = this.getCurrencyRate('AUD', 'CNY')
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