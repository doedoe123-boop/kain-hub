<script setup>
import { ref, onMounted, watch } from "vue";
import { RouterLink, useRoute, useRouter } from "vue-router";
import {
  MagnifyingGlassIcon,
  FunnelIcon,
  HomeModernIcon,
} from "@heroicons/vue/24/outline";
import { propertiesApi } from "@/api/properties";

const route = useRoute();
const router = useRouter();

const properties = ref([]);
const meta = ref({});
const loading = ref(true);

const filters = ref({
  search: route.query.search ?? "",
  type: route.query.type ?? "",
  listing_type: route.query.listing_type ?? "",
  min_price: route.query.min_price ?? "",
  max_price: route.query.max_price ?? "",
  bedrooms: route.query.bedrooms ?? "",
  city: route.query.city ?? "",
});

const propertyTypes = [
  { label: "All Types", value: "" },
  { label: "House & Lot", value: "house" },
  { label: "Condominium", value: "condo" },
  { label: "Apartment", value: "apartment" },
  { label: "Townhouse", value: "townhouse" },
  { label: "Commercial Space", value: "commercial" },
  { label: "Vacant Lot", value: "lot" },
  { label: "Warehouse", value: "warehouse" },
  { label: "Farm / Agricultural", value: "farm" },
];

const listingTypes = [
  { label: "All Listings", value: "" },
  { label: "For Sale", value: "for_sale" },
  { label: "For Rent", value: "for_rent" },
  { label: "For Lease", value: "for_lease" },
  { label: "Pre-Selling", value: "pre_selling" },
];

const listingBadgeClass = {
  for_sale: "bg-emerald-100 text-emerald-700",
  for_rent: "bg-sky-100 text-sky-700",
  for_lease: "bg-amber-100 text-amber-700",
  pre_selling: "bg-purple-100 text-purple-700",
};

const listingLabel = {
  for_sale: "For Sale",
  for_rent: "For Rent",
  for_lease: "For Lease",
  pre_selling: "Pre-Selling",
};

function formatPrice(price, currency = "PHP", period = null) {
  const formatted = parseFloat(price).toLocaleString("en-PH", {
    style: "currency",
    currency: currency || "PHP",
    maximumFractionDigits: 0,
  });
  return period ? `${formatted}/${period.replace("_", " ")}` : formatted;
}

async function load(page = 1) {
  loading.value = true;
  try {
    const { data } = await propertiesApi.list({
      ...Object.fromEntries(
        Object.entries(filters.value).filter(([, v]) => v !== ""),
      ),
      page,
    });
    properties.value = data.data ?? data;
    meta.value = data.meta ?? {};
  } finally {
    loading.value = false;
  }
}

function onSearch() {
  router.replace({
    query: Object.fromEntries(
      Object.entries(filters.value).filter(([, v]) => v !== ""),
    ),
  });
  load();
}

function resetFilters() {
  filters.value = {
    search: "",
    type: "",
    listing_type: "",
    min_price: "",
    max_price: "",
    bedrooms: "",
    city: "",
  };
  router.replace({ query: {} });
  load();
}

onMounted(() => load());
watch(
  () => route.query,
  () => load(),
);
</script>

