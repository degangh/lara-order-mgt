<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  data: () => ({
    chartdata: {
      labels: ['January', 'February', 'March', 'April', 'May'],
      datasets: [
        {
          label: 'Sales Revenue',
          borderColor: '#f87979',
          data: [40, 23, 33, 52, 29],
          fill: false
        },
        {
          label: 'Monthly Average',
          borderColor: 'navy',
          data: [35,35,35,35,35],
          fill: false
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false
    }
  }),

  mounted () {
    this.renderChart(this.chartdata, this.options)
  }
}
</script>