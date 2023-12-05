<template>
    <div class="">
      <v-row>
        <v-col cols="8">
          <v-card class="ml-5">
            <v-img
              cover
              height="500"
              :src="path + data.thumbnail"
            ></v-img>
          </v-card>
        </v-col>
        <v-col >
          <v-card
          :loading="loading"
          max-width="470"
        >
          <template v-slot:loader="{ isActive }">
            <v-progress-linear
              :active="isActive"
              color="deep-purple"
              height="4"
              indeterminate
            ></v-progress-linear>
          </template>

          <v-card-item>
            <v-row>
              <v-col><v-btn size="small" class="button" color="#f5ec42">Chứng nhận Car</v-btn></v-col>
              <v-col class="d-flex justify-end">
                <img
                  class="icon-score"
                  src="../../../public/images/logo_icon.png"
                />
                <span class="score">80/100</span>
              </v-col>
            </v-row>
            <div class="container-content py-5">
                  <span class="content-style">{{ data.title }}</span>
            </div>
            <div class="car-price">
              <p>Giá niêm yết:</p>
              <v-card-title><h2 class="title-size">{{ data.price }}<span class="6">₫</span> <span class="font-size">Chỉ từ 2.9 triệu/tháng</span></h2></v-card-title>
            </div>

            <div class="box-action">
              <v-row class="justify-center">
                <v-col class="px-0 text-center"> <!-- Thêm lớp text-center để căn giữa theo chiều ngang -->
                  <span class="icon">
                    <v-icon
                      color="#081f4d"
                      icon="mdi-heart"
                      size="small"
                    ></v-icon>
                  </span>
                  <span>Yêu thích</span>
                </v-col>
                <v-col class="text-center"> <!-- Thêm lớp text-center để căn giữa theo chiều ngang -->
                  <span class="icon">
                    <v-icon
                      color="#081f4d"
                      icon="mdi-heart"
                      size="small"
                    ></v-icon>
                  </span>
                  <span>So sánh</span>
                </v-col>
                <v-col class="text-center"> <!-- Thêm lớp text-center để căn giữa theo chiều ngang -->
                  <span class="icon">
                    <v-icon
                      color="#081f4d"
                      icon="mdi-heart"
                      size="small"
                    ></v-icon>
                  </span>
                  <span>Chia sẽ</span>
                </v-col>
              </v-row>
            </div>
          </v-card-item>

          <v-row class="card">
            <v-col cols="12">
              <div class="box">
                <v-row>
                  <v-col style="padding-bottom: 5px;">
                    <div class="odo">
                    <span class="icon">
                      <v-icon
                        color="#081f4d"
                        icon="mdi-car-speed-limiter"
                        size="small"
                      ></v-icon>
                    </span>
                    <span>{{ data.odo }} km</span>
                  </div>
                  </v-col>
                  <v-col style="padding-bottom: 5px;">
                    <div class="odo">
                      <span class="icon">
                        <v-icon
                          color="#081f4d"
                          icon="mdi-car-brake-abs"
                          size="small"
                        ></v-icon>
                      </span>
                      <span>{{ data.brand?.name }}</span>
                    </div>
                    
                  </v-col>
                </v-row>
                <v-row>
                  <v-col style="padding-bottom: 5px; padding-top: 5px;">
                    <div class="odo">
                    <span class="icon">
                      <v-icon
                        color="#081f4d"
                        icon="mdi-tune-vertical"
                        size="small"
                      ></v-icon>
                    </span>
                    <span>{{ data.gear?.name }}</span>
                  </div>
                  </v-col>
                  <v-col style="padding-bottom: 5px; padding-top: 5px;">
                    <div class="odo">
                    <span class="icon">
                      <v-icon
                        color="#081f4d"
                        icon="mdi-water-boiler"
                        size="small"
                      ></v-icon>
                    </span>
                    <span>Xe {{ data.engine }}</span>
                  </div>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col style="padding-bottom: 5px; padding-top: 5px;">
                    <div class="odo">
                      <span class="icon">
                        <v-icon
                          color="#081f4d"
                          icon="mdi-car-back"
                          size="small"
                        ></v-icon>
                      </span>
                      <span>{{ data.seat }} chỗ</span>
                    </div>
                    </v-col>
                    <v-col style="padding-bottom: 0px; padding-top: 5px;">
                      <div class="odo">
                        <span class="icon">
                          <v-icon
                            color="#081f4d"
                            icon="mdi-map-marker"
                            size="small"
                          ></v-icon>
                        </span>
                        <span>SX: {{ data.year }}</span>
                      </div>
                    </v-col>
                  </v-row>
                  
                </div>
                
              </v-col>
              <div class="flex mt-4 justify-space-around">
                <v-btn
                  width="190"
                  class="text-none mb-4 ml-5 font-weight-bold"
                  color="#FFD600"
                  size="large"
                  variant="flat"
                  @click="loading = !loading"
                >
                  Đăng ký lái thử
                </v-btn>
                <v-btn
                  width="190"
                  class="text-none mb-4 mr-5 font-weight-bold"
                  color="green-darken-3"
                  size="large"
                  variant="flat"
                  @click="buyCar"
                >
                  Mua ngay
                </v-btn>
              </div>
            </v-row>
        </v-card>
        </v-col>
      </v-row>
      <v-card class="pt-16 ">
        <v-tabs v-model="tab" color="deep-purple-accent-4" align-tabs="center" class = "font-weight-bold">
          <v-tab class ="tab" :value="1">Tổng quan</v-tab>
          <v-tab class ="tab" :value="2">Thông số kỹ thuật</v-tab>
        </v-tabs>
        <v-window v-model="tab">
          <v-window-item v-for="n in 2" :key="n" :value="n" >
            <!-- Tổng quan -->
            <v-container fluid v-if="tab == 1">
              <div class="bg-bgLight p-8">
                <div class="max-w-screen-lg mx-auto">
                  <h3 class="text-center font-bold text-2xl text-tcSecondary mb-5">Tổng quan</h3>
                  <div class="grid grid-cols-2 pt-2 sm:gap-12">
                    <div class="col-span-2 sm:col-span-1">
                      <ul class="list-none">
                        <li class="flex items-center justify-between pb-2 border-b border-b-gray-200 mb-2">
                          <span class="font-bold text-tcSecondary">Động Cơ</span>
                          <span class="info-text">{{ data.engine }}</span>
                        </li>
                        <li class="flex items-center justify-between pb-2 border-b border-b-gray-200 mb-2">
                          <span class="font-bold text-tcSecondary">Kiểu dáng</span>
                          <span class="info-text">{{ data.figure?.name }}</span>
                        </li>
                        <li class="flex items-center justify-between pb-2 border-b border-b-gray-200 mb-2">
                          <span class="font-bold text-tcSecondary">Hãng xe</span>
                          <span class="info-text">{{ data.brand?.name }}</span>
                        </li>
                        <li class="flex items-center justify-between pb-2 border-b border-b-gray-200 mb-2">
                          <span class="font-bold text-tcSecondary">Năm sản xuất</span>
                          <span class="info-text">{{ data.year }}</span>
                        </li>
                      </ul>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                      <ul class="list-none">
                        <li class="flex items-center justify-between pb-2 border-b border-b-gray-200 mb-2">
                          <span class="font-bold text-tcSecondary">ODO</span>
                          <span class="info-text">{{ data.odo }}km</span>
                        </li>

                        <li class="flex items-center justify-between pb-2 border-b border-b-gray-200 mb-2">
                          <span class="font-bold text-tcSecondary">Số ghế</span>
                          <span class="info-text">{{ data.seat }}</span>
                        </li>
                        <li class="flex items-center justify-between pb-2 border-b border-b-gray-200 mb-2">
                          <span class="font-bold text-tcSecondary">Hộp số</span>
                          <span class="info-text">{{ data.gear?.name }}</span>
                        </li>
                        <li class="flex items-center justify-between pb-2 border-b border-b-gray-200 mb-2">
                          <span class="font-bold text-tcSecondary">Màu sắc</span>
                          <span class="info-text">{{ data.color?.name }}</span>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </v-container>

            <!-- Thông số kỹ thuật -->
            <v-container fluid v-else>
              <div class="bg-bgLight p-8">
                <div class="max-w-screen-lg mx-auto">
                  <h3 class="text-center font-bold text-2xl text-tcSecondary mb-5">Thông số kỹ thuật</h3>
                  <div class="grid grid-cols-2 pt-2 sm:gap-12">
                    <div class="col-span-2 sm:col-span-1">
                      <ul class="list-none">
                        <li class="flex items-center justify-between pb-2 border-b border-b-gray-200 mb-2">
                          <span class="font-bold text-tcSecondary">Hộp số</span>
                          <span class="info-text">{{ data.engine }}</span>
                        </li>
                        <li class="flex items-center justify-between pb-2 border-b border-b-gray-200 mb-2">
                          <span class="font-bold text-tcSecondary">Nhiên liệu</span>
                          <span class="info-text">{{ data.engine }}</span>
                        </li>
                        <li class="flex items-center justify-between pb-2 border-b border-b-gray-200 mb-2">
                          <span class="font-bold text-tcSecondary">Hệ thống</span>
                          <span class="info-text">{{ data.engine }}</span>
                        </li>
                      </ul>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                      <ul class="list-none">
                        <li class="flex items-center justify-between pb-2 border-b border-b-gray-200 mb-2">
                          <span class="font-bold text-tcSecondary">Xuất xứ</span>
                          <span class="info-text">{{ data.engine }}</span>
                        </li>
                        <li class="flex items-center justify-between pb-2 border-b border-b-gray-200 mb-2">
                          <span class="font-bold text-tcSecondary">Dòng xe</span>
                          <span class="info-text">{{ data.engine }}</span>
                        </li>
                        <li class="flex items-center justify-between pb-2 border-b border-b-gray-200 mb-2">
                          <span class="font-bold text-tcSecondary">Động cơ CC</span>
                          <span class="info-text">{{ data.engine }}</span>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </v-container>
          </v-window-item>
        </v-window>
      </v-card>
      <div class="bg-tcPrimary py-10 px-4">
    <h3 class="text-center font-bold text-2xl text-tcSecondary">Chứng nhận HomeCar</h3>
    <div class="max-w-screen-2xl mx-auto flex flex-col items-center lg:items-start lg:flex-row mt-8 gap-4">
      <div class="flex gap-6 max-w-[400px]">
        <img src="https://files-cdn.carpla.vn/carpla-assets/carplavn/img/icon.9e26f31.png" alt="" width="84">
        <p class="font-bold text-tcSecondary leading-7">
          Tất cả những chiếc xe được chứng nhận HomeCar đều được kiểm tra cẩn thận để đảm bảo bạn hoàn toàn yên tâm khi mua hàng.
        </p>
      </div>
      <div class="flex gap-4 mt-6 lg:mt-0 justify-center lg:justify-start flex-wrap">
        <div class="w-[150px] lg:flex-1 lg:w-auto flex-col flex items-center justify-between gap-4">
          <img src="https://files-cdn.carpla.vn/carpla-assets/carplavn/img/step_4.43fcd61.png" alt="" width="48">
          <span class="font-bold text-sm text-center">Cam kết bảo hành lên đến 12 tháng hoặc 20.000 km</span>
        </div>
        <div class="w-[150px] lg:flex-1 lg:w-auto flex-col flex items-center justify-between gap-4">
          <img src="https://files-cdn.carpla.vn/carpla-assets/carplavn/img/item_5.43eb655.png" alt="" width="48">
          <span class="font-bold text-sm text-center">Xe đã được kiểm định 160 điểm bởi HomeCar</span>
        </div>
        <div class="w-[150px] lg:flex-1 lg:w-auto flex-col flex items-center justify-between gap-4">
          <img src="https://files-cdn.carpla.vn/carpla-assets/carplavn/img/item_1.7eb1538.png" alt="" width="48">
          <span class="font-bold text-sm text-center">Thông tin tình trạng xe minh bạch</span>
        </div>
        <div class="w-[150px] lg:flex-1 lg:w-auto flex-col flex items-center justify-between gap-4">
          <img src="https://files-cdn.carpla.vn/carpla-assets/carplavn/img/item_2.516b61f.png" alt="" width="48">
          <span class="font-bold text-sm text-center">Xe không đâm đụng ảnh hưởng đến kết cấu khung gầm</span>
        </div>
        <div class="w-[150px] lg:flex-1 lg:w-auto flex-col flex items-center justify-between gap-4">
          <img src="https://files-cdn.carpla.vn/carpla-assets/carplavn/img/item_3.dd726c2.png" alt="" width="48">
          <span class="font-bold text-sm text-center">Xe không ngập nước, thuỷ kích</span>
        </div>
      </div>
    </div>
  </div>
    </div>
