<template>
<div>
    <v-tabs fix-tabs centered  v-model="active">
        <v-tab> Profile </v-tab>
        <v-tab> Order History </v-tab>
    </v-tabs>
    <customer-profile v-show="active == 0"></customer-profile>
    <customer-order v-show="active == 1"></customer-order>
</div>
</template>

<script>
import CustomerProfile from './CustomerProfile'
import CustomerOrder from './CustomerOrder'
export default {
    data () {
        return {
            active: null
        }
    },
    components: {
        CustomerProfile,
        CustomerOrder
    },
    methods: {
        
    }
}
</script>

<style scoped>
</style>