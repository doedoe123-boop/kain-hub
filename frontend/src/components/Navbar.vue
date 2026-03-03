<script setup>
import { RouterLink, useRoute } from "vue-router";
import {
  ShoppingCartIcon,
  Bars3Icon,
  XMarkIcon,
  UserCircleIcon,
  MagnifyingGlassIcon,
} from "@heroicons/vue/24/outline";
import { ref } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useCartStore } from "@/stores/cart";

const auth = useAuthStore();
const cart = useCartStore();
const route = useRoute();
const mobileOpen = ref(false);

const backendUrl = import.meta.env.VITE_API_BASE_URL ?? "http://localhost:8080";

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
    class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/95 shadow-sm backdrop-blur-md"
  >
    <div
      class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6"
    >
      <!-- Logo -->
      <RouterLink to="/" class="flex shrink-0 items-center gap-2.5 group">
        <span
          class="flex size-8 items-center justify-center rounded-lg bg-gradient-to-br from-brand-500 to-brand-700 text-sm font-bold text-white shadow-sm ring-1 ring-brand-600/20 group-hover:shadow-brand-500/30 group-hover:shadow-md transition-shadow"
        >
          N
        </span>
        <span class="hidden text-[1.05rem] font-bold tracking-tight text-slate-900 sm:block">
          Negosyo<span class="text-brand-500">Hub</span>
        </span>
      </RouterLink>

      <!-- Desktop sector nav -->
      <nav class="hidden flex-1 items-center gap-0.5 md:flex">
        <RouterLink
          v-for="sector in sectors"
          :key="sector.to"
          :to="sector.to"
          class="relative px-4 py-2 text-sm font-medium transition-colors"
          :class="
            isActive(sector.to)
              ? 'text-brand-600'
              : 'text-slate-600 hover:text-slate-900'
          "
        >
          {{ sector.label }}
          <span
            v-if="isActive(sector.to)"
            class="absolute inset-x-2 -bottom-px h-0.5 rounded-full bg-brand-500"
          />
        </RouterLink>

        <span class="mx-1 h-4 w-px bg-slate-200" />

        <a
          :href="`${backendUrl}/register/sector`"
          target="_blank"
          class="flex items-center gap-1 rounded-lg px-4 py-2 text-sm font-medium text-slate-500 transition-colors hover:bg-slate-50 hover:text-slate-900"
        >
          Sell with us
          <svg
            class="size-3 opacity-60"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2.5"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"
            />
          </svg>
        </a>
      </nav>

      <!-- Right utilities -->
      <div class="flex items-center gap-1.5">
        <!-- Inline search shortcut (desktop) -->
        <RouterLink
          to="/stores?focus=1"
          class="hidden items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-sm text-slate-400 transition-colors hover:border-slate-300 hover:bg-white hover:text-slate-600 md:flex"
          aria-label="Search stores"
        >
          <MagnifyingGlassIcon class="size-3.5 shrink-0" />
          <span class="text-xs">Search…</span>
          <kbd class="ml-1 hidden rounded border border-slate-200 bg-white px-1 py-0.5 text-[10px] text-slate-400 lg:inline">
            /
          </kbd>
        </RouterLink>

        <!-- Cart -->
        <button
          type="button"
          class="relative rounded-lg p-2 text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors"
          aria-label="Shopping cart"
          @click="cart.toggleDrawer"
        >
          <ShoppingCartIcon class="size-5" />
          <Transition
            enter-active-class="transition-all duration-200"
            enter-from-class="scale-50 opacity-0"
            enter-to-class="scale-100 opacity-100"
            leave-active-class="transition-all duration-150"
            leave-from-class="scale-100 opacity-100"
            leave-to-class="scale-50 opacity-0"
          >
            <span
              v-if="cart.totalQuantity > 0"
              class="absolute -right-0.5 -top-0.5 flex size-4 items-center justify-center rounded-full bg-brand-500 text-[10px] font-bold text-white ring-2 ring-white"
            >
              {{ cart.totalQuantity > 9 ? "9+" : cart.totalQuantity }}
            </span>
          </Transition>
        </button>

        <!-- Guest -->
        <template v-if="!auth.isLoggedIn">
          <RouterLink
            to="/login"
            class="hidden rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors sm:block"
          >
            Sign in
          </RouterLink>
          <RouterLink
            to="/register"
            class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-600 hover:shadow-brand-500/25 hover:shadow-md active:bg-brand-700 transition-all"
          >
            Register
          </RouterLink>
        </template>

        <!-- Logged in -->
        <template v-else>
          <RouterLink
            to="/account/orders"
            class="hidden items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors sm:flex"
          >
            <UserCircleIcon class="size-4.5" />
            Account
          </RouterLink>
          <button
            type="button"
            class="rounded-lg px-3 py-2 text-sm font-medium text-slate-400 hover:bg-red-50 hover:text-red-500 transition-colors"
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
    <Transition
      enter-active-class="transition-all duration-200 ease-out"
      enter-from-class="-translate-y-2 opacity-0"
      enter-to-class="translate-y-0 opacity-100"
      leave-active-class="transition-all duration-150 ease-in"
      leave-from-class="translate-y-0 opacity-100"
      leave-to-class="-translate-y-2 opacity-0"
    >
      <nav
        v-if="mobileOpen"
        class="border-t border-slate-100 bg-white px-4 py-2 md:hidden"
      >
        <RouterLink
          v-for="sector in sectors"
          :key="sector.to"
          :to="sector.to"
          class="flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition-colors"
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
            class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50"
            @click="mobileOpen = false"
          >
            <UserCircleIcon class="size-4" />
            My Account
          </RouterLink>
          <template v-else>
            <RouterLink
              to="/login"
              class="flex items-center rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50"
              @click="mobileOpen = false"
            >
              Sign in
            </RouterLink>
            <RouterLink
              to="/register"
              class="mt-1 flex items-center rounded-xl bg-brand-50 px-3 py-2.5 text-sm font-semibold text-brand-600 hover:bg-brand-100"
              @click="mobileOpen = false"
            >
              Create account
            </RouterLink>
          </template>
          <a
            :href="`${backendUrl}/register/sector`"
            target="_blank"
            class="mt-1 flex items-center gap-1.5 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-500 hover:bg-slate-50"
            @click="mobileOpen = false"
          >
            Sell with us
            <svg
              class="size-3.5 opacity-70"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2.5"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"
              />
            </svg>
          </a>
        </div>
      </nav>
    </Transition>
  </header>
</template>
