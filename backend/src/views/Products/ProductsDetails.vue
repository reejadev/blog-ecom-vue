<template>
  <div v-if="visible" class="modal-overlay" @click.self="close">
    <div class="modal-content">
      <button class="close-button" @click="close">X</button>

      <!-- <input type="file" multiple @change="uploadImages"> -->
      <input type="file" multiple @change="handleFileSelection">
    
    <!-- Save Button -->
    <button @click="uploadImages" :disabled="!selectedFiles.length">Save</button>

      <div class="image-gallery">
        <div v-for="image in images" :key="image.id" class="image-item">
          <img :src="getImageUrl(image.image_path)" width="150" height="150" alt="Product Image" />
                  <button @click="deleteImage(image.id)">Delete</button>
      </div>
    </div>
  </div>
</div>

</template>

<script>
import axios from 'axios'; // Import Axios
export default {
  data() {
    return {
      localImages: [], // Array to store images
      selectedFiles: [], // Array to store selected files before upload
      // productId: null, // Initialize productId
      // newProduct: {
      //   additionalImages: [] // Initialize this to store selected images
      // }
    }
    },
  //   mounted() {
  //   // Access productId from route parameters
  //   this.productId = this.$route.params.productId;
  //   this.fetchProductDetails();
  // },
  props: {
    
    images: {
      type: Array,
      required: true
    },
    visible: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    close() {
      this.$emit('close');
    },
    getImageUrl(path) {
      // Adjust this base URL to match your server's URL
      const baseUrl = 'http://127.0.0.1:8000/storage/';
      return `${baseUrl}${path}`;
    },

    handleFileSelection(event) {
      this.selectedFiles = Array.from(event.target.files);
    },

    async uploadImages(productId) {
      if (this.selectedFiles.length === 0) {
        alert('Please select images to upload.');
        return;
      }

      const formData = new FormData();
      this.selectedFiles.forEach(file => {
        formData.append('additionalImages[]', file);
      });

      try {
  const response = await axios.post(`http://127.0.0.1:8000/api/products/${this.productId}/additional-images`, formData);
  this.images = response.data;
  this.selectedFiles = [];
  alert('Images uploaded successfully.');
} catch (error) {
  console.error('Error uploading images:', error.response ? error.response.data : error.message);
  alert('Failed to upload images. Please try again.');
}
    },


// async uploadImages() {
//       try {
//         if (this.newProduct.additionalImages && this.newProduct.additionalImages.length > 0) {
//           const additionalImagesFormData = new FormData();
//           additionalImagesFormData.append('product_id', this.productId);

//           this.newProduct.additionalImages.forEach((image, index) => {
//             additionalImagesFormData.append(`additionalImages[${index}]`, image);
//           });

//           console.log(`Product ID: ${this.productId}`);
//           console.log(`URL: http://127.0.0.1:8000/api/products/${this.productId}/additional-images`);

//           await axios.post(`http://127.0.0.1:8000/api/products/${this.productId}/additional-images`, additionalImagesFormData, {
//             headers: {
//               'Content-Type': 'multipart/form-data'
//             }
//           });

//           this.showModal = false;
//           this.fetchProductDetails();
//         }
//       } catch (error) {
//         console.error('Error uploading additional images:', error.response ? error.response.data : error.message);
//         alert('Failed to upload images. Please try again.');
//       }
//     },
  
    async deleteImage(imageId) {
      if (confirm('Are you sure you want to delete this image?')) {
        try {
          await axios.delete(`http://127.0.0.1:8000/api/products/${this.productId}/delete-image/${imageId}`);
          this.images = this.images.filter(image => image.id !== imageId); // Remove deleted image from array
          alert('Image deleted successfully.');
        } catch (error) {
          console.error('Error deleting image:', error.response ? error.response.data : error.message);
          alert('Failed to delete image. Please try again.');
        }
      }
    }
  }
  
};
</script>

<style>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.8);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 5px;
  max-width: 90%;
  max-height: 90%;
  overflow-y: auto;
}

.image-gallery img {
  max-width: 100%;
  margin-bottom: 10px;
}

.close-button {
  background: transparent;
  border: none;
  font-size: 20px;
  cursor: pointer;
  position: absolute;
  top: 10px;
  right: 10px;
}

.image-item {
  margin: 10px;
  position: relative;
}

.image-item button {
  display: block;
  margin-top: 5px;
  background: red;
  color: white;
  border: none;
  cursor: pointer;
  padding: 5px;
}
</style>