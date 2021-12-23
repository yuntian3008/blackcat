<template>
  <div class="container">
    <bar-chart
      v-if="loaded"
      :chartdata="chartdata"
      :options="options"/>
    <label for="customRange3" class="form-label">Top Rating : {{ topNumber }}</label>
    <input type="range" class="form-range" min="1" max="10" step="1" v-model="topNumber" @change="updateChart()" id="customRange3">
  </div>
</template>

<script>
import BarChart from '../components/charts/BarChart.vue'

export default {
  name: 'TopRating',
  components: { BarChart },
  data: () => ({
    topNumber: 5,
    loaded: false,
    chartdata: null,
    options: {
      responsive: true,
      legend: {
      position: 'bottom',
      },
      title: {
        display: true,
        text: 'Top Rating',
      },
      scales: {
          yAxes: [{
              ticks: {
                  beginAtZero: true,
              },
              barPercentage: 0.5
          }]
      },
      
    },
    resp: [],
  }),
  mounted () {
    this.updateChart()
  },
  methods: {
    updateChart() {
      var app = this;
      this.loaded = false;
      axios.get('/api/v1/statistics/reviews/top/'+app.topNumber,{
        headers: app.$bearerAPITOKEN
      }).then((resp) => {
        var labels = [];
        var data = [];
        for (let x of resp.data) {
          labels.push(x.product_name);
          data.push(x.avg_rating);
        }
        this.chartdata = {
          labels: labels,
          datasets: [
            {
              label: 'Stars',
              backgroundColor: '#FFA500',
              data: data,
            }
          ]
        },
        this.options.title.text = "Top Rating "+resp.data.length;
        this.loaded = true;
      }).catch((resp) => {
        console.log(resp);
      });
    }
  }
}
</script>