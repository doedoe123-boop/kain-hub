<script setup>
import { ref, computed, onMounted } from "vue";
import { useRoute, useRouter, RouterLink } from "vue-router";
import {
  CheckCircleIcon,
  XCircleIcon,
  ExclamationTriangleIcon,
} from "@heroicons/vue/24/solid";
import {
  ArrowPathIcon,
  ShoppingBagIcon,
  MapPinIcon,
  CreditCardIcon,
  BuildingStorefrontIcon,
} from "@heroicons/vue/24/outline";
import { ordersApi } from "@/api/orders";
import { cartApi } from "@/api/cart";

const route = useRoute();
const router = useRouter();
const order = ref(null);
const loading = ref(true);
const cancelling = ref(false);
const reordering = ref(false);
const reorderError = ref(false);
const showCancelModal = ref(false);

onMounted(async () => {
  try {
    const { data } = await ordersApi.show(route.params.id);
    order.value = data.order ?? data;
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
  pending: "bg-yellow-100 text-yellow-700 border-yellow-200",
  confirmed: "bg-blue-100 text-blue-700 border-blue-200",
  preparing: "bg-purple-100 text-purple-700 border-purple-200",
  ready: "bg-indigo-100 text-indigo-700 border-indigo-200",
  delivered: "bg-green-100 text-green-700 border-green-200",
  cancelled: "bg-red-100 text-red-700 border-red-200",
};

const paymentStatusColors = {
  pending: "bg-yellow-100 text-yellow-700",
  paid: "bg-green-100 text-green-700",
  failed: "bg-red-100 text-red-600",
  refunded: "bg-slate-100 text-slate-600",
};

const productLines = computed(() =>
  (order.value?.lines ?? []).filter((l) => l.type !== "shipping"),
);

const shippingLine = computed(() =>
  (order.value?.lines ?? []).find((l) => l.type === "shipping"),
);

const shippingAddress = computed(() => {
  const addrs = order.value?.addresses ?? [];
  return addrs.find((a) => a.type === "shipping") ?? addrs[0] ?? null;
});

function formatDate(dateStr) {
  if (!dateStr) return "";
  const d = new Date(dateStr);
  return d.toLocaleDateString("en-PH", {
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  });
}

async function cancelOrder() {
  cancelling.value = true;

  try {
    const { data } = await ordersApi.cancel(order.value.id);
    order.value = data.order ?? data;
  } finally {
    cancelling.value = false;
    showCancelModal.value = false;
  }
}

async function reorder() {
  reordering.value = true;
  reorderError.value = false;

  try {
    for (const line of productLines.value) {
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
      class="mb-5 inline-flex items-center gap-1.5 text-sm font-medium text-brand-600 transition-colors hover:text-brand-700"
    >
      ← My Orders
    </RouterLink>

    <!-- Skeleton loading -->
    <div v-if="loading" class="space-y-4">
      <div class="h-8 w-48 animate-pulse rounded-lg bg-slate-100" />
      <div class="h-28 animate-pulse rounded-2xl bg-slate-100" />
      <div class="h-48 animate-pulse rounded-2xl bg-slate-100" />
    </div>

    <div v-else-if="order">
      <!-- Header -->
      <div class="mb-6 flex flex-wrap items-start justify-between gap-3">
        <div>
          <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">
            Order #{{ order.id }}
          </h1>
          <p class="mt-1 text-sm text-slate-500">
            {{ formatDate(order.created_at) }}
          </p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
          <span
            class="rounded-full border px-3 py-1 text-xs font-semibold capitalize"
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
            Payment: {{ order.payment_status }}
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
                  'border-brand-500 bg-white ring-4 ring-brand-100':
                    stepState(i) === 'active',
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
                'font-bold text-brand-700': stepState(i) === 'active',
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
        <div>
          <p class="font-semibold">This order was cancelled</p>
          <p v-if="order.cancelled_at" class="mt-0.5 text-xs text-red-500">
            {{ formatDate(order.cancelled_at) }}
          </p>
        </div>
      </div>

      <!-- Store info -->
      <div
        v-if="order.store"
        class="mb-4 flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-5 py-3 shadow-sm"
      >
        <div
          class="flex size-9 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-600"
        >
          <BuildingStorefrontIcon class="size-5" />
        </div>
        <div class="min-w-0 flex-1">
          <p class="text-sm font-semibold text-slate-900">
            {{ order.store.name }}
          </p>
        </div>
      </div>

      <!-- Line items -->
      <div class="mb-4 rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div
          class="flex items-center gap-2 border-b border-slate-100 px-5 py-3"
        >
          <ShoppingBagIcon class="size-4 text-slate-400" />
          <h2 class="text-sm font-bold text-slate-900">
            Items ({{ productLines.length }})
          </h2>
        </div>
        <ul class="divide-y divide-slate-100">
          <li
            v-for="line in productLines"
            :key="line.id"
            class="flex items-center gap-4 px-5 py-4"
          >
            <div
              class="size-14 shrink-0 overflow-hidden rounded-lg border border-slate-100 bg-slate-50"
            >
              <img
                v-if="line.thumbnail"
                :src="line.thumbnail"
                :alt="line.description"
                class="size-full object-cover"
              />
              <div
                v-else
                class="flex size-full items-center justify-center text-slate-300"
              >
                <ShoppingBagIcon class="size-6" />
              </div>
            </div>
            <div class="min-w-0 flex-1">
              <p class="text-sm font-medium leading-snug text-slate-800">
                {{ line.description || "Item" }}
              </p>
              <p class="mt-0.5 text-xs text-slate-500">
                Qty: {{ line.quantity }}
                <span v-if="line.unit_price?.formatted">
                  &middot; {{ line.unit_price.formatted }} each
                </span>
              </p>
            </div>
            <span class="shrink-0 text-sm font-semibold text-slate-900">
              {{ line.sub_total?.formatted }}
            </span>
          </li>
          <li
            v-if="!productLines.length"
            class="px-5 py-6 text-center text-sm text-slate-400"
          >
            No item details available.
          </li>
        </ul>

        <!-- Price breakdown -->
        <div class="space-y-2 border-t border-slate-100 px-5 py-4 text-sm">
          <div
            v-if="order.sub_total"
            class="flex justify-between text-slate-600"
          >
            <span>Subtotal</span>
            <span>{{ order.sub_total.formatted }}</span>
          </div>
          <div v-if="shippingLine" class="flex justify-between text-slate-600">
            <span>{{ shippingLine.description }}</span>
            <span>{{
              shippingLine.total?.formatted ?? order.shipping_total?.formatted
            }}</span>
          </div>
          <div
            v-else-if="
              order.shipping_total &&
              order.shipping_total.value &&
              order.shipping_total.value > 0
            "
            class="flex justify-between text-slate-600"
          >
            <span>Shipping</span>
            <span>{{ order.shipping_total.formatted }}</span>
          </div>
          <div
            v-if="
              order.tax_total &&
              order.tax_total.value &&
              order.tax_total.value > 0
            "
            class="flex justify-between text-slate-600"
          >
            <span>Tax</span>
            <span>{{ order.tax_total.formatted }}</span>
          </div>
          <div
            class="flex justify-between border-t border-slate-100 pt-2 font-bold text-slate-900"
          >
            <span>Total</span>
            <span class="text-lg">{{ order.total?.formatted }}</span>
          </div>
        </div>
      </div>

      <!-- Shipping address -->
      <div
        v-if="shippingAddress"
        class="mb-4 rounded-2xl border border-slate-200 bg-white shadow-sm"
      >
        <div
          class="flex items-center gap-2 border-b border-slate-100 px-5 py-3"
        >
          <MapPinIcon class="size-4 text-slate-400" />
          <h2 class="text-sm font-bold text-slate-900">Delivery Address</h2>
        </div>
        <div class="px-5 py-4 text-sm text-slate-600">
          <p class="font-medium text-slate-800">
            {{ shippingAddress.first_name }}
            {{ shippingAddress.last_name }}
          </p>
          <p>{{ shippingAddress.line_one }}</p>
          <p v-if="shippingAddress.line_two">
            {{ shippingAddress.line_two }}
          </p>
          <p>
            {{ shippingAddress.city }},
            {{ shippingAddress.state }}
            {{ shippingAddress.postcode }}
          </p>
          <p v-if="shippingAddress.contact_phone" class="mt-1 text-slate-500">
            {{ shippingAddress.contact_phone }}
          </p>
        </div>
      </div>

      <!-- Payment info -->
      <div
        v-if="order.payment_status"
        class="mb-6 rounded-2xl border border-slate-200 bg-white shadow-sm"
      >
        <div
          class="flex items-center gap-2 border-b border-slate-100 px-5 py-3"
        >
          <CreditCardIcon class="size-4 text-slate-400" />
          <h2 class="text-sm font-bold text-slate-900">Payment</h2>
        </div>
        <div class="px-5 py-4 text-sm text-slate-600">
          <div class="flex items-center gap-2">
            <span class="font-medium capitalize text-slate-800">{{
              order.payment_status
            }}</span>
            <span v-if="order.paid_at" class="text-xs text-slate-400">
              &middot; {{ formatDate(order.paid_at) }}
            </span>
          </div>
          <p v-if="order.payment_intent_id" class="mt-1 text-xs text-slate-400">
            Ref: {{ order.payment_intent_id }}
          </p>
        </div>
      </div>

      <!-- Actions -->
      <div class="flex flex-wrap gap-3">
        <button
          v-if="order.status === 'pending'"
          class="rounded-xl border border-red-300 px-5 py-2.5 text-sm font-medium text-red-600 transition-colors hover:bg-red-50 disabled:opacity-60"
          @click="showCancelModal = true"
        >
          Cancel Order
        </button>

        <button
          v-if="order.lines?.length"
          class="flex items-center gap-2 rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-50 disabled:opacity-60"
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

    <!-- Cancel confirmation modal -->
    <Teleport to="body">
      <div
        v-if="showCancelModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
        @click.self="showCancelModal = false"
      >
        <div
          class="w-full max-w-sm rounded-2xl bg-white p-6 shadow-xl"
          @click.stop
        >
          <div class="mb-4 flex items-center gap-3">
            <div
              class="flex size-10 items-center justify-center rounded-full bg-red-100"
            >
              <ExclamationTriangleIcon class="size-5 text-red-600" />
            </div>
            <h3 class="text-lg font-bold text-slate-900">Cancel Order?</h3>
          </div>
          <p class="mb-6 text-sm text-slate-600">
            Are you sure you want to cancel
            <strong>Order #{{ order?.id }}</strong
            >? This action cannot be undone. If payment was already processed, a
            refund will be initiated.
          </p>
          <div class="flex justify-end gap-3">
            <button
              class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-50"
              @click="showCancelModal = false"
            >
              Keep Order
            </button>
            <button
              :disabled="cancelling"
              class="rounded-xl bg-red-600 px-4 py-2 text-sm font-bold text-white transition-colors hover:bg-red-700 disabled:opacity-60"
              @click="cancelOrder"
            >
              {{ cancelling ? "Cancelling…" : "Yes, Cancel Order" }}
            </button>
          </div>
        </div>
      </div>
    </Teleport>
  </div>
</template>
