<!-- resources/js/components/Dashboard.vue -->
<template>
    <div class="p-6 space-y-6">
        <h1 class="text-3xl font-bold text-white">Painel Financeiro</h1>

        <!-- Resumo geral -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Receitas -->
        <div class="p-4 text-center text-white bg-green-600 rounded-lg shadow">
            <div class="text-sm">Total Receitas</div>
            <div class="text-2xl font-bold">
            <template v-if="isLoading">
                <div class="w-24 h-8 mx-auto bg-green-400 rounded animate-pulse"></div>
            </template>
            <template v-else>
                <span ref="receitasRef"></span>
            </template>
            </div>
        </div>

        <!-- Total Despesas -->
        <div class="p-4 text-center text-white bg-red-600 rounded-lg shadow">
            <div class="text-sm">Total Despesas</div>
            <div class="text-2xl font-bold">
            <template v-if="isLoading">
                <div class="w-24 h-8 mx-auto bg-red-400 rounded animate-pulse"></div>
            </template>
            <template v-else>
                <span ref="despesasRef"></span>
            </template>
            </div>
        </div>

        <!-- Saldo Geral -->
        <div
            :class="balance >= 0 ? 'bg-blue-600' : 'bg-[#881111]'"
            class="p-4 text-center text-white rounded-lg shadow"
        >
            <div class="text-sm">Saldo Geral</div>
            <div class="text-2xl font-bold">
            <template v-if="isLoading">
                <div class="w-24 h-8 mx-auto bg-blue-400 rounded animate-pulse"></div>
            </template>
            <template v-else>
                <span ref="balanceRef"></span>
            </template>
            </div>
        </div>

        <!-- Melhor Usuário -->
        <div class="bg-[#444] p-4 rounded-lg text-center text-white shadow">
            <div class="text-sm">Melhor Usuário</div>
            <div class="text-xl font-bold">
            <template v-if="isLoading">
                <div class="w-32 h-6 mx-auto bg-gray-600 rounded animate-pulse"></div>
            </template>
            <template v-else>
                {{ bestUser }}
            </template>
            </div>
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
            <span>R$ {{ (totalsByUser.despesas[user] || 0).toFixed(2) }}</span>
            </div>
            <div
            class="flex justify-between mt-2 font-bold"
            :class="{
                'text-green-400': (rec - (totalsByUser.despesas[user] || 0)) >= 0,
                'text-red-400': (rec - (totalsByUser.despesas[user] || 0)) < 0
            }"
            >
            <span>Saldo:</span>
            <span>R$ {{ (rec - (totalsByUser.despesas[user] || 0)).toFixed(2) }}</span>
            </div>
        </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed, nextTick } from 'vue'
import axios from 'axios'
import { CountUp } from 'countup.js'

// --- Estado e referências ---
const receitas = ref([])
const despesas = ref([])
const isLoading = ref(true)
const receitasRef = ref(null)
const despesasRef = ref(null)
const balanceRef  = ref(null)

// --- Computeds ---
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
        acc[u] = (acc[u] || 0) + parseFloat(inc.value || 0)
        return acc
    }, {})
    const des = despesas.value.reduce((acc, exp) => {
        const u = exp.user?.name || '— sem usuário —'
        acc[u] = (acc[u] || 0) + parseFloat(exp.value || 0)
        return acc
    }, {})
    return { receitas: rec, despesas: des }
})

const bestUser = computed(() => {
    let best = null, bestVal = -Infinity
    for (const u in totalsByUser.value.receitas) {
        const val = totalsByUser.value.receitas[u] - (totalsByUser.value.despesas[u] || 0)
        if (val > bestVal) {
        bestVal = val
        best = u
        }
    }
    return best || '—'
})

// --- Função para animar quando visível ---
function animateWhenVisible(el, endVal, opts) {
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => {
        if (e.isIntersecting) {
            new CountUp(el, endVal, opts).start()
            observer.unobserve(el)
        }
        })
    }, { threshold: 0.5 })
    observer.observe(el)
}

// --- Montagem e fetch ---
onMounted(async () => {
  // busca dados
    const [r, d] = await Promise.all([
        axios.get('/api/v1/incomes'),
        axios.get('/api/v1/expenses'),
    ])
    receitas.value = r.data
    despesas.value = d.data

  // desliga skeletons e espera o DOM atualizar
  isLoading.value = false
  await nextTick()

  // opções CountUp com formatação BR
    const countOpts = {
        prefix: 'R$ ',
        duration: 1.5,
        separator: '.',
        decimal: ','
    }

  // dispara animações quando os cartões entrarem em vista
    animateWhenVisible(receitasRef.value, totalReceitas.value, countOpts)
    animateWhenVisible(despesasRef.value, totalDespesas.value, countOpts)
    animateWhenVisible(balanceRef.value, balance.value, countOpts)
})
</script>
