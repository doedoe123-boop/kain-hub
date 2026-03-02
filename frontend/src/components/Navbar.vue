<script setup>
import { RouterLink, useRoute } from "vue-router";
import {
  ShoppingCartIcon,
  Bars3Icon,
  XMarkIcon,
  UserCircleIcon,
} from "@heroicons/vue/24/outline";
import { ref } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useCartStore } from "@/stores/cart";

const auth = useAuthStore();
const cart = useCartStore();
const route = useRoute();
const mobileOpen = ref(false);

const sectors = [
  { label: "Stores", to: "/stores" },
  { label: "Properties", to: "/properties" },
];

function isActive(path) {
  return route.path.startsWith(path);
}
</script>

<template>
  <header
    class="sticky top-0 z-40 border-b border-slate-200 bg-white shadow-sm"
  >
    <div
      class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6"
    >
      <!-- Logo -->
      <RouterLink to="/" class="flex shrink-0 items-center gap-2">
        <span
          class="flex size-8 items-center justify-center rounded-lg bg-brand-500 text-sm font-bold text-white"
        >
          N
        </span>
        <span class="hidden text-lg font-bold text-slate-900 sm:block"
          >NegosyoHub</span
        >
      </RouterLink>

      <!-- Desktop sector nav -->
      <nav class="hidden items-center gap-1 md:flex">
        <RouterLink
          v-for="sector in sectors"
          :key="sector.to"
          :to="sector.to"
          class="rounded-lg px-4 py-2 text-sm font-medium transition-colors"
          :class="
            isActive(sector.to)
              ? 'bg-brand-50 text-brand-600'
              : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'
          "
        >
          {{ sector.label }}
        </RouterLink>
      </nav>

      <!-- Right utilities -->
      <div class="flex items-center gap-2">
        <!-- Cart -->
        <button
          type="button"
          class="relative rounded-lg p-2 text-slate-600 hover:bg-slate-100 transition-colors"
          aria-label="Shopping cart"
          @click="cart.toggleDrawer"
        >
          <ShoppingCartIcon class="size-5" />
          <span
            v-if="cart.totalQuantity > 0"
            class="absolute -right-0.5 -top-0.5 flex size-4 items-center justify-center rounded-full bg-brand-500 text-[10px] font-bold text-white"
          >
            {{ cart.totalQuantity > 9 ? "9+" : cart.totalQuantity }}
          </span>
        </button>

        <!-- Guest -->
        <template v-if="!auth.isLoggedIn">
          <RouterLink
            to="/login"
            class="hidden text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors sm:block"
          >
            Sign in
          </RouterLink>
          <RouterLink
            to="/register"
            class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-600 transition-colors"
          >
            Register
          </RouterLink>
        </template>

        <!-- Logged in -->
        <template v-else>
          <RouterLink
            to="/account/orders"
            class="hidden items-center gap-1.5 text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors sm:flex"
          >
            <UserCircleIcon class="size-5" />
            Account
          </RouterLink>
          <button
            type="button"
            class="text-sm font-medium text-slate-400 hover:text-red-500 transition-colors"
            @click="auth.logout"
          >
            Sign out
          </button>
        </template>

        <!-- Mobile toggle -->
        <button
          type="button"
          class="rounded-lg p-2 text-slate-600 hover:bg-slate-100 transition-colors md:hidden"
          :aria-label="mobileOpen ? 'Close menu' : 'Open menu'"
          @click="mobileOpen = !mobileOpen"
        >
          <XMarkIcon v-if="mobileOpen" class="size-5" />
          <Bars3Icon v-else class="size-5" />
        </button>
      </div>
    </div>

    <!-- Mobile nav -->
    <nav
      v-if="mobileOpen"
      class="border-t border-slate-100 bg-white px-4 py-2 md:hidden"
    >
      <RouterLink
        v-for="sector in sectors"
        :key="sector.to"
        :to="sector.to"
        class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium transition-colors"
        :class="
          isActive(sector.to)
            ? 'bg-brand-50 text-brand-600'
            : 'text-slate-700 hover:bg-slate-50'
        "
        @click="mobileOpen = false"
      >
        {{ sector.label }}
      </RouterLink>

      <div class="mt-2 border-t border-slate-100 pt-2">
        <RouterLink
          v-if="auth.isLoggedIn"
          to="/account/orders"
          class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700"
          @click="mobileOpen = false"
        >
          My Account
        </RouterLink>
        <RouterLink
          v-else
          to="/login"
          class="flex items-center rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700"
          @click="mobileOpen = false"
        >
          Sign in
        </RouterLink>
      </div>
    </nav>
  </header>
</template>
