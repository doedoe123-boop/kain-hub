<script setup>
import { ref, computed, onMounted } from "vue";
import { useRoute, RouterLink } from "vue-router";
import {
  ChevronRightIcon,
  MapPinIcon,
  HomeModernIcon,
  ArrowLeftIcon,
  EyeIcon,
  PhoneIcon,
  UserCircleIcon,
} from "@heroicons/vue/24/outline";
import { propertiesApi } from "@/api/properties";

const route = useRoute();
const property = ref(null);
const loading = ref(true);
const error = ref(null);
const selectedImage = ref(0);

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

const typeLabel = {
  house: "House & Lot",
  condo: "Condominium",
  apartment: "Apartment",
  townhouse: "Townhouse",
  commercial: "Commercial Space",
  lot: "Vacant Lot",
  warehouse: "Warehouse",
  farm: "Farm / Agricultural",
};

onMounted(async () => {
  try {
    const { data } = await propertiesApi.show(route.params.slug);
    property.value = data;
  } catch (e) {
    error.value =
      e.response?.status === 404
        ? "Property not found."
        : "Failed to load property.";
  } finally {
    loading.value = false;
  }
});

const images = computed(() => property.value?.images ?? []);
const hasGallery = computed(() => images.value.length > 0);

const formattedPrice = computed(() => {
  if (!property.value) return "";
  const p = property.value;
  const formatted = parseFloat(p.price).toLocaleString("en-PH", {
    style: "currency",
    currency: p.price_currency || "PHP",
    maximumFractionDigits: 0,
  });
  return p.price_period
    ? `${formatted} / ${p.price_period.replace("_", " ")}`
    : formatted;
});
</script>

