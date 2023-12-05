<template>
  <v-card flat>
    <v-card-title class="d-flex align-center pe-2">
      <v-icon icon="mdi-video-input-component"></v-icon> &nbsp;
      History Buy Car

      <v-spacer></v-spacer>

      <v-text-field
        v-model="search"
        prepend-inner-icon="mdi-magnify"
        density="compact"
        label="Search"
        single-line
        flat
        hide-details
        variant="solo-filled"
      ></v-text-field>
    </v-card-title>

    <v-divider></v-divider>
    <v-data-table v-model:search="search" :items="items" :headers="headers" class="pa-5">
      <template v-slot:header.id>
        <div class="header_title">ID</div>
      </template>
      <template v-slot:header.title>
        <div class="header_title">Name</div>
      </template>
      <template v-slot:header.thumbnail>
        <div class="header_title">Thumbnail</div>
      </template>
      <template v-slot:header.price>
        <div class="header_title">Price</div>
      </template>
      <template v-slot:header.verify>
        <div class="header_title">Verify</div>
      </template>
      <template v-slot:header.status>
        <div class="header_title">Status</div>
      </template>
      <template v-slot:header.actions>
        <div class="header_title">Action</div>
      </template>
      <template v-slot:item.thumbnail="{ item }">
        <v-card
          width="100"
          height="56"
          class="ma-2"
        >

          <v-img
            :src="`http://127.0.0.1:8000${item.thumbnail}`"
            height="65"
            width="100"
          ></v-img>
        </v-card>
      </template>

      <template v-slot:item.verify="{ item }">
        <div>
          <v-chip
            :color="item.verify ? 'green' : 'red'"
            :text="item.verify ? 'Đã duyệt' : 'Đang đợi duyệt'"
            class="text-uppercase"
            label
            size="small"
          ></v-chip>
        </div>
      </template>
      <template v-slot:[`item.actions`]="{ item } " >
        <v-icon
          small
          class="mr-2"
          @click="editItem(item)"
          
        >
          mdi-file-document-edit-outline
        </v-icon>
        <v-icon
          small
          @click="deleteItem(item.id)"
        >
          mdi-delete
        </v-icon>
                
      </template>    
    </v-data-table>
  </v-card>
  <v-dialog v-model="dialogEdit" >
    <v-card title="Update Car" >
      <div class="pa-10">
        <div class="form-control w-full mb-2">
          <label class="label">
            <span class="label-text">Tên Xe / Title</span>
          </label>
          <v-text-field v-model="editedItem.title" label="Nhập Tên/Title" variant="outlined"></v-text-field>
        </div>
        <div class="d-flex mb-1">
          <div class="form-control w-full mb-2 pr-5">
            <label class="label">
              <span class="label-text">Hãng xe</span>
            </label>
            <v-select
              v-model="editedItem.brand_id"
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
              v-model="editedItem.figure_id"
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
              v-model="editedItem.year"
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
            <v-text-field v-model="editedItem.odo" suffix="Km" label="Nhập số km đã chạy" variant="outlined"></v-text-field>
          </div>  
        </div>
        <div class="d-flex mb-1">
          <div class="form-control w-full mb-2 pr-5">
            <label class="label">
              <span class="label-text">Hộp số</span>
            </label>
            <v-select
              v-model="editedItem.gear_id"
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
              v-model="editedItem.color_id"
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
              v-model="editedItem.seat"
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
              v-model="editedItem.engine"
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
              v-model="editedItem.price"
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
              v-model="editedItem.description"
              label="Nhập thông tin"
              variant="outlined"
            ></v-text-field>
          </div>  
        </div>
        <v-file-input
          @change="onFileChange"
          v-model="thumbnail"
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
          <button @click.prevent="submitInfo(editedItem.id)" class="btn">Gửi thông tin</button>
        </div>
      </div>
    </v-card>
  </v-dialog>
  <v-dialog width="500" v-model="dialogDelete">
      <v-card title="Cảnh Báo">
        <v-card-text>
          Hãy cân nhắc trước khi Xoá!!
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
          <v-btn color="blue darken-1" text @click="deleteItemConfirm()">OK</v-btn>
        </v-card-actions>
      </v-card>
  </v-dialog>
  <!-- {{ brands }} -->
