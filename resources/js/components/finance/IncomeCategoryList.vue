<template>
  <div class="max-w-xl mx-auto bg-[#1A1D23] p-6 mt-10 rounded-xl shadow-md">
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-2xl font-bold text-[#3B82F6]">Income Categories</h2>
      <!-- Botão para criar nova categoria de Income -->
      <RouterLink
        to="/income-categories/create"
        class="px-3 py-1 bg-[#3B82F6] text-white rounded hover:bg-blue-600 transition"
      >
        Add Income Category
      </RouterLink>
    </div>

    <div v-if="categories.length === 0" class="text-center text-gray-400">
      No categories found.
    </div>

    <ul v-else class="space-y-2">
      <li
        v-for="category in categories"
        :key="category.id"
        class="flex items-center justify-between bg-[#0F1115] px-4 py-2 rounded border border-gray-700"
      >
        <div class="flex items-center space-x-3">
          <input
            v-if="editingId === category.id"
            v-model="editName"
            class="bg-[#1A1D23] border border-blue-500 text-white p-1 rounded"
          />
          <span v-else class="text-white">{{ category.name }}</span>

          <span
            v-if="category.color"
            :style="{ backgroundColor: category.color }"
            class="w-4 h-4 rounded-full"
          ></span>
        </div>

        <div class="flex items-center space-x-2">
          <button
            v-if="editingId === category.id"
            @click="updateCategory(category)"
            class="text-sm text-green-400"
          >
            Save
          </button>
          <button
            v-else
            @click="startEditing(category)"
            class="text-sm text-blue-400"
          >
            Edit
          </button>
          <button
            @click="deleteCategory(category)"
            class="text-sm text-red-400"
          >
            Delete
          </button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import axios from 'axios'

const categories = ref([])
const editingId = ref(null)
const editName = ref('')

const fetchCategories = async () => {
  try {
    const response = await axios.get('/api/v1/income-categories')
    categories.value = response.data
  } catch (error) {
    console.error(error)
  }
}

onMounted(fetchCategories)

const startEditing = (category) => {
  editingId.value = category.id
  editName.value = category.name
}

const updateCategory = async (category) => {
  try {
    await axios.put(`/api/v1/income-categories/${category.id}`, {
      name: editName.value,
      color: category.color,
    })
    editingId.value = null
    editName.value = ''
    fetchCategories()
  } catch (error) {
    console.error(error)
  }
}

const deleteCategory = async (category) => {
  if (!confirm('Are you sure you want to delete this category?')) return
  try {
    await axios.delete(`/api/v1/income-categories/${category.id}`)
    fetchCategories()
  } catch (error) {
    console.error(error)
  }
}
</script>
