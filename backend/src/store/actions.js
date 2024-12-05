// store/actions.js
import axios from "axios";

export default {
  async getProducts(
    { commit },
    { perPage, search, sortField, sortDirection, page }
  ) {
    try {
      const response = await axios.get("/products", {
        params: {
          perPage,
          search,
          sortField,
          sortDirection,
          page,
        },
      });
      commit("SET_PRODUCTS", response.data);
      return response; // Ensure the response is returned
    } catch (error) {
      console.error("Error fetching products:", error);
      throw error; // Ensure errors are propagated
    }
  },
  async createProduct({ commit }, product) {
    try {
      const response = await axios.post(
        "http://localhost:8000/app/products",
        product
      );
      commit("ADD_PRODUCT", response.data);
      return response; // Ensure the response is returned
    } catch (error) {
      console.error("Error creating product:", error);
      throw error; // Ensure errors are propagated
    }
  },
  async updateProduct({ commit }, product) {
    try {
      const response = await axios.put(
        `http://localhost:5173/app/products/${product.id}`,
        product
      );
      commit("UPDATE_PRODUCT", response.data);
      return response; // Ensure the response is returned
    } catch (error) {
      console.error("Error updating product:", error);
      throw error; // Ensure errors are propagated
    }
  },
  async deleteProduct({ commit }, productId) {
    try {
      const response = await axios.delete(
        `http://localhost:8000/app/products/${productId}`
      );
      commit("REMOVE_PRODUCT", productId);
      return response; // Ensure the response is returned
    } catch (error) {
      console.error("Error deleting product:", error);
      throw error; // Ensure errors are propagated
    }
  },
};
