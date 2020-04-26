/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

import Chart from 'chart.js';


window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('registry-chart', require('./components/RegistryChart.vue').default);




/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */




const app = new Vue({
    el: '#app'
});


// var ctx = document.getElementById('myChart').getContext("2d");
//
// var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
// gradientStroke.addColorStop(0, '#80b6f4');
// gradientStroke.addColorStop(1, '#f49080');
//
// var myChart = new Chart(ctx, {
//     type: 'line',
//     data: {
//         labels: ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL"],
//         datasets: [{
//             label: "Data",
//             borderColor: gradientStroke,
//             pointRadius: 0,
//             fill: true,
//             backgroundColor: gradientStroke,
//             borderWidth: 1,
//             data: [100, 120, 150, 170, 180, 170, 160]
//         }]
//     },
//     options: {
//         legend: {
//             position: "bottom"
//         },
//         scales: {
//             yAxes: [{
//                 ticks: {
//                     fontColor: "rgba(0,0,0,0.5)",
//                     fontStyle: "bold",
//                     beginAtZero: true,
//                     maxTicksLimit: 5,
//                     padding: 20
//                 },
//                 gridLines: {
//                     drawTicks: false,
//                     display: false
//                 }
//
//             }],
//             xAxes: [{
//                 gridLines: {
//                     zeroLineColor: "transparent"
//                 },
//                 ticks: {
//                     padding: 20,
//                     fontColor: "rgba(0,0,0,0.5)",
//                     fontStyle: "bold"
//                 }
//             }]
//         }
//     }
// });

//
// var chartColors = {
//     color1: '#FEB2B2',
//     color2: '#FBD38D',
//     color3: '#9ae6b4',
//
// };
//
//
// var ctx = document.getElementById("myChart").getContext("2d");
// var myChart = new Chart(ctx, {
//     type: 'doughnut',
//     data: {
//         labels: ['Aktulane szkolenia', 'Nieaktulane szkolnia'],
//         datasets: [{
//             label: 'Registry',
//             backgroundColor: [
//                 chartColors.color1,
//                 '#e2e8f0'
//
//             ],
//             data: [75,25 ]
//         }],
//     },
//     options: {
//         legend: { display: false },
//         cutoutPercentage: 75,
//
//     }
// });
//
// var colorChangeValue = 50; //set this to whatever is the deciding color change value
// var dataset = myChart.data.datasets[0];
//
//     if (dataset.data[0] <= 50) {
//         dataset.backgroundColor[0] = chartColors.color1;
//     }
//     else if ((dataset.data[0] > 51) && (dataset.data[0] <= 75)){
//         dataset.backgroundColor[0] = chartColors.color2;
//     }
//     else{
//         dataset.backgroundColor[0] = chartColors.color3;
//     }
//
// myChart.update();


