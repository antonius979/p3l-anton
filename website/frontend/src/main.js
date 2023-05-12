

import Vue from "vue";
import App from "./App.vue";
import vuetify from "@/plugins/vuetify";
import router from "./router";
import axios from 'axios'; // Tambahan ini GD11


Vue.config.productionTip = false;

//Tambahan GD11
Vue.prototype.$http = axios; // code standar untu menggunakan axios
// Vue.prototype.$api = 'https://backend-ajr.project-ku.xyz/api'; //link backend
Vue.prototype.$api = 'http://localhost:8000/api';
Vue.prototype.$image = 'https://backend-ajr.project-ku.xyz';

new Vue({
  vuetify,
  router,
  render: (h) => h(App),
}).$mount("#app");