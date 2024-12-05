import "./assets/main.css";
import "./index.css";
import { createApp } from "vue";
import store from "./store";
import router from "./router";
//import { createPinia } from "pinia";
import App from "./App.vue";

const app = createApp(App);

//app.use(createPinia());
app.use(router);
app.use(store);
app.mount("#app");
