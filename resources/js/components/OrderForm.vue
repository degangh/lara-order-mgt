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
        <v-form v-model="valid" ref="ContactForm">
        <v-container grid-list-sm class="pa-4">
          
        </v-container>
        </v-form>
        <v-card-actions>
          <!--v-btn flat color="primary">More</v-btn-->
          <v-spacer></v-spacer>
          <v-btn flat color="primary" @click="emitCloseDialog('orderDialog')">Cancel</v-btn>
          <v-btn flat @click="">Save</v-btn>
        </v-card-actions>
      </v-card></v-dialog>
</div>
</template>

<script>
export default {
    name: "OrderForm",

    data() {
      return {
          valid: false
      }
    },

    props: {
        dialog: Boolean
    },

    methods: {
        emitCloseDialog (form) {
        this.$refs.ContactForm.reset()
        this.$emit("closeDialog", form)
      }
    }
}
</script>