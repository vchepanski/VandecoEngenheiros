<!-- resources/js/components/Dashboard.vue -->
<template>
    <div class="p-6 space-y-6">
    <h1 class="text-3xl font-bold text-white">Painel Financeiro</h1>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="p-4 text-center text-white bg-green-600 rounded-lg shadow">
            <div class="text-sm">Total Receitas</div>
            <div class="text-2xl font-bold">R$ {{ totalReceitas.toFixed(2) }}</div>
        </div>
        <div class="p-4 text-center text-white bg-red-600 rounded-lg shadow">
            <div class="text-sm">Total Despesas</div>
            <div class="text-2xl font-bold">R$ {{ totalDespesas.toFixed(2) }}</div>
        </div>
        <div :class="balance >= 0 ? 'bg-blue-600' : 'bg-[#881111]'"
            class="p-4 text-center text-white rounded-lg shadow">
            <div class="text-sm">Saldo Geral</div>
            <div class="text-2xl font-bold">R$ {{ balance.toFixed(2) }}</div>
        </div>
        <!-- quem tem maior saldo -->
        <div class="bg-[#444] p-4 rounded-lg text-center text-white shadow">
            <div class="text-sm">Melhor Usuário</div>
            <div class="text-xl font-bold">{{ bestUser }}</div>
        </div>
        </div>

        <!-- Detalhe por usuário -->
        <h2 class="text-2xl font-semibold text-white">Por Usuário</h2>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div
            v-for="(rec, user) in totalsByUser.receitas"
            :key="user"
            class="bg-[#0F1115] p-4 rounded-lg shadow"
        >
            <div class="mb-1 font-semibold text-white">{{ user }}</div>
            <div class="flex justify-between text-sm text-gray-300">
            <span>Receitas:</span>
            <span>R$ {{ rec.toFixed(2) }}</span>
            </div>
            <div class="flex justify-between text-sm text-gray-300">
            <span>Despesas:</span>
            <span>R$ {{ (totalsByUser.despesas[user]||0).toFixed(2) }}</span>
            </div>
            <div class="flex justify-between mt-2 font-bold"
                :class="{
                'text-green-400': (rec - (totalsByUser.despesas[user]||0)) >= 0,
                'text-red-400':   (rec - (totalsByUser.despesas[user]||0)) < 0
                }"
            >
            <span>Saldo:</span>
            <span>R$ {{ (rec - (totalsByUser.despesas[user]||0)).toFixed(2) }}</span>
            </div>
        </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

const receitas = ref([])
const despesas = ref([])

onMounted(async () => {
    const [r, d] = await Promise.all([
        axios.get('/api/v1/incomes'),
        axios.get('/api/v1/expenses'),
    ])
    receitas.value = r.data
    despesas.value = d.data
})

// soma total geral
const totalReceitas = computed(() =>
    receitas.value.reduce((sum, inc) => sum + parseFloat(inc.value || 0), 0)
)
const totalDespesas = computed(() =>
    despesas.value.reduce((sum, exp) => sum + parseFloat(exp.value || 0), 0)
)
const balance = computed(() => totalReceitas.value - totalDespesas.value)

const totalsByUser = computed(() => {
    const rec = receitas.value.reduce((acc, inc) => {
        const u = inc.user?.name || '— sem usuário —'
        acc[u] = (acc[u]||0) + parseFloat(inc.value||0)
        return acc
    }, {})
    const des = despesas.value.reduce((acc, exp) => {
        const u = exp.user?.name || '— sem usuário —'
        acc[u] = (acc[u]||0) + parseFloat(exp.value||0)
        return acc
    }, {})
    return { receitas: rec, despesas: des }
})

const bestUser = computed(() => {
    let best = null, bestVal = -Infinity
    for (const u in totalsByUser.value.receitas) {
        const val = totalsByUser.value.receitas[u] - (totalsByUser.value.despesas[u]||0)
        if (val > bestVal) {
        bestVal = val
        best = u
        }
    }
    return best || '—'
    })
</script>
