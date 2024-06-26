<template>
  <label for="file-upload" class="custom-file-upload">
    {{ props.button_text }}
  </label>
  <input
    id="file-upload"
    class="file-input"
    type="file"
    @change="handleFileChange"
  />
</template>
<script setup lang="ts">
import { useClientStore } from "@stores/clientStore.ts";
import { ref, defineProps } from "vue";

const clientStore = useClientStore();

const props = defineProps({
  button_text: String,
});

const uploadedFile = ref<File | null>(null);
const fileValidation = ref<string | null>(null);

const handleFileChange = (e: Event) => {
  const input = e.target as HTMLInputElement;
  if (input.files && input.files.length > 0) {
    uploadedFile.value = input.files[0];
    console.log("Selected file:", uploadedFile.value);
    clientStore.handleFileChange(uploadedFile.value);
  } else {
    fileValidation.value = "Error when uploading file, please try again";
  }
};
</script>
<style>
.file-input {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
}

input[type="file"] {
  display: none;
}

.custom-file-upload {
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: rgb(2, 101, 2);
  color: white;
  display: inline-block;
  padding: 6px 12px;
  cursor: pointer;
  margin-top: 15px;
}

.custom-file-upload:hover {
  background-color: rgb(0, 175, 0);
  color: white;
}

@media screen and (min-width: 768px) {
  .file-input {
    width: 200px;
    height: 40px;
    font-size: 16px;
    padding: 8px 16px;
  }
}
</style>