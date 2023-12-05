import { RouteRecordRaw, createRouter, createWebHistory } from "vue-router";
import HomePage from "./pages/HomePage.vue";
import LoginPage from "./pages/auth/LoginPage.vue";
import RegisterPage from "./pages/auth/RegisterPage.vue";
import ProfilePage from "./pages/account/ProfilePage.vue";
import ChangePasswordPage from "./pages/account/ChangePasswordPage.vue";
import HistoryTransaction from "./pages/account/HistoryTransaction.vue";
import AccountLayout from "./pages/account/AccountLayout.vue";
import HistoryBuyCarPage from "./pages/account/HistoryBuyCarPage.vue";
import HistorySaleCarPage from "./pages/account/HistorySaleCarPage.vue";

import AdminLayout from "./pages/account/admin/AdminLayout.vue";
import AdminDashboardPage from "./pages/account/admin/AdminDashboardPage.vue";
import AdminUserPage from "./pages/account/admin/AdminUserPage.vue";
import AdminCarPage from "./pages/account/admin/AdminCarPage.vue";
import AdminReportPage from "./pages/account/admin/AdminReportPage.vue";

import ListCar from "./components/home/ListCar.vue";
import CarInfo from "./pages/buy_car/CarInfo.vue";

import SaleCar from "./pages/sale_car/SaleCar.vue";
import FavoritesCar from "./pages/favorites_car/FavoritesCar.vue";



const routes: RouteRecordRaw[] = [
  { path: "/", component: HomePage },
  {
    path: "/auth",
    children: [
      { path: "login", component: LoginPage },
      { path: "register", component: RegisterPage },
    ],
  },
  { path: "/list-car", component: ListCar },
  { path: '/car-info/:carId', name: "CarInfo", component: CarInfo},
  {
    path: "/account",
    component: AccountLayout,
    children: [
      { path: "profile", component: ProfilePage },
      { path: "change-password", component: ChangePasswordPage },
      { path: "history-transaction", component: HistoryTransaction },
      { path: "history-buy-car", component: HistoryBuyCarPage },
      { path: "history-sale-car", component: HistorySaleCarPage },
      {
        path: "admin",
        component: AdminLayout,
        children: [
          { path: "dashboard", component: AdminDashboardPage },
          { path: "user", component: AdminUserPage },
          { path: "car", component: AdminCarPage },
          { path: "report", component: AdminReportPage },
        ],
      },
    ],
  },
  { path: "/sale-car", component: SaleCar },
  { path: "/favorites-car", component: FavoritesCar },

];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
