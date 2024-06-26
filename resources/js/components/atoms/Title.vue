<template>
  <h1>{{ props.title }}</h1>
</template>
<script setup lang="ts">
import { defineProps } from "vue";

const props = defineProps({
  title: String,
});
</script>