<template>
  <th @click="handleClick" class="cursor-pointer px-4 py-2 text-left">
    <div class="flex items-center">
      <!-- Sorting Icon for Actions column -->
      <span v-if="field === 'actions' && isSorted" class="mr-2">
        <svg v-if="sortDirection === 'asc'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
        </svg>
        <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
      </span>
      <!-- Slot Content -->
      <slot></slot>
    </div>
  </th>
</template>

<script>
export default {
  props: {
    field: String,
    sortField: String,
    sortDirection: String,
  },
  computed: {
    isSorted() {
      return this.sortField === this.field;
    },
  },
  methods: {
    handleClick() {
      this.$emit('click', this.field);
    },
  },
};
</script>

<style scoped>
/* Add any required styles here */
</style>