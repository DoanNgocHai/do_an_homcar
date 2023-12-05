<template>
  <div>
    <div class="slider-main">
      <Carousel />
    </div>
    <div class="container w-full mx-auto py-6">
      <div class="flex my-5">
        <BuyCar />
        <SaleCar />
      </div>
      <ListCar />
    </div>

  </div>
</template>

<script setup lang="ts">
import BuyCar from '../components/home/BuyCar.vue';
import SaleCar from '../components/home/SaleCar.vue';
import ListCar from '../components/home/ListCar.vue';
import Carousel from '../components/home/Carousel.vue';

</script>
<style scoped>
.container {
  position: relative;
  bottom: 16rem;
}
</style>