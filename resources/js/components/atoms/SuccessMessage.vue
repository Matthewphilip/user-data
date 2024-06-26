<template>
  <p class="success-message">{{ props.message }}</p>
</template>
    <script setup lang="ts">
import { defineProps } from "vue";

const props = defineProps({
  message: String,
});
</script>
  <style>
.success-message {
  color: rgb(1, 169, 1);
  margin-top: 10px;
}
</style>