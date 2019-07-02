<template>
<div>
<v-dialog v-model="dialog" width="800px" :fullscreen="$vuetify.breakpoint.smAndDown" persistent>
<v-card>
        <v-toolbar dark color="primary">
          
          <v-toolbar-title>Create Order</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn icon dark @click="emitCloseDialog('orderDialog')">
            <v-icon>close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-form v-model="valid" ref="OrderForm">
        <v-container grid-list-sm class="pa-4">

            <v-stepper v-model="e1">
    <v-stepper-header>
      <v-stepper-step :complete="e1 > 1" step="1">Choose Customer</v-stepper-step>

      <v-divider></v-divider>

      <v-stepper-step :complete="e1 > 2" step="2">Add Products</v-stepper-step>

      <v-divider></v-divider>

      <v-stepper-step step="3">Final Confirmation</v-stepper-step>
    </v-stepper-header>

    <v-stepper-items>
      <v-stepper-content step="1">
        <v-card
          class="mb-5"
          color="grey lighten-1"
          height="200px"
        ></v-card>

    


      </v-stepper-content>

      <v-stepper-content step="2">
        <v-card
          class="mb-5"
          color="grey lighten-1"
          height="200px"
        ></v-card>


      </v-stepper-content>

      <v-stepper-content step="3">
        <v-card
          class="mb-5"
          color="grey lighten-1"
          height="200px"
        ></v-card>

      </v-stepper-content>
    </v-stepper-items>
  </v-stepper>
          
        </v-container>
        </v-form>
        <v-card-actions>
          <!--v-btn flat color="primary">More</v-btn-->
          <v-spacer></v-spacer>
          <v-btn flat color="primary" @click="emitCloseDialog('orderDialog')">Cancel</v-btn>
          <v-btn flat @click="next(e1)">Continue</v-btn>
        </v-card-actions>
      </v-card></v-dialog>
</div>
</template>

<script>
export default {
    name: "OrderForm",

    data() {
      return {
          valid: false,
          e1: 0
      }
    },

    props: {
        dialog: Boolean
    },

    methods: {
        emitCloseDialog (form) {
        this.$refs.OrderForm.reset()
        this.$emit("closeDialog", form)
      },

      next(){
          console.log(this.e1)
          this.e1 = parseInt(this.e1) + 1
      }
    }
}
</script>