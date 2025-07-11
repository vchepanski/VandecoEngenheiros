<template>
  <section class="relative h-screen pt-16 overflow-hidden">
    <!-- Partículas (plugin global) -->
    <Particles
      id="tsparticles"
      class="absolute inset-0 z-0"
      :options="particlesOptions"
    />

    <!-- Gradient animado no hero -->
    <div class="absolute inset-0 z-10 opacity-70 animate-bg-gradient"></div>

    <!-- Conteúdo principal + animação Lottie manual -->
    <div
      class="relative z-20 flex flex-col-reverse items-center justify-center h-full gap-8 px-6 text-white md:flex-row"
    >
      <!-- Texto e botão -->
      <div class="space-y-6 md:w-1/2">
        <h1
          class="text-5xl font-extrabold text-transparent md:text-6xl bg-clip-text bg-gradient-to-r from-yellow-400 to-pink-500 animate-text-gradient"
        >
          Vandeco Finanças 💰
        </h1>
        <p class="text-lg md:text-xl text-[#A0A4AC]">
          Organize seu dinheiro de forma inteligente.
        </p>
        <button
          ref="cta"
          class="px-8 py-3 mt-4 text-gray-900 transition transform bg-white rounded-full shadow-2xl hover:scale-105"
          @click="goToDashboard"
        >
          Começar Agora
        </button>
      </div>

      <!-- Container para Lottie -->
      <div class="flex justify-center md:w-1/2">
        <div ref="lottieContainer" class="w-64 h-64 md:w-80 md:h-80"></div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import animationData from '../assets/finance.json'
import lottie from 'lottie-web'

// Configuração das partículas (já registradas globalmente)
const particlesOptions = {
  fpsLimit: 60,
  particles: {
    number: { value: 40 },
    size: { value: 3 },
    move: { enable: true, speed: 1.5 },
    links: { enable: true, distance: 150, color: '#ffffff', opacity: 0.2 },
  },
  interactivity: {
    events: {
      onHover: { enable: true, mode: 'repulse' },
      onClick: { enable: true, mode: 'push' },
    },
    modes: { repulse: { distance: 100 }, push: { quantity: 4 } },
  },
  detectRetina: true,
}

const cta = ref(null)
const lottieContainer = ref(null)

onMounted(async () => {
  // Tilt no botão
  const { default: VanillaTilt } = await import('vanilla-tilt')
  if (cta.value) {
    VanillaTilt.init(cta.value, {
      max: 15,
      speed: 400,
      glare: true,
      'max-glare': 0.2,
    })
  }

  // Inicializa a animação Lottie
  if (lottieContainer.value) {
    lottie.loadAnimation({
      container: lottieContainer.value,
      renderer: 'svg',
      loop: true,
      autoplay: true,
      animationData,
    })
  }
})

function goToDashboard() {
  // useRouter().push('/dashboard')
}
</script>

<style>
@keyframes bg-gradient {
  0% { background: linear-gradient(45deg, #1e293b, #0f172a); }
  50% { background: linear-gradient(45deg, #0f172a, #1e3a8a); }
  100% { background: linear-gradient(45deg, #1e293b, #0f172a); }
}
.animate-bg-gradient {
  animation: bg-gradient 8s ease infinite;
}

@keyframes text-gradient {
  0%, 100% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
}
.animate-text-gradient {
  background-size: 200% 200%;
  animation: text-gradient 5s ease infinite;
}
</style>