</template>

<script lang="ts">
import { useToast } from 'vue-toastification';
import { buyCarByCarId, getCarInfo } from '../../apis/user/car.js';

export default {
  setup() {
    const toast = useToast();

    return {
      toast,
    }
  },
  
  data() {
    return {
      path: "http://127.0.0.1:8000",
      loading: false,
      selection: 1,
      currentId: '',
      data: [],
      tab: null,
      carDetails: [
        { label: 'Nhiên liệu', value: 'Xăng' },
        { label: 'Số ghế', value: '5' },
        { label: 'Kiểu dáng', value: 'Hatchback' },
        { label: 'Năm sản xuất', value: '2019' },
        { label: 'ODO', value: '51.974 km' },
        { label: 'Phiên bản', value: '1.2 CVT' },
        { label: 'Dẫn động', value: 'Cầu trước' },
        { label: 'Màu ngoại thất', value: 'Đỏ' },
      ],
      carLandscape: [
        { label: 'Nhiên liệu', value: 'Dầu' },
        { label: 'Số ghế', value: '1' },
        { label: 'Kiểu dáng', value: 'Hatchqqq' },
        { label: 'Năm sản xuất', value: '2020' },
        { label: 'ODO', value: '1111km' },
        { label: 'Phiên bản', value: '1.2 CVT' },
        { label: 'Dẫn động', value: 'Cầu trước' },
        { label: 'Màu ngoại thất', value: 'Xanh' },
      ],
    };
  },
  mounted() {
    
  },
  created(){
    this.getData();
  },
  methods: {
    async getData() {
      const data = await getCarInfo(this.$route.params.carId);
      if (data) {
        this.data = data;
        console.log(this.data);
      }
    },
    reserve () {
      this.loading = true

      setTimeout(() => (this.loading = false), 2000)
    },

    convertNumtoPrice(number: any) {
      console.log(number?.slice(0, -6));
      return number?.slice(0, 2);
    },

    async buyCar() {
      const carId = this.$route.params.carId as string;
      const res = await buyCarByCarId(parseInt(carId));
      if (res) {
        this.toast.success("Gửi yêu cầu mua xe thành công");
      }
    },

  },
  computed: {
    currentCarDetails() {
      return this.tab === 1 ? this.data : this.carDetails;
    },
  },
  watch: {
    tab() {
      // If you need to perform additional actions when the tab changes
      // For example, fetch data from an API based on the selected tab
    },
  },
}
</script>

