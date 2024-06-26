<template>
  <button class="action-button" @click="emitEvent">
    {{ props.text }}
  </button>
</template>
<script setup lang="ts">
import { defineProps, defineEmits } from "vue";

const props = defineProps({
  text: String,
});

const emit = defineEmits(["event"]);

const emitEvent = () => {
  emit("event");
};
</script>
<style>
.action-button {
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: rgb(2, 101, 2);
  color: white;
  display: inline-block;
  padding: 6px 12px;
  cursor: pointer;
}

.action-button:hover {
  background-color: rgb(0, 175, 0);
  color: white;
}
</style>