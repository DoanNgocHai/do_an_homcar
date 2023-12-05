<template>
  <div class="bg-yellow pa-6 d-flex justify-space-around mb-6">
    <div>
      <v-img
        :width="400"
        aspect-ratio="16/9"
        cover
        src="../../../public/images/car-bg.png"
      ></v-img>
      <p class="font-weight-bold text-center text-h5">
        Bán xe của bạn với giá tốt nhất
      </p>
    </div>
    <div class="card card-compact w-2/4 bg-base-100 shadow-xl card-bordered">
      <div class="card-body pa-10">
        <h2 class="card-title">Bán xe Bán Xe</h2>
        <form action="" class="form-control w-full">
          <div class="form-control w-full mb-2">
            <label class="label">
              <span class="label-text">Tên Xe / Title</span>
            </label>
            <v-text-field v-model="form.title" label="Nhập Tên/Title" variant="outlined"></v-text-field>
          </div>
          <div class="d-flex mb-1">
            <div class="form-control w-full mb-2 pr-5">
              <label class="label">
                <span class="label-text">Hãng xe</span>
              </label>
              <v-select
                v-model="form.selectedBrand"
                :items="brands"
                item-title="name"
                item-value="id"
                placeholder="Chọn hãng xe"
                variant="outlined"
                clearable
              ></v-select>
            </div>
            <div class="form-control w-full mb-2">
              <label class="label">
                <span class="label-text">Dòng xe</span>
              </label>
              <v-select
                v-model="form.selectedFigure"
                :items="figures"
                item-title="name"
                item-value="id"
                placeholder="Chọn dòng xe"
                variant="outlined"
                clearable
              ></v-select>
            </div>  
          </div>
          
          <div class="d-flex mb-1">
            <div class="form-control w-full mb-2 pr-5">
              <label class="label">
                <span class="label-text">Năm sản xuất</span>
              </label>
              <v-select
                v-model="form.selectedYear"
                :items="years"
                placeholder="Chọn năm sản xuất"
                variant="outlined"
                clearable
              ></v-select>
            </div>
            <div class="form-control w-full mb-2">
              <label class="label">
                <span class="label-text">ODO</span>
              </label>
              <v-text-field v-model="form.odo" suffix="Km" label="Nhập số km đã chạy" variant="outlined"></v-text-field>
            </div>  
          </div>
          <div class="d-flex mb-1">
            <div class="form-control w-full mb-2 pr-5">
              <label class="label">
                <span class="label-text">Hộp số</span>
              </label>
              <v-select
                v-model="form.selectedGear"
                :items="gears"
                item-title="name"
                item-value="id"
                placeholder="Chọn hộp số"
                variant="outlined"
                clearable
              ></v-select>
            </div>
            <div class="form-control w-full mb-2">
              <label class="label">
                <span class="label-text">Màu sắc</span>
              </label>
              <v-select
                v-model="form.selectedColor"
                :items="colors"
                item-title="name"
                item-value="id"
                placeholder="Chọn màu sắc"
                variant="outlined"
                clearable
              ></v-select>
            </div>  
          </div>
          <div class="d-flex mb-1">
            <div class="form-control w-full mb-2 pr-5">
              <label class="label">
                <span class="label-text">Số chỗ ngồi</span>
              </label>
              <v-select
                v-model="form.selectedSeat"
                :items="seats"
                item-title="name"
                item-value="id"
                placeholder="Chọn số chỗ ngồi của xe"
                variant="outlined"
                clearable
              ></v-select>
            </div>
            <div class="form-control w-full mb-2">
              <label class="label">
                <span class="label-text">Động cơ</span>
              </label>
              <v-select
                v-model="form.selectedEngine"
                :items="engines"
                item-title="name"
                item-value="id"
                placeholder="Chọn động cơ xe"
                variant="outlined"
                clearable
              ></v-select>
            </div>  
          </div>
          <div class="d-flex mb-1">
            <div class="form-control w-full mb-2 pr-5">
              <label class="label">
                <span class="label-text">Giá cả</span>
              </label>
              <v-text-field
                v-model="form.price"
                label="Nhập số tiền muốn bán"
                type="number"
                prefix="Vnđ"
                variant="outlined"
              ></v-text-field>
            </div>
            <div class="form-control w-full mb-2">
              <label class="label">
                <span class="label-text">Thông tin thêm</span>
              </label>
              <v-text-field
                v-model="form.description"
                label="Nhập thông tin"
                variant="outlined"
              ></v-text-field>
            </div>  
          </div>
          <v-file-input
            @change="onFileChange"
            v-model="form.thumbnail"
            color="deep-purple-accent-4"
            counter
            label="File input"
            multiple
            placeholder="Select your files"
            prepend-icon="mdi-camera"
            variant="outlined"
            :show-size="1000"
          >
            <template v-slot:selection="{ fileNames }">
              <template v-for="(fileName, index) in fileNames" :key="fileName">
                <v-chip
                  v-if="index < 2"
                  color="deep-purple-accent-4"
                  label
                  size="small"
                  class="me-2"
                >
                  {{ fileName }}
                </v-chip>

                <span
                  v-else-if="index === 2"
                  class="text-overline text-grey-darken-3 mx-2"
                >
                  + file_name.length - 2  File(s)
                </span>
              </template>
            </template>
          </v-file-input>
          <div class="form-control w-full mt-2">
            <button @click.prevent="submitInfo" class="btn">Gửi thông tin</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { uploadFile } from '../../apis/common/upload-file'
