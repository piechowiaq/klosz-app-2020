<script>
    import { Doughnut } from 'vue-chartjs'

    export default {
        extends: Doughnut,
        data: () => ({
            chartdata: {
                labels: ['Aktulane szkolenia', 'Nieaktulane szkolnia'],
                datasets: [
                    {
                        backgroundColor: ['#FEB2B2','#e2e8f0'],
                        data: [75, 25],
                        borderWidth: 0

                    },

                ],
            },
            options: {
                legend: { display: false },
                cutoutPercentage: 75,
                rotation: -0.5* Math.PI,
                circumference:	2*Math.PI,
            }
        }),

        mounted () {
            this.renderChart(this.chartdata, this.options)
        }
    }
</script>

<style>

</style>