<template>
  <div>
    <!-- Skeleton -->
    <div v-if="loading" class="animate-pulse">
      <div class="aspect-[21/8] w-full bg-slate-200" />
      <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6">
        <div class="grid gap-6 md:grid-cols-3">
          <div class="md:col-span-2 space-y-4">
            <div class="h-6 w-2/3 rounded bg-slate-200" />
            <div class="h-4 w-1/3 rounded bg-slate-100" />
            <div class="h-8 w-1/4 rounded bg-slate-200" />
            <div class="h-4 w-full rounded bg-slate-100" />
            <div class="h-4 w-5/6 rounded bg-slate-100" />
          </div>
          <div class="h-48 rounded-2xl bg-slate-100" />
        </div>
      </div>
    </div>

    <!-- Error -->
    <div
      v-else-if="error"
      class="mx-auto max-w-5xl px-4 py-20 text-center sm:px-6"
    >
      <HomeModernIcon class="mx-auto mb-4 size-12 text-slate-300" />
      <p class="text-lg font-medium text-slate-600">{{ error }}</p>
      <RouterLink
        to="/properties"
        class="mt-4 inline-flex items-center gap-1.5 text-sm text-teal-600 hover:text-teal-700"
      >
        <ArrowLeftIcon class="size-4" /> Back to properties
      </RouterLink>
    </div>

    <template v-else-if="property">
      <!-- Image gallery -->
      <div class="bg-slate-900">
        <div class="relative aspect-[21/8] overflow-hidden">
          <img
            v-if="hasGallery"
            :src="images[selectedImage]"
            :alt="property.title"
            class="h-full w-full object-cover opacity-90"
          />
          <div
            v-else
            class="flex h-full items-center justify-center bg-gradient-to-br from-teal-900 to-slate-900"
          >
            <HomeModernIcon class="size-20 text-teal-700" />
          </div>
          <div
            v-if="images.length > 1"
            class="absolute bottom-3 left-1/2 flex -translate-x-1/2 gap-2"
          >
            <button
              v-for="(img, i) in images"
              :key="i"
              class="size-12 overflow-hidden rounded-lg border-2 transition-all"
              :class="
                selectedImage === i
                  ? 'border-white opacity-100'
                  : 'border-transparent opacity-60 hover:opacity-90'
              "
              @click="selectedImage = i"
            >
              <img :src="img" class="h-full w-full object-cover" />
            </button>
          </div>
        </div>
      </div>

      <!-- Main content -->
      <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6">
        <!-- Breadcrumb -->
        <nav
          class="mb-6 flex items-center gap-1.5 text-xs text-slate-400"
          aria-label="Breadcrumb"
        >
          <RouterLink to="/" class="hover:text-teal-600 transition-colors">Home</RouterLink>
          <ChevronRightIcon class="size-3" />
          <RouterLink to="/properties" class="hover:text-teal-600 transition-colors">Properties</RouterLink>
          <ChevronRightIcon class="size-3" />
          <span class="line-clamp-1 text-slate-600">{{ property.title }}</span>
        </nav>

        <div class="grid gap-8 md:grid-cols-3">
          <!-- Left: main info -->
          <div class="md:col-span-2">
            <div class="mb-3 flex flex-wrap gap-2">
              <span
                class="rounded-full px-3 py-1 text-xs font-semibold"
                :class="listingBadgeClass[property.listing_type] ?? 'bg-slate-100 text-slate-600'"
              >
                {{ listingLabel[property.listing_type] ?? property.listing_type }}
              </span>
              <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">
                {{ typeLabel[property.property_type] ?? property.property_type }}
              </span>
            </div>

            <h1 class="mb-1 text-2xl font-bold text-slate-900">{{ property.title }}</h1>

            <p class="mb-3 flex items-center gap-1 text-sm text-slate-500">
              <MapPinIcon class="size-4 shrink-0 text-teal-500" />
              <span>
                {{ [property.address_line, property.barangay, property.city, property.province].filter(Boolean).join(", ") }}
              </span>
            </p>

            <p class="mb-6 text-3xl font-bold text-teal-700">{{ formattedPrice }}</p>

            <!-- Core specs -->
            <div
              v-if="property.bedrooms || property.bathrooms || property.floor_area || property.lot_area || property.garage_spaces"
              class="mb-6 grid grid-cols-2 gap-3 rounded-2xl bg-slate-50 p-4 sm:grid-cols-3 lg:grid-cols-5"
            >
              <div v-if="property.bedrooms != null" class="text-center">
                <p class="text-xl">🛏</p>
                <p class="text-sm font-semibold text-slate-800">{{ property.bedrooms }}</p>
                <p class="text-xs text-slate-500">Bedrooms</p>
              </div>
              <div v-if="property.bathrooms != null" class="text-center">
                <p class="text-xl">🚿</p>
                <p class="text-sm font-semibold text-slate-800">{{ property.bathrooms }}</p>
                <p class="text-xs text-slate-500">Bathrooms</p>
              </div>
              <div v-if="property.garage_spaces != null" class="text-center">
                <p class="text-xl">🚗</p>
                <p class="text-sm font-semibold text-slate-800">{{ property.garage_spaces }}</p>
                <p class="text-xs text-slate-500">Garage</p>
              </div>
              <div v-if="property.floor_area" class="text-center">
                <p class="text-xl">📐</p>
                <p class="text-sm font-semibold text-slate-800">{{ property.floor_area }} sqm</p>
                <p class="text-xs text-slate-500">Floor Area</p>
              </div>
              <div v-if="property.lot_area" class="text-center">
                <p class="text-xl">🖹️</p>
                <p class="text-sm font-semibold text-slate-800">{{ property.lot_area }} sqm</p>
                <p class="text-xs text-slate-500">Lot Area</p>
              </div>
            </div>

            <section v-if="property.description" class="mb-6">
              <h2 class="mb-2 font-semibold text-slate-800">About this property</h2>
              <p class="whitespace-pre-line text-sm leading-relaxed text-slate-600">{{ property.description }}</p>
            </section>

            <section v-if="property.features && property.features.length" class="mb-6">
              <h2 class="mb-3 font-semibold text-slate-800">Features</h2>
              <div class="flex flex-wrap gap-2">
                <span
                  v-for="feature in property.features"
                  :key="feature"
                  class="rounded-full bg-teal-50 px-3 py-1 text-xs font-medium text-teal-700 ring-1 ring-teal-200"
                >
                  {{ feature }}
                </span>
              </div>
            </section>

            <section class="mb-6">
              <h2 class="mb-3 font-semibold text-slate-800">Property Details</h2>
              <dl class="grid grid-cols-2 gap-y-2 text-sm sm:grid-cols-3">
                <template v-if="property.year_built">
                  <dt class="text-slate-500">Year Built</dt>
                  <dd class="font-medium text-slate-800">{{ property.year_built }}</dd>
                </template>
                <template v-if="property.floors">
                  <dt class="text-slate-500">Floors</dt>
                  <dd class="font-medium text-slate-800">{{ property.floors }}</dd>
                </template>
                <template v-if="property.zip_code">
                  <dt class="text-slate-500">ZIP Code</dt>
                  <dd class="font-medium text-slate-800">{{ property.zip_code }}</dd>
                </template>
              </dl>
            </section>

            <section v-if="property.video_url" class="mb-6">
              <h2 class="mb-3 font-semibold text-slate-800">Video Tour</h2>
              <a :href="property.video_url" target="_blank" rel="noopener" class="text-sm text-teal-600 hover:underline">
                Watch on external link →
              </a>
            </section>
          </div>

          <!-- Right: sidebar -->
          <div class="space-y-4">
            <div class="flex items-center gap-2 rounded-xl bg-slate-50 px-4 py-2.5 text-sm text-slate-500">
              <EyeIcon class="size-4" />
              {{ property.views_count?.toLocaleString() ?? 0 }} views
            </div>

            <div v-if="property.store" class="overflow-hidden rounded-2xl border bg-white shadow-sm">
              <div class="bg-teal-600 px-4 py-3">
                <p class="text-xs font-semibold uppercase tracking-wide text-teal-100">Listed by</p>
                <RouterLink
                  :to="`/stores/${property.store.slug}`"
                  class="mt-0.5 block font-bold text-white hover:underline"
                >
                  {{ property.store.name }}
                </RouterLink>
              </div>
              <div class="p-4">
                <template v-if="property.store.agent_bio">
                  <div class="mb-3 flex items-start gap-3">
                    <img
                      v-if="property.store.agent_photo"
                      :src="property.store.agent_photo"
                      class="size-10 rounded-full object-cover ring-2 ring-teal-100"
                    />
                    <UserCircleIcon v-else class="size-10 shrink-0 text-slate-300" />
                    <p class="text-xs leading-relaxed text-slate-600">{{ property.store.agent_bio }}</p>
                  </div>
                </template>
                <a
                  v-if="property.store.phone"
                  :href="`tel:${property.store.phone}`"
                  class="flex w-full items-center justify-center gap-2 rounded-xl bg-teal-600 py-2.5 text-sm font-medium text-white hover:bg-teal-700 transition-colors"
                >
                  <PhoneIcon class="size-4" />
                  {{ property.store.phone }}
                </a>
              </div>
            </div>

            <div
              v-if="property.nearby_places && property.nearby_places.length"
              class="rounded-2xl border bg-white p-4 shadow-sm"
            >
              <h3 class="mb-2 text-sm font-semibold text-slate-800">Nearby Places</h3>
              <ul class="space-y-1 text-sm text-slate-600">
                <li
                  v-for="place in property.nearby_places"
                  :key="place.name ?? place"
                  class="flex items-center gap-1.5"
                >
                  <span class="text-teal-400">•</span>
                  {{ place.name ?? place }}
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>
