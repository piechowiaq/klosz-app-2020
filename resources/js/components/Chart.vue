<template>
    <canvas :width="width" :height="height" :id="id"></canvas>
</template>

<script>
    import Chart from 'chart.js';
    export default {
        props: ['id','width','height','type','title','labels','data', 'fill', 'backgroundColor', 'borderColor', 'borderWidth'],
        mounted() {
            var chartColors = {
                color1: '#FEB2B2',
                color2: '#FBD38D',
                color3: '#9ae6b4',

            };
            var ctx = document.getElementById(this.id).getContext('2d');
            var myChart = new Chart(ctx, {
                type: this.type ? this.type : 'doughnut',
                data: {
                    labels: ['Aktulane', 'Nieaktulane'],
                    datasets: [{
                        label: this.title,
                        data: this.data,
                        fill: this.fill,
                        backgroundColor: [chartColors.color1, '#e2e8f0'],
                        borderColor: this.borderColor,
                        borderWidth: this.borderWidth ? this.borderWidth : 0
                    }]
                },
                options: {
                    legend: { display: false },
                    cutoutPercentage: 75,

                }
            });

            var dataset = myChart.data.datasets[0];

            if (dataset.data[0] <= 50) {
                dataset.backgroundColor[0] = chartColors.color1;
            }
            else if ((dataset.data[0] > 51) && (dataset.data[0] <= 75)){
                dataset.backgroundColor[0] = chartColors.color2;
            }
            else{
                dataset.backgroundColor[0] = chartColors.color3;
            }
        }
    }
</script>

<style scoped>

</style>
