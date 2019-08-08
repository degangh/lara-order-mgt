<template>
<div>
<ul>
    <li v-for="(item, index) of products" :key="index">{{item.name}}</li>
</ul>
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