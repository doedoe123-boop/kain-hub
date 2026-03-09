<script setup>
import { ref, onMounted } from "vue";
import { RouterLink, useRoute } from "vue-router";
import { CheckCircleIcon } from "@heroicons/vue/24/solid";
import { useCartStore } from "@/stores/cart";
import { paypalApi } from "@/api/paypal";

const route = useRoute();
const cart = useCartStore();

const orderId = ref(route.query.order ?? null);
const status = ref(orderId.value ? "success" : "loading"); // loading | success | error
const errorMessage = ref(null);

onMounted(async () => {
  // PayPal redirects back with ?token=<paypal_order_id>&PayerID=<payer_id>
  const paypalOrderId = route.query.token;

  if (!paypalOrderId) {
    // Not a PayPal return — already have an order ID from direct placement
    if (!orderId.value) {
      status.value = "error";
      errorMessage.value = "Missing order information.";
    }
    return;
  }

  // Capture the PayPal payment and create the order
  status.value = "loading";
  try {
    const storeId =
      cart.storeId ?? Number(sessionStorage.getItem("paypal_store_id"));
    const { data } = await paypalApi.captureOrder(paypalOrderId, storeId);

    orderId.value = data.order_id;
    status.value = "success";

    // Clean up
    sessionStorage.removeItem("paypal_store_id");
    cart.reset();
  } catch (e) {
    status.value = "error";
    errorMessage.value =
      e.response?.data?.message ??
      "Payment capture failed. Please contact support.";
  }
});
</script>

<template>
  <div class="flex flex-col items-center justify-center py-20 text-center">
    <!-- Loading state while capturing PayPal payment -->
    <template v-if="status === 'loading'">
      <div
        class="mb-4 size-16 animate-spin rounded-full border-4 border-brand-200 border-t-brand-500"
      />
      <h1 class="text-2xl font-bold text-gray-900">Processing Payment...</h1>
      <p class="mt-2 text-gray-500">
        Please wait while we confirm your payment with PayPal.
      </p>
    </template>

    <!-- Success state -->
    <template v-else-if="status === 'success'">
      <CheckCircleIcon class="mb-4 size-16 text-green-500" />
      <h1 class="text-3xl font-bold text-gray-900">Order Confirmed!</h1>
      <p class="mt-2 text-gray-500">
        Thank you for your purchase. We'll notify you when it ships.
      </p>
      <p v-if="orderId" class="mt-1 text-sm text-gray-400">
        Order #{{ orderId }}
      </p>
      <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:gap-4">
        <RouterLink
          to="/account/orders"
          class="rounded-xl bg-brand-500 px-6 py-3 text-sm font-semibold text-white hover:bg-brand-600 transition-colors"
        >
          View My Orders
        </RouterLink>
        <RouterLink
          to="/stores"
          class="rounded-xl border px-6 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors"
        >
          Continue Shopping
        </RouterLink>
      </div>
    </template>

    <!-- Error state -->
    <template v-else-if="status === 'error'">
      <div
        class="mb-4 flex size-16 items-center justify-center rounded-full bg-red-100"
      >
        <span class="text-3xl text-red-500">!</span>
      </div>
      <h1 class="text-2xl font-bold text-gray-900">Payment Failed</h1>
      <p class="mt-2 text-gray-500">{{ errorMessage }}</p>
      <div class="mt-8">
        <RouterLink
          to="/checkout"
          class="rounded-xl bg-brand-500 px-6 py-3 text-sm font-semibold text-white hover:bg-brand-600 transition-colors"
        >
          Try Again
        </RouterLink>
      </div>
    </template>
  </div>
</template>
