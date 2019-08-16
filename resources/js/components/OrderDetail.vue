<template>
<div>
<table class="table table-striped">
    <tr v-for="(item, index) of products" :key="index">
        <td>{{item.name}}</td>
        <td>AUD{{item.ref_price_aud}}</td>
        <td>CNY<input :value="item.rrp_cny"></td>
        <td>{{item.num}}</td>
    </tr>
</table>
</div>
</template>
<script>
export default {
    name: "OrderDetail",
    props: {
        products: Array
    }
}
</script>