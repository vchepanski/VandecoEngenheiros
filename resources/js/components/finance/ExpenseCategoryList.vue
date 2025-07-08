<!-- ExpenseCategoryList.vue -->
<template>
  <div class="max-w-3xl mx-auto bg-[#1A1D23] p-6 mt-10 rounded-xl shadow-md">
    <!-- Cabeçalho com título + botão -->
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-2xl font-bold text-[#3B82F6]">Expense Categories</h2>
      <RouterLink
        to="/expense-categories/create"
        class="px-3 py-1 bg-[#3B82F6] text-white rounded hover:bg-blue-600 transition"
      >
        Add Expense Category
      </RouterLink>
    </div>

    <!-- Card para cada categoria-pai -->
    <div v-for="cat in categories" :key="cat.id" class="mb-8">
      <div class="bg-[#0F1115] p-4 rounded-lg flex justify-between items-center">
        <span class="text-lg text-white font-semibold">{{ cat.name }}</span>
        <div class="space-x-2">
          <button @click="editCategory(cat)" class="px-2 py-1 bg-yellow-500 rounded hover:bg-yellow-600">
            Editar
          </button>
          <button @click="deleteCategory(cat.id)" class="px-2 py-1 bg-red-500 rounded hover:bg-red-600">
            Excluir
          </button>
        </div>
      </div>

      <!-- Subcategorias em grid -->
      <div v-if="cat.children?.length" class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div
          v-for="child in cat.children"
          :key="child.id"
          class="bg-[#16181d] p-3 rounded-lg flex justify-between items-center"
        >
          <div>
            <span class="text-white font-medium">{{ child.name }}</span>
            <p class="text-xs text-gray-400 mt-1">Pai: {{ cat.name }}</p>
          </div>
          <div class="flex space-x-2">
            <button @click="editCategory(child)" class="px-2 py-1 bg-yellow-500 rounded hover:bg-yellow-600 text-xs">
              Editar
            </button>
            <button @click="deleteCategory(child.id)" class="px-2 py-1 bg-red-500 rounded hover:bg-red-600 text-xs">
              Excluir
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, RouterLink } from 'vue-router'
import axios from 'axios'

const router     = useRouter()
const categories = ref([])

const loadCategories = async () => {
  try {
    const { data } = await axios.get('/api/v1/expense-categories')
    categories.value = data
  } catch (error) {
    console.error(error)
  }
}

const deleteCategory = async (id) => {
  if (!confirm('Deseja realmente excluir?')) return
  await axios.delete(`/api/v1/expense-categories/${id}`)
  loadCategories()
}

const editCategory = (cat) => {
  router.push({ name: 'expense-categories.edit', params: { id: cat.id } })
}

onMounted(loadCategories)
</script>
