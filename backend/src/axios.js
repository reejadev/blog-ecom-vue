import axios from "axios";
import store from "./store"; // Assuming you have a Vuex store setup
import router from "./router"; // Assuming you have a Vue Router setup

const axiosClient = axios.create({
  baseURL: "http://127.0.0.1:8000", // Replace with your API base URL
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

axiosClient.interceptors.request.use(
  (config) => {
    const token = store.state.user.token; // Assuming your Vuex store has a token state
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

axiosClient.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
    if (error.response.status === 401) {
      store.commit("setToken", null);
      router.push({ name: "login" });
    }
    return Promise.reject(error);
  }
);

export default axiosClient;
