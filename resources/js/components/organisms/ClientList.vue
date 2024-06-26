<template>
  <Loading v-if="loading" :text="loading" />
  <Button text="Save All Records" @event="handleSubmitAll" />
  <SuccessMessage v-if="success" :message="success" />
  <ValidationMessage v-if="error" :validation="error" />
  <div class="client-container">
    <div
      v-for="(client, index) in client_data"
      :key="index"
      class="client-wrapper"
    >
      <ClientCard :client="client" class="client_card" />
    </div>
  </div>
</template>
          
  <script setup lang="ts">
import ClientCard from "@molecules/ClientCard.vue";
import Loading from "@atoms/Loading.vue";
import ValidationMessage from "@atoms/ValidationMessage.vue";
import SuccessMessage from "@atoms/SuccessMessage.vue";
import Button from "@atoms/Button.vue";
import { useClientStore } from "@stores/clientStore.ts";
import { toRefs, computed } from "vue";

interface ClientObject {
  title: string;
  first_name?: string;
  initial?: string;
  last_name: string;
}

interface ClientData extends Array<ClientObject> {}

interface Props {
  client_data: ClientData[];
}

const props = defineProps<Props>();

const { client_data } = toRefs(props);

const clientStore = useClientStore();

const loading = computed(() => clientStore.loading);

const success = computed(() => clientStore.success.success_all);

const error = computed(() => clientStore.error.error_all);

const handleSubmitAll = () => {
  clientStore.handleSubmitAll(props.client_data);
};
</script>
<style>
.client-container {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  width: 90%;
  margin-top: 20px;
}

.client-wrapper {
  width: 100%;
  margin-bottom: 20px;
}

.client-card {
  border: 1px solid white;
  border-radius: 15px;
  background-color: #ccc;
  box-shadow: 0 0 20px rgba(255, 255, 255, 0.806);
  padding: 10px 20px;
}

@media (min-width: 1050px) {
  .client-container {
    width: 70%;
    flex-wrap: wrap;
    flex-direction: row;
  }

  .client-wrapper {
    width: calc(33.33% - 20px);
  }
}
</style>