<template>
  <div class="ex">
      <div class="jumbotron">
        <h1>Welcome to App</h1>
        <p>There are examples.</p>
        <section class="container">
          <h1>Demo examples of vue-chartjs</h1>
            <div class="columns">
              <div class="column">
                <h3>Line Chart</h3>
                <line-chart></line-chart>
              </div>
            </div>
        <!-- </section>
        
        <section class="container"> -->
          <h1>Example 2</h1>
            <div class="columns">
              <div class="column">
                
                <h3>Polararea</h3>
                <polar-area-example></polar-area-example>
              </div>
            </div>
        </section>
      </div>
  </div>
</template>

<script>
import LineChart from '@/components/LineChart'
import PolarAreaExample from '@/components/PolarAreaExample'

export default {
  name: 'ex',
  components: {
      LineChart,
      PolarAreaExample
    }
  }
</script>

<style lang="scss">
  .jumbotron {
    padding: 2rem;

    p:last-of-type {
      margin-bottom: 0;
    }
  }
</style>
