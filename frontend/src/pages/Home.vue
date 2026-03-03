<script setup>
import { ref, onMounted } from "vue";
import { RouterLink } from "vue-router";
import {
  BuildingStorefrontIcon,
  HomeModernIcon,
  BriefcaseIcon,
} from "@heroicons/vue/24/outline";
import { storesApi } from "@/api/stores";
import { productsApi } from "@/api/products";
import { propertiesApi } from "@/api/properties";
import PhMapHero from "@/components/PhMapHero.vue";

const backendUrl = import.meta.env.VITE_API_BASE_URL ?? "http://localhost:8080";

const featuredStores = ref([]);
const featuredProducts = ref([]);
const latestProperties = ref([]);

const sectorLabels = {
  ecommerce: "E-Commerce",
  real_estate: "Real Estate",
  services: "Services",
};
const loading = ref(true);
const productsLoading = ref(true);
const propertiesLoading = ref(true);

const sectors = [
  {
    label: "E-Commerce",
    description: "Shop from local online stores & retailers",
    to: "/stores",
    icon: BuildingStorefrontIcon,
    color: "bg-brand-50 text-brand-600 ring-brand-200",
    badge: "bg-brand-100 text-brand-700",
  },
  {
    label: "Real Estate",
    description: "Houses, condos, and commercial spaces",
    to: "/properties",
    icon: HomeModernIcon,
    color: "bg-teal-50 text-teal-600 ring-teal-200",
    badge: "bg-teal-100 text-teal-700",
  },
  {
    label: "Services",
    description: "Coming soon — freelancers and professionals",
    to: null,
    icon: BriefcaseIcon,
    color: "bg-slate-50 text-slate-400 ring-slate-200",
    badge: "bg-slate-100 text-slate-500",
    soon: true,
  },
];

onMounted(async () => {
  try {
    const { data } = await storesApi.list({ per_page: 8, featured: true });
    featuredStores.value = data.data ?? data;
  } catch {
    featuredStores.value = [];
  } finally {
    loading.value = false;
  }

  try {
    const { data } = await productsApi.list({ per_page: 6 });
    featuredProducts.value = data.data ?? data;
  } catch {
    featuredProducts.value = [];
  } finally {
    productsLoading.value = false;
  }

  try {
    const { data } = await propertiesApi.list({ per_page: 4 });
    latestProperties.value = data.data ?? data;
  } catch {
    latestProperties.value = [];
  } finally {
    propertiesLoading.value = false;
  }
});
</script>

