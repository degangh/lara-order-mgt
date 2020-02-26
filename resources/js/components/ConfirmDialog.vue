<template>
<div>
<v-dialog v-model="dialog" persistent max-width="290" @keydown.esc="noEvent()">
    <v-card>
        <v-card-title class="headline">{{title}}</v-card-title>
        <v-card-text> {{message}}</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn flat   @click="noEvent()">No</v-btn>
          <v-btn flat color="primary"  @click="yesEvent()">Yes</v-btn>
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
        title: String,
        message: String

    },
    methods: {
        emitCloseDialog(form) {
            this.$emit("closeDialog", form)
        },
        yesEvent(){
            this.$emit("yesEvent")
        },
        noEvent(){
            this.$emit("noEvent")
        }
    }
}
</script>
