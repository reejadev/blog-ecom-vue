import { createStore } from "vuex";
import { state } from "./state";
import * as actions from "./actions";
import * as mutations from "./mutations";
import Products from "../views/Products.vue";

const store = createStore({
  state: {
    user: {
      token: sessionStorage.getItem("TOKEN"),
      data: {},
    },
  },
  getters: {},
  actions: {},
  mutations: {},
});

export default store;
