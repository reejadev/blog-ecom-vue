<template>
  <div class="min-h-full bg-gray-200 flex w-full h-screen">
    <Sidebar :class="{'-ml-[200px]': !sidebarOpened}" class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2 absolute inset-y-0 left-0 transform lg:relative lg:translate-x-0 transition duration-200 ease-in-out" />
    <div class="flex-1 flex flex-col">
      <Navbar @toggle-sidebar="toggleSidebar"></Navbar>
      <main class="p-6 flex-1 w-full">
        <router-view></router-view>
      </main>
    </div>
  </div>
</template>

<script>
import Sidebar from './Sidebar.vue';
import Navbar from './Navbar.vue';

export default {
  components: {
    Sidebar,
    Navbar
  },
  data() {
    return {
      sidebarOpened: true
    };
  },
  methods: {
    toggleSidebar() {
      this.sidebarOpened = !this.sidebarOpened;
    }
  }
};
</script>

<style scoped>
.min-h-full {
  min-height: 100vh;
  min-width: 100vh;
}
</style>