import { userSaleCar, CreateCarDto } from '../../apis/user/car'
import { useRouter } from 'vue-router';
import { useToast } from "vue-toastification";

import {
  getBrands,
  Brand,

  Figures,
  getFigures,

  Gears,
  getGears,

  Colors,
  getColors,

} from '../../apis/taxonomy';
import { useStore,mapGetters } from 'vuex';
export default defineComponent({
  setup() {
    const router = useRouter();
    const toast = useToast();
    const store = useStore();
    return {
      router,
      toast,
      store
    }
  },
  data() {
    return {
      brands: [] as Brand[],

      figures: [] as Figures[],

      years: [
        '2009' , '2010' ,'2011' , '2012' ,'2013' , '2014' ,'2015' , '2016' , '2017' , '2018' ,'2019' , '2020' ,'2021' , '2022' ,'2023'
      ],
      seats: [
        '4' , '5' ,'6' , '7' ,'8'
      ],
      engines:[
        'Xăng' , 'Dầu' ,'Điện' , 'Hybrid' ,'Hydro'
      ],
      gears: [] as Gears[],

      colors: [] as Colors[],
      form: {
        title:'',
        selectedBrand: null as string | null,
        selectedFigure: null as string | null,
        selectedYear: null as string | null,
        selectedGear: null as string | null,
        selectedColor: null as string | null,
        selectedSeat: null as string | null,
        selectedEngine: null as string | null,
        odo: '',
        price: '',
        description: '',
        thumbnail: [],
      },
      // selectedFile: [],
      // images:[],
    };

  },
  
  methods: {
    async fetchBrands() {
      try {
        const response = await getBrands();
        this.brands = response.data;
        this.store.dispatch('brandsAction', response.data);
      } catch (error) {
        console.error('Error fetching brands:', error);
      }
    },
    async fetchFigures() {
      try {
        const response = await getFigures();
        this.figures = response.data;
      } catch (error) {
        console.error('Error fetching brands:', error);
      }
    },
    async fetchColors() {
      try {
        const response = await getColors();
        this.colors = response.data;
      } catch (error) {
        console.error('Error fetching brands:', error);
      }
    },
    async fetchGears() {
      try {
        const response = await getGears();
        this.gears = response.data;
      } catch (error) {
        console.error('Error fetching brands:', error);
      }
    },
    onFileChange(file:any) {
      if (!file) {
        return;
      }
      const reader = new FileReader();
      reader.onload = () => {
        this.form.thumbnail = file;
      };
    },
    async submitInfo() {
      let param = { "image": this.form.thumbnail[0] };
      const data = await uploadFile(param);
      const { title, selectedBrand, selectedFigure, selectedYear, odo, selectedGear, selectedColor, selectedSeat, selectedEngine, price, description, thumbnail} = this.form;
      
      const createCarDto: CreateCarDto = {
        title,
        brand_id: selectedBrand || '',
        figure_id: selectedFigure || '',
        year: selectedYear || '',
        odo,
        gear_id: selectedGear || '',
        color_id: selectedColor || '',
        seat: selectedSeat || '',
        engine: selectedEngine || '',
        price: +price,
        description,
        thumbnail: data.path
      };
      console.log(createCarDto);

      try {
        const data = await userSaleCar(createCarDto);

        if (data) {
          // this.router.push('/account/history-sale-car');
          this.toast.success("Thêm mới xe thành công, vui lòng đợi xét duyệt!!");
        }
      } catch (error) {
        this.toast.error("Thêm mới xe thất bại!!");
        console.error('Error submitting car info:', error);
      }
    },
  },
  computed: {
    ...mapGetters(['brands']),
  },
  created() {
    this.fetchBrands();
    this.fetchFigures();
    this.fetchGears();
    this.fetchColors();

  },
});
</script>

<style lang="scss" scoped>
.product-card {
  width: 360px;
  height: 420px;
  border-radius: 10px;
  background-color: #fff;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.1);
}

.product-image {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.product-info {
  padding: 20px;
}

.product-name {
  font-size: 18px;
  font-weight: bold;
}

.product-price {
  display: flex;
  justify-content: space-between;
}

.price {
  font-size: 16px;
}

.monthly-payment {
  font-size: 14px;
}

.product-status {
  font-size: 14px;
}

.product-features {
  margin-top: 10px;
}

.feature {
  font-size: 14px;
}

.product-id {
  display: flex;
  justify-content: space-between;
  margin-top: 10px;
}

.product-id .product-id {
  font-size: 16px;
}

.product-id button {
  font-size: 14px;
  background-color: #0080FF;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 5px 10px;
}
</style>