<style lang="scss" scoped>
.font-size {
  font-size: .875rem;
  color: #2e54a5;
  font-weight: 400;
  font-size: 1rem;
}

.title-size {
  font-weight: 700;
  margin-bottom: 7px;
  color: #1c2c5e;
  font-family: Roboto Black,sans-serif;
  font-size: 1.875rem;
    line-height: 2.25rem;
}

.container-content {
  overflow: hidden;
  text-overflow: ellipsis;
  border-top-style: dashed;
  border-top-width: thin;
}

.content-style {
  width: 100%;
  text-overflow: ellipsis;
  color: black !important;
  padding: 0px !important;
  font-family: SFProDisplay-Bold,Arial,sans-serif!important;
    font-weight: 600;
    font-size: 1.5rem;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    display: -webkit-box;
    overflow: hidden;
    line-height: 2rem;
}

.button {
  font-weight: 550 !important;
  margin: 10px 0px 10px 3px;
  box-shadow: none !important;
}

.box {
  border-radius: 15px;
  background-color: #f2f4fa;
  margin: 0px 15px 0px 15px;
  height: 110px;
  padding: 10px 10px 20px 20px;
  color: #081f4d;
}

.box-action {
  border-radius: 15px;
  background-color: #f2f4fa;
  height: 35px;
  padding: 10px 10px 20px 20px;
  color: #081f4d;
}
.box-action .v-row{

}
.icon {
  position: relative;
  top: -3px;
  margin-right: 5px;
}

.card {
  padding-bottom: 30px;
}

.text-tcSecondary{
  color: #081f4d;

}
.tab{
  font-family: SFProDisplay-Bold,Arial,sans-serif!important;
    font-weight: 700!important;
    font-size: 15px;
}
.info-text{
  font-weight: 600;
  color: #aa9405;
}

//
.bg-tcPrimary {
  background-color: #FFDD00;
}

.card button span {
  color: #081f4d;
}
.car-price p {
  color: #081f4d;
}
.score{
  position: relative;
  top: 6px;
  color: #1c2c5e;
  font-weight: 600;
}
.icon-score{
    width: 43px;
  height: 33px;
  padding-right: 10px;
}
</style>
