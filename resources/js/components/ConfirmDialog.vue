<template>
<div>
<v-dialog v-model="dialog" persistent max-width="290">
    <v-card>
        <v-card-title class="headline">Confirm</v-card-title>
        <v-card-text>Confirm to mark to order status to SENT ?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn flat   @click="emitCloseDialog('closeDialog')">No</v-btn>
          <v-btn flat color="primary"  @click="emitCloseDialog('closeDialog')">Yes</v-btn>
        </v-card-actions>
    </v-card>
</v-dialog>
</div>
</template>

<script>
export default {
    name: "ConfirmDialog", 
    props: {
        dialog: Boolean,

    },
    methods: {
        emitCloseDialog(form) {
            this.$emit("closeDialog", form)
        }
    }
}
</script>
