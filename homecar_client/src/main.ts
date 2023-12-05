import { createApp } from "vue";
import "./style.css";
import App from "./App.vue";

import router from "./router";
import 'vuetify/lib/styles/main.css'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/lib/components/index.mjs'
import * as directives from 'vuetify/lib/directives/index.mjs'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import '@mdi/font/css/materialdesignicons.css'
import { store } from './stores'
const vuetify = createVuetify({
  components,
  directives,
})
createApp(App).use(router).use(vuetify).use(Toast).use(store).mount("#app");
