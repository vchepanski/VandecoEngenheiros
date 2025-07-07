<template>
  <div class="max-w-xl mx-auto bg-[#1A1D23] p-6 mt-10 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-[#3B82F6] mb-6">Add Income</h2>

    <!-- Mensagem de sucesso -->
    <div v-if="successMessage" class="p-3 mb-4 text-white bg-green-700 rounded">
      {{ successMessage }}
    </div>

    <form @submit.prevent="submitForm">
      <!-- Select de usuário -->
      <div class="mb-4">
        <UserSelect v-model="form.user_id" :label="'User'" />
        <FormError :error="errors.user_id?.[0]" />
      </div>

      <!-- Select de categoria -->
      <div class="mb-4">
        <label class="block mb-1 text-sm text-white">Category</label>
        <select v-model="form.income_category_id" class="w-full p-2 rounded bg-[#0F1115] border border-gray-700 text-white">
          <option disabled value="">Select a category</option>
          <option v-for="cat in categories" :key="cat.id" :value="cat.id">
            {{ cat.name }}
          </option>
        </select>
        <FormError :error="errors.income_category_id?.[0]" />
      </div>

      <!-- Valor -->
      <div class="mb-4">
        <label class="block mb-1 text-sm text-white">Value (R$)</label>
        <CurrencyInput v-model="form.value" :error="!!errors.value" />
        <FormError :error="errors.value?.[0]" />
      </div>

      <!-- Descrição -->
      <div class="mb-4">
        <label class="block mb-1 text-sm text-white">Description</label>
        <input
          v-model="form.description"
          type="text"
          class="w-full p-2 rounded bg-[#0F1115] border border-gray-700 text-white"
        />
        <FormError :error="errors.description?.[0]" />
      </div>

      <!-- Data -->
      <div class="mb-6">
        <label class="block mb-1 text-sm text-white">Date</label>
        <input
          v-model="form.date"
          type="date"
          class="w-full p-2 rounded bg-[#0F1115] border border-gray-700 text-white"
        />
        <FormError :error="errors.date?.[0]" />
      </div>

      <button
        type="submit"
        class="w-full bg-[#3B82F6] hover:bg-blue-600 text-white font-bold py-2 px-4 rounded"
      >
        Save Income
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

// Shared components
import CurrencyInput from '../shared/CurrencyInput.vue'
import UserSelect from '../shared/UserSelect.vue'
import FormError from '../shared/FormError.vue'

// Form state
const form = ref({
  user_id: '',
  income_category_id: '',
  value: '',
  description: '',
  date: ''
})

const users = ref([])
const categories = ref([])
const errors = ref({})
const successMessage = ref('')

// Carrega usuários e categorias
onMounted(async () => {
  const [usersRes, catRes] = await Promise.all([
    axios.get('/api/v1/users'),
    axios.get('/api/v1/income-categories')
  ])
  users.value = usersRes.data
  categories.value = catRes.data
})

// Envia o formulário
const submitForm = async () => {
  errors.value = {}
  successMessage.value = ''

  try {
    const response = await axios.post('/api/v1/incomes', form.value)
    successMessage.value = response.data.message

    // Limpa formulário
    form.value = {
      user_id: '',
      income_category_id: '',
      value: '',
      description: '',
      date: ''
    }
  } catch (error) {
    if (error.response?.status === 422) {
      errors.value = error.response.data.errors
    } else {
      console.error(error)
    }
  }
}
</script>
