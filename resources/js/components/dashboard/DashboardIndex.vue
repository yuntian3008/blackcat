<template>
    <div>
        
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
            <div class="col-sm mx-3 card">
                <canvas ref="chart1" height="300"></canvas>                
            </div>
            <div class="col-sm mx-3 card" >
                <canvas ref="chart2" height="300" @mouseover="chart2move" @mouseleave="chart2move"></canvas>                
            </div>
            <div class="col-sm mx-3 card" >
                <canvas ref="chart3" height="300"></canvas>                
            </div>
            <div class="col-sm mx-3 card" >
                <canvas ref="chart4" height="300"></canvas>                
            </div>
        </div>
    </div>
</template>

<script>
    import Chart from 'chart.js';

export default {
    data: function() {
        return {
            chart1 : null,
            chart2 : null,
            chart3 : null,
            chart4 : null,
            colors: {
                red: 'rgb(255, 99, 132)',
                orange: 'rgb(255, 159, 64)',
                yellow: 'rgb(255, 205, 86)',
                green: 'rgb(75, 192, 192)',
                blue: 'rgb(54, 162, 235)',
                purple: 'rgb(153, 102, 255)',
                grey: 'rgb(201, 203, 207)'
            }
        }
    },
    mounted() {
        var color = Chart.helpers.color;
        this.chart1 = new Chart(this.$refs.chart1.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                datasets: [{
                    label: '2018 Sales',
                    data: [300, 700, 450, 750, 1200],
                    borderColor: color(this.colors.orange).alpha(0.5).rgbString(),
                    fill: false,
                    },
                    {
                    label: '2017 Sales',
                    data: [200, 450, 900, 600, 1000],
                    borderColor: color(this.colors.green).alpha(0.5).rgbString(),
                    fill: false,
                    },
                    {
                    label: '2019 Sales',
                    data: [400, 900, 1000, 500, 700],
                    borderColor: color(this.colors.blue).alpha(0.5).rgbString(),
                    fill: false,
                    }],
            },
            options: {
                responsive: true,
                legend: {
                position: 'bottom',
                },
                title: {
                display: true,
                text: 'Sales Chart'
                }
            }
        });

        this.chart2 = new Chart(this.$refs.chart2.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: [
                    'Ho Chi Minh',
                    'Ha Noi',
                    'Da Nang'
                ],
                datasets: [{
                    data: [10, 20, 30],
                    backgroundColor: [
                        color(this.colors.red).alpha(0.5).rgbString(),
                        color(this.colors.green).alpha(0.5).rgbString(),
                        color(this.colors.yellow).alpha(0.5).rgbString(),
                    ],
                    hoverBorderWidth: 8,
                    hoverBorderColor: '#ffffff',
                }],
            },
            options: {
                responsive: true,
                legend: {
                    position: 'right',
                },
                title: {
                    display: true,
                    text: 'Location Chart'
                }
            }
        });

        this.char3 = new Chart(this.$refs.chart3.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['2017', '2018', '2019', '2020'],
                datasets: [{
                    label: '< 20 age customer',
                    data: [300, 700, 450, 750],
                    backgroundColor: color(this.colors.red).alpha(0.5).rgbString(),
                    fill: false,
                    },
                    {
                    label: '20 - 60 age customer',
                    data: [200, 450, 900, 600],
                    backgroundColor: color(this.colors.blue).alpha(0.5).rgbString(),
                    fill: false,
                    },
                    {
                    label: '> 60 age customer',
                    data: [400, 900, 1000, 500],
                    backgroundColor: color(this.colors.green).alpha(0.5).rgbString(),
                    fill: false,
                    }],
            },
            options: {
                responsive: true,
                legend: {
                position: 'bottom',
                },
                title: {
                display: true,
                text: 'Customer Chart'
                }
            }
        });
        this.char4 = new Chart(this.$refs.chart4.getContext('2d'), {
            type: 'polarArea',
            data: {
                labels: ['Ho Chi Minh', 'Ha Noi', 'Can tho', 'Da nang', 'Hai Phong'],
                datasets: [{
                    label: '< 20 age customer',
                    data: [500,400,100,200,150],
                    backgroundColor: [
                        color(this.colors.red).alpha(0.5).rgbString(),
                        color(this.colors.orange).alpha(0.5).rgbString(),
                        color(this.colors.yellow).alpha(0.5).rgbString(),
                        color(this.colors.green).alpha(0.5).rgbString(),
                        color(this.colors.blue).alpha(0.5).rgbString(),
                    ],
                }],
            },
            options: {
                responsive: true,
                legend: {
                position: 'right',
                },
                title: {
                display: true,
                text: 'Customer Chart'
                }
            }
        });
    },
    methods: {
        chart2move: function(){
            if (this.chart2.options.circumference === Math.PI) {
                this.chart2.options.circumference = 2 * Math.PI;
                this.chart2.options.rotation = -Math.PI / 2;
            } else {
                this.chart2.options.circumference = Math.PI;
                this.chart2.options.rotation = -Math.PI;
            }

            this.chart2.update();
        }
    }
}


</script>
