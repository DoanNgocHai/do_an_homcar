<template>
  <div class="card card-compact w-2/3 bg-base-100 shadow-xl card-bordered	 mr-4 buy-car">
    <div class="card-body">
      <div class="mb-4">
        <h3 class="card-title">Mua xe</h3>
        <div class="w-full mb-2">
          <input type="text" placeholder="Tìm kiếm xe..." class="input input-bordered w-full" />
        </div>
        <div class="w-full flex justify-between">
          <button class="btn">Dưới 300tr</button>
          <button class="btn">Từ 300tr - 500tr</button>
          <button class="btn">Từ 500tr - 700tr</button>
          <button class="btn">Trên 700tr</button>
          <button class="btn btn-warning">Giúp tôi chọn xe</button>
        </div>
      </div>
      <div class="">
        <h3 class="card-title mb-2">Xe theo hãng / kiểu dáng</h3>
        <div class="w-full">
          <div class="list-brands">
            <div class="_1brand">
              <img src="https://cdn-v2.carpla.vn/x36/cms/honda-1689061995.100.png" alt="Honda">
              <h6>Honda</h6>
            </div>
            <div class="_1brand">
              <img src="https://cdn-v2.carpla.vn/x36/cms/honda-1689061995.100.png" alt="Honda">
              <h6>Honda</h6>
            </div>
            <div class="_1brand">
              <img src="https://cdn-v2.carpla.vn/x36/cms/honda-1689061995.100.png" alt="Honda">
              <h6>Honda</h6>
            </div>
            <div class="_1brand">
              <img src="https://cdn-v2.carpla.vn/x36/cms/honda-1689061995.100.png" alt="Honda">
              <h6>Honda</h6>
            </div>
            <div class="_1brand">
              <img src="https://cdn-v2.carpla.vn/x36/cms/honda-1689061995.100.png" alt="Honda">
              <h6>Honda</h6>
            </div>
            <div class="_1brand">
              <img src="https://cdn-v2.carpla.vn/x36/cms/honda-1689061995.100.png" alt="Honda">
              <h6>Honda</h6>
            </div>
            <div class="_1brand">
              <img src="https://cdn-v2.carpla.vn/x36/cms/honda-1689061995.100.png" alt="Honda">
              <h6>Honda</h6>
            </div>
          </div>
          <div class="list-brands">
            <div class="_1brand">
              <img src="https://cdn-v2.carpla.vn/x36/cms/honda-1689061995.100.png" alt="Honda">
              <h6>Honda</h6>
            </div>
            <div class="_1brand">
              <img src="https://cdn-v2.carpla.vn/x36/cms/honda-1689061995.100.png" alt="Honda">
              <h6>Honda</h6>
            </div>
            <div class="_1brand">
              <img src="https://cdn-v2.carpla.vn/x36/cms/honda-1689061995.100.png" alt="Honda">
              <h6>Honda</h6>
            </div>
            <div class="_1brand">
              <img src="https://cdn-v2.carpla.vn/x36/cms/honda-1689061995.100.png" alt="Honda">
              <h6>Honda</h6>
            </div>
            <div class="_1brand">
              <img src="https://cdn-v2.carpla.vn/x36/cms/honda-1689061995.100.png" alt="Honda">
              <h6>Honda</h6>
            </div>
            <div class="_1brand">
              <img src="https://cdn-v2.carpla.vn/x36/cms/honda-1689061995.100.png" alt="Honda">
              <h6>Honda</h6>
            </div>
            <div class="_1brand">
              <img src="https://cdn-v2.carpla.vn/x36/cms/honda-1689061995.100.png" alt="Honda">
              <h6>Honda</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
export default {
  data() {
    return {

    }
  }

}
</script>

<style lang="scss" scoped>
.list-brands {
  display: flex;
  margin: 20px 0px;

  ._1brand {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: calc(100% / 7);
    text-align: center;
    cursor: pointer;

    h6 {
      text-align: center;
    }

    img {
      display: block;
      width: 40px;
      height: 40px;
    }
  }
}
</style>
