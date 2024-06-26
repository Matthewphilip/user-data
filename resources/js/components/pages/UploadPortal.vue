<template>
  <div class="upload-portal">
    <FileUpload />
    <ClientList v-if="client_data" :client_data="client_data" />
  </div>
</template>
        
<script setup lang="ts">
import FileUpload from "@organisms/FileUpload.vue";
import ClientList from "@organisms/ClientList.vue";
import { useClientStore } from "@stores/clientStore.ts";
import { computed } from "vue";

const client_store = useClientStore();

const client_data = computed(() => client_store.client_data);
</script>

<style>
.upload-portal {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
</style>