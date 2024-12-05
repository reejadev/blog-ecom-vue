<template>
 <div class="flex px-6 py-12 lg:px-8 bg-white" >
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">    
      <h2
        class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">
       {{ title }}
      </h2>
    </div>
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">       
      <slot></slot>   
    </div>
  </div>
</template>


<script setup>
const {title} = defineProps({
title: String
})



</script>

<style scoped>

</style>