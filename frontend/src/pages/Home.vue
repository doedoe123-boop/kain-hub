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
import DicedHeroSection from "@/components/DicedHeroSection.vue";
import CategoryStrip from "@/components/CategoryStrip.vue";

const backendUrl = import.meta.env.VITE_API_BASE_URL ?? "http://localhost:8080";

const featuredStores     = ref([]);
const featuredProducts   = ref([]);
const latestProperties   = ref([]);
const loading            = ref(true);
const productsLoading    = ref(true);
const propertiesLoading  = ref(true);

const sectorLabels = {
  ecommerce:   "E-Commerce",
  real_estate: "Real Estate",
  services:    "Services",
};

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
    color: "bg-emerald-50 text-emerald-600 ring-emerald-200",
    badge: "bg-emerald-100 text-emerald-700",
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

// Category icon row data
const categoryIcons = [
  { label: "Electronics",   icon: "📱", to: "/stores?category=electronics" },
  { label: "Fashion",       icon: "👗", to: "/stores?category=fashion" },
  { label: "Home & Living", icon: "🛋️", to: "/stores?category=home" },
  { label: "Food",          icon: "🛒", to: "/stores?category=food" },
  { label: "Gadgets",       icon: "💻", to: "/stores?category=gadgets" },
  { label: "Beauty",        icon: "💄", to: "/stores?category=beauty" },
  { label: "Sports",        icon: "⚽", to: "/stores?category=sports" },
  { label: "Properties",    icon: "🏡", to: "/properties"             },
  { label: "Services",      icon: "🔧", to: "/stores?category=services" },
];

// Discount helper — works if product has compare_at_price field
function discount(product) {
  const orig = parseFloat(product.compare_at_price ?? product.original_price ?? 0);
  const curr = parseFloat(product.price ?? 0);
  if (!orig || !curr || orig <= curr) return null;
  return {
    pct: Math.round((1 - curr / orig) * 100),
    save: Math.round(orig - curr),
    original: orig,
  };
}

function peso(val) {
  return "₱" + parseFloat(val ?? 0).toLocaleString("en-PH", { maximumFractionDigits: 0 });
}

// Spotlight uses first 3 stores; assign each a visual theme
const spotlightThemes = [
  { bg: "#0F2044", accent: "#059669", label: "Top Pick"   },
  { bg: "#059669", accent: "#0F2044", label: "Featured"   },
  { bg: "#1a1a2e", accent: "#f95d2f", label: "Trending"   },
];

const listingLabel = {
  for_sale:    "For Sale",
  for_rent:    "For Rent",
  for_lease:   "For Lease",
  pre_selling: "Pre-Selling",
};
const listingBadgeClass = {
  for_sale:    "bg-emerald-100 text-emerald-700",
  for_rent:    "bg-sky-100 text-sky-700",
  for_lease:   "bg-amber-100 text-amber-700",
  pre_selling: "bg-purple-100 text-purple-700",
};

onMounted(async () => {
  try {
    const { data } = await storesApi.list({ per_page: 8, featured: true });
    featuredStores.value = data.data ?? data;
  } catch { featuredStores.value = []; }
  finally { loading.value = false; }

  try {
    const { data } = await productsApi.list({ per_page: 8 });
    featuredProducts.value = data.data ?? data;
  } catch { featuredProducts.value = []; }
  finally { productsLoading.value = false; }

  try {
    const { data } = await propertiesApi.list({ per_page: 4 });
    latestProperties.value = data.data ?? data;
  } catch { latestProperties.value = []; }
  finally { propertiesLoading.value = false; }
});
</script>

