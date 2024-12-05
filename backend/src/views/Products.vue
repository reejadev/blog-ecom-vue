<template>
  <div class="text-black">
    <div class="button-container">
      <button class="add-product-btn" @click="showModal = true">Add New Product</button>
    </div>
    
    <!-- Modal for adding a new product -->
    <div v-if="showModal" class="modal">
      <div class="modal-content">
        <span class="close" @click="showModal = false">&times;</span>
        <h2>Add New Product</h2>
        <form @submit.prevent="createProduct">
          <div>
            <label for="title">Title:</label>
            <input type="text" v-model="newProduct.title" required>
          </div>
          <div>
            <label for="description">Description:</label>
            <textarea v-model="newProduct.description" required></textarea>
          </div>
          <div>
            <label for="price">Price:</label>
            <input type="number" v-model="newProduct.price" required>
          </div>
          <div>
            <label for="image">Image:</label>
            <input type="file" @change="onFileChange">
          </div>
          <button type="submit" class="create-btn">Create</button>
        </form>
      </div>
    </div>

    <!-- Products Table -->
    <ProductsTable :products="products" @fetch-products="fetchProducts"></ProductsTable>
  </div>
</template>

<script>
import ProductsTable from './Products/ProductsTable.vue';
import axios from 'axios'; // Using default Axios

export default {
  components: {
    ProductsTable
  },
  data() {
    return {
      showModal: false,
      newProduct: {
        title: '',
        description: '',
        price: '',
        image: null
      },
      products: []
    };
  },
  methods: {
    onFileChange(event) {
      this.newProduct.image = event.target.files[0];
    },
    async createProduct() {
      const formData = new FormData();
      formData.append('title', this.newProduct.title);
      formData.append('description', this.newProduct.description);
      formData.append('price', this.newProduct.price);
      if (this.newProduct.image) {
        formData.append('image', this.newProduct.image);
      }

      try {
        const response = await axios.post('http://127.0.0.1:8000/api/products', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });
        this.showModal = false;
        this.fetchProducts();
      } catch (error) {
        console.error('Error creating product:', error.response ? error.response.data : error.message);
      }
    },
    async fetchProducts() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/products');
        this.products = response.data.data;
      } catch (error) {
        console.error('Error fetching products:', error.response ? error.response.data : error.message);
      }
    }
  },
  mounted() {
    this.fetchProducts();
  }
};
</script>

<style>
/* Add your styles for the modal and other elements here */
.text-black {
  color: black;
}

.button-container {
  display: flex;
  justify-content: flex-end;
  margin-bottom: 20px;
}

.add-product-btn {
  background-color: #007bff;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.add-product-btn:hover {
  background-color: #0056b3;
}

.modal {
  display: block;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgb(0,0,0);
  background-color: rgba(0,0,0,0.4);
}

.modal-content {
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

.create-btn {
  background-color: #007bff;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.create-btn:hover {
  background-color: #0056b3;
}
</style>