<template>
  <div>
    <!-- Hero -->
    <PhMapHero />

    <!-- ── Trust bar ─────────────────────────────────────────────────── -->
    <div class="border-b border-slate-100 bg-white">
      <div class="mx-auto max-w-7xl px-4 sm:px-6">
        <div class="grid grid-cols-2 divide-x divide-slate-100 sm:grid-cols-4">
          <div
            v-for="stat in [
              { value: '500+', label: 'Local Stores', icon: '🏪' },
              { value: '8', label: 'Cities Covered', icon: '📍' },
              { value: '3', label: 'Sectors', icon: '🏢' },
              { value: '100%', label: 'Philippine-made', icon: '🇵🇭' },
            ]"
            :key="stat.label"
            class="flex items-center justify-center gap-3 py-4"
          >
            <span class="text-xl leading-none">{{ stat.icon }}</span>
            <div>
              <p class="text-sm font-bold text-slate-900">{{ stat.value }}</p>
              <p class="text-xs text-slate-500">{{ stat.label }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Sector picker -->
    <section class="border-b border-slate-100 bg-white px-4 py-12 sm:px-6">
      <div class="mx-auto max-w-7xl">
        <div class="mb-7 text-center">
          <h2 class="text-2xl font-bold text-slate-900">What are you looking for?</h2>
          <p class="mt-1.5 text-sm text-slate-500">Browse our growing list of local sectors.</p>
        </div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
          <component
            :is="sector.soon ? 'div' : RouterLink"
            v-for="sector in sectors"
            :key="sector.label"
            :to="sector.soon ? undefined : sector.to"
            class="group relative flex items-start gap-4 rounded-2xl border p-5 transition-all"
            :class="
              sector.soon
                ? 'cursor-not-allowed bg-slate-50 opacity-60'
                : 'cursor-pointer bg-white shadow-sm hover:shadow-md hover:-translate-y-0.5'
            "
          >
            <span
              class="flex size-12 shrink-0 items-center justify-center rounded-xl ring-1 transition-transform group-hover:scale-105"
              :class="sector.color"
            >
              <component :is="sector.icon" class="size-6" />
            </span>
            <div class="min-w-0">
              <p class="flex items-center gap-2 font-semibold text-slate-800">
                {{ sector.label }}
                <span
                  v-if="sector.soon"
                  class="rounded-full px-2 py-0.5 text-xs font-medium"
                  :class="sector.badge"
                  >Coming Soon</span
                >
              </p>
              <p class="mt-0.5 text-sm text-slate-500 line-clamp-2">
                {{ sector.description }}
              </p>
            </div>
            <svg
              v-if="!sector.soon"
              class="absolute right-4 top-1/2 size-4 -translate-y-1/2 text-slate-300 transition-all group-hover:text-brand-400 group-hover:translate-x-0.5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" />
            </svg>
          </component>
        </div>
      </div>
    </section>

    <!-- Featured Products -->
    <section class="mx-auto max-w-7xl px-4 pt-12 pb-8 sm:px-6">
      <div class="mb-7 flex items-end justify-between">
        <div>
          <p class="mb-1 text-xs font-semibold uppercase tracking-widest text-brand-500">E-Commerce</p>
          <h2 class="text-2xl font-bold text-slate-900">Latest Products</h2>
          <p class="mt-1 text-sm text-slate-500">Shop from local stores across the Philippines.</p>
        </div>
        <RouterLink
          to="/stores"
          class="flex items-center gap-1 text-sm font-semibold text-brand-600 hover:text-brand-700 transition-colors"
        >
          Browse stores
          <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
          </svg>
        </RouterLink>
      </div>

      <!-- Skeleton -->
      <div
        v-if="productsLoading"
        class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4"
      >
        <div
          v-for="i in 8"
          :key="i"
          class="h-52 animate-pulse rounded-2xl bg-slate-100"
        />
      </div>

      <!-- Empty -->
      <div
        v-else-if="featuredProducts.length === 0"
        class="rounded-2xl border border-dashed border-slate-200 bg-white py-14 text-center"
      >
        <p class="text-2xl mb-2">🛍️</p>
        <p class="text-sm font-medium text-slate-500">No products yet — check back soon!</p>
      </div>

      <!-- Grid -->
      <div v-else class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
        <RouterLink
          v-for="product in featuredProducts"
          :key="product.id"
          :to="`/products/${product.id}`"
          class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all"
        >
          <div class="aspect-square overflow-hidden bg-slate-100">
            <img
              v-if="product.thumbnail"
              :src="product.thumbnail"
              :alt="product.name"
              class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
            />
            <div
              v-else
              class="flex h-full items-center justify-center bg-gradient-to-br from-brand-50 to-slate-100 text-4xl"
            >
              🛍️
            </div>
          </div>
          <div class="flex flex-1 flex-col p-3">
            <p class="line-clamp-2 text-sm font-medium leading-snug text-slate-700 group-hover:text-brand-600 transition-colors">
              {{ product.name }}
            </p>
            <p
              v-if="product.price"
              class="mt-auto pt-2 text-sm font-bold text-slate-900"
            >
              ₱{{ parseFloat(product.price).toLocaleString("en-PH", { maximumFractionDigits: 0 }) }}
            </p>
          </div>
        </RouterLink>
      </div>
    </section>

    <!-- Latest Properties -->
    <section class="bg-gradient-to-b from-teal-50/60 to-white py-12">
      <div class="mx-auto max-w-7xl px-4 sm:px-6">
        <div class="mb-7 flex items-end justify-between">
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-widest text-teal-600">Real Estate</p>
            <h2 class="text-2xl font-bold text-slate-900">Latest Properties</h2>
            <p class="mt-1 text-sm text-slate-500">Houses, condos, and commercial spaces for sale or rent.</p>
          </div>
          <RouterLink
            to="/properties"
            class="flex items-center gap-1 text-sm font-semibold text-teal-700 hover:text-teal-800 transition-colors"
          >
            View all
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
          </RouterLink>
        </div>

        <!-- Skeleton -->
        <div
          v-if="propertiesLoading"
          class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4"
        >
          <div
            v-for="i in 4"
            :key="i"
            class="h-64 animate-pulse rounded-2xl bg-teal-100/60"
          />
        </div>

        <!-- Empty -->
        <div
          v-else-if="latestProperties.length === 0"
          class="rounded-2xl border border-dashed border-teal-200 bg-white py-14 text-center"
        >
          <p class="text-2xl mb-2">🏡</p>
          <p class="text-sm font-medium text-slate-500">No listings yet — check back soon!</p>
        </div>

        <!-- Grid -->
        <div
          v-else
          class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4"
        >
          <RouterLink
            v-for="property in latestProperties"
            :key="property.id"
            :to="`/properties/${property.slug}`"
            class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all"
          >
            <div class="relative aspect-[16/9] overflow-hidden bg-slate-100">
              <img
                v-if="property.images && property.images[0]"
                :src="property.images[0]"
                :alt="property.title"
                class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
              />
              <div
                v-else
                class="flex h-full items-center justify-center bg-gradient-to-br from-teal-50 to-slate-100 text-4xl"
              >
                🏡
              </div>
              <span
                class="absolute left-2.5 top-2.5 rounded-full px-2.5 py-0.5 text-xs font-semibold shadow-sm"
                :class="{
                  'bg-emerald-100 text-emerald-700': property.listing_type === 'for_sale',
                  'bg-sky-100 text-sky-700': property.listing_type === 'for_rent',
                  'bg-amber-100 text-amber-700': property.listing_type === 'for_lease',
                  'bg-purple-100 text-purple-700': property.listing_type === 'pre_selling',
                  'bg-slate-100 text-slate-600': !['for_sale','for_rent','for_lease','pre_selling'].includes(property.listing_type),
                }"
              >
                {{
                  { for_sale: "For Sale", for_rent: "For Rent", for_lease: "For Lease", pre_selling: "Pre-Selling" }[property.listing_type] ?? property.listing_type
                }}
              </span>
            </div>
            <div class="p-4">
              <p class="line-clamp-2 font-semibold text-slate-800 group-hover:text-teal-700 transition-colors leading-snug">
                {{ property.title }}
              </p>
              <p class="mt-1 text-xs text-slate-400 flex items-center gap-1">
                <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
                {{ property.city }}
              </p>
              <p class="mt-2 text-base font-bold text-teal-700">
                ₱{{ parseFloat(property.price).toLocaleString("en-PH", { maximumFractionDigits: 0 }) }}
              </p>
            </div>
          </RouterLink>
        </div>
      </div>
    </section>

    <!-- Featured Stores -->
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6">
      <div class="mb-7 flex items-end justify-between">
        <div>
          <p class="mb-1 text-xs font-semibold uppercase tracking-widest text-brand-500">Discover</p>
          <h2 class="text-2xl font-bold text-slate-900">Featured Stores</h2>
          <p class="mt-1 text-sm text-slate-500">Handpicked local businesses worth visiting.</p>
        </div>
        <RouterLink
          to="/stores"
          class="flex items-center gap-1 text-sm font-semibold text-brand-600 hover:text-brand-700 transition-colors"
        >
          View all
          <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
          </svg>
        </RouterLink>
      </div>

      <!-- Skeleton -->
      <div
        v-if="loading"
        class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4"
      >
        <div
          v-for="i in 8"
          :key="i"
          class="h-44 animate-pulse rounded-2xl bg-slate-100"
        />
      </div>

      <!-- Empty -->
      <div
        v-else-if="featuredStores.length === 0"
        class="rounded-2xl border border-dashed border-slate-200 bg-white py-14 text-center"
      >
        <p class="text-2xl mb-2">🏪</p>
        <p class="text-sm font-medium text-slate-500">No featured stores yet — check back soon!</p>
      </div>

      <!-- Grid -->
      <div v-else class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
        <RouterLink
          v-for="store in featuredStores"
          :key="store.id"
          :to="`/stores/${store.slug}`"
          class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all"
        >
          <!-- Banner -->
          <div class="aspect-[3/2] w-full overflow-hidden bg-slate-100">
            <img
              v-if="store.banner_url"
              :src="store.banner_url"
              :alt="store.name"
              class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
            />
            <div
              v-else
              class="flex h-full items-center justify-center"
              :class="
                store.sector === 'real_estate'
                  ? 'bg-gradient-to-br from-teal-50 to-teal-100'
                  : 'bg-gradient-to-br from-brand-50 to-brand-100'
              "
            >
              <span class="text-3xl">{{ store.sector === "real_estate" ? "🏠" : "🛍️" }}</span>
            </div>
          </div>
          <!-- Info -->
          <div class="flex items-center gap-3 p-3">
            <img
              v-if="store.logo_url"
              :src="store.logo_url"
              :alt="store.name"
              class="size-10 shrink-0 rounded-xl bg-slate-100 object-cover ring-2 ring-white shadow-sm"
            />
            <div
              v-else
              class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-lg"
            >
              🏪
            </div>
            <div class="min-w-0">
              <p class="truncate text-sm font-semibold text-slate-800 group-hover:text-brand-600 transition-colors">
                {{ store.name }}
              </p>
              <p class="text-xs text-slate-400">{{ sectorLabels[store.sector] ?? store.sector }}</p>
            </div>
          </div>
        </RouterLink>
      </div>
    </section>

    <!-- ── CTA banner ─────────────────────────────────────────────────── -->
    <section class="bg-gradient-to-br from-slate-900 to-slate-800 py-14 text-white">
      <div class="mx-auto max-w-7xl px-4 text-center sm:px-6">
        <p class="mb-3 text-sm font-semibold uppercase tracking-widest text-brand-400">For Business Owners</p>
        <h2 class="text-3xl font-bold">Grow your business with NegosyoHub</h2>
        <p class="mx-auto mt-3 max-w-xl text-base text-slate-400">
          List your store, manage orders and products, and reach thousands of local customers — free to get started.
        </p>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
          <a
            :href="`${backendUrl}/register/sector`"
            target="_blank"
            class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-brand-600 hover:shadow-brand-500/30 hover:shadow-lg active:bg-brand-700 transition-all"
          >
            Register your store
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
          </a>
          <RouterLink
            to="/stores"
            class="inline-flex items-center gap-2 rounded-xl border border-slate-700 bg-white/5 px-6 py-3 text-sm font-semibold text-white hover:bg-white/10 transition-colors"
          >
            Browse stores
          </RouterLink>
        </div>
      </div>
    </section>
  </div>
</template>