<template>
  <div>

    <!-- ── Diced Hero ──────────────────────────────────────────────────── -->
    <div style="background: #0F2044;">
      <DicedHeroSection
        top-text="The Philippine Marketplace"
        main-text="Shop. Invest. Discover."
        sub-main-text="Find everything from local online stores and fresh products to prime real estate — all in one trusted, Filipino-built platform."
        button-text="Explore Now"
        :slides="[
          { title: 'Local Shopping',  image: 'https://images.unsplash.com/photo-1555529669-e69e7aa0ba9a?w=800&auto=format&fit=crop' },
          { title: 'Real Estate',     image: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&auto=format&fit=crop' },
          { title: 'Fresh Products',  image: 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=800&auto=format&fit=crop' },
          { title: 'Marketplace',     image: 'https://images.unsplash.com/photo-1506484381205-f7945653044d?w=800&auto=format&fit=crop' },
        ]"
        :on-main-button-click="() => $router.push('/stores')"
        :on-grid-image-click="(i) => $router.push(i > 1 ? '/properties' : '/stores')"
        background-color="transparent"
      />
    </div>

    <!-- ── Category strip ─────────────────────────────────────────────── -->
    <CategoryStrip />

    <!-- ── Sector picker ──────────────────────────────────────────────── -->
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
                >Coming Soon</span>
              </p>
              <p class="mt-0.5 text-sm text-slate-500 line-clamp-2">{{ sector.description }}</p>
            </div>
            <svg
              v-if="!sector.soon"
              class="absolute right-4 top-1/2 size-4 -translate-y-1/2 text-slate-300 transition-all group-hover:text-emerald-400 group-hover:translate-x-0.5"
              fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
            >
              <path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" />
            </svg>
          </component>
        </div>
      </div>
    </section>

    <!-- ── Featured Products ───────────────────────────────────────────── -->
    <section class="mx-auto max-w-7xl px-4 pt-12 pb-8 sm:px-6">
      <!-- Header -->
      <div class="mb-6 flex items-end justify-between">
        <div>
          <p class="mb-1 text-xs font-semibold uppercase tracking-widest text-brand-500">E-Commerce</p>
          <h2 class="text-2xl font-bold text-slate-900">Latest Products</h2>
          <p class="mt-1 text-sm text-slate-500">Shop from local stores across the Philippines.</p>
        </div>
        <RouterLink
          to="/stores"
          class="flex items-center gap-1 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors"
        >
          View All
          <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
          </svg>
        </RouterLink>
      </div>

      <!-- Skeleton -->
      <div v-if="productsLoading" class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
        <div v-for="i in 8" :key="i" class="animate-pulse rounded-2xl bg-white shadow-sm ring-1 ring-slate-100">
          <div class="aspect-square rounded-t-2xl bg-slate-100" />
          <div class="p-3 space-y-2">
            <div class="h-4 w-3/4 rounded bg-slate-100" />
            <div class="h-4 w-1/2 rounded bg-slate-200" />
            <div class="h-3 w-1/3 rounded bg-slate-100" />
          </div>
        </div>
      </div>

      <!-- Empty -->
      <div v-else-if="featuredProducts.length === 0" class="rounded-2xl border border-dashed border-slate-200 bg-white py-14 text-center">
        <p class="text-2xl mb-2">🛍️</p>
        <p class="text-sm font-medium text-slate-500">No products yet — check back soon!</p>
      </div>

      <!-- UPGRADED Product Grid -->
      <div v-else class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
        <RouterLink
          v-for="product in featuredProducts"
          :key="product.id"
          :to="`/products/${product.id}`"
          class="group relative flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all hover:-translate-y-0.5 hover:border-emerald-200 hover:shadow-md"
        >
          <!-- Image area -->
          <div class="relative aspect-square overflow-hidden bg-white">
            <img
              v-if="product.thumbnail"
              :src="product.thumbnail"
              :alt="product.name"
              class="h-full w-full object-contain p-2 transition-transform duration-300 group-hover:scale-105"
            />
            <div v-else class="flex h-full items-center justify-center bg-gradient-to-br from-brand-50 to-slate-100 text-4xl">🛍️</div>

            <!-- Discount badge -->
            <span
              v-if="discount(product)"
              class="absolute right-2 top-2 rounded-lg bg-brand-500 px-2 py-0.5 text-[10px] font-bold text-white shadow-sm"
            >
              {{ discount(product).pct }}% OFF
            </span>
          </div>

          <!-- Info -->
          <div class="flex flex-1 flex-col p-3">
            <p class="line-clamp-2 text-sm font-medium leading-snug text-slate-700 transition-colors group-hover:text-emerald-700">
              {{ product.name }}
            </p>
            <div class="mt-auto pt-2">
              <!-- Current price -->
              <p class="text-sm font-bold text-slate-900">{{ peso(product.price) }}</p>
              <!-- Original + savings (conditional) -->
              <template v-if="discount(product)">
                <p class="text-xs text-slate-400 line-through">{{ peso(discount(product).original) }}</p>
                <p class="text-xs font-semibold text-emerald-600">Save {{ peso(discount(product).save) }}</p>
              </template>
            </div>
          </div>
        </RouterLink>
      </div>
    </section>

    <!-- ── Store Spotlight (3-col branded banners) ─────────────────────── -->
    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6">
      <div class="mb-5 flex items-end justify-between">
        <div>
          <p class="mb-1 text-xs font-semibold uppercase tracking-widest text-emerald-600">Discover</p>
          <h2 class="text-2xl font-bold text-slate-900">Featured Stores</h2>
        </div>
        <RouterLink to="/stores" class="flex items-center gap-1 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
          View All
          <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
          </svg>
        </RouterLink>
      </div>

      <!-- Spotlight cards (top 3 stores) -->
      <div v-if="loading" class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div v-for="i in 3" :key="i" class="h-36 animate-pulse rounded-2xl bg-slate-100" />
      </div>

      <div v-else-if="featuredStores.length > 0" class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-6">
        <RouterLink
          v-for="(store, i) in featuredStores.slice(0, 3)"
          :key="store.id"
          :to="`/stores/${store.slug}`"
          class="group relative flex h-36 overflow-hidden rounded-2xl shadow-sm transition-all hover:shadow-lg hover:-translate-y-0.5"
          :style="{ background: spotlightThemes[i].bg }"
        >
          <!-- BG image overlay -->
          <img
            v-if="store.banner_url"
            :src="store.banner_url"
            :alt="store.name"
            class="absolute inset-0 h-full w-full object-cover opacity-20 transition-opacity group-hover:opacity-30"
          />
          <!-- Content -->
          <div class="relative z-10 flex h-full w-full flex-col justify-between p-4">
            <div class="flex items-start justify-between">
              <!-- Store logo bubble -->
              <div class="flex size-10 items-center justify-center overflow-hidden rounded-xl bg-white/10 ring-1 ring-white/20 text-xl">
                <img v-if="store.logo_url" :src="store.logo_url" :alt="store.name" class="h-full w-full object-cover" />
                <span v-else>🏪</span>
              </div>
              <!-- Badge -->
              <span
                class="rounded-full px-2.5 py-0.5 text-[10px] font-bold text-white"
                :style="{ background: spotlightThemes[i].accent }"
              >{{ spotlightThemes[i].label }}</span>
            </div>
            <div>
              <p class="text-sm font-bold text-white line-clamp-1">{{ store.name }}</p>
              <p class="mt-0.5 text-xs text-white/60">{{ sectorLabels[store.sector] ?? 'Local Store' }}</p>
              <p
                class="mt-2 inline-flex items-center gap-1 text-xs font-bold text-white/90 transition-all group-hover:gap-2"
              >
                Visit Store →
              </p>
            </div>
          </div>
        </RouterLink>
      </div>

      <!-- Regular store grid (rest of stores) -->
      <div v-if="!loading && featuredStores.length > 3" class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
        <RouterLink
          v-for="store in featuredStores.slice(3)"
          :key="store.id"
          :to="`/stores/${store.slug}`"
          class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all"
        >
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
              :class="store.sector === 'real_estate' ? 'bg-gradient-to-br from-slate-100 to-slate-200' : 'bg-gradient-to-br from-brand-50 to-brand-100'"
            >
              <span class="text-3xl">{{ store.sector === "real_estate" ? "🏠" : "🛍️" }}</span>
            </div>
          </div>
          <div class="flex items-center gap-3 p-3">
            <img
              v-if="store.logo_url"
              :src="store.logo_url" :alt="store.name"
              class="size-10 shrink-0 rounded-xl bg-slate-100 object-cover ring-2 ring-white shadow-sm"
            />
            <div v-else class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-lg">🏪</div>
            <div class="min-w-0">
              <p class="truncate text-sm font-semibold text-slate-800 group-hover:text-emerald-700 transition-colors">{{ store.name }}</p>
              <p class="text-xs text-slate-400">{{ sectorLabels[store.sector] ?? store.sector }}</p>
            </div>
          </div>
        </RouterLink>
      </div>

      <!-- All stores skeleton / empty -->
      <div v-else-if="loading" class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
        <div v-for="i in 4" :key="i" class="h-44 animate-pulse rounded-2xl bg-slate-100" />
      </div>
      <div v-else-if="featuredStores.length === 0" class="rounded-2xl border border-dashed border-slate-200 bg-white py-14 text-center">
        <p class="text-2xl mb-2">🏪</p>
        <p class="text-sm font-medium text-slate-500">No featured stores yet — check back soon!</p>
      </div>
    </section>

    <!-- ── Latest Properties ────────────────────────────────────────────── -->
    <section class="bg-gradient-to-b from-slate-50 to-white py-12">
      <div class="mx-auto max-w-7xl px-4 sm:px-6">
        <div class="mb-7 flex items-end justify-between">
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-widest text-emerald-600">Real Estate</p>
            <h2 class="text-2xl font-bold text-slate-900">Latest Properties</h2>
            <p class="mt-1 text-sm text-slate-500">Houses, condos, and commercial spaces for sale or rent.</p>
          </div>
          <RouterLink
            to="/properties"
            class="flex items-center gap-1 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors"
          >
            View All
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
          </RouterLink>
        </div>

        <!-- Skeleton -->
        <div v-if="propertiesLoading" class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
          <div v-for="i in 4" :key="i" class="animate-pulse rounded-2xl bg-white shadow-sm ring-1 ring-slate-100">
            <div class="aspect-[16/9] rounded-t-2xl bg-slate-100" />
            <div class="p-4 space-y-2">
              <div class="h-4 w-3/4 rounded bg-slate-100" />
              <div class="h-3 w-1/2 rounded bg-slate-100" />
              <div class="h-5 w-1/3 rounded bg-slate-200" />
            </div>
          </div>
        </div>

        <!-- Empty -->
        <div v-else-if="latestProperties.length === 0" class="rounded-2xl border border-dashed border-slate-200 bg-white py-14 text-center">
          <p class="text-2xl mb-2">🏡</p>
          <p class="text-sm font-medium text-slate-500">No listings yet — check back soon!</p>
        </div>

        <!-- Grid -->
        <div v-else class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
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
              <div v-else class="flex h-full items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-4xl">🏡</div>
              <!-- Listing badge -->
              <span
                class="absolute left-2.5 top-2.5 rounded-full px-2.5 py-0.5 text-xs font-semibold shadow-sm"
                :class="listingBadgeClass[property.listing_type] ?? 'bg-slate-100 text-slate-600'"
              >
                {{ listingLabel[property.listing_type] ?? property.listing_type }}
              </span>
            </div>
            <div class="p-4">
              <p class="line-clamp-2 font-semibold text-slate-800 group-hover:text-emerald-700 transition-colors leading-snug">
                {{ property.title }}
              </p>
              <p class="mt-1 flex items-center gap-1 text-xs text-slate-400">
                <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
                {{ property.city }}
              </p>
              <p class="mt-2 text-base font-bold text-brand-500">
                {{ peso(property.price) }}
              </p>
            </div>
          </RouterLink>
        </div>
      </div>
    </section>

    <!-- ── Seller CTA banner ────────────────────────────────────────────── -->
    <section style="background: #0F2044;" class="py-14 text-white">
      <div class="mx-auto max-w-7xl px-4 text-center sm:px-6">
        <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-emerald-400">For Business Owners</p>
        <h2 class="text-3xl font-bold">Grow your business with NegosyoHub</h2>
        <p class="mx-auto mt-3 max-w-xl text-base text-white/60">
          List your store, manage orders and products, and reach thousands of local customers — free to get started.
        </p>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
          <a
            :href="`${backendUrl}/register/sector`"
            target="_blank"
            class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 hover:shadow-emerald-500/30 hover:shadow-lg active:bg-emerald-700 transition-all"
          >
            Register your store
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
          </a>
          <RouterLink
            to="/stores"
            class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/5 px-6 py-3 text-sm font-semibold text-white hover:bg-white/10 transition-colors"
          >
            Browse stores
          </RouterLink>
        </div>
      </div>
    </section>

  </div>
</template>

<style scoped>
.scrollbar-none::-webkit-scrollbar { display: none; }
.scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
</style>
