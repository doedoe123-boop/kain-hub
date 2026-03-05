<script setup>
import { ref, onMounted } from "vue";
import { RouterLink } from "vue-router";
import { ordersApi } from "@/api/orders";

const orders = ref([]);
const loading = ref(true);

onMounted(async () => {
  try {
    const { data } = await ordersApi.list();
    orders.value = data.data ?? data;
  } finally {
    loading.value = false;
  }
});

const statusColors = {
  pending: "bg-yellow-100 text-yellow-700",
  processing: "bg-blue-100 text-blue-700",
  dispatched: "bg-purple-100 text-purple-700",
  delivered: "bg-green-100 text-green-700",
  cancelled: "bg-red-100 text-red-700",
};
</script>

<template>
  <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6">
    <!-- Breadcrumb -->
    <RouterLink
      to="/account"
      class="mb-5 inline-flex items-center gap-1.5 text-sm font-medium text-brand-600 hover:text-brand-700 transition-colors"
    >
      ← My Account
    </RouterLink>

    <h1 class="mb-6 text-3xl font-extrabold tracking-tight text-slate-900">
      My Orders
    </h1>

    <div v-if="loading" class="space-y-3">
      <div
        v-for="i in 4"
        :key="i"
        class="h-20 animate-pulse rounded-2xl bg-slate-100"
      />
    </div>

    <div
      v-else-if="orders.length === 0"
      class="rounded-2xl border border-dashed border-slate-200 bg-white py-12 text-center"
    >
      <p class="font-medium text-slate-500">No orders yet.</p>
      <RouterLink
        to="/stores"
        class="mt-3 inline-block text-sm font-medium text-brand-600 hover:underline"
      >
        Start shopping →
      </RouterLink>
    </div>

    <ul v-else class="space-y-3">
      <li
        v-for="order in orders"
        :key="order.id"
        class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm"
      >
        <div
          class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between"
        >
          <div class="flex items-center justify-between gap-3 sm:block">
            <p class="font-semibold text-slate-800">Order #{{ order.id }}</p>
            <span
              class="rounded-full px-2.5 py-0.5 text-xs font-medium capitalize sm:hidden"
              :class="
                statusColors[order.status] ?? 'bg-slate-100 text-slate-500'
              "
            >
              {{ order.status }}
            </span>
          </div>
          <p class="text-xs text-slate-400 sm:hidden">{{ order.created_at }}</p>
          <div class="flex items-center gap-3">
            <span
              class="hidden rounded-full px-2.5 py-0.5 text-xs font-medium capitalize sm:inline-block"
              :class="
                statusColors[order.status] ?? 'bg-slate-100 text-slate-500'
              "
            >
              {{ order.status }}
            </span>
            <p class="hidden text-xs text-slate-400 sm:block">
              {{ order.created_at }}
            </p>
            <span class="font-bold text-slate-900">{{
              order.total?.formatted
            }}</span>
            <RouterLink
              :to="`/account/orders/${order.id}`"
              class="rounded-lg border border-brand-200 bg-brand-50 px-3 py-1.5 text-xs font-medium text-brand-600 transition-colors hover:bg-brand-100"
            >
              View →
            </RouterLink>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>
