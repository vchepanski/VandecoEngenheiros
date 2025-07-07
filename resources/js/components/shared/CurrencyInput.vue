<template>
  <div class="relative">
    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#A0A4AC]">R$</span>
    <input
      v-model="displayValue"
      @blur="formatOnBlur"
      @input="parseValue"
      type="text"
      inputmode="decimal"
      :class="[
        'w-full pl-10 pr-3 py-2 rounded bg-[#0F1115] border',
        error ? 'border-red-500' : 'border-gray-700',
        'text-white focus:outline-none focus:ring-2 focus:ring-blue-500'
      ]"
    />
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  modelValue: {
    type: [Number, String],
    default: ''
  },
  error: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['update:modelValue'])

const displayValue = ref('')

// Sincroniza input visual com valor externo
watch(() => props.modelValue, (newVal) => {
  if (newVal !== '' && !isNaN(newVal)) {
    displayValue.value = newVal.toString().replace('.', ',')
  } else {
    displayValue.value = ''
  }
}, { immediate: true })

// Converte ao digitar (sem formatar)
function parseValue() {
  const raw = displayValue.value
    .replace(/\s/g, '')
    .replace(/[R$]/g, '')
    .replace(/\./g, '')
    .replace(/,/g, '.')

  const parsed = parseFloat(raw)
  emit('update:modelValue', isNaN(parsed) ? '' : parsed)
}

// Formata ao sair do campo
function formatOnBlur() {
  if (displayValue.value === '') return

  const number = parseFloat(
    displayValue.value.replace(/\./g, '').replace(',', '.')
  )

  if (!isNaN(number)) {
    displayValue.value = number.toLocaleString('pt-BR', {
      style: 'currency',
      currency: 'BRL'
    })
  }
}
</script>
