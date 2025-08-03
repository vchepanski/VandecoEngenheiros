<!-- ExpenseList.vue -->
<template>
<div class="p-6 space-y-6">
    <!-- Cabeçalho e Ações -->
    <div class="flex flex-col items-start justify-between sm:flex-row sm:items-center">
    <h2 class="text-2xl font-bold text-white">Despesas</h2>
    <div class="flex mt-4 space-x-2 sm:mt-0">
        <RouterLink
        to="/expenses/create"
        class="px-4 py-2 text-white bg-green-600 rounded shadow hover:bg-green-700"
        >
        + Nova Despesa
        </RouterLink>
        <RouterLink
        to="/expense-categories"
        class="px-4 py-2 bg-[#3B82F6] hover:bg-blue-600 text-white rounded shadow"
        >
        Categorias de Despesa
        </RouterLink>
    </div>
    </div>

    <!-- Resumo de Totais -->
    <div class="grid max-w-4xl grid-cols-1 gap-4 mx-auto sm:grid-cols-3">
    <!-- Total Geral ocupa toda a largura em sm, depois 1col -->
    <div class="sm:col-span-3 md:col-span-1 bg-[#0F1115] p-4 rounded-lg text-center">
        <h4 class="text-sm text-gray-400">Total Geral</h4>
        <p class="text-2xl font-bold text-red-500">R$ {{ totalGeral.toFixed(2) }}</p>
    </div>
    <!-- Totais individuais -->
    <div
        v-for="(total, user) in totalsByUser"
        :key="user"
        class="bg-[#0F1115] p-4 rounded-lg text-center"
    >
        <h4 class="text-sm text-gray-400">{{ user }}</h4>
        <p class="text-2xl font-bold text-red-500">R$ {{ total.toFixed(2) }}</p>
    </div>
    </div>

    <!-- Tabela de Despesas -->
    <div class="overflow-x-auto">
    <table class="w-full bg-[#1A1D23] text-[#E4E7EB] rounded-lg overflow-hidden">
        <thead class="bg-[#0F1115]">
        <tr>
            <th class="px-4 py-2 text-left">Data</th>
            <th class="px-4 py-2 text-left">Usuário</th>
            <th class="px-4 py-2 text-left">Categoria</th>
            <th class="px-4 py-2 text-left">Descrição</th>
            <th class="px-4 py-2 text-right">Valor (R$)</th>
            <th class="px-4 py-2 text-center">Ações</th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="expense in expenses"
            :key="expense.id"
            class="border-b border-gray-700 hover:bg-[#16181d] transition"
        >
            <td class="px-4 py-3">{{ expense.date }}</td>
            <td class="px-4 py-3">{{ expense.user.name }}</td>
            <td class="px-4 py-3">
            <div>{{ getCategoryName(expense.expense_category_id) }}</div>
            <div
                v-if="getCategoryParent(expense.expense_category_id)"
                class="mt-1 text-xs text-gray-400"
            >
                Pai: {{ getCategoryParent(expense.expense_category_id) }}
            </div>
            </td>
            <td class="max-w-xs px-4 py-3 truncate">
            {{ expense.description || '—' }}
            </td>
            <td class="px-4 py-3 font-semibold text-right text-red-500">
            R$ {{ Number(expense.value).toFixed(2) }}
            </td>
            <td class="px-4 py-3 space-x-2 text-center">
            <button
                @click="editExpense(expense.id)"
                class="px-3 py-1 text-xs transition bg-gray-600 rounded hover:bg-gray-700"
            >
                Editar
            </button>
            <button
                @click="deleteExpense(expense.id)"
                class="px-3 py-1 text-xs transition bg-red-600 rounded hover:bg-red-700"
            >
                Excluir
            </button>
            </td>
        </tr>
        </tbody>
    </table>
    </div>
</div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import { useRouter, RouterLink } from 'vue-router'

const expenses   = ref([])
const categories = ref([])
const router     = useRouter()

onMounted(async () => {
    const [eRes, cRes] = await Promise.all([
        axios.get('/api/v1/expenses'),
        axios.get('/api/v1/expense-categories')
    ])
    expenses.value   = eRes.data
    categories.value = cRes.data
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

const getCategoryName = id => {
    const cat = flatCategories.value.find(c => c.id === id)
    return cat ? cat.name : '— sem categoria —'
}

const getCategoryParent = id => {
    for (const root of categories.value) {
        if (root.children?.some(child => child.id === id)) {
        return root.name
        }
    }
    return null
}

const editExpense = (id) => {
    router.push({ name: 'expenses.edit', params: { id } })
}

const deleteExpense = async id => {
    if (!confirm('Deseja realmente excluir esta despesa?')) return
    await axios.delete(`/api/v1/expenses/${id}`)
    expenses.value = expenses.value.filter(e => e.id !== id)
}

const totalsByUser = computed(() => {
    return expenses.value.reduce((acc, expense) => {
        const name = expense.user?.name || '— sem usuário —'
        const v = parseFloat(expense.value) || 0
        acc[name] = (acc[name] || 0) + v
        return acc
    }, {})
})

const totalGeral = computed(() =>
    Object.values(totalsByUser.value).reduce((sum, v) => sum + v, 0)
)

</script>
