<template>
  <div class="text-black">
    <div class="table-header">
      <h2>Products</h2>
      <input type="text" v-model="search" @input="fetchProducts" placeholder="Search products...">
    </div>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Image</th>
          <th>Title</th>
          <th>Price</th>
          <th>Last Updated</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td>{{ product.id }}</td>
          <!-- <td><img :src="images/product.image" alt="Product Image" width="150" height="150"></td> -->
          <td><img :src="images/product.image" alt="Product Image" width="150" height="150"></td>
          <td>{{ product.title }}</td>
          <td>{{ product.price }}</td>
          <td>{{ product.updated_at }}</td>
          <td>
            <div class="dropdown">
              <button class="dropbtn">⋮</button>
              <div class="dropdown-content">
                <a href="#" @click.prevent="editProduct(product)">Edit</a>
                <a href="#" @click.prevent="deleteProduct(product.id)">Delete</a>
              </div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios'; // Using default Axios

export default {
  props: ['products'],
  data() {
    return {
      search: '',
    };
  },
  methods: {
    async fetchProducts() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/products', {
          params: {
            search: this.search,
          }
        });
        this.$emit('fetch-products', response.data.data);
      } catch (error) {
        console.error('Error fetching products:', error.response ? error.response.data : error.message);
      }
    },
    onFileChange(event) {
      this.newProduct.image = event.target.files[0];
    },
    
    editProduct(product) {
      // Implement edit product logic here
    },
    async deleteProduct(productId) {
      try {
        await axios.delete(`http://127.0.0.1:8000/api/products/${productId}`);
        this.fetchProducts();
      } catch (error) {
        console.error('Error deleting product:', error.response ? error.response.data : error.message);
      }
    }
  },
  watch: {
    search() {
      this.fetchProducts();
    }
  },
  mounted() {
    this.fetchProducts();
  }
};
</script>

<style>
/* Add your styles for the table and other elements here */
.text-black {
  color: black;
}

.table-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #f2f2f2;
}

img {
  border-radius: 5px;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropbtn {
  background: none;
  border: none;
  font-size: 18px;
  cursor: pointer;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {
  background-color: #f1f1f1;
}

.dropdown:hover .dropdown-content {
  display: block;
}

.dropdown:hover .dropbtn {
  background-color: #3e8e41;
}
</style>