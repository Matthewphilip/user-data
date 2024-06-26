<template>
  <p class="validation-message">{{ props.validation }}</p>
</template>
  <script setup lang="ts">
import { defineProps } from "vue";

const props = defineProps({
  validation: String,
});
</script>
<style>
.validation-message {
  color: red;
  margin-top: 10px;
}
</style>