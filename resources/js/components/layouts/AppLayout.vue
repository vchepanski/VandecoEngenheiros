<template>
  <div class="min-h-screen bg-[#0F1115] text-[#E4E7EB]">
    <header class="sticky top-0 z-50 bg-gradient-to-r from-[#0A0D12]/80 to-[#1A1D23]/80 backdrop-blur-sm shadow-lg">
      <div class="flex items-center justify-between px-6 py-4 mx-auto max-w-7xl">
        <!-- Logo como link pra Home -->
        <RouterLink
          to="/"
          class="text-4xl font-extrabold text-[#3B82F6] tracking-wide transform transition hover:scale-105"
        >
          Vandeco Finanças
        </RouterLink>
        <nav class="flex space-x-8 text-base">
          <RouterLink
            to="/users"
            class="relative px-2 pb-1 text-gray-400 transition hover:text-white"
            active-class="text-white after:absolute after:-bottom-1 after:left-0 after:w-full after:h-0.5 after:bg-[#3B82F6]"
          >
            Usuários
          </RouterLink>
          <RouterLink
            to="/incomes"
            class="relative px-2 pb-1 text-gray-400 transition hover:text-white"
            active-class="text-white after:absolute after:-bottom-1 after:left-0 after:w-full after:h-0.5 after:bg-[#3B82F6]"
          >
            Receitas
          </RouterLink>
          <RouterLink
            to="/expenses"
            class="relative px-2 pb-1 text-gray-400 transition hover:text-white"
            active-class="text-white after:absolute after:-bottom-1 after:left-0 after:w-full after:h-0.5 after:bg-[#3B82F6]"
          >
            Despesas
          </RouterLink>
        </nav>
      </div>
    </header>

    <main class="p-6">
      <RouterView />
    </main>
  </div>
</template>

<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>
