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
      <v-flex class="text-field-footer grey--text text--lighten-4" >Real-time exchange rate from EU central bank</v-flex>
    </v-container>
  </div>
</template>
<script>
export default {
  data() {
    return {
      exchange_rate: null
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
      fetch('https://api.exchangeratesapi.io/latest?base='+base+'&symbols=' + target).then(function(response){
        return response.json()
      }).then(data => this.exchange_rate = parseFloat(data.rates[target]).toFixed(2))
    }
  },
  mounted() {
    this.getCurrencyRate('AUD', 'CNY')
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
.text-field-footer
{
  margin-top: -1rem
}
</style>