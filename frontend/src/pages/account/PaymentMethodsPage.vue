<script setup>
import { ref, onMounted } from "vue";
import {
  CreditCardIcon,
  PlusIcon,
  TrashIcon,
  CheckCircleIcon,
} from "@heroicons/vue/24/outline";
import { paymentMethodsApi } from "@/api/paymentMethods";

const methods = ref([]);
const loading = ref(true);
const deletingId = ref(null);

onMounted(fetchMethods);

async function fetchMethods() {
  loading.value = true;

  try {
    const { data } = await paymentMethodsApi.list();
    methods.value = data.data ?? data;
  } finally {
    loading.value = false;
  }
}

async function remove(id) {
  if (!confirm("Remove this payment method?")) {
    return;
  }

  deletingId.value = id;

  try {
    await paymentMethodsApi.destroy(id);
    methods.value = methods.value.filter((m) => m.id !== id);
  } finally {
    deletingId.value = null;
  }
}

async function setDefault(id) {
  await paymentMethodsApi.setDefault(id);
  await fetchMethods();
}

const brandLabel = {
  visa: "Visa",
  mastercard: "Mastercard",
  jcb: "JCB",
  amex: "Amex",
};

const brandColor = {
  visa: "text-blue-700",
  mastercard: "text-red-600",
  jcb: "text-green-700",
  amex: "text-teal-700",
};
</script>

<template>
  <div class="mx-auto max-w-2xl px-4 py-8 sm:px-0">
    <div class="mb-6 flex items-center justify-between">
      <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">
        Payment Methods
      </h1>
      <!-- Add card via PayMongo — redirect to checkout for now -->
      <p class="text-xs text-slate-400">Cards are saved during checkout</p>
    </div>

    <!-- Info banner -->
    <div
      class="mb-5 flex items-start gap-3 rounded-2xl border border-blue-100 bg-blue-50 p-4 text-sm text-blue-700"
    >
      <CreditCardIcon class="mt-0.5 size-5 shrink-0" />
      <p>
        Your saved cards are securely tokenised via PayMongo. We never store raw
        card numbers.
      </p>
    </div>

    <!-- Skeleton -->
    <div v-if="loading" class="space-y-3">
      <div
        v-for="i in 2"
        :key="i"
        class="h-20 animate-pulse rounded-2xl bg-slate-100"
      />
    </div>

    <!-- Empty -->
    <div
      v-else-if="methods.length === 0"
      class="rounded-2xl border border-dashed border-slate-200 bg-white py-14 text-center"
    >
      <CreditCardIcon class="mx-auto mb-3 size-10 text-slate-300" />
      <p class="font-medium text-slate-500">No saved payment methods</p>
      <p class="mt-1 text-sm text-slate-400">
        Cards saved during checkout will appear here.
      </p>
    </div>

    <!-- List -->
    <ul v-else class="space-y-3">
      <li
        v-for="method in methods"
        :key="method.id"
        class="flex items-center gap-4 rounded-2xl border bg-white p-5 shadow-sm transition-colors"
        :class="method.is_default ? 'border-brand-300' : 'border-slate-200'"
      >
        <!-- Brand icon placeholder -->
        <div
          class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-sm font-bold"
          :class="brandColor[method.brand] ?? 'text-slate-600'"
        >
          {{ brandLabel[method.brand] ?? method.brand?.toUpperCase() }}
        </div>

        <div class="min-w-0 flex-1">
          <div class="flex flex-wrap items-center gap-2">
            <p class="text-sm font-semibold text-slate-900">
              •••• {{ method.last4 }}
            </p>
            <span
              v-if="method.is_default"
              class="rounded-full bg-brand-100 px-2 py-0.5 text-xs font-medium text-brand-700"
              >Default</span
            >
          </div>
          <p class="text-xs text-slate-400">
            Expires {{ method.exp_month }}/{{ method.exp_year }}
          </p>
        </div>

        <!-- Actions -->
        <div class="flex shrink-0 items-center gap-1">
          <button
            v-if="!method.is_default"
            class="flex items-center gap-1 rounded-lg px-3 py-1.5 text-xs font-medium text-slate-500 transition-colors hover:bg-slate-100 hover:text-slate-700"
            @click="setDefault(method.id)"
          >
            <CheckCircleIcon class="size-3.5" />
            Set default
          </button>
          <button
            class="rounded-lg p-1.5 text-slate-400 transition-colors hover:bg-red-50 hover:text-red-500"
            :disabled="deletingId === method.id"
            @click="remove(method.id)"
          >
            <TrashIcon class="size-4" />
          </button>
        </div>
      </li>
    </ul>
  </div>
</template>
