<template>
  <div class="header bg-base-100">
    <div class="header-content w-full mx-auto flex justify-between items-center">
      <div class="logo">
        <a href="/">
          <img src="../../public/images/logoCar-ok1.png" alt="Logo" class="h-20 w-auto" />
        </a>
      </div>
      <div class="menu-header whitespace-nowrap text-neutral">
        <ul class="flex">
          <li><router-link to="/">Trang chủ</router-link></li>
          <li><router-link to="/">Mua xe</router-link></li>
          <li><router-link to="/sale-car">Bán xe</router-link></li>
          <li><router-link to="/sale-car">Dịch vụ</router-link></li>
          <li><router-link to="/sale-car">Giới thiệu</router-link></li>
        </ul>
      </div>
      <div data-id="account" class="h-[40px] rounded-full border-gray-200 border px-4 py-2 hidden lg:flex items-center nav-hover-item cursor-pointer group font-bold text-ellipsis overflow-hidden whitespace-nowrap mr-3 max-w-[200px]">
        <div >
          <img src="../../public/images/account_icon.png" width="24" height="24" alt="Tài khoản" class="inline-flex">
          <span v-if="user == null" title=" " class="text-neutral hidden lg:inline ml-2 mr-2 text-ellipsis overflow-hidden whitespace-nowrap">Tài khoản</span>
          <span v-else title=" " class="text-neutral hidden lg:inline ml-2 mr-2 text-ellipsis overflow-hidden whitespace-nowrap">{{user.user.name}}</span>
          
        </div>
        <!-- Dropdown content -->
        <transition name="fade">
          <div v-if="user == null" class="menu-dropdown-nav py-0 top-14 w-40 group-hover:block drop-shadow-lg bg-white dropdown-menu absolute hidden h-auto rounded-md z-50">
            <div class="menu-dropdown-nav py-4 bg-white">
              <ul class="list-none top-2 text-gray-700 pt-1 mx-4">
                <li>
                  <router-link to="/auth/register" class="w-full py-2 px-4 hover:bg-slate-200 block whitespace-no-wrap rounded-md navbar-item-link mb-1" rel="nofollow">Đăng ký</router-link>
                </li>
                <li>
                  <router-link to="/auth/login" class="w-full py-2 px-4 hover:bg-slate-200 block whitespace-no-wrap rounded-md navbar-item-link" rel="nofollow">Đăng nhập</router-link>
                </li>
              </ul>
            </div>
          </div>
          <div v-else class="menu-dropdown-nav py-0 top-14 w-40 group-hover:block drop-shadow-lg bg-white dropdown-menu absolute hidden h-auto rounded-md z-50">
            <div class="menu-dropdown-nav py-4 bg-white">
              <ul class="list-none top-2 text-gray-700 pt-1 mx-4">
                <li>
                  <router-link to="/account" class="w-full py-2 px-4 hover:bg-slate-200 block whitespace-no-wrap rounded-md navbar-item-link" rel="nofollow">Quản lý</router-link>
                </li>
                <li>
                  <a @click="onSubmit()" class="w-full py-2 px-4 hover:bg-slate-200 block whitespace-no-wrap rounded-md navbar-item-link" rel="nofollow">Đăng xuất</a>
                </li>
              </ul>
            </div>
          </div>
        </transition> 
      </div>
      <div class="car-like px-2 items-center hidden lg:flex" bis_skin_checked="1">
        <div class="cursor-pointer tooltip w-[42px] h-[42px] flex justify-center items-center rounded-full border-gray-200 border" bis_skin_checked="1">
          <router-link to="/favorites-car" class="w-full h-full flex justify-center items-center" rel="nofollow" aria-label="favorite-cars">
            <img src="../../public/images/heart.png" width="24" alt="xe yêu thích" height="24"> 
            <img src="../../public/images/heart_active_button.png" alt="xe yêu thích" width="24" height="24" style="display: none;">
          </router-link> 
        </div>
      </div>
      <span class="pr-2 cursor-pointer">
        <span class="text-sm block leading-[1rem]">Hotline CSKH</span>
        <a class="font-bold text-tcSecondary text-lg leading-[1rem]">0396337628</a>
      </span>
    </div>
  </div>
</template>
<script>
// import { getHeader } from "../apis/instance";
import { mapGetters } from 'vuex';
import { logout } from '../apis/auth';
import { useToast } from "vue-toastification";

export default {
  data() {
    const toast = useToast();
    return {
      isVisible: false,
      toast,
    };
  },
  methods: {
    async onSubmit() {
      // try {
      //   const data = await logout();
      //   if (data) {
          this.toast.success("Đăng xuất thành công");
          localStorage.removeItem('access_token');
          localStorage.removeItem('user');
          this.$router.push({ path: '/auth/login'});

      //   }
      // } catch (error) {
      //   this.toast.error("lỗi");
      // }
      // this.loading = false;
    }
  },
  // mounted() {
  //   setInterval(() => {
  //     const { headers } = getHeader();
  //     this.headers = headers;
  //   }, 1000); // Cập nhật mỗi giây (có thể điều chỉnh thời gian tùy ý)
  // },
  computed: {
    ...mapGetters(['user']),
  }
};
</script>
<style scoped>
/* Thêm các kiểu CSS tùy chỉnh cho header */

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
.header {
  background-color: #ffffff;
  color: rgb(0, 0, 0);
  
}

.header-content {
  position: fixed;
  z-index: 1;
  background: #ffff;
  padding: 0px 5rem;
}

.logo {
  flex: 1; /* Logo chiếm phần lớn của header */
}

.menu-header {
  color: #081f4d!important;
  font-family: inherit;
  font-weight: 600!important;
  margin-right: 29px;
  font-size: 16px;
}
.menu-header ul li {
  margin-right: 33px;
}
.car-like{
  margin-right: 20px;

}

.user {
  /* Thêm các thuộc tính CSS tùy chỉnh cho phần người dùng */
}

</style>
