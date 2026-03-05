<script setup>
import { ref, onMounted } from "vue";
import { RouterLink } from "vue-router";
import {
  ShoppingBagIcon,
  UserCircleIcon,
  ClockIcon,
  ChevronRightIcon,
} from "@heroicons/vue/24/outline";
import { useAuthStore } from "@/stores/auth";
import { ordersApi } from "@/api/orders";

const auth = useAuthStore();
const recentOrders = ref([]);
const loading = ref(true);

onMounted(async () => {
  try {
    const { data } = await ordersApi.list();
    const all = data.data ?? data;
    recentOrders.value = all.slice(0, 3);
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
    <!-- Header -->
    <div class="mb-8">
      <p class="text-sm text-slate-500">Welcome back,</p>
      <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
        {{ auth.user?.name }}
      </h1>
    </div>

    <!-- Quick links -->
    <div class="mb-8 grid gap-4 sm:grid-cols-2">
      <RouterLink
        to="/account/orders"
        class="group flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5"
      >
        <div
          class="flex size-12 items-center justify-center rounded-xl bg-brand-50 text-brand-600 group-hover:bg-brand-100 transition-colors"
        >
          <ShoppingBagIcon class="size-6" />
        </div>
        <div class="flex-1 min-w-0">
          <p class="font-semibold text-slate-900">My Orders</p>
          <p class="text-sm text-slate-500">Track and view your orders</p>
        </div>
        <ChevronRightIcon
          class="size-4 shrink-0 text-slate-300 group-hover:text-brand-500 transition-colors"
        />
      </RouterLink>

      <RouterLink
        to="/account/profile"
        class="group flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5"
      >
        <div
          class="flex size-12 items-center justify-center rounded-xl bg-slate-100 text-slate-600 group-hover:bg-slate-200 transition-colors"
        >
          <UserCircleIcon class="size-6" />
        </div>
        <div class="flex-1 min-w-0">
          <p class="font-semibold text-slate-900">My Profile</p>
          <p class="text-sm text-slate-500">View your account details</p>
        </div>
        <ChevronRightIcon
          class="size-4 shrink-0 text-slate-300 group-hover:text-brand-500 transition-colors"
        />
      </RouterLink>
    </div>

    <!-- Recent orders -->
    <div>
      <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
          <ClockIcon class="size-4.5 text-slate-400" />
          <h2 class="text-base font-bold text-slate-900">Recent Orders</h2>
        </div>
        <RouterLink
          to="/account/orders"
          class="text-sm font-medium text-brand-600 hover:text-brand-700 transition-colors"
        >
          View all →
        </RouterLink>
      </div>

      <!-- Skeleton -->
      <div v-if="loading" class="space-y-3">
        <div
          v-for="i in 3"
          :key="i"
          class="h-16 animate-pulse rounded-2xl bg-slate-100"
        />
      </div>

      <!-- Empty -->
      <div
        v-else-if="recentOrders.length === 0"
        class="rounded-2xl border border-dashed border-slate-200 bg-white py-12 text-center"
      >
        <ShoppingBagIcon class="mx-auto mb-3 size-10 text-slate-300" />
        <p class="font-medium text-slate-500">No orders yet</p>
        <p class="mt-1 text-sm text-slate-400">
          Browse stores and place your first order.
        </p>
        <RouterLink
          to="/stores"
          class="mt-4 inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-brand-500 to-brand-600 px-5 py-2.5 text-sm font-bold text-white hover:from-brand-600 hover:to-brand-700 transition-all"
        >
          Browse Stores
        </RouterLink>
      </div>

      <!-- Orders list -->
      <ul v-else class="space-y-3">
        <li v-for="order in recentOrders" :key="order.id">
          <RouterLink
            :to="`/account/orders/${order.id}`"
            class="group flex items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition-all hover:shadow-md hover:border-brand-200"
          >
            <div class="min-w-0">
              <p class="font-semibold text-slate-800">Order #{{ order.id }}</p>
              <p class="text-xs text-slate-400">{{ order.created_at }}</p>
            </div>
            <div class="flex shrink-0 items-center gap-3">
              <span
                class="rounded-full px-2.5 py-0.5 text-xs font-medium capitalize"
                :class="
                  statusColors[order.status] ?? 'bg-slate-100 text-slate-500'
                "
              >
                {{ order.status }}
              </span>
              <span class="hidden font-bold text-slate-900 sm:block">{{
                order.total?.formatted
              }}</span>
              <ChevronRightIcon
                class="size-4 text-slate-300 group-hover:text-brand-500 transition-colors"
              />
            </div>
          </RouterLink>
        </li>
      </ul>
    </div>
  </div>
</template>
