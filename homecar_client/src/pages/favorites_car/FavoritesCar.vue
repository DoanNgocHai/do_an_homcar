<template>
    <div>
      <v-row class="px-20">
        <v-col cols="12">
          <v-card-title><h2 class="title-size"><span></span>Ô tô trong danh sách xe yêu thích của bạn</h2></v-card-title>
        </v-col>
        <v-col class="py" cols="4" v-for="(item, index) in data" :key="index">
          <v-card
          :loading="loading"
          max-width="500"
          >
          <v-btn @click="deleteFavorites(item.id)">x</v-btn>
            <template v-slot:loader="{ isActive }">
              <v-progress-linear
                :active="isActive"
                color="deep-purple"
                height="4"
                indeterminate
              ></v-progress-linear>
            </template>
            <a @click="getCarInfo(item?.car?.id)" >
              <v-img
                v-if="!item.car.thumbnail"
                src="../../../public/images/logoCar.png"
                cover
                height="250"
              ></v-img>
              <v-img
                cover
                height="250"
                v-else :src="path + item.car.thumbnail"
              ></v-img>
            </a>
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
              
              <v-card-title><h2 class="title-size">{{formatNumber(item.car.price)}} <span class="font-size">Chỉ từ 2.9 triệu/tháng</span></h2></v-card-title>

              <div>
                <v-row >
                  <v-col cols="10" class="container-content">
                    <span class="content-style">{{ item.car.title }}</span>
                  </v-col>
                  <v-col cols="2">
                    <span class="me-1">
                      <v-icon
                        @click="saveFavorites(item.car.id)"
                        color="#000000"
                        icon="mdi-heart"
                        size="large"
                      >
                      </v-icon>
                      <v-tooltip
                        activator="parent"
                        location="bottom"
                      >Lưu vào xe yêu thích của bạn</v-tooltip>
                    </span>
<!-- <span class="me-1">
  <v-icon
    @click="toggleFavorite(item.id)"
    :color="isFavorite(item.id) ? 'red' : '#000000'"
    :icon="isFavorite(item.id) ? 'mdi-heart' : 'mdi-heart-outline'"
    size="large"
  >
  </v-icon>
</span> -->
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
                      <span>{{ item.car.odo }} km</span>
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
                        <span>{{ item.car.brand.name }}</span>
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
                      <span>{{ item.car.gear.name }}</span>
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
                      <span>Xe {{ item.car.engine }}</span>
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
                        <span>{{ item.car.seat }} chỗ</span>
                      </div>
                    </v-col>
                    <v-col style="padding-bottom: 5px; padding-top: 5px;">
                      <div class="odo">
                      <span class="icon">
                        <v-icon
                          color="#081f4d"
                          icon="mdi-alpha-y-box-outline"
                          size="small"
                        ></v-icon>
                      </span>
                      <span>Năm {{ item.car.year }}</span>
                    </div>
                    </v-col>
                  </v-row>
                </div>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
      </v-row>
    </div>
</template>

<script lang="ts">
import { saveCarFavorites, SaveFavoritesDto,listCarFavorites,deleteCarFavorites } from '../../apis/user/favorites';
import { useToast } from "vue-toastification";
export default {
  data() {
    const toast = useToast();
    return {
      path: "http://127.0.0.1:8000",
      loading: false,
      selection: 1,
      data: [],
      toast
    };
  },
  setup() {
    return {
    }
  },
  created(){
    this.getData();
  },
  methods: {
    async getData() {
      const data = await listCarFavorites();
      
      if (data) {
        this.data = data;
      console.log(data);

      }
    },
    getCarInfo(id:string) {
      this.$router.push({ path: '/car-info/' + id });
    },
    formatNumber(number:any) {
      if (number >= 1000000 && number < 1000000000) {
        const millions = (number / 1000000).toFixed(0);
        return `${millions}~ Triệu`;
      }
      else if (number >= 1000000000) {
        const billions = (number / 1000000000 * 10) / 10;
        return `${billions}~ Tỉ`;
      } 
      else {
        return number.toString();
      }
    },
    async saveFavorites(carId:any){
      const saveFavoritesDto: SaveFavoritesDto = {
        car_id: carId || '',
      };
      try {
        const data = await saveCarFavorites(saveFavoritesDto);
        if (data) {
          this.toast.success("Đã thêm vào xe yêu thích!!");
        }
      } catch (error) {
        this.toast.warning("Xe này đã được thêm vào trước đó!!");
      }
    },
    async deleteFavorites(favId: any) {
      try {
        const data = await deleteCarFavorites(favId);
        if (data) {
          this.toast.success("Đã xóa khỏi xe yêu thích!!");
        }
      } catch (error) {
        this.toast.warning("lỗi");
      }
    },
    isFavorite(vehicleId:any) {
      return this.data.includes(vehicleId);
    },
    async toggleFavorite(vehicleId:any) {
      const index = this.data.indexOf(vehicleId);
      const saveFavoritesDto: SaveFavoritesDto = {
        car_id: vehicleId || '',
      };
      if (index === -1) {
        try {
          // Gọi API để thêm vào danh sách yêu thích
          const data = await saveCarFavorites(saveFavoritesDto);
          console.log(data);
          if (data) {
            this.toast.success("Đã thêm vào xe yêu thích!!");
          }
          this.data.push(vehicleId);
        } catch (error) {
          this.toast.error("lỗi");
          console.error('Có lỗi khi thêm vào yêu thích', error);
        }
      } else {
        try {
          const data = await deleteCarFavorites(favId);
          this.data.splice(index, 1);
          if (data) {
            this.toast.success("Đã xóa khỏi xe yêu thích!!");
          }
        } catch (error) {
          this.toast.warning("lỗi");
        }
      }
    },
  }
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
  color: #1c2c5e;
  font-weight: 700;
  font-size: 30px;
  margin-bottom: 7px;
}

.container-content {
  overflow: hidden;
  text-overflow: ellipsis;
}

.content-style {
  width: 10%;
  font-size: 25px;
  font-weight: 500;
  letter-spacing: 2px;
  white-space: nowrap;
  text-overflow: ellipsis;
  color: #1c2c5e !important;
  padding: 0px !important;
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
.icon {
  position: relative;
  top: -3px;
  margin-right: 5px;
}

.card {
  padding-bottom: 30px;
}
.icon-score{
  width: 43px;
  height: 33px;
  padding-right: 10px;
}
.score{
  position: relative;
  top: 6px;
  color: #1c2c5e;
  font-weight: 600;
}
</style>
