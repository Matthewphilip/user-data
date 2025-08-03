<template>
  <div class="client-card">
    <div class="client-card__details-container">
      <p>{{ client.title }}</p>
      <p v-if="client.first_name">{{ client.first_name }}</p>
      <p v-if="client.initial">{{ client.initial }}</p>
      <p>{{ client.last_name }}</p>
    </div>
    <Button text="+" @event="handleSubmitIndividual" />
  </div>
  <ValidationMessage v-if="error" :validation="error" />
</template>
  
  <script setup lang="ts">
import Button from "@atoms/Button.vue";
import ValidationMessage from "@atoms/ValidationMessage.vue";
import { useClientStore } from "@stores/clientStore.ts";
import { toRefs, computed } from "vue";

const clientStore = useClientStore();

interface ClientObject {
  title: string;
  first_name?: string;
  initial?: string;
  last_name: string;
}

interface Props {
  client: ClientObject;
}

const props = defineProps<Props>();

const { client } = toRefs(props);

const error = computed(() => clientStore.error.error_individua);

const handleSubmitIndividual = () => {
  clientStore.handleSubmitIndividual(props.client);
};
</script>
  
<style lang="scss">
.client-card {
  border: 1px solid white;
  border-radius: 15px;
  background-color: #ccc;
  box-shadow: 0 0 15px rgba(255, 255, 255, 0.5);
  padding: 10px 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;

  &__details-container {
    display: flex;
    flex-direction: row;
  }
}

.client-card p {
  margin-right: 5px;
}
</style>