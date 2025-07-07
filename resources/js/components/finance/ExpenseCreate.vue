<!-- resources/js/components/finance/ExpenseCreate.vue -->
<template>
  <div class="max-w-xl mx-auto bg-[#1A1D23] p-6 mt-10 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-[#3B82F6] mb-6">Add Expense</h2>

    <!-- Mensagem de sucesso -->
    <div
      v-if="successMessage"
      class="p-3 mb-4 text-white bg-green-700 rounded"
    >
      {{ successMessage }}
    </div>

    <!-- Erros gerais -->
    <FormError :errors="errors" />

    <form @submit.prevent="submitForm">
      <!-- Usuário -->
      <div class="mb-4">
        <label class="block mb-1 text-sm text-white">Usuário</label>
        <UserSelect v-model="form.user_id" :users="users" />
        <FormError field="user_id" :errors="errors" />
      </div>

      <!-- Categoria -->
      <div class="mb-4">
        <label class="block mb-1 text-sm text-white">Categoria</label>
        <select
          v-model="form.expense_category_id"
          required
          class="w-full p-2 rounded bg-[#0F1115] border border-gray-700 text-white"
        >
          <option :value="null" disabled>— Selecione —</option>
          <option
            v-for="cat in flatCategories"
            :key="cat.id"
            :value="cat.id"
          >
            {{ ' '.repeat(cat.level * 2) }}{{ cat.name }}
          </option>
        </select>
        <FormError field="expense_category_id" :errors="errors" />
      </div>

      <!-- Valor -->
      <div class="mb-4">
        <label class="block mb-1 text-sm text-white">Valor (R$)</label>
        <CurrencyInput v-model="form.value" />
        <FormError field="value" :errors="errors" />
      </div>

      <!-- Data -->
      <div class="mb-4">
        <label class="block mb-1 text-sm text-white">Data</label>
        <input
          v-model="form.date"
          type="date"
          required
          class="w-full p-2 rounded bg-[#0F1115] border border-gray-700 text-white"
        />
        <FormError field="date" :errors="errors" />
      </div>

      <!-- Descrição -->
      <div class="mb-4">
        <label class="block mb-1 text-sm text-white">
          Descrição (opcional)
        </label>
        <textarea
          v-model="form.description"
          class="w-full p-2 rounded bg-[#0F1115] border border-gray-700 text-white"
        ></textarea>
        <FormError field="description" :errors="errors" />
      </div>

      <button
        type="submit"
        class="w-full bg-[#3B82F6] hover:bg-blue-600 text-white font-bold py-2 px-4 rounded"
      >
        Save Expense
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

import UserSelect    from '@/components/shared/UserSelect.vue'
import CurrencyInput from '@/components/shared/CurrencyInput.vue'
import FormError     from '@/components/shared/FormError.vue'

const form = ref({
  user_id:             null,
  expense_category_id: null,
  value:               '',
  date:                '',
  description:         ''
})

const errors = ref({})
const successMessage = ref('')
const users = ref([])
const categories = ref([])

onMounted(async () => {
  try {
    const [u, c] = await Promise.all([
      axios.get('/api/v1/users'),
      axios.get('/api/v1/expense-categories'),
    ])
    users.value = u.data
    categories.value = c.data
  } catch (e) {
    console.error(e)
  }
})

const flatten = (cats, level = 0) =>
  cats.reduce((acc, cat) => {
    acc.push({ id: cat.id, name: cat.name, level })
    if (cat.children?.length) {
      acc.push(...flatten(cat.children, level + 1))
    }
    return acc
  }, [])

const flatCategories = computed(() => flatten(categories.value))

const submitForm = async () => {
  errors.value = {}
  successMessage.value = ''
  try {
    await axios.post('/api/v1/expenses', form.value)
    successMessage.value = 'Despesa salva com sucesso.'
    form.value = {
      user_id:             null,
      expense_category_id: null,
      value:               '',
      date:                '',
      description:         ''
    }
  } catch (err) {
    if (err.response?.status === 422) {
      errors.value = err.response.data.errors || {}
    } else {
      console.error(err)
    }
  }
}
</script>
