<template>
  <header class="navbar">
    <button @click="toggleSidebar" class="text-gray-500 focus:outline-none ">    
      <img :src="profilePhotoUrl" alt="Profile Photo" class="profile-photo">
    </button>
    <div class="dropdown">
        <button class="text-blue-500 focus:outline-none dropdown-button">
          Admin
          <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div class="dropdown-menu hidden">
            <a href="#" class="dropdown-item">Settings</a>
            <a href="#" class="dropdown-item">Help</a>
            <router-link to="/logout" class="dropdown-item">Logout</router-link>
        </div>
    </div>

  </header>
</template>

<script>
import profilePhoto from '@/assets/images/IMG_4351.jpg'; // Adjust the path if necessary
export default {
  name: 'Navbar',
  data() {
    return {
      profilePhotoUrl: profilePhoto
    };
  },
  methods: {
    toggleSidebar() {
      this.$emit('toggle-sidebar');
    }
  }
};
</script>

<style scoped>
.navbar {
  display: flex;
  justify-content: flex-end; /* Align content to the right */
  align-items: center;
  width: 100%;
  max-width: 100%;
  padding: 1rem 2rem;
  background-color: white;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-button {
    display: flex;
    align-items: center;
    cursor: pointer;
    background: none;
    border: none;
    padding: 0;
}
.dropdown-menu {
    display: none;
    position: absolute;
    background-color: white;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    right: 0;
}

.dropdown-item {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-item:hover {
    background-color: #f1f1f1;
}

.dropdown:hover .dropdown-menu {
    display: block;
}

.flex {
  display: flex;
  align-items: center;
}

.space-x-4 > * + * {
  margin-left: 1rem;
}

.profile-photo {
    height: 40px; /* Adjusted for better visibility */
    width: 40px;  /* Adjusted for better visibility */
    border-radius: 50%; /* Optional: Makes the image circular */
    margin-right: 10px; 
}

.profile-photo-small {
    height: 20px; /* Smaller size for the button */
    width: 20px;  /* Smaller size for the button */
    border-radius: 50%; /* Makes the image circular */
    margin-right: 8px; /* Space between image and text */
}


</style>