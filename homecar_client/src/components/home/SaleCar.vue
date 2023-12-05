<template>
  <div class="card card-compact w-1/3 bg-base-100 shadow-xl card-bordered">
    <div class="card-body">
      <h2 class="card-title">Bán xe</h2>
      <form action="">
        <div class="form-control w-full mb-2">
          <label class="label">
            <span class="label-text">Hãng xe</span>
          </label>
          <select class="select select-bordered">
            <option disabled selected>Chọn hãng xe</option>
            <option>Star Wars</option>
            <option>Harry Potter</option>
            <option>Lord of the Rings</option>
            <option>Planet of the Apes</option>
            <option>Star Trek</option>
          </select>
        </div>
        <div class="form-control w-full mb-2">
          <label class="label">
            <span class="label-text">Dòng xe</span>
          </label>
          <select class="select select-bordered">
            <option disabled selected>Chọn dòng xe</option>
            <option>Star Wars</option>
            <option>Harry Potter</option>
            <option>Lord of the Rings</option>
            <option>Planet of the Apes</option>
            <option>Star Trek</option>
          </select>
        </div>
        <div class="form-control w-full mt-2">
          <button type="submit" class="btn">Gửi thông tin</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">

</script>

<style lang="scss" scoped>
</style>
