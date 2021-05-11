<script>
import { Bar } from 'vue-chartjs'
import axios from 'axios'

export default {
    name: "Analytics",
    extends: Bar,
    async mounted() { // The var which will play the Chart data roll
        let chartData = null
        await axios.post('/analytics/analytic').then(res => {
            chartData = {
                labels: res.data.labels,
                datasets: [
                    {
                        label: 'Clicks',
                        backgroundColor: '#f87979',
                        data: res.data.clicks.data
                    },
                    {
                        label: 'Views',
                        backgroundColor: 'cyan',
                        data: res.data.views.data
                    }
                ]
            }
        }).catch(err => console.log(err.response))
        console.log(chartData)
        let options = {
            responsive: true,
            maintainAspectRatio: false
        }
        this.renderChart(chartData, options)
    }
}
</script>