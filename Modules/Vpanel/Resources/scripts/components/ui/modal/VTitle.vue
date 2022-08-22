<template>
  <p class="text-white">{{ text }}</p>
</template>

<script lang="ts">
export default {
  props: {
    text: { type: String, required: true }
  },
}
</script>