</template>
<script>
import { historySale, deleteCar } from '../../apis/user/car';
import { useToast } from "vue-toastification";
import { useStore,mapGetters } from 'vuex';
import { updateCar } from '../../apis/user/car';
import { uploadFile } from '../../apis/common/upload-file'
  export default {
    data () {
      const toast = useToast();
      return {
        path: "http://127.0.0.1:8000",
        loading: false,
        toast,
        data: [],
        search: '',
        dialogEdit: false,
        dialogDelete: false,
        items: [],
        idCar:'',
        headers: [
          {
            text: 'No',
            value:'id'

          }, 
          {
            text: 'Name',
            value:'title'

          }, 
          {
            text: 'Thumbnail',
            value:'thumbnail'
          }, 
          {
            text: 'Price',
            value: 'price',
          },
          { text: 'Verify', value: 'verify' },
          { text: 'Status', value: 'status' },

          { text: 'Action', value: 'actions', sortable: false },
        ],
        editedItem: '',
        years: [
        '2009' , '2010' ,'2011' , '2012' ,'2013' , '2014' ,'2015' , '2016' , '2017' , '2018' ,'2019' , '2020' ,'2021' , '2022' ,'2023'
        ],
        seats: [
        '4' , '5' ,'6' , '7' ,'8'
        ],
        engines:[
          'Xăng' , 'Dầu' ,'Điện' , 'Hybrid' ,'Hydro'
        ],
        file_not_null:'',
        thumbnail: [],
      }
    },
    watch: {
      dialogEdit(newVal) {
        if (!newVal) {
          this.thumbnail = []
        }
      }
    },
    created(){
      this.getData();
    },
    methods: {
      onFileChange(file) {
        console.log(file);
        if (!file) {
          return;
        }
        const reader = new FileReader();
        reader.onload = () => {
          this.thumbnail = file;
        };
      },
      async getData() {
        const data = await historySale();
        if (data) {
          this.items = data;
        }
      },
      editItem (item) {
        this.dialogEdit = !this.dialogEdit;
        //Object.assign() sao chép các thuộc tính có thể đếm được và sở hữu từ đối tượng nguồn sang đối tượng đích
        this.editedItem = Object.assign({}, item);
      },

      async submitInfo(id){
        try {
          // let is_thumbnail = this.editedItem.thumbnail ;
          let param = { "image": this.thumbnail[0] };
          let file_not_null = "";

          if(this.thumbnail[0]){
            file_not_null = { "image": this.thumbnail[0] };
            const upload_file = await uploadFile(file_not_null);
            this.editedItem.thumbnail = upload_file.path
          }
          const data = await updateCar(id,this.editedItem);
          if (data) {
            this.toast.success("Cập nhật xe thành công!!");
          }
          this.getData();
          this.dialogEdit = false;
        } catch (error) {
          // Xử lý lỗi một cách thích hợp, ví dụ in ra console
          this.toast.error("Cập nhật hồ sơ thất bại!!");
        }
      },
      async deleteItemConfirm () {
        
        try {
          const data = await deleteCar(this.idCar);
          if (data) {
            this.getData();
            this.dialogDelete = false
            this.toast.success("Xoá thành công");
            
          }
        } catch (error) {
          this.toast.success("Xoá dữ liệu thất bại");
        }
      },
      deleteItem (id) {
        this.idCar = id
        this.dialogDelete = true
      },
      close () {
        this.dialog = false
      },

      closeDelete () {
        this.dialogDelete = false
      },

    },
    computed: {
      ...mapGetters(['brands','figures','gears','colors']),
    },
  }
</script>
<style scoped>
.header_title{
  font-size: 18px;
    font-weight: 600;
}
</style>