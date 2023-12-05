<template>
  <v-container>
    <v-row no-gutters>
      <v-col cols="12" sm="12">

        <v-card outlined>
          <div class="mx-auto text-center">
            <v-file-input
              id="avatar-input"
              v-model="avatar"
              outlined
              dense
              @change="onFileChange"
              hide-input
              prepend-icon="mdi-camera"
              style="display: none"
            >
            </v-file-input>
            <label>
              <v-avatar size="120" @click="onAvatarClick">
                <img
                  v-if="!image && !profile.avatar"
                  src="../../../public/images/car-bg.png"
                />
                <img v-else-if="image" :src="image" />
                <img v-else :src="path + profile.avatar" />
              </v-avatar>
              <v-icon class="icon-camera" @click="onAvatarClick" color="success" icon="mdi-camera"></v-icon>

            </label>
          </div>
          <v-card-text>
            <v-row>
              <v-col cols="12" md="6">
                <label>Name</label>
                <v-text-field
                  dense
                  v-model="profile.name"
                  label="Name"
                  variant="outlined"
                  :rules="nameRules"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <label>Email Personal</label>
                <v-text-field
                  dense
                  v-model="profile.email"
                  label="Email"
                  :rules="emailRules"
                  required
                  variant="outlined"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <label>Phone</label>
                <v-text-field
                  dense 
                  v-model="profile.phone"
                  label="Phone"
                  variant="outlined"
                  :rules="phoneRules"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <label>Address</label>
                <v-text-field
                  dense
                  v-model="profile.address"
                  label="Address"
                  variant="outlined"
                  :rules="addressRules"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <label>Birthday</label>
                <VueDatePicker class="field_birthday" placeholder="Birth day" v-model="profile.date_of_birth" :enable-time-picker="false" />
                <!-- <v-menu
                  ref="menu"
                  v-model="menu"
                  :close-on-content-click="false"
                  :return-value.sync="date"
                  transition="scale-transition"
                  offset-y
                  min-width="auto"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      label="Birthday"
                      outlined
                      dense
                      v-model="profile.date_of_birth"
                      readonly
                      v-bind="attrs"
                      :on="on"
                      :rules="birthdayRules"
                      required
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="profile.date_of_birth"
                    :max="maxDate"
                    no-title
                    scrollable
                  >
                    <v-spacer></v-spacer>
                    <v-btn text color="primary" @click="menu = false">
                      Close
                    </v-btn>
                    <v-btn text color="primary" @click="$refs.menu.save(date)">
                      Save
                    </v-btn>
                  </v-date-picker>
                </v-menu> -->
              </v-col>
              <v-col cols="12" md="6">
                <label>Citizen Identity</label>
                <v-text-field
                  dense
                  variant="outlined"
                  v-model="profile.citizen_identity"
                  label="citizen_identity"
                  required
                ></v-text-field>
              </v-col>

              <v-col cols="12" md="12">
                <label class="font-weight-medium">Password</label>
                <v-text-field
                  dense
                  v-model="profile.password"
                  label="Password"
                  variant="outlined"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-btn :loading="loading" color="primary" @click="Update()">
                  <v-icon>mdi-content-save</v-icon>
                  Update
                </v-btn>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { mapGetters } from 'vuex';
