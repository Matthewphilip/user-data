<template>
  <p class="loading">{{ props.text }}</p>
</template>
    <script setup lang="ts">
import { defineProps } from "vue";

const props = defineProps({
  text: String,
});
</script>
<style>
.loading {
  color: white;
}
</style>