import { createRouter, createWebHistory } from "vue-router";
import RequestPassword from "../views/RequestPassword.vue";
import ResetPassword from "../views/ResetPassword.vue";
import Dashboard from "../views/Dashboard.vue";
import Login from "../views/Login.vue";
import store from "../store";
import AppLayout from "@/components/AppLayout.vue";
import NotFound from "@/components/NotFound.vue";
import Products from "../views/Products.vue";
import ProductsTable from "../views/Products/ProductsTable.vue"; // Import ProductsTable component
import Users from "../views/Users.vue";
import Settings from "../views/Settings.vue";
import ProductsDetails from "../views/Products/ProductsDetails.vue";

const routes = [
  {
    path: "/app",
    name: "app",
    component: AppLayout,
    meta: {
      requiresAuth: true,
    },
    children: [
      {
        path: "dashboard",
        name: "app.dashboard",
        component: Dashboard,
      },
      {
        path: "products",
        name: "app.products",
        component: Products,
        children: [
          {
            path: "",
            name: "app.products.table",
            component: ProductsTable,
          },
          {
            // path: "/products/:id",
            // name: "app.products.details",
            // component: ProductsDetails,
            path: "/products/:id/details",
            name: "app.products.details",
            component: ProductsDetails,
          },
        ],
      },
      {
        path: "users",
        name: "app.users",
        component: Users,
      },
      {
        path: "settings",
        name: "app.settings",
        component: Settings,
      },
    ],
  },

  {
    path: "/dashboard",
    name: "dashboard",
    component: Dashboard,
  },
  {
    path: "/",
    name: "login",
    component: Login,
  },
  {
    path: "/request-password",
    name: "request-password",
    component: RequestPassword,
  },
  {
    path: "/resetpassword/token",
    name: "resetpassword",
    component: ResetPassword,
  },

  {
    path: "/logout",
    name: "logout",
    component: Login,
  },

  {
    path: "/:pathMatch(.*)",
    name: "notfound",
    component: NotFound,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// router.beforeEach((to, from, next) => {
//   if (to.meta.requiresAuth && !store.state.user.token) {
//     next({ name: "login" });
//   } else if (to.meta.requiresGuest && store.state.user.token) {
//     next({ name: "app.dashboard" });
//   } else {
//     next();
//   }
// });

export default router;
