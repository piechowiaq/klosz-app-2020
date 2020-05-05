var trainingChartValue = window.trainingChartValue;

var chartColors = {
    color1: '#FEB2B2',
    color2: '#FBD38D',
    color3: '#9ae6b4',

};


// var ctx = document.getElementById("trainingChart").getContext("2d");
var myChart = new Chart('trainingChart', {
    type: 'doughnut',
    data: {
        labels: ['Aktulane szkolenia', 'Nieaktulane szkolnia'],
        datasets: [{
            label: 'Training',
            backgroundColor: [
                chartColors.color1,
                '#e2e8f0'

            ],
            data: [trainingChartValue, 100-trainingChartValue ]
        }],
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


