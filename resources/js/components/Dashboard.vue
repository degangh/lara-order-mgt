<template>

<v-container  fluid grid-list-md>
                
<revenue-section></revenue-section>
                <v-layout>
                    <v-flex mt-3 xs12>
                    <v-card>
                        <v-card-title>Sales Revenu</v-card-title>
                        <v-card-text>
                            <sales-line-chart></sales-line-chart>
                        </v-card-text>
                    </v-card>
                    </v-flex>
                </v-layout>
                </v-container>
</template>

<script>
import SalesLineChart from "./SalesLineChart"
import RevenueSection from "./RevenueSection"
export default {
    components: {
        SalesLineChart,
        RevenueSection
    },  
    
}
</script>