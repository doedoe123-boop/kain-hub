<script setup>
import { ref, onMounted } from "vue";
import { RouterLink } from "vue-router";
import {
  BuildingStorefrontIcon,
  HomeModernIcon,
  BriefcaseIcon,
} from "@heroicons/vue/24/outline";
import { storesApi } from "@/api/stores";
import PhMapHero from "@/components/PhMapHero.vue";

const featuredStores = ref([]);
const loading = ref(true);

const sectors = [
  {
    label: "Food & Retail",
    description: "Restaurants, shops, and local businesses",
    to: "/stores",
    icon: BuildingStorefrontIcon,
    color: "bg-brand-50 text-brand-600 ring-brand-200",
  },
  {
    label: "Real Estate",
    description: "Houses, condos, and commercial spaces",
    to: "/properties",
    icon: HomeModernIcon,
    color: "bg-teal-50 text-teal-600 ring-teal-200",
  },
  {
    label: "Services",
    description: "Coming soon — freelancers and professionals",
    to: null,
    icon: BriefcaseIcon,
    color: "bg-slate-50 text-slate-400 ring-slate-200",
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
});
</script>

<template>
  <div>
    <!-- Hero -->
    <PhMapHero />

    <!-- Sector picker -->
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6">
      <h2 class="mb-1 text-xl font-bold text-slate-900">Browse by Sector</h2>
      <p class="mb-6 text-sm text-slate-500">
        Choose a sector to start discovering.
      </p>
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <component
          :is="sector.soon ? 'div' : RouterLink"
          v-for="sector in sectors"
          :key="sector.label"
          :to="sector.soon ? undefined : sector.to"
          class="group flex items-start gap-4 rounded-2xl border bg-white p-5 shadow-sm transition-shadow"
          :class="
            sector.soon
              ? 'cursor-not-allowed opacity-60'
              : 'cursor-pointer hover:shadow-md'
          "
        >
          <span
            class="flex size-11 shrink-0 items-center justify-center rounded-xl ring-1 transition-transform group-hover:scale-105"
            :class="sector.color"
          >
            <component :is="sector.icon" class="size-6" />
          </span>
          <div class="min-w-0">
            <p class="font-semibold text-slate-800">
              {{ sector.label }}
              <span
                v-if="sector.soon"
                class="ml-2 rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-400"
                >Soon</span
              >
            </p>
            <p class="mt-0.5 line-clamp-1 text-sm text-slate-500">
              {{ sector.description }}
            </p>
          </div>
        </component>
      </div>
    </section>

    <!-- Featured stores -->
    <section class="mx-auto max-w-7xl px-4 pb-16 sm:px-6">
      <div class="mb-6 flex items-end justify-between">
        <div>
          <h2 class="text-xl font-bold text-slate-900">Featured Stores</h2>
          <p class="mt-1 text-sm text-slate-500">
            Handpicked local businesses.
          </p>
        </div>
        <RouterLink
          to="/stores"
          class="text-sm font-medium text-brand-600 hover:text-brand-700 transition-colors"
        >
          View all →
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
        class="rounded-2xl border border-dashed border-slate-300 py-16 text-center text-slate-400"
      >
        No featured stores yet — check back soon!
      </div>

      <!-- Grid -->
      <div v-else class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
        <RouterLink
          v-for="store in featuredStores"
          :key="store.id"
          :to="`/stores/${store.slug}`"
          class="group flex flex-col overflow-hidden rounded-2xl border bg-white shadow-sm hover:shadow-md transition-shadow"
        >
          <!-- Banner -->
          <div class="aspect-[3/2] w-full overflow-hidden bg-slate-100">
            <img
              v-if="store.banner_url"
              :src="store.banner_url"
              :alt="store.name"
              class="h-full w-full object-cover transition-transform group-hover:scale-105"
            />
            <div
              v-else
              class="flex h-full items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200"
            >
              <span class="text-3xl">🏪</span>
            </div>
          </div>
          <!-- Info -->
          <div class="flex items-center gap-3 p-3">
            <img
              v-if="store.logo_url"
              :src="store.logo_url"
              :alt="store.name"
              class="size-10 shrink-0 rounded-xl bg-slate-100 object-cover ring-2 ring-white"
            />
            <div class="min-w-0">
              <p
                class="truncate text-sm font-semibold text-slate-800 group-hover:text-brand-600 transition-colors"
              >
                {{ store.name }}
              </p>
              <p class="text-xs text-slate-500">{{ store.sector }}</p>
            </div>
          </div>
        </RouterLink>
      </div>
    </section>
  </div>
</template>
