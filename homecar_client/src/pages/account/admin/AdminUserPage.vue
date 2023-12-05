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
      <template v-slot:header.name>
        <div class="header_title">Name</div>
      </template>
      <template v-slot:header.avatar>
        <div class="header_title">Avatar</div>
      </template>
      <template v-slot:header.email>
        <div class="header_title">Email</div>
      </template>
      <template v-slot:header.phone>
        <div class="header_title">Phone</div>
      </template>
      <template v-slot:header.date_of_birth>
        <div class="header_title">Birthday</div>
      </template>
      <template v-slot:header.actions>
        <div class="header_title">Action</div>
      </template>
      <template v-slot:item.avatar="{ item }">
          <v-img
            v-if="item.avatar"
            :src="`http://127.0.0.1:8000${item.avatar}`"
            height="50"
            width="50"
          ></v-img>
          <v-img
            v-else
            src="../../../../public/images/avatarDF.png"
            height="50"
            width="50"
          ></v-img>
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
import { listUser } from '../../../apis/admin/manage';
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
            value:'name'

          }, 
          {
            text: 'Avatar',
            value:'avatar'
          }, 
          {
            text: 'Email',
            value: 'email',
          },
          { text: 'Phone', value: 'phone' },

          { text: 'Birthday', value: 'date_of_birth' },
        
          { text: 'Action', value: 'actions', sortable: false },
        ],
        editedItem: '',
      }
    },
    watch: {

    },
    created(){
      this.getData();
    },
  methods: {
    async getData() {
      const data = await listUser();
      if (data) {
        this.items = data;
      }
      console.log(this.items);
    },
  }
  }
</script>
<style scoped>
.header_title{
  font-size: 18px;
  font-weight: 600;
}
</style>