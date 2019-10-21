<template>
  <div class="container">
    <chart-area
      v-if="loaded"
      :chartdata="chartdata"
      :options="options"/>
  </div>
</template>

<script>
import ChartArea from '@/components/Chart.vue'
import axios from 'axios'

export default {
  name: 'PolarAreaExample',
  components: { ChartArea },
  data: () => ({
    loaded: false,
    chartdata: null,
    options: {
      responsive: true,
      maintainAspectRatio: false
    }
  }),
  mounted () {
    axios.get('/').then(response => {
        this.chartdata = response.data;
        this.loaded = true;
      });
  }
}
</script>
