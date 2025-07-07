<!-- ExpenseCategoryList.vue -->
<template>
  <div class="max-w-3xl mx-auto bg-[#1A1D23] p-6 mt-10 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-[#3B82F6] mb-4">Expense Categories</h2>

    <!-- Botão para criar nova categoria de despesa -->
    <div class="flex justify-end mb-6">
      <RouterLink
        to="/expense-categories/create"
        class="px-3 py-1 bg-[#3B82F6] text-white rounded hover:bg-blue-600 transition"
      >
        Add Expense Category
      </RouterLink>
    </div>

    <ul>
      <li v-for="cat in categories" :key="cat.id" class="mb-4">
        <div class="flex items-center justify-between">
          <span class="text-lg text-white">{{ cat.name }}</span>
          <div class="space-x-2">
            <button @click="editCategory(cat)" class="px-2 py-1 bg-yellow-500 rounded">Editar</button>
            <button @click="deleteCategory(cat.id)" class="px-2 py-1 bg-red-500 rounded">Excluir</button>
          </div>
        </div>
        <ul v-if="cat.children && cat.children.length" class="mt-2 ml-6">
          <li
            v-for="child in cat.children"
            :key="child.id"
            class="flex items-center justify-between mb-2"
          >
            <span class="text-white">{{ child.name }}</span>
            <div class="space-x-2">
              <button @click="editCategory(child)" class="px-2 py-1 bg-yellow-500 rounded">Editar</button>
              <button @click="deleteCategory(child.id)" class="px-2 py-1 bg-red-500 rounded">Excluir</button>
            </div>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, RouterLink } from 'vue-router'
import axios from 'axios'

const router = useRouter()
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
  try {
    await axios.delete(`/api/v1/expense-categories/${id}`)
    loadCategories()
  } catch (error) {
    console.error(error)
  }
}

const editCategory = (cat) => {
  router.push({ name: 'expense-categories.edit', params: { id: cat.id } })
}

onMounted(loadCategories)
</script>
