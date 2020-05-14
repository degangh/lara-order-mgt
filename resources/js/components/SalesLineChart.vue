<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  data: () => ({
    chartdata: {
      labels: [],
      datasets: [
        {
          label: 'Sales Revenue',
          borderColor: '#f87979',
          data: [],
          fill: false
        },
        {
          label: 'Monthly Profit',
          borderColor: 'navy',
          data: [],
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
    axios.get('/api/dashboard/monthly/sum').then((res)=>{
      res.data.map((i)=>{
        this.chartdata.datasets[0].data.push(i.sum)
        this.chartdata.labels.push(i.order_month)    
      })
    }).then(()=>{
      axios.get('/api/dashboard/monthly/profit').then((res)=>{
      res.data.map((i)=>{
        this.chartdata.datasets[1].data.push(i.sum)
      })
      this.renderChart(this.chartdata, this.options)
    })  
    })

    

    
    
    
  }
}
</script>