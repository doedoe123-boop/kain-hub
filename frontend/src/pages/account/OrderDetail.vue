<script setup>
import { ref, computed, onMounted } from "vue";
import { useRoute, useRouter, RouterLink } from "vue-router";
import { CheckCircleIcon, XCircleIcon } from "@heroicons/vue/24/solid";
import { ArrowPathIcon } from "@heroicons/vue/24/outline";
import { ordersApi } from "@/api/orders";
import { cartApi } from "@/api/cart";

const route = useRoute();
const router = useRouter();
const order = ref(null);
const loading = ref(true);
const cancelling = ref(false);
const reordering = ref(false);
const reorderError = ref(false);

onMounted(async () => {
  try {
    const { data } = await ordersApi.show(route.params.id);
    order.value = data;
  } finally {
    loading.value = false;
  }
});

const steps = [
  { key: "pending", label: "Order Placed" },
  { key: "confirmed", label: "Confirmed" },
  { key: "preparing", label: "Preparing" },
  { key: "ready", label: "Ready for Pickup" },
  { key: "delivered", label: "Delivered" },
];

const statusOrder = ["pending", "confirmed", "preparing", "ready", "delivered"];

const currentStepIndex = computed(() => {
  const status = order.value?.status;

  if (status === "cancelled") {
    return -1;
  }

  return statusOrder.indexOf(status);
});

function stepState(index) {
  if (order.value?.status === "cancelled") {
    return "cancelled";
  }

  if (index < currentStepIndex.value) {
    return "done";
  }

  if (index === currentStepIndex.value) {
    return "active";
  }

  return "upcoming";
}

const statusColors = {
  pending: "bg-yellow-100 text-yellow-700",
  confirmed: "bg-blue-100 text-blue-700",
  preparing: "bg-purple-100 text-purple-700",
  ready: "bg-indigo-100 text-indigo-700",
  delivered: "bg-green-100 text-green-700",
  cancelled: "bg-red-100 text-red-700",
};

const paymentStatusColors = {
  pending: "bg-yellow-100 text-yellow-700",
  paid: "bg-green-100 text-green-700",
  failed: "bg-red-100 text-red-700",
  refunded: "bg-slate-100 text-slate-600",
};

async function cancelOrder() {
  if (!confirm("Cancel this order? This cannot be undone.")) {
    return;
  }

  cancelling.value = true;

  try {
    const { data } = await ordersApi.cancel(order.value.id);
    order.value = data;
  } finally {
    cancelling.value = false;
  }
}

async function reorder() {
  reordering.value = true;
  reorderError.value = false;

  try {
    for (const line of order.value?.lines ?? []) {
      await cartApi.addItem("product", line.purchasable_id, line.quantity);
    }
    router.push("/cart");
  } catch {
    reorderError.value = true;
  } finally {
    reordering.value = false;
  }
}
</script>

