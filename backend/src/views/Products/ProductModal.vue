<template>
    <div v-if="visible" class="modal text-black" >
      <div class="modal-content">
        <span @click="closeModal" class="close">&times;</span>
        <h2 class="space-y-2 block text-2xl font-bold text-gray-700 mb-2">{{ product.id ? 'Edit Product' : 'Add New Product' }}</h2>
        <form @submit.prevent="onSubmit" class="space-y-4">
    <div class="space-y-2">
      <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
      <input type="text" v-model="product.title" id="title" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
    </div>
    
    <div class="space-y-2">
      <label for="image" class="block text-sm font-medium text-gray-700">Upload Image</label>
      <input type="file" @change="onImageChange" id="image" required class="mt-1 block w-half border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
      <div v-if="product.imagePreview" class="mt-2">
        <img :src="product.imagePreview" alt="Image Preview" class="max-w-xs rounded-md" />
      </div>
    </div>


    <div class="space-y-2">
      <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
      <input type="text" v-model="product.price" id="price" required class="mt-1 block w-half border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
    </div>
       

    <div class="space-y-2">
          <button type="submit" class="py-2 px-4 border border-transparent 
          text-sm font-medium rounded-md text-white bg-indigo-600 hover"
   :disabled="loading">{{ product.id ? 'Update' : 'Create' }}</button>
          <button class="py-2 px-4 border border-transparent 
          text-sm font-medium rounded-md text-white bg-indigo-600 hover" type="button" @click="deleteProduct" v-if="product.id">Delete</button>
        </div>

        </form>

      </div>
    </div>
  </template>
  
  <script>
  import { ref, watch } from 'vue';
  import { useStore } from 'vuex';
  
  export default {
    name: 'ProductModal',
    props: {
      modelValue: {
        type: Boolean,
        required: true,
      },
      product: {
        type: Object,
        required: true,
      },
    },
    emits: ['update:modelValue', 'close'],
    setup(props, { emit }) {
      const store = useStore();
      const loading = ref(false);
      const product = ref({ ...props.product });
      const visible = ref(props.modelValue);
  
      watch(() => props.modelValue, (newVal) => {
        visible.value = newVal;
      });
  
      watch(() => props.product, (newVal) => {
        product.value = { ...newVal };
      });
  
      const closeModal = () => {
        emit('update:modelValue', false);
        emit('close');
      };
  
      // const onSubmit = () => {
      //   loading.value = true;
      //   if (product.value.id) {
      //     store.dispatch('updateProduct', product.value)
      //       .then(response => {
      //         loading.value = false;
      //         if (response.status === 200) {
      //           // TODO: show notification
      //           store.dispatch('getProducts');
      //           closeModal();
      //         }
      //       });
      //   } else {
      //     store.dispatch('createProduct', product.value)
      //       .then(response => {
      //         loading.value = false;
      //         if (response.status === 201) {
      //           // TODO: show notification
      //           store.dispatch('getProducts');
      //           closeModal();
      //         }
      //       });
      //   }
      // };

      const onSubmit = () => {
  loading.value = true;
  if (product.value.id) {
    store.dispatch('updateProduct', product.value)
      .then(response => {
        loading.value = false;
        if (response.status === 200) {
          // TODO: show notification
          store.dispatch('getProducts');
          closeModal();
        }
      })
      .catch(error => {
        loading.value = false;
        console.error('Error updating product:', error);
        // TODO: show error notification
      });
  } else {
    store.dispatch('createProduct', product.value)
      .then(response => {
        loading.value = false;
        if (response.status === 201) {
          // TODO: show notification
          store.dispatch('getProducts');
          closeModal();
        }
      })
      .catch(error => {
        loading.value = false;
        console.error('Error creating product:', error);
        // TODO: show error notification
      });
  }
};
  
      const deleteProduct = () => {
        if (product.value.id) {
          store.dispatch('deleteProduct', product.value.id)
            .then(response => {
              if (response.status === 200) {
                // TODO: show notification
                store.dispatch('getProducts');
                closeModal();
              }
            });
        }
      };
  
      return {
        loading,
        product,
        visible,
        closeModal,
        onSubmit,
        deleteProduct,
      };
    },
  };
  </script>
  
  <style scoped>
  /* Add your styles here */
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
  </style>