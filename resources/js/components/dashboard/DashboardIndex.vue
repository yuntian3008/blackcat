<template>
    <div class="bg-indigo-900 relative overflow-hidden h-screen w-full">
        <img src="assets/images/dashboard.jpg" class="absolute h-full w-full object-cover"/>
        <div class="inset-0 bg-black opacity-25 absolute">
        </div>
        <div class="container mx-auto px-6 md:px-12 relative z-10 flex items-center py-32 xl:py-40">
            <div class="lg:w-3/5 xl:w-2/5 flex flex-col items-start relative z-10">
                <span class="font-bold uppercase text-yellow-400">
                    BlackCat
                </span>
                <h1 class="font-bold text-6xl sm:text-7xl text-white leading-tight mt-4">
                    Have a nice day
                </h1>
            </div>
        </div>
</div>
    <!-- <div>
        
        <div class="card-body row">
            <a href="#" class="col-sm mx-3 btn text-white badge-color-red-5 card zoom">
                <div class="card-body row align-items-center">
                    <i class="fas fa-coins fsize-64"></i>
                    <div class="col">
                        <h5 class="card-title">Sales</h5>
                        <h3 class="card-text">851036</h3>
                    </div>
                    <i class="fas fa-arrow-circle-right fsize-32"></i>
                </div>
            </a>
            <a href="#" class="col-sm mx-3 btn text-white badge-color-orange-5 card zoom">
                <div class="card-body row align-items-center">
                    <i class="fas fa-receipt fsize-64"></i>
                    <div class="col">
                        <h5 class="card-title">Orders</h5>
                        <h3 class="card-text">3185</h3>
                    </div>
                    <i class="fas fa-arrow-circle-right fsize-32"></i>
                </div>
            </a>
            <a href="#" class="col-sm mx-3 btn text-white badge-color-yellow-5 card zoom">
                <div class="card-body row align-items-center">
                    <i class="fas fa-box fsize-64"></i>
                    <div class="col">
                        <h5 class="card-title">Products</h5>
                        <h3 class="card-text">58443</h3>
                    </div>
                    <i class="fas fa-arrow-circle-right fsize-32"></i>
                </div>
            </a>
            <a href="#" class="col-sm mx-3 btn text-white badge-color-green-5 card zoom">
                <div class="card-body row align-items-center">
                    <i class="fas fa-users fsize-64"></i>
                    <div class="col">
                        <h5 class="card-title">Customers</h5>
                        <h3 class="card-text">86547</h3>
                    </div>
                    <i class="fas fa-arrow-circle-right fsize-32"></i>
                </div>
            </a>
            <a href="#" class="col-sm mx-3 btn text-white badge-color-blue-5 card zoom">
                <div class="card-body row align-items-center">
                    <i class="fas fa-store-alt fsize-64"></i>
                    <div class="col">
                        <h5 class="card-title">Shops</h5>
                        <h3 class="card-text">48</h3>
                    </div>
                    <i class="fas fa-arrow-circle-right fsize-32"></i>
                </div>
            </a>
        </div>      
        <div class="card-body row">
            <div class="col-sm mx-6 card">
                <canvas ref="chart1" height="300"></canvas>                
            </div>
            <div class="col-sm mx-6 card" >
                <canvas ref="chart3" height="300"></canvas>                
            </div>
        </div>
    </div> -->
</template>

<script>
//     import Chart from 'chart.js';

// export default {
//     data: function() {
//         return {
//             loaded: false,
//             chart1 : null,
//             chart2 : null,
//             chart3 : null,
//             chart4 : null,
//             colors: {
//                 red: 'rgb(255, 99, 132)',
//                 orange: 'rgb(255, 159, 64)',
//                 yellow: 'rgb(255, 205, 86)',
//                 green: 'rgb(75, 192, 192)',
//                 blue: 'rgb(54, 162, 235)',
//                 purple: 'rgb(153, 102, 255)',
//                 grey: 'rgb(201, 203, 207)'
//             },
//             top: [],
//             countProductByRating : [],
//         }
//     },
//     mounted() {
//         var color = Chart.helpers.color;
//         var app = this;
//         axios.get('/api/v1/statistics/reviews/count-product-by-rating',{
//                 headers: app.$bearerAPITOKEN
//             })
//                 .then(function (resp) {
//                     app.countProductByRating = resp.data;
//                     app.loaded = true;
//                     app.initChart1();
                    
