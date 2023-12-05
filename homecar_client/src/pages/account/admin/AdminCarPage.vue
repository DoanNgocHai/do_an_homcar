<template>
  <v-card flat>
    <v-card-title class="d-flex align-center pe-2">
      <v-icon icon="mdi-video-input-component"></v-icon> &nbsp;
      History Sale Car

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
      <template v-slot:header.brand.name>
        <div class="header_title">Hãng xe</div>
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
          @click="dialogVerify(item.id)"
          
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
  <v-dialog width="500" v-model="dialogVerifyCar" >
    <v-card title="Verify Car">
      <v-card-text>
        Bạn muốn đăng xe này lên hệ thống
      </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="red-darken-1"
            variant="text"
            @click="dialogConfirmSeller = false"
          >
            Hủy bỏ
          </v-btn>
          <v-btn
            color="green-darken-1"
            variant="text"
            @click="verifyCar()"
          >
            Xác nhận đăng
          </v-btn>
        </v-card-actions>
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
</template>
<script>
import { listCar, adminVerify } from '../../../apis/admin/manage';
import { useToast } from "vue-toastification";
import { useStore,mapGetters } from 'vuex';
import { updateCar } from '../../../apis/user/car';
import { uploadFile } from '../../../apis/common/upload-file'
  export default {
    data () {
      const toast = useToast();
      return {
        path: "http://127.0.0.1:8000",
        loading: false,
        toast,
        data: [],
        search: '',
        dialogVerifyCar: false,
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
            value:'title',
            width: '200'
          }, 
          {
            text: 'Thumbnail',
            value:'thumbnail'
          }, 
          {
            text: 'Brands',
            value:'brand.name'
          }, 
          {
            text: 'Price',
            value: 'price',
          },
          { text: 'Verify', value: 'verify' },
          { text: 'Status', value: 'status' },

          { text: 'Action', value: 'actions', sortable: false },
        ],
      }
    },
    watch: {
    },
    created(){
      this.getData();
    },
    methods: {
      async getData() {
        const data = await listCar();
        if (data) {
          this.items = data;
        }
      },
      async verifyCar() {
        const data = await adminVerify(this.idCar);
        this.toast.success("Verify thành công");
        this.dialogVerifyCar = !this.dialogVerifyCar;
        this.getData();
      },
      dialogVerify(id) {
        this.idCar = id;
        this.dialogVerifyCar = !this.dialogVerifyCar;
      },
    },
    computed: {
    },
  }
</script>
<style scoped>
.header_title{
  font-size: 18px;
  font-weight: 600;
}
</style>