import { getProfile, updateProfile } from '../../apis/profile/profile';
import { useToast } from "vue-toastification";
import { uploadFile } from '../../apis/common/upload-file'
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
export default {
  components: { VueDatePicker },
  data() {
    const toast = useToast();
    return {
      menu: false,
      date: "",
      image: null,
      path: "http://127.0.0.1:8000",
      avatar: [],
      password: "",
      profile: {
        // _method: "PUT",
        name: "",
        email: "",
        avatar: "",
        date_of_birth: "",
        address: "",
        phone: "",
        password: "",
      },
      nameRules: [
        v => !!v || 'Name is required',
        v => (v && v.length <= 20) || 'Name must be less than 20 characters',
      ],
      emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ],
      phoneRules: [
        v => !!v || 'Phone is required',
        v => (v && v.length <= 10) || 'Phone must be less than 10 characters',
      ],
      addressRules: [
        v => !!v || 'Address is required',
        v => (v && v.length <= 100) || 'Phone must be less than 100 characters',
      ],
      birthdayRules: [
        v => !!v || 'Birthday is required',
      ],
      citizenRules: [
        v => !!v || 'Citizen Identity is required',
        v => (v && v.length <= 12 ) || 'Citizen Identity must be less than 12 characters',
      ],
      toast,
      loading: false,
      formattedDateOfBirth: ''
    };
  },
  watch: {
    // Khi profile.date_of_birth thay đổi, hãy cập nhật formattedDateOfBirth
    'profile.date_of_birth': function (newValue) {
      this.formattedDateOfBirth = this.formatDate(newValue);
    }
  },
  created() {
    this.userProfile();
  },
  computed: {
    maxDate() {
      let now = new Date();
      return now.toISOString().slice(0, 10);
    },
    ...mapGetters(['user']),

  },
  methods: {
    createImage(file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        this.image = e.target.result;
        this.avatar = file;
      };
      reader.readAsDataURL(file[0]);
    },
    onFileChange() {
      if (!this.avatar) {
        return;
      }
      this.createImage(this.avatar);
    },
    async userProfile() {
      try {
        const response = await getProfile();
        this.profile = response;
        console.log(response);
      } catch (error) {
        console.error('Error fetching brands:', error);
      }
    },
    async Update() {
      this.loading = true;
      let param = { "image": this.avatar[0] };
      const data = await uploadFile(param);
      // if (this.profile.password != "") {
      //     this.profile.password = this.password;
      // } else {
      //     this.profile.password = "";
      // }
      const dataRs = {
        name: this.profile.name,
        // citizen_identity: this.profile.citizen_identity,
        // email: this.profile.email,
        date_of_birth: this.formattedDateOfBirth,
        phone: this.profile.phone,
        address: this.profile.address,
        avatar: data.path,
        // password: this.profile.password,
      };
      console.log(dataRs);
      try {
        const data = await updateProfile(dataRs);
        if (data) {
          this.toast.success("Cập nhật hồ sơ thành công!!");
        }
      } catch (error) {
        // Xử lý lỗi một cách thích hợp, ví dụ in ra console
        this.toast.error("Cập nhật hồ sơ thất bại!!");
      }
      this.loading = false;
    },
    onAvatarClick() {
      document.getElementById("avatar-input").click();
    },
    formatDate(date) {
      if (!date) return '';
      // Tạo một đối tượng Date mới từ giá trị date
      const d = new Date(date);
      // Định dạng lại ngày tháng
      let month = '' + (d.getMonth() + 1),
          day = '' + d.getDate(),
          year = d.getFullYear();
      
      // Thêm số 0 vào trước nếu là một chữ số
      if (month.length < 2) 
          month = '0' + month;
      if (day.length < 2) 
          day = '0' + day;

      // Trả về chuỗi đã được định dạng
      return [year,month,day].join('-');
    }
  },
  mounted() {
    // Khi component được tạo, định dạng ngày tháng ban đầu
    this.formattedDateOfBirth = this.formatDate(this.profile.date_of_birth);
  }
};
</script>

<style scoped lang="scss">
.v-avatar img:hover {
  cursor: -webkit-grab;
}
label {
  font-weight: 450;
  position: relative;
  top: -10px
}
.col-md-6 {
}
.v-avatar img{
  border: solid 3px #4caf50;
}
.v-avatar{
  margin-top: 50px;
  cursor: pointer;
  border: solid 3px #4caf50;
}
.icon-camera{
  padding-top: 120px;
  padding-left: 25px;
  cursor: pointer;
}
.field-birthday{
  padding: 15px;
    padding-left: 35px;
    border: 1px solid #a3a1a1 !important;
}
</style>