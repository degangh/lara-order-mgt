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
                       @click="popupFormDialog('contactDialog')"
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
                       @click="popupFormDialog('productDialog')"
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
                       @click="popupFormDialog('addressDialog')"
                       v-if= "addressButton"
                >
                <v-icon >
                    business
                </v-icon>
                </v-btn>

                <v-btn 
                       fab
                       small
                       color="light-blue accent-1"
                       dark
<<<<<<< HEAD
                       @click="popupFormDialog('editOrderDialog')"
=======
                       @click="popupFormDialog('orderDialog', 'edit')"
>>>>>>> 1f4b5a30a5cb51e82754389bea6427230a8ea175
                       v-if= "editOrderButton"
                >
                <v-icon >
                    edit
                </v-icon>
                </v-btn>

                <v-btn 
                       fab
                       small
                       color="indigo"
                       dark
                       @click="popupFormDialog('orderDialog')"
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
            addressButton: false,
            editOrderButton: false
        }
    },

    mounted () {
        if (this.$router.currentRoute.name == "customerInfo") this.addressButton = true
        else this.addressButton = false

        if (this.$router.currentRoute.name == "orderDetailPage") this.editOrderButton = true
        else this.editOrderButton = false
    },

   watch: {
        '$route' (to, from){
            if (this.$router.currentRoute.name == 'customerInfo') this.addressButton = true
            else this.addressButton = false
            if (this.$router.currentRoute.name == "orderDetailPage") this.editOrderButton = true
            else this.editOrderButton = false
   }},

    methods: {
        
        popupFormDialog (form, action=null) {
            this.$emit('popupFormDialog', {form: form, action:action})
        }

    }
}
</script>


