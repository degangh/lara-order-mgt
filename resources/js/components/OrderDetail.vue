<template>
<div>
<v-container>
    <v-flex row v-for="(item, index) of products" :key="index" align-center wrap>
        <v-flex md3 sm12 xs12 class="flex-cell">{{item.name}}</v-flex>
        <v-flex md3 sm4 xs4>
            <v-text-field class="table-cell-input"  prefix="AUD" :value="item.ref_price_aud"></v-text-field>
        </v-flex>
        <v-flex md3 sm4 xs4>
            <v-text-field class="table-cell-input"  prefix="CNY" :value="item.rrp_cny" @change="emitUpdateSelectedProduct(item.id, 'rrp_cny')"></v-text-field>
        </v-flex>
        <v-flex md3 sm4 xs4><v-text-field class="table-cell-input" :value="item.num"></v-text-field></v-flex>
    </v-flex>
</v-container>

</div>
</template>
<script>
export default {
    name: "OrderDetail",
    props: {
        products: Array
    },
    methods: {
        emitUpdateSelectedProduct(product_id, key){
            this.$emit('updateSelectedProducts', {
                product_id: product_id,
                new_value: event.target.value,
                key: key
            })
        }
    }
}
</script>

<style scoped>
.flex-cell {
    margin:0px
}

.table-cell-input{
    font-size: 0.9rem;
    margin-left: 0.5rem;
    
}

.table-cell-input input {
    text-align: center;
}

</style>