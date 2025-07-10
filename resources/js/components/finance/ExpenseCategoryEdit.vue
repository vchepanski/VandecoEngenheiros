<!-- resources/js/components/finance/ExpenseCategoryEdit.vue -->
<template>
    <div class="max-w-xl mx-auto bg-[#1A1D23] p-6 mt-10 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold text-[#3B82F6] mb-6">Editar Categoria de Despesa</h2>

        <div v-if="successMessage" class="p-3 mb-4 text-white bg-green-700 rounded">
        {{ successMessage }}
        </div>
        <FormError :errors="errors" />

        <form @submit.prevent="submitForm">
        <div class="mb-4">
            <label class="block mb-1 text-sm text-white">Nome</label>
            <input
            v-model="form.name"
            type="text"
            required
            class="w-full p-2 rounded bg-[#0F1115] border border-gray-700 text-white"
            />
            <FormError field="name" :errors="errors" />
        </div>

        <div class="mb-4">
            <label class="block mb-1 text-sm text-white">Descrição (opcional)</label>
            <textarea
            v-model="form.description"
            class="w-full p-2 rounded bg-[#0F1115] border border-gray-700 text-white"
            ></textarea>
            <FormError field="description" :errors="errors" />
        </div>

        <div class="mb-4">
            <label class="block mb-1 text-sm text-white">Categoria Pai (opcional)</label>
            <select
            v-model="form.parent_id"
            class="w-full p-2 rounded bg-[#0F1115] border border-gray-700 text-white"
            >
            <option :value="null">— Sem Pai —</option>
            <option
                v-for="cat in flatCategories"
                :key="cat.id"
                :value="cat.id"
                :disabled="cat.id === categoryId"
            >
                {{ ' '.repeat(cat.level*2) }}{{ cat.name }}
            </option>
            </select>
            <FormError field="parent_id" :errors="errors" />
        </div>

        <div class="flex space-x-2">
            <button
            type="submit"
            class="flex-1 bg-[#3B82F6] hover:bg-blue-600 text-white font-bold py-2 rounded"
            >
            Atualizar
            </button>
            <RouterLink
            to="/expense-categories"
            class="flex-1 py-2 font-bold text-center text-white bg-gray-600 rounded hover:bg-gray-700"
            >
            Cancelar
            </RouterLink>
        </div>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import { useRoute, useRouter, RouterLink } from 'vue-router'
import FormError from '@/components/shared/FormError.vue'

const route = useRoute()
const router = useRouter()
const categoryId = route.params.id

const form = ref({
    name: '',
    description: '',
    parent_id: null
    })
const errors = ref({})
const successMessage = ref('')
const categories = ref([])

onMounted(async () => {
    try {
        const [cRes, eRes] = await Promise.all([
        axios.get('/api/v1/expense-categories'),
        axios.get(`/api/v1/expense-categories/${categoryId}`)
        ])
        categories.value = cRes.data

        const cat = eRes.data
        form.value.name = cat.name
        form.value.description = cat.description
        form.value.parent_id = cat.parent_id
    } catch (err) {
        console.error(err)
    }
})

const flatten = (cats, level = 0) =>
    cats.reduce((acc, c) => {
        acc.push({ id: c.id, name: c.name, level })
        if (c.children?.length) acc.push(...flatten(c.children, level + 1))
        return acc
    }, [])
    const flatCategories = computed(() => flatten(categories.value))

// submissão
const submitForm = async () => {
    errors.value = {}
    successMessage.value = ''
    try {
        await axios.put(`/api/v1/expense-categories/${categoryId}`, form.value)
        successMessage.value = 'Categoria atualizada com sucesso.'
        setTimeout(() => router.push('/expense-categories'), 800)
    } catch (err) {
        if (err.response?.status === 422) {
        errors.value = err.response.data.errors || {}
        } else {
        console.error(err)
        }
    }
}
</script>
