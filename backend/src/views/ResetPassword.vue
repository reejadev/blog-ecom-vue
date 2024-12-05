<script setup lang="ts">
import GuestLayout from '@/components/GuestLayout.vue';
</script>


<template>

  
  
     <GuestLayout title="Set new Password">
  
      <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm bg-white">
        <form class="space-y-6" action="#" method="POST">
          <div>
          
            <div class="mt-2">
              <input
                id="pw"
                name="pw"
                type="text"
                autocomplete="pw"
                required
                  placeholder="New Password"
                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-black-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6"
                style="color: black"
              />
            </div>
            <div class="mt-2">
              <input
                id="repeat pw"
                name="repeat pw"
                type="text"
                autocomplete="repeat pw"
                required
                  placeholder="Repeat Password"
                class="block w-full rounded-md border-0 py-1.5 text-gray-900
                 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-black-400
                  focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6"
                style="color: black"
              />
            </div>
          </div>
            <button
              type="submit"
              class="flex w-full justify-center rounded-md bg-indigo-600
               px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm 
               hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2
                focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
            Submit
            </button>
          
        </form>
        <div class="text-sm">
       
          <router-link to="/login" class="font-semibold text-indigo-600 
          hover:text-indigo-500">
           
         Go back to Login
          </router-link>
       
      </div>
      </div>
    </GuestLayout>
   
    
  </template>
  
  <style scoped></style>
  