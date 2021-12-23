<template>
  <div class="container">
    <div class="row">
      <div class="col">
         <allocation-of-qty-by-rating></allocation-of-qty-by-rating>
      </div>
      <div class="col">
        <top-rating></top-rating>
      </div>
      <div class="col">
        Column
      </div>
    </div>
  </div>
</template>

<script>
import AllocationOfQtyByRating from './ratings/AllocationOfQtyByRating.vue'
import TopRating from './ratings/TopRating.vue'
export default {
  components: { AllocationOfQtyByRating, TopRating },
  data: () => ({
    loaded: false,
    chartdata: null,
  }),
  mounted () {
    // this.loaded = false
    // try {
    //   const { userlist } = await fetch('/api/userlist')
    //   this.chartdata = userlist
    //   this.loaded = true
    // } catch (e) {
    //   console.error(e)
    // }
  }
}
</script>