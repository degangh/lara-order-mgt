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
            transition: 'slide-y-reverse-transition'
        }
    },

    computed: {
      activeFab () {
        switch (this.tabs) {
          case 'one': return { 'class': 'purple', icon: 'account_circle' }
          case 'two': return { 'class': 'red', icon: 'edit' }
          case 'three': return { 'class': 'green', icon: 'keyboard_arrow_up' }
          default: return {}
        }
      }
    },

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


