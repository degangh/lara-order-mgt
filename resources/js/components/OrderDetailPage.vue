<template>
    <div>oop2</div>
</template>

<script>
export default {
    data () {
        return {
            orderDetails: []
        }
    },

    mounted () {
        this.requestOrderDetailData()
    },

    methods: {
        requestOrderDetailData() {
            axios.get('/api/orders/' + this.$route.params.id)
            .then(this.handleResponse)
            .catch(this.handleError)
        },
        handleResponse (res) {
            console.log(res.data)
            this.ready = true
            this.loading = false
        },
        handleError (error) {
            alert (error)
            this.ready = true
            this.loading = false
        }
    }
}
</script>