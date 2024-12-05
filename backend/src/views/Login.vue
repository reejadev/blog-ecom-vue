<template>
  <GuestLayout title="Sign into your account">
    <div class="min-h-full flex w-full h-screen">
      <form class="space-y-6" method="POST" @submit.prevent="login">
        <div v-if="errorMsg" class="flex items-center justify-between bg-red-500 text-white rounded">
          {{ errorMsg }}
          <span @click="errorMsg = ''" class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-red-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </span>
        </div>
        <div>
          <label for="email" class="text-sm font-medium text-gray-900">Email address</label>
          <div class="mt-2">
            <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm" style="color: black"/>
          </div>
        </div>
        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
          </div>
          <div class="mt-2">
            <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm"/>
          </div>
        </div>

        <div class="text-sm mt-2 mb-2">          
          <router-link to="/request-password" class="font-semibold text-indigo-600 hover:text-indigo-500">           
            Forgot password?
          </router-link>
        </div>



        <div>
          <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Sign in
          </button>
        </div>
      </form>
    </div>
  </GuestLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
import GuestLayout from '@/components/GuestLayout.vue';

const loading = ref(false);
const user = ref({ email: '', password: '' });
const loadConfigFromFile = ref(false);
const errorMsg = ref('');

const router = useRouter();
const store = useStore();

async function login() {
  loading.value = true;
  try {
    console.log('Dispatching login with user:', user.value);
    await store.dispatch('login', user.value);
    console.log('Login successful');
    loadConfigFromFile.value = false;
    router.push({ name: 'app.dashboard' });
  } catch (error) {
    console.error('Login failed', error);
    loadConfigFromFile.value = false;
    if (error.response && error.response.data) {
      errorMsg.value = error.response.data.message;
    } else {
      errorMsg.value = 'An unexpected error occurred';
    }
  } finally {
    loading.value = false;
  }
}
</script>

<style scoped></style>