<script setup>
import { ref, onMounted } from "vue";
import { RouterLink } from "vue-router";
import {
  ShoppingBagIcon,
  MapPinIcon,
  CreditCardIcon,
  UserCircleIcon,
  ClockIcon,
  ChevronRightIcon,
  Cog6ToothIcon,
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
  confirmed: "bg-blue-100 text-blue-700",
  preparing: "bg-purple-100 text-purple-700",
  ready: "bg-indigo-100 text-indigo-700",
  delivered: "bg-green-100 text-green-700",
  cancelled: "bg-red-100 text-red-700",
};

const quickLinks = [
  {
    to: "/account/orders",
    label: "My Orders",
    description: "Track and view your orders",
    icon: ShoppingBagIcon,
    color: "bg-brand-50 text-brand-600 group-hover:bg-brand-100",
  },
  {
    to: "/account/addresses",
    label: "Addresses",
    description: "Manage delivery addresses",
    icon: MapPinIcon,
    color: "bg-green-50 text-green-600 group-hover:bg-green-100",
  },
  {
    to: "/account/payment-methods",
    label: "Payment Methods",
    description: "Saved cards and billing",
    icon: CreditCardIcon,
    color: "bg-violet-50 text-violet-600 group-hover:bg-violet-100",
  },
  {
    to: "/account/profile",
    label: "My Profile",
    description: "Name, email and phone",
    icon: UserCircleIcon,
    color: "bg-slate-100 text-slate-600 group-hover:bg-slate-200",
  },
  {
    to: "/account/settings",
    label: "Settings",
    description: "Notifications and account",
    icon: Cog6ToothIcon,
    color: "bg-orange-50 text-orange-600 group-hover:bg-orange-100",
  },
];
</script>

<template>
  <div class="mx-auto max-w-3xl px-4 py-8 sm:px-6">
    <!-- Header -->
    <div class="mb-8">
      <p class="text-sm text-slate-500">Welcome back,</p>
      <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
        {{ auth.user?.name }}
      </h1>
      <div
        class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-0.5 text-sm text-slate-500"
      >
        <span>{{ auth.user?.email }}</span>
        <span v-if="auth.user?.phone" class="flex items-center gap-1">
          <span class="text-slate-300">·</span>
          {{ auth.user?.phone }}
        </span>
      </div>
    </div>

    <!-- Quick links grid -->
    <div class="mb-8 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
      <RouterLink
        v-for="link in quickLinks"
        :key="link.to"
        :to="link.to"
        class="group flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md"
      >
        <div
          class="flex size-11 shrink-0 items-center justify-center rounded-xl transition-colors"
          :class="link.color"
        >
          <component :is="link.icon" class="size-5" />
        </div>
        <div class="min-w-0 flex-1">
          <p class="font-semibold text-slate-900">{{ link.label }}</p>
          <p class="truncate text-xs text-slate-500">{{ link.description }}</p>
        </div>
        <ChevronRightIcon
          class="size-4 shrink-0 text-slate-300 transition-colors group-hover:text-brand-500"
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
          class="text-sm font-medium text-brand-600 transition-colors hover:text-brand-700"
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
          class="mt-4 inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-brand-500 to-brand-600 px-5 py-2.5 text-sm font-bold text-white transition-all hover:from-brand-600 hover:to-brand-700"
        >
          Browse Stores
        </RouterLink>
      </div>

      <!-- Orders list -->
      <ul v-else class="space-y-3">
        <li v-for="order in recentOrders" :key="order.id">
          <RouterLink
            :to="`/account/orders/${order.id}`"
            class="group flex items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition-all hover:border-brand-200 hover:shadow-md"
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
                class="size-4 text-slate-300 transition-colors group-hover:text-brand-500"
              />
            </div>
          </RouterLink>
        </li>
      </ul>
    </div>
  </div>
</template>
