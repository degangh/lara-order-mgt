<template>
    <div>
        <v-layout row wrap>
            <v-flex  xs6 sm6 md3>
                <v-card color="green" class="white--text">
                <v-card-text>
                    <v-layout>
                    <v-flex xs4 sm5>
                    <v-icon
                    :class="{'large-icon':$vuetify.breakpoint.smAndUp}"
                     dark class="white--text">attach_money</v-icon>
                    </v-flex>
                    <v-flex xs8 sm7 text-xs-right>
                    <div>Sales Revenue</div>
                    <div
                    :class="{'subtitle-1': $vuetify.breakpoint.xsOnly, 'display-1':$vuetify.breakpoint.smAndUp}"
                    >{{sales_revenue | numeral('0,0.[00]')}}</div>
                    </v-flex>
                    </v-layout>
                </v-card-text>
                </v-card>
            </v-flex>
            <v-flex  xs6 sm6 md3>
                <v-card color="orange" class="white--text">
                <v-card-text>
                    <v-layout>
                    <v-flex xs4 sm5>
                    <v-icon :class="{'large-icon':$vuetify.breakpoint.smAndUp}" class="white--text"  dark >shopping_cart</v-icon>
                    </v-flex>
                    <v-flex xs8 sm7 text-xs-right>
                    <div>Transactions</div>
                    <div class="display-1">{{transaction}}</div>
                    </v-flex>
                    </v-layout>
                </v-card-text>
                </v-card>
            </v-flex>
            <v-flex  xs6 sm6 md3>
                <v-card color="indigo" class="white--text">
                <v-card-text>
                    <v-layout>
                    <v-flex xs5>
                    <v-icon :class="{'large-icon':$vuetify.breakpoint.smAndUp}" class="white--text"  dark >check_circle_outline</v-icon>
                    </v-flex>
                    <v-flex xs7 text-xs-right>
                    <div>Profit</div>
                    <div class="display-1">{{profit}}</div>
                    </v-flex>
                    </v-layout>
                </v-card-text>
                </v-card>
                </v-flex>
            <v-flex  xs6 sm6 md3>
                <v-card color="purple" class="white--text">
                <v-card-text>
                    <v-layout>
                    <v-flex xs5>
                    <v-icon :class="{'large-icon':$vuetify.breakpoint.smAndUp}" class="white--text"  dark >favorite_border</v-icon>
                    </v-flex>
                    <v-flex xs7 text-xs-right>
                    <div>Average Profit Rate</div>
                    <div class="display-1">{{profit_rate | numeral('0.[00]%') }}</div>
                    </v-flex>
                    </v-layout>
                </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    
        <v-layout row wrap>
            <v-flex  xs6 sm6 md3>
                <v-card color="blue" class="white--text">
                <v-card-text>
                    <v-layout>
                    <v-flex xs5>
                    <v-icon :class="{'large-icon':$vuetify.breakpoint.smAndUp}" class="white--text"  dark >money_off</v-icon>
                    </v-flex>
                    <v-flex xs7 text-xs-right>
                    <div>Overdued Amount</div>
                    <div :class="{'large-icon':$vuetify.breakpoint.smAndUp}" class="display-1">{{overdue_amount | numeral('0,0.[00]')}}</div>
                    </v-flex>
                    </v-layout>
                </v-card-text>
                </v-card>
            </v-flex>
            <v-flex  xs6 sm6 md3>
                <v-card color="blue" class="white--text">
                <v-card-text>
                    <v-layout>
                    <v-flex xs5>
                    <v-icon :class="{'large-icon':$vuetify.breakpoint.smAndUp}" class="white--text"  dark >warning</v-icon>
                    </v-flex>
                    <v-flex xs7 text-xs-right>
                    <div>Overdued Orders</div>
                    <div class="display-1">{{overdue_orders}}</div>
                    </v-flex>
                    </v-layout>
                </v-card-text>
                </v-card>
            </v-flex>
            <v-flex  xs6 sm6 md3>
                <v-card color="blue" class="white--text">
                <v-card-text>
                    <v-layout>
                    <v-flex xs5>
                    <v-icon :class="{'large-icon':$vuetify.breakpoint.smAndUp}" class="white--text"  dark >flight_takeoff</v-icon>
                    </v-flex>
                    <v-flex xs7 text-xs-right>
                    <div>To Be Sent</div>
                    <div class="display-1">{{pending_deliveries}}</div>
                    </v-flex>
                    </v-layout>
                </v-card-text>
                </v-card>
                </v-flex>
            <v-flex  xs6 sm6 md3>
                <v-card color="blue" class="white--text">
                <v-card-text>
                    <v-layout>
                    <v-flex xs5>
                    <v-icon :class="{'large-icon':$vuetify.breakpoint.smAndUp}" class="white--text"  dark >schedule</v-icon>
                    </v-flex>
                    <v-flex xs7 text-xs-right>
                    <div>Pending Orders</div>
                    <div class="display-1">{{pending_orders}}</div>
                    </v-flex>
                    </v-layout>
                </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </div>
</template>
<script>

export default {
    data () {
        return {
            sales_revenue: null,
            transaction: null,
            profit:null,
            profit_rate: null,
            overdue_amount: null,
            overdue_orders: null,
            pending_deliveries: null,
            pending_orders: null
        }
    },
    mounted () {
        this.requestDashboardData();
    },
    methods: {
        requestDashboardData () {
            axios.get('/api/dashboard').then((res) => {
                this.sales_revenue = res.data.sales_revenue
                this.transaction = res.data.transaction
                this.profit = res.data.profit
                this.profit_rate = (res.data.sales_revenue > 0) ? res.data.profit/res.data.sales_revenue : 0
                this.overdue_amount = res.data.overdue_amount
                this.overdue_orders = res.data.overdue_orders
                this.pending_deliveries = res.data.pending_deliveries
                this.pending_orders = res.data.pending_orders
            })
        }
    }
}

</script>

<style scoped>
.large-icon {
    font-size: 65px !important
}
</style>