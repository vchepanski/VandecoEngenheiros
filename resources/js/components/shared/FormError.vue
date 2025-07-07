<template>
  <div v-if="error" class="mt-1 text-sm text-red-500">
    {{ error }}
  </div>
</template>

<script setup>
defineProps({
  error: String
})
</script>
