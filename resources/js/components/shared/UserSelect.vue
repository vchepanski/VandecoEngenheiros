<template>
  <div>
    <label v-if="label" class="block mb-1 text-sm text-white">{{ label }}</label>
    <select
      v-model="internalValue"
      @change="$emit('update:modelValue', internalValue)"
      class="w-full p-2 rounded bg-[#0F1115] border border-gray-700 text-white"
    >
      <option disabled value="">Select a user</option>
      <option v-for="user in users" :key="user.id" :value="user.id">
        {{ user.name }}
      </option>
    </select>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'

const props = defineProps({
  modelValue: [String, Number],
  label: { type: String, default: 'User' }
})
const emit = defineEmits(['update:modelValue'])

const users = ref([])
const internalValue = ref(props.modelValue)

onMounted(async () => {
  const response = await axios.get('/api/v1/users')
  users.value = response.data
})

watch(() => props.modelValue, (newVal) => {
  internalValue.value = newVal
})
</script>
