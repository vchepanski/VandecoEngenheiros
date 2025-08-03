<template>
    <div class="bg-[#1f1f1f] rounded-lg p-4 shadow text-white">
        <h2 class="mb-4 text-lg font-semibold">Gastos por Categoria</h2>
        <div class="max-w-md mx-auto">
        <Doughnut :data="chartData" :options="chartOptions" />
        </div>
    </div>
</template>

    <script setup>
    import { computed } from 'vue'
    import { Doughnut } from 'vue-chartjs'
    import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    ArcElement,
    CategoryScale,
    } from 'chart.js'

    // Registro dos elementos que o ChartJS vai usar
    ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale)

    // Props
    const props = defineProps({
    despesas: {
        type: Array,
        required: true
    }
    })

    // Gera cor única e consistente para cada nome
    function corPorNome(nome) {
    let hash = 0
    for (let i = 0; i < nome.length; i++) {
        hash = nome.charCodeAt(i) + ((hash << 5) - hash)
    }
    const h = hash % 360
    return `hsl(${h}, 65%, 55%)`
    }

    // Agrupar e somar por categoria
    const despesasPorCategoria = computed(() => {
    const grupo = {}
    props.despesas.forEach(d => {
        const nome = d.expense_category?.name || 'Sem Categoria'
        grupo[nome] = (grupo[nome] || 0) + parseFloat(d.value || 0)
    })
    return grupo
    })

    // Dados do gráfico com cores dinâmicas
    const chartData = computed(() => {
    const labels = Object.keys(despesasPorCategoria.value)
    const data = Object.values(despesasPorCategoria.value)
    const backgroundColor = labels.map(label => corPorNome(label))

    return {
        labels,
        datasets: [
        {
            data,
            backgroundColor,
            borderWidth: 1,
        }
        ]
    }
    })

    // Tooltip com porcentagem
    const chartOptions = {
    responsive: true,
    plugins: {
        legend: {
        position: 'bottom',
        labels: {
            color: 'white'
        }
        },
        tooltip: {
        callbacks: {
            label: ctx => {
            const valor = ctx.parsed
            const total = ctx.dataset.data.reduce((sum, val) => sum + val, 0)
            const porcentagem = ((valor / total) * 100).toFixed(1)
            return `${ctx.label}: R$ ${valor.toFixed(2)} (${porcentagem}%)`
            }
        }
        }
    }
    }
</script>
