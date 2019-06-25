<template>

<v-container  fluid grid-list-md>
                <v-layout row wrap>
                    <v-flex  xs12 sm3>
                        <v-card color="green" class="white--text">
                        <v-card-text>
                            <v-layout>
                            <v-flex xs5>
                            <v-icon class="white--text" size="65px" dark >attach_money</v-icon>
                            </v-flex>
                            <v-flex xs7 text-xs-right>
                            <div>Sales Revenue</div>
                            <div class="display-1">2,333</div>
                            </v-flex>
                            </v-layout>
                        </v-card-text>
                        </v-card>
                    </v-flex>
                    <v-flex  xs12 sm3>
                        <v-card color="orange" class="white--text">
                        <v-card-text>
                            <v-layout>
                            <v-flex xs5>
                            <v-icon class="white--text" size="65px" dark >shopping_cart</v-icon>
                            </v-flex>
                            <v-flex xs7 text-xs-right>
                            <div>Transactions</div>
                            <div class="display-1">17</div>
                            </v-flex>
                            </v-layout>
                        </v-card-text>
                        </v-card>
                    </v-flex>
                    <v-flex  xs12 sm3>
                        <v-card color="indigo" class="white--text">
                        <v-card-text>
                            <v-layout>
                            <v-flex xs5>
                            <v-icon class="white--text" size="65px" dark >check_circle_outline</v-icon>
                            </v-flex>
                            <v-flex xs7 text-xs-right>
                            <div>Profit</div>
                            <div class="display-1">799</div>
                            </v-flex>
                            </v-layout>
                        </v-card-text>
                        </v-card>
                        </v-flex>
                    <v-flex  xs12 sm3>
                        <v-card color="purple" class="white--text">
                        <v-card-text>
                            <v-layout>
                            <v-flex xs5>
                            <v-icon class="white--text" size="65px" dark >favorite_border</v-icon>
                            </v-flex>
                            <v-flex xs7 text-xs-right>
                            <div>ARPU</div>
                            <div class="display-1">80</div>
                            </v-flex>
                            </v-layout>
                        </v-card-text>
                        </v-card>
                    </v-flex>
                </v-layout>

                <v-layout>
                    <v-flex m-3 xs12>
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
export default {
    components: {
        SalesLineChart
    }
}
</script>