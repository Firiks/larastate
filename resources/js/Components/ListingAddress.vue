<template>
  <span>
    Street: {{ listing.street }} {{ listing.street_nr }}, City: {{
      listing.city }}
  </span>
</template>

<script setup>
defineProps({
    listing: Object,
})
</script>
