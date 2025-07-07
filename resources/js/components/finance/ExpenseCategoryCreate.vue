<template>
  <div class="max-w-xl mx-auto bg-[#1A1D23] p-6 mt-10 rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-[#3B82F6] mb-6">Add Expense Category</h2>

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
          required
        />
      </div>

      <div class="mb-4">
        <label class="block mb-1 text-sm text-white">Descrição (opcional)</label>
        <textarea
          v-model="form.description"
          class="w-full p-2 rounded bg-[#0F1115] border border-gray-700 text-white"
        ></textarea>
      </div>

      <div class="mb-4">
        <label class="block mb-1 text-sm text-white">Categoria Pai (opcional)</label>
        <select
          v-model="form.parent_id"
          class="w-full p-2 rounded bg-[#0F1115] border border-gray-700 text-white"
        >
          <option :value="null">— Raiz —</option>
            <option v-for="cat in flatCategories" :key="cat.id" :value="cat.id">
                {{ ' '.repeat(cat.level * 2) }}{{ cat.name }}
            </option>
        </select>
    </div>
    <div class="mb-4">
        <label class="inline-flex items-center text-white">
            <input type="checkbox" v-model="form.recurring" class="form-checkbox" />
            <span class="ml-2 text-sm">Recorrente todo mês</span>
        </label>
    </div>

      <button
        type="submit"
        class="w-full bg-[#3B82F6] hover:bg-blue-600 text-white font-bold py-2 px-4 rounded"
      >
        Save Expense Category
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

const form = ref({ name: '', description: '', parent_id: null })
const successMessage = ref('')
const categories = ref([])

const loadCategories = async () => {
  try {
    const { data } = await axios.get('/api/v1/expense-categories')
    categories.value = data
  } catch (error) {
    console.error(error)
  }
}

const flatten = (cats, level = 0) =>
  cats.reduce((acc, cat) => {
    acc.push({ id: cat.id, name: cat.name, level })
    if (cat.children && cat.children.length) {
      acc.push(...flatten(cat.children, level + 1))
    }
    return acc
  }, [])

const flatCategories = computed(() => flatten(categories.value))

const submitForm = async () => {
  successMessage.value = ''
  try {
    await axios.post('/api/v1/expense-categories', form.value)
    successMessage.value = 'Categoria salva com sucesso.'
    form.value = { name: '', description: '', parent_id: null }
    loadCategories()
  } catch (error) {
    console.error(error)
  }
}

onMounted(loadCategories)
</script>
