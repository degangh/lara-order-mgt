<template>

<v-speed-dial
                    v-model="fab"
                    right
                    direction="top"
                    transition="scale-transition"
                    bottom
                    fixed
                    class="mb-5"
            >
                <v-btn
                        slot="activator"
                        color="blue"
                        fab
                        dark
                        v-model="fab"
                >
                    <v-icon  >
                        add
                    </v-icon>
                    <v-icon>close</v-icon>
                </v-btn>

                <v-btn 
                       fab
                       small
                       color="green"
                       dark
                       @click="clickCreateContact"
                >
                <v-icon >
                    account_circle
                </v-icon>
                </v-btn>

                <v-btn 
                       fab
                       small
                       color="orange"
                       dark
                       @click="clickCreateProduct"
                >
                <v-icon >
                    shopping_cart
                </v-icon>
                </v-btn>

                <v-btn 
                       fab
                       small
                       color="blue-grey darken-2"
                       dark
                       @click="clickCreateProduct"
                       v-if= "addressButton"
                >
                <v-icon >
                    business
                </v-icon>
                </v-btn>

                <v-btn 
                       fab
                       small
                       color="indigo"
                       dark
                >
                <v-icon >
                    attach_money
                </v-icon>
                </v-btn>

         
  
        

    </v-speed-dial>

</template>

<script>
export default {
    name: 'FloatingButton',
    data () {
        return {
            direction: 'top',
            fab: false,
            fling: false,
            hover: false,
            tabs: null,
            top: false,
            right: true,
            bottom: true,
            left: false,
            transition: 'slide-y-reverse-transition',
            addressButton: false
        }
    },

    mounted () {
        if (this.$router.currentRoute.name == "customerInfo") this.addressButton = true
        else this.addressButton = false
    },

   watch: {
        '$route' (to, from){
            if (this.$router.currentRoute.name == 'customerInfo') this.addressButton = true
            else this.addressButton = false
   }},

    methods: {
        clickCreateContact () {

            this.$emit('popupContactForm')
        },
        clickCreateProduct () {

            this.$emit('popupProductForm')
        }

    }
}
</script>


