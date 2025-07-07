<template>
  <div class="max-w-4xl mx-auto bg-[#1A1D23] p-6 mt-10 rounded-xl shadow-md">
    <!-- Botão para categorias de Income -->
    <div class="flex justify-end mb-6 space-x-2">
        <RouterLink
            to="/incomes/create"
            class="px-3 py-1 text-white transition bg-green-600 rounded hover:bg-green-700"
        >
            Add Income
        </RouterLink>
        <RouterLink
            to="/income-categories"
            class="px-3 py-1 bg-[#3B82F6] text-white rounded hover:bg-blue-600 transition"
        >
            Income Categories
        </RouterLink>
    </div>

    <h2 class="text-2xl font-bold text-[#3B82F6] mb-6">Income List</h2>

    <table class="w-full text-left text-white border-collapse">
      <thead>
        <tr class="bg-[#0F1115] text-[#A0A4AC] border-b border-gray-700">
          <th class="px-4 py-2">User</th>
          <th class="px-4 py-2">Category</th>
          <th class="px-4 py-2">Value</th>
          <th class="px-4 py-2">Date</th>
          <th class="px-4 py-2">Description</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="income in incomes"
          :key="income.id"
          class="border-b border-gray-700 hover:bg-[#181b22]"
        >
          <td class="px-4 py-2">{{ income.user?.name }}</td>
          <td class="px-4 py-2">
            <span>{{ income.income_category?.name || '-' }}</span>
          </td>
          <td class="px-4 py-2">
            R$ {{ parseFloat(income.value).toLocaleString('pt-BR', { minimumFractionDigits: 2 }) }}
          </td>
          <td class="px-4 py-2">{{ income.date }}</td>
          <td class="px-4 py-2">{{ income.description }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { RouterLink } from 'vue-router'

const incomes = ref([])

onMounted(async () => {
  const response = await axios.get('/api/v1/incomes')
  incomes.value = response.data
})
</script>
