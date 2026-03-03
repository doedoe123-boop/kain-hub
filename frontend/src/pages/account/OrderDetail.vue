<script setup>
import { ref, onMounted } from "vue";
import { useRoute, RouterLink } from "vue-router";
import { ordersApi } from "@/api/orders";

const route = useRoute();
const order = ref(null);
const loading = ref(true);

onMounted(async () => {
  try {
    const { data } = await ordersApi.show(route.params.id);
    order.value = data;
  } finally {
    loading.value = false;
  }
});
</script>

<template>
  <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6">
    <RouterLink
      to="/account/orders"
      class="mb-5 inline-flex items-center gap-1.5 text-sm font-medium text-brand-600 hover:text-brand-700"
    >
      ← Back to Orders
    </RouterLink>

    <div v-if="loading" class="space-y-3">
      <div class="h-8 w-48 animate-pulse rounded bg-gray-100" />
    </div>

    <div v-else-if="order">
      <h1 class="mb-6 text-2xl font-bold text-gray-900">
        Order #{{ order.id }}
      </h1>

      <div class="rounded-2xl border bg-white p-5">
        <ul class="divide-y text-sm">
          <li
            v-for="line in order.lines"
            :key="line.id"
            class="flex items-start justify-between gap-3 py-3"
          >
            <span class="flex-1 text-gray-700 leading-snug"
              >{{ line.description }} × {{ line.quantity }}</span
            >
            <span class="shrink-0 font-medium text-gray-900">{{
              line.sub_total?.formatted
            }}</span>
          </li>
        </ul>
        <div
          class="mt-4 flex justify-between border-t pt-3 font-semibold text-gray-900"
        >
          <span>Total</span>
          <span class="shrink-0">{{ order.total?.formatted }}</span>
        </div>
      </div>
    </div>
  </div>
</template>
