<template>
  <div class="upload">
    <Title title="Client Upload Portal" />
    <Text text="Please upload a file to display client data" />
    <div class="input-container">
      <Input button_text="Upload" />
    </div>
    <ValidationMessage v-if="error" :validation="error" />
  </div>
</template>
        
  <script setup lang="ts">
import Input from "@atoms/Input.vue";
import Title from "@atoms/Title.vue";
import Text from "@atoms/Text.vue";
import ValidationMessage from "@atoms/ValidationMessage.vue";
import { computed } from "vue";
import { useClientStore } from "@stores/clientStore.ts";

const clientStore = useClientStore();

const error = computed(() => clientStore.error.error_upload);
</script>

<style>
.upload {
  margin-top: 100px;
  border: 1px solid white;
  border-radius: 15px;
  background-color: #ccc;
  box-shadow: 0 0 15px rgba(255, 255, 255, 0.806);
  padding: 20px 40px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  margin-bottom: 50px;
}

.input-container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
</style>