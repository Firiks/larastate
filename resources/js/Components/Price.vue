<template>
  <span>{{ formattedPrice }}</span>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    price: [Number, String], // price can be a number or a string
})

// display formatted price to euro format
const formattedPrice = computed(
    () => Number(props.price).toLocaleString('de-DE', {
        style: 'currency',
        currency: 'EUR',
        maximumFractionDigits: 2,
    }),
)
</script>
