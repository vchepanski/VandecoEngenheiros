<template>
  <div class="max-w-xl mx-auto bg-[#1A1D23] p-6 mt-10 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-[#3B82F6] mb-6">Add Income Category</h2>

    <div v-if="successMessage" class="p-3 mb-4 text-white bg-green-700 rounded">
      {{ successMessage }}
    </div>

    <form @submit.prevent="submitForm">
      <div class="mb-4">
        <label class="block mb-1 text-sm text-white">Category Name</label>
        <input
          v-model="form.name"
          type="text"
          class="w-full p-2 rounded bg-[#0F1115] border border-gray-700 text-white"
        />
      </div>

      <div class="mb-4">
        <label class="block mb-1 text-sm text-white">Color (optional)</label>
        <input
          v-model="form.color"
          type="text"
          placeholder="#3B82F6"
          class="w-full p-2 rounded bg-[#0F1115] border border-gray-700 text-white"
        />
      </div>

      <button
        type="submit"
        class="w-full bg-[#3B82F6] hover:bg-blue-600 text-white font-bold py-2 px-4 rounded"
      >
        Save Category
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const form = ref({
  name: '',
  color: ''
})

const successMessage = ref('')

const submitForm = async () => {
  successMessage.value = ''

  try {
    const response = await axios.post('/api/v1/income-categories', form.value)
    successMessage.value = response.data.message
    form.value = { name: '', color: '' }
  } catch (error) {
    console.error(error)
  }
}
</script>
