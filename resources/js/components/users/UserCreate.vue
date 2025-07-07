<template>
  <div class="max-w-xl mx-auto bg-[#1A1D23] p-6 mt-10 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-[#3B82F6] mb-6">Create New User</h2>

    <!-- Success message -->
    <div v-if="successMessage" class="p-3 mb-4 text-white bg-green-700 rounded">
      {{ successMessage }}
    </div>

    <!-- Error messages -->
    <div v-if="Object.keys(errors).length" class="p-3 mb-4 text-white bg-red-700 rounded">
      <ul>
        <li v-for="(message, field) in errors" :key="field">{{ message[0] }}</li>
      </ul>
    </div>

    <form @submit.prevent="submitForm">
      <!-- Name -->
      <div class="mb-4">
        <label class="block mb-1 text-sm">Name</label>
        <input v-model="form.name" type="text" class="w-full p-2 rounded bg-[#0F1115] border border-gray-700 text-white" />
      </div>

      <!-- Email -->
      <div class="mb-4">
        <label class="block mb-1 text-sm">Email</label>
        <input v-model="form.email" type="email" class="w-full p-2 rounded bg-[#0F1115] border border-gray-700 text-white" />
      </div>

      <!-- Password -->
      <div class="mb-6">
        <label class="block mb-1 text-sm">Password</label>
        <input v-model="form.password" type="password" class="w-full p-2 rounded bg-[#0F1115] border border-gray-700 text-white" />
      </div>

      <button type="submit" class="w-full bg-[#3B82F6] hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
        Create User
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

// ⏺️ Variáveis reativas
const form = ref({
  name: '',
  email: '',
  password: ''
})

const errors = ref({})
const successMessage = ref('')

// 🔁 Função que envia o formulário
const submitForm = async () => {
  errors.value = {}
  successMessage.value = ''

  try {
    const response = await axios.post('/api/v1/users', form.value)

    successMessage.value = response.data.message
    form.value = { name: '', email: '', password: '' }

  } catch (error) {
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors
    } else {
      console.error(error)
    }
  }
}
</script>
