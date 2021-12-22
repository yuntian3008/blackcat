<template>
  <div class="container">
    <line-chart
      v-if="loaded"
      :chartdata="chartdata"
      :options="options"/>
  </div>
</template>

<script>
import LineChart from '../components/charts/LineChart.vue'

export default {
  name: 'AllocationOfQtyByRating',
  components: { LineChart },
  data: () => ({
    loaded: false,
    chartdata: null,
    options: {
      responsive: true,
      legend: {
      position: 'bottom',
      },
      title: {
        display: true,
        text: 'Allocate of quantity by rating'
      }
    }
  }),
  async mounted () {
    var app = this;
    this.loaded = false;
    // await 
    //     .then(function (resp) {
    //         app.top = resp.data;
    //         app.loaded = true;
    //         app.initChart3();
            
    //     })
    //     .catch(function (resp) {
    //         console.log(resp);
    //         alert("Could not load Count Product By Rating");
    //     });
    try {
      const { data } = await axios.get('/api/v1/statistics/reviews/count-product-by-rating',{
        headers: app.$bearerAPITOKEN
      })
      this.chartdata = {
        labels: ['0', '1', '2', '3', '4', '5'],
        datasets: [
          {
            label: 'Quantity',
            backgroundColor: '#f87979',
            data: data,
          }
        ]
      },
      this.loaded = true
    } catch (e) {
      console.error(e)
    }
  }
}
</script>