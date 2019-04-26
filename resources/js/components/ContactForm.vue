<template>
<v-dialog v-model="dialog" width="800px">
      <v-card>
        <v-card-title
          class="grey lighten-4 py-4 title"
        >
          Create contact
        </v-card-title>
        <v-container grid-list-sm class="pa-4">
          <v-layout row wrap>
            <v-flex xs12 align-center justify-space-between>
              <v-layout align-center>
                
                <v-flex xs9>
                <v-text-field
                  placeholder="Name"
                  prepend-icon="contacts"
                ></v-text-field>
                </v-flex>
                <v-flex xs3>
                  <v-text-field
                  placeholder="Initial"
                ></v-text-field>
                </v-flex>
              </v-layout>
            </v-flex>
            <v-text-field
                prepend-icon="business"
                placeholder="Address"
              ></v-text-field>
            
            
            <v-flex xs12>
              <v-text-field
                prepend-icon="picture_in_picture"
                placeholder="ID No#"
              ></v-text-field>
            </v-flex>
            <v-flex xs12>
              <v-text-field
                type="tel"
                prepend-icon="phonelink_ring"
                placeholder="13888888888"
                mask="phone"
              ></v-text-field>
            </v-flex>
            <v-flex xs12>
              <v-text-field
                prepend-icon="notes"
                placeholder="Notes"
              ></v-text-field>
            </v-flex>
          </v-layout>
        </v-container>
        <v-card-actions>
          <!--v-btn flat color="primary">More</v-btn-->
          <v-spacer></v-spacer>
          <v-btn flat color="primary" @click="emitCloseDialog">Cancel</v-btn>
          <v-btn flat @click="emitCloseDialog">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    </template>

<script>
export default {
    name: "ContactForm",

    props: {
        dialog: Boolean
    },

    methods : {
      emitCloseDialog () {
        this.$emit("closeContactDialog")
      }
    }
}
</script>

<style>
</style>