<template>
  <div>
    <!-- Page header -->
    <div class="bg-gradient-to-br from-teal-600 to-teal-800 py-12 text-white">
      <div class="mx-auto max-w-7xl px-4 sm:px-6">
        <RouterLink
          to="/"
          class="mb-4 inline-flex items-center gap-1 text-sm text-teal-200 hover:text-white transition-colors"
        >
          ← Home
        </RouterLink>
        <h1 class="text-3xl font-bold">Browse Properties</h1>
        <p class="mt-1 text-teal-100">
          Find your next home, investment, or commercial space.
        </p>
      </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6">
      <!-- Filters -->
      <form
        class="mb-8 rounded-2xl border bg-white p-4 shadow-sm"
        @submit.prevent="onSearch"
      >
        <div class="relative mb-3">
          <MagnifyingGlassIcon
            class="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-slate-400"
          />
          <input
            v-model="filters.search"
            type="search"
            placeholder="Search by title, city, or address…"
            class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-9 pr-4 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-400"
          />
        </div>

        <div class="flex flex-wrap gap-2">
          <select
            v-model="filters.type"
            class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-400"
          >
            <option v-for="t in propertyTypes" :key="t.value" :value="t.value">
              {{ t.label }}
            </option>
          </select>

          <select
            v-model="filters.listing_type"
            class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-400"
          >
            <option v-for="l in listingTypes" :key="l.value" :value="l.value">
              {{ l.label }}
            </option>
          </select>

          <input
            v-model="filters.bedrooms"
            type="number"
            min="1"
            placeholder="Min bedrooms"
            class="w-32 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-400"
          />

          <input
            v-model="filters.min_price"
            type="number"
            min="0"
            placeholder="Min price"
            class="w-32 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-400"
          />

          <input
            v-model="filters.max_price"
            type="number"
            min="0"
            placeholder="Max price"
            class="w-32 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-400"
          />

          <input
            v-model="filters.city"
            type="text"
            placeholder="City"
            class="w-36 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-400"
          />

          <button
            type="submit"
            class="flex items-center gap-1.5 rounded-xl bg-teal-600 px-4 py-2 text-sm font-medium text-white hover:bg-teal-700 transition-colors"
          >
            <FunnelIcon class="size-4" />
            Search
          </button>

          <button
            type="button"
            class="rounded-xl border border-slate-200 px-4 py-2 text-sm text-slate-500 hover:text-slate-700 transition-colors"
            @click="resetFilters"
          >
            Reset
          </button>
        </div>
      </form>

      <!-- Skeleton -->
      <div
        v-if="loading"
        class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3"
      >
        <div
          v-for="i in 6"
          :key="i"
          class="animate-pulse overflow-hidden rounded-2xl border bg-white shadow-sm"
        >
          <div class="aspect-[16/9] bg-slate-200" />
          <div class="p-4 space-y-3">
            <div class="h-4 w-3/4 rounded bg-slate-200" />
            <div class="h-3 w-1/2 rounded bg-slate-100" />
            <div class="h-5 w-1/3 rounded bg-slate-200" />
          </div>
        </div>
      </div>

      <!-- Empty state -->
      <div
        v-else-if="properties.length === 0"
        class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-slate-300 py-20 text-center"
      >
        <HomeModernIcon class="mb-3 size-10 text-slate-300" />
        <p class="font-medium text-slate-500">No properties found</p>
        <p class="mt-1 text-sm text-slate-400">
          Try adjusting your filters or
          <button
            class="text-teal-600 underline underline-offset-2"
            @click="resetFilters"
          >
            reset all
          </button>
        </p>
      </div>

      <!-- Grid -->
      <div
        v-else
        class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3"
      >
        <RouterLink
          v-for="property in properties"
          :key="property.id"
          :to="`/properties/${property.slug}`"
          class="group overflow-hidden rounded-2xl border bg-white shadow-sm transition-shadow hover:shadow-md"
        >
          <div class="relative aspect-[16/9] overflow-hidden bg-slate-100">
            <img
              v-if="property.images && property.images[0]"
              :src="property.images[0]"
              :alt="property.title"
              class="h-full w-full object-cover transition-transform group-hover:scale-105"
            />
            <div
              v-else
              class="flex h-full items-center justify-center bg-gradient-to-br from-teal-50 to-slate-100"
            >
              <HomeModernIcon class="size-12 text-teal-200" />
            </div>
            <span
              class="absolute left-3 top-3 rounded-full px-2.5 py-1 text-xs font-semibold"
              :class="listingBadgeClass[property.listing_type] ?? 'bg-slate-100 text-slate-600'"
            >
              {{ listingLabel[property.listing_type] ?? property.listing_type }}
            </span>
          </div>

          <div class="p-4">
            <p
              class="mb-1 line-clamp-2 font-semibold text-slate-800 group-hover:text-teal-700 transition-colors"
            >
              {{ property.title }}
            </p>
            <p class="mb-2 text-xs text-slate-400">
              {{ property.city }}{{ property.province ? `, ${property.province}` : "" }}
            </p>
            <div
              v-if="property.bedrooms || property.floor_area"
              class="mb-3 flex flex-wrap gap-3 text-xs text-slate-500"
            >
              <span v-if="property.bedrooms">🛏 {{ property.bedrooms }} BR</span>
              <span v-if="property.bathrooms">🚿 {{ property.bathrooms }} BA</span>
              <span v-if="property.floor_area">📐 {{ property.floor_area }} sqm</span>
            </div>
            <p class="text-lg font-bold text-teal-700">
              {{ formatPrice(property.price, property.price_currency, property.price_period) }}
            </p>
          </div>
        </RouterLink>
      </div>

      <!-- Pagination -->
      <div
        v-if="meta.last_page > 1"
        class="mt-8 flex items-center justify-center gap-2"
      >
        <button
          v-for="page in meta.last_page"
          :key="page"
          class="size-9 rounded-xl border text-sm font-medium transition-colors"
          :class="
            meta.current_page === page
              ? 'bg-teal-600 text-white border-teal-600'
              : 'bg-white text-slate-600 hover:bg-slate-50'
          "
          @click="load(page)"
        >
          {{ page }}
        </button>
      </div>
    </div>
  </div>
</template>
