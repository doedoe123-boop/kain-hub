<script setup>
import { RouterLink } from "vue-router";
import { TrashIcon, ShoppingBagIcon } from "@heroicons/vue/24/outline";
import { useCartStore } from "@/stores/cart";
import { onMounted } from "vue";

const cart = useCartStore();
onMounted(() => cart.fetch());
</script>

<template>
  <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6">
    <!-- Heading -->
    <div class="mb-8">
      <h1 class="text-2xl font-bold text-slate-900">Shopping Cart</h1>
      <p v-if="cart.lineCount > 0" class="mt-1 text-sm text-slate-500">
        {{ cart.totalQuantity }} item{{ cart.totalQuantity !== 1 ? "s" : "" }} in your cart
      </p>
    </div>

    <!-- Empty state -->
    <div v-if="cart.lineCount === 0" class="rounded-2xl border border-dashed border-slate-300 bg-white py-20 text-center">
      <div class="mx-auto mb-4 flex size-14 items-center justify-center rounded-full bg-slate-100">
        <ShoppingBagIcon class="size-7 text-slate-400" />
      </div>
      <p class="font-medium text-slate-600">Your cart is empty</p>
      <p class="mt-1 text-sm text-slate-400">Browse stores and add items to get started.</p>
      <RouterLink
        to="/stores"
        class="mt-5 inline-flex items-center gap-1.5 rounded-xl bg-brand-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-brand-600 transition-colors"
      >
        Browse stores →
      </RouterLink>
    </div>

    <div v-else class="grid gap-5 lg:grid-cols-3">
      <!-- Line items -->
      <div class="lg:col-span-2">
        <ul class="divide-y divide-slate-100 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
          <li
            v-for="line in cart.cart?.lines"
            :key="line.id"
            class="flex gap-4 p-4"
          >
            <div class="size-20 shrink-0 overflow-hidden rounded-xl bg-slate-100">
              <img
                :src="line.purchasable?.thumbnail ?? '/placeholder.png'"
                class="size-full object-cover"
              />
            </div>
            <div class="flex flex-1 flex-col justify-between min-w-0">
              <p class="font-medium text-slate-800 line-clamp-2">
                {{ line.purchasable?.name }}
              </p>
              <div class="flex items-center justify-between mt-2">
                <!-- Qty controls -->
                <div class="flex items-center gap-1 rounded-lg border border-slate-200 bg-slate-50 p-0.5">
                  <button
                    type="button"
                    class="flex size-7 items-center justify-center rounded-md text-slate-600 hover:bg-white hover:text-slate-900 disabled:opacity-40 transition-colors"
                    @click="cart.updateItem(line.id, line.quantity - 1)"
                    :disabled="line.quantity <= 1"
                  >
                    −
                  </button>
                  <span class="w-6 text-center text-sm font-semibold text-slate-700">
                    {{ line.quantity }}
                  </span>
                  <button
                    type="button"
                    class="flex size-7 items-center justify-center rounded-md text-slate-600 hover:bg-white hover:text-slate-900 transition-colors"
                    @click="cart.updateItem(line.id, line.quantity + 1)"
                  >
                    +
                  </button>
                </div>
                <div class="flex items-center gap-3">
                  <span class="font-bold text-slate-900">{{ line.sub_total?.formatted }}</span>
                  <button
                    type="button"
                    class="rounded-lg p-1.5 text-slate-400 hover:bg-red-50 hover:text-red-500 transition-colors"
                    @click="cart.removeItem(line.id)"
                  >
                    <TrashIcon class="size-4" />
                  </button>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>

      <!-- Order summary -->
      <div class="lg:col-span-1">
        <div class="sticky top-24 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
          <h2 class="mb-4 text-base font-semibold text-slate-900">Order summary</h2>
          <div class="space-y-2 text-sm text-slate-600">
            <div class="flex justify-between">
              <span>Subtotal</span>
              <span class="font-medium text-slate-900">{{ cart.total }}</span>
            </div>
            <div class="flex justify-between">
              <span>Delivery</span>
              <span class="text-slate-400">Calculated at checkout</span>
            </div>
          </div>
          <div class="my-4 border-t border-slate-100" />
          <div class="flex justify-between text-base font-bold text-slate-900">
            <span>Total</span>
            <span>{{ cart.total }}</span>
          </div>
          <RouterLink
            to="/checkout"
            class="mt-4 flex w-full items-center justify-center gap-2 rounded-xl bg-brand-500 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-brand-600 hover:shadow-brand-500/25 hover:shadow-md active:bg-brand-700 transition-all"
          >
            Proceed to Checkout
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
          </RouterLink>
          <p class="mt-3 text-center text-xs text-slate-400">
            Taxes and delivery calculated at checkout
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
