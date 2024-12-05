<template>
  <div :class="['bg-gray-800 text-white w-64 space-y-6 py-7 px-2 absolute inset-y-0 left-0 transform lg:relative lg:translate-x-0 transition duration-200 ease-in-out', sidebarClass]">
    <nav>
      <ul>
        <li class="mb-4">
          <router-link to="/app/dashboard" class="flex items-center space-x-2 text-white hover:text-gray-300">
            <span>Dashboard</span>
          </router-link>
        </li>
        <li class="mb-4">
          <router-link to="/app/products" class="flex items-center space-x-2 text-white hover:text-gray-300">
            <span>Products</span>
          </router-link>
        </li>
        <li class="mb-4">
          <router-link to="/app/users" class="flex items-center space-x-2 text-white hover:text-gray-300">
            <span>Users</span>
          </router-link>
        </li>
        <li class="mb-4">
          <router-link to="/app/settings" class="flex items-center space-x-2 text-white hover:text-gray-300">
            <span>Settings</span>
          </router-link>
        </li>
      </ul>
    </nav>
  
  </div>
</template>

<script>
export default {
  name: 'Sidebar',
  props: {
    sidebarClass: {
      type: String,
      default: ''
    }
  }
};
</script>

<style scoped>
/* Add any additional styles here */
</style>