<template>
  <div class="mx-auto max-w-3xl px-4 py-8 sm:px-0">
    <RouterLink
      to="/account/orders"
      class="mb-5 inline-flex items-center gap-1.5 text-sm font-medium text-brand-600 hover:text-brand-700 transition-colors"
    >
      ← My Orders
    </RouterLink>

    <div v-if="loading" class="space-y-3">
      <div class="h-8 w-48 animate-pulse rounded bg-slate-100" />
      <div class="h-24 animate-pulse rounded-2xl bg-slate-100" />
      <div class="h-40 animate-pulse rounded-2xl bg-slate-100" />
    </div>

    <div v-else-if="order">
      <!-- Header row -->
      <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">
          Order #{{ order.id }}
        </h1>
        <div class="flex flex-wrap items-center gap-2">
          <span
            class="rounded-full px-3 py-1 text-xs font-semibold capitalize"
            :class="statusColors[order.status] ?? 'bg-slate-100 text-slate-500'"
          >
            {{ order.status }}
          </span>
          <span
            v-if="order.payment_status"
            class="rounded-full px-3 py-1 text-xs font-semibold capitalize"
            :class="
              paymentStatusColors[order.payment_status] ??
              'bg-slate-100 text-slate-500'
            "
          >
            {{ order.payment_status }}
          </span>
        </div>
      </div>

      <!-- Status timeline (not shown if cancelled) -->
      <div
        v-if="order.status !== 'cancelled'"
        class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
      >
        <ol class="flex items-start gap-0">
          <li
            v-for="(step, i) in steps"
            :key="step.key"
            class="flex flex-1 flex-col items-center"
          >
            <!-- Connector line before (skip first) -->
            <div class="flex w-full items-center">
              <div
                v-if="i > 0"
                class="h-0.5 flex-1 transition-colors"
                :class="
                  stepState(i) === 'done' || stepState(i) === 'active'
                    ? 'bg-brand-500'
                    : 'bg-slate-200'
                "
              />
              <div
                class="flex size-7 shrink-0 items-center justify-center rounded-full border-2 transition-all"
                :class="{
                  'border-brand-500 bg-brand-500': stepState(i) === 'done',
                  'border-brand-500 bg-white': stepState(i) === 'active',
                  'border-slate-200 bg-white': stepState(i) === 'upcoming',
                }"
              >
                <CheckCircleIcon
                  v-if="stepState(i) === 'done'"
                  class="size-4 text-white"
                />
                <div
                  v-else-if="stepState(i) === 'active'"
                  class="size-2.5 rounded-full bg-brand-500"
                />
              </div>
              <div
                v-if="i < steps.length - 1"
                class="h-0.5 flex-1 transition-colors"
                :class="
                  stepState(i) === 'done' ? 'bg-brand-500' : 'bg-slate-200'
                "
              />
            </div>
            <p
              class="mt-2 text-center text-xs font-medium leading-tight"
              :class="{
                'text-brand-700': stepState(i) === 'active',
                'text-slate-600': stepState(i) === 'done',
                'text-slate-400': stepState(i) === 'upcoming',
              }"
            >
              {{ step.label }}
            </p>
          </li>
        </ol>
      </div>

      <!-- Cancelled banner -->
      <div
        v-else
        class="mb-6 flex items-center gap-3 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700"
      >
        <XCircleIcon class="size-5 shrink-0" />
        This order was cancelled.
      </div>

      <!-- Line items -->
      <div
        class="mb-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"
      >
        <ul class="divide-y text-sm">
          <li
            v-for="line in order.lines"
            :key="line.id"
            class="flex items-start justify-between gap-3 py-3"
          >
            <span class="flex-1 leading-snug text-slate-700">
              {{ line.description }} × {{ line.quantity }}
            </span>
            <span class="shrink-0 font-medium text-slate-900">
              {{ line.sub_total?.formatted }}
            </span>
          </li>
        </ul>
        <div
          class="mt-4 flex justify-between border-t pt-3 font-bold text-slate-900"
        >
          <span>Total</span>
          <span class="shrink-0">{{ order.total?.formatted }}</span>
        </div>
      </div>

      <!-- Actions -->
      <div class="flex flex-wrap gap-3">
        <button
          v-if="order.status === 'pending'"
          class="rounded-xl border border-red-300 px-4 py-2 text-sm font-medium text-red-600 transition-colors hover:bg-red-50 disabled:opacity-60"
          :disabled="cancelling"
          @click="cancelOrder"
        >
          {{ cancelling ? "Cancelling…" : "Cancel Order" }}
        </button>

        <button
          v-if="order.lines?.length"
          class="flex items-center gap-2 rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50 disabled:opacity-60"
          :disabled="reordering"
          @click="reorder"
        >
          <ArrowPathIcon class="size-4" />
          {{ reordering ? "Adding to cart…" : "Reorder" }}
        </button>
        <p v-if="reorderError" class="mt-2 w-full text-xs text-red-600">
          Failed to add items to cart. Please try again.
        </p>
      </div>
    </div>
  </div>
</template>