//                 })
//                 .catch(function (resp) {
//                     console.log(resp);
//                     alert("Could not load Count Product By Rating");
//                 });
//         axios.get('/api/v1/statistics/reviews/top/5',{
//                 headers: app.$bearerAPITOKEN
//             })
//                 .then(function (resp) {
//                     app.top = resp.data;
//                     app.loaded = true;
//                     app.initChart3();
                    
//                 })
//                 .catch(function (resp) {
//                     console.log(resp);
//                     alert("Could not load Count Product By Rating");
//                 });
        

        // this.chart2 = new Chart(this.$refs.chart2.getContext('2d'), {
        //     type: 'doughnut',
        //     data: {
        //         labels: [
        //             'Ho Chi Minh',
        //             'Ha Noi',
        //             'Da Nang'
        //         ],
        //         datasets: [{
        //             data: [10, 20, 30],
        //             backgroundColor: [
        //                 color(this.colors.red).alpha(0.5).rgbString(),
        //                 color(this.colors.green).alpha(0.5).rgbString(),
        //                 color(this.colors.yellow).alpha(0.5).rgbString(),
        //             ],
        //             hoverBorderWidth: 8,
        //             hoverBorderColor: '#ffffff',
        //         }],
        //     },
        //     options: {
        //         responsive: true,
        //         legend: {
        //             position: 'right',
        //         },
        //         title: {
        //             display: true,
        //             text: 'Location Chart'
        //         }
        //     }
        // });

        
        // this.char4 = new Chart(this.$refs.chart4.getContext('2d'), {
        //     type: 'polarArea',
        //     data: {
        //         labels: ['Ho Chi Minh', 'Ha Noi', 'Can tho', 'Da nang', 'Hai Phong'],
        //         datasets: [{
        //             label: '< 20 age customer',
        //             data: [500,400,100,200,150],
        //             backgroundColor: [
        //                 color(this.colors.red).alpha(0.5).rgbString(),
        //                 color(this.colors.orange).alpha(0.5).rgbString(),
        //                 color(this.colors.yellow).alpha(0.5).rgbString(),
        //                 color(this.colors.green).alpha(0.5).rgbString(),
        //                 color(this.colors.blue).alpha(0.5).rgbString(),
        //             ],
        //         }],
        //     },
        //     options: {
        //         responsive: true,
        //         legend: {
        //         position: 'right',
        //         },
        //         title: {
        //         display: true,
        //         text: 'Customer Chart'
        //         }
        //     }
        // });
//     },
//     methods: {
//         initChart1: function() {
//             var color = Chart.helpers.color;
//             var app = this;
//             app.chart1 = new Chart(app.$refs.chart1.getContext('2d'), {
//                 type: 'line',
//                 data: {
//                     labels: ['0', '1', '2', '3', '4','5'],
//                     datasets: [
//                         {
//                         label: 'Quantity Product',
//                         data: [0, app.countProductByRating[0], app.countProductByRating[1], app.countProductByRating[2], app.countProductByRating[3], app.countProductByRating[4]],
//                         borderColor: color(app.colors.blue).alpha(0.5).rgbString(),
//                         fill: false,
//                         }],
//                 },
//                 options: {
//                     responsive: true,
//                     legend: {
//                     position: 'bottom',
//                     },
//                     title: {
//                     display: true,
//                     text: 'Sales Chart'
//                     }
//                 }
//             });
//         },
//         initChart3: function() {
//             var color = Chart.helpers.color;
//             var app = this;
//             app.char3 = new Chart(app.$refs.chart3.getContext('2d'), {
//                 type: 'bar',
//                 data: {
//                     labels: [app.top[0].product_name, app.top[1].product_name, app.top[2].product_name],
//                     datasets: [
//                         {
//                         label: 'Stars',
//                         data: [app.top[0].avg_rating, app.top[1].avg_rating, app.top[2].avg_rating],
//                         backgroundColor: color(app.colors.yellow).alpha(0.5).rgbString(),
//                         fill: false,
//                         }],
//                 },
//                 options: {
//                     title: {
//                         display: true,
//                         text: 'Top 5',
//                     },
//                     scales: {
//                         yAxes: [{
//                             ticks: {
//                                 beginAtZero: true,
//                             },
//                             barPercentage: 0.3
//                         }]
//                     },
//                 }
//             });
//         },
//         chart2move: function(){
//             if (this.chart2.options.circumference === Math.PI) {
//                 this.chart2.options.circumference = 2 * Math.PI;
//                 this.chart2.options.rotation = -Math.PI / 2;
//             } else {
//                 this.chart2.options.circumference = Math.PI;
//                 this.chart2.options.rotation = -Math.PI;
//             }

//             this.chart2.update();
//         }
//     }
// }


</script>
