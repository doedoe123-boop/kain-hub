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
  CheckCircleIcon,
  ExclamationCircleIcon,
  ShieldCheckIcon,
  LockClosedIcon,
  ShareIcon,
} from "@heroicons/vue/24/outline";
import { propertiesApi } from "@/api/properties";

const route = useRoute();
const property = ref(null);
const loading = ref(true);
const error = ref(null);
const selectedImage = ref(0);
const showAllImages = ref(false);

// Inquiry form state
const inquiry = ref({ name: "", email: "", phone: "", message: "" });
const inquirySubmitting = ref(false);
const inquirySuccess = ref(false);
const inquiryError = ref(null);

const listingBadgeClass = {
  for_sale: "bg-emerald-100 text-emerald-700 ring-emerald-200",
  for_rent: "bg-sky-100 text-sky-700 ring-sky-200",
  for_lease: "bg-amber-100 text-amber-700 ring-amber-200",
  pre_selling: "bg-purple-100 text-purple-700 ring-purple-200",
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
const thumbnails = computed(() => images.value.slice(1, 5));

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

const monthlyEstimate = computed(() => {
  if (!property.value?.price) return null;
  const price = parseFloat(property.value.price);
  if (isNaN(price) || property.value.listing_type !== "for_sale") return null;
  // Simple Pag-IBIG estimate: ~20yr at 6.5%
  const monthly = (price * 0.005) * 1.065;
  return monthly.toLocaleString("en-PH", { maximumFractionDigits: 0 });
});

const fullAddress = computed(() => {
  if (!property.value) return "";
  return [
    property.value.address_line,
    property.value.barangay,
    property.value.city,
    property.value.province,
  ]
    .filter(Boolean)
    .join(", ");
});

async function submitInquiry() {
  inquiryError.value = null;
  inquirySubmitting.value = true;
  try {
    await propertiesApi.submitInquiry(route.params.slug, inquiry.value);
    inquirySuccess.value = true;
    inquiry.value = { name: "", email: "", phone: "", message: "" };
  } catch {
    inquiryError.value = "Failed to send inquiry. Please try again.";
  } finally {
    inquirySubmitting.value = false;
  }
}

function copyLink() {
  navigator.clipboard.writeText(window.location.href);
}
</script>

<template>
  <div class="min-h-screen bg-slate-50">

    <!-- ── Skeleton ──────────────────────────────────────────────────── -->
    <div v-if="loading" class="animate-pulse">
      <div class="h-[420px] w-full bg-slate-200" />
      <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6">
        <div class="grid gap-8 lg:grid-cols-[1fr_360px]">
          <div class="space-y-4">
            <div class="h-5 w-32 rounded-full bg-slate-200" />
            <div class="h-8 w-2/3 rounded-lg bg-slate-200" />
            <div class="h-4 w-1/3 rounded bg-slate-100" />
            <div class="h-12 w-1/4 rounded-lg bg-slate-200" />
            <div class="h-28 rounded-2xl bg-slate-100" />
            <div class="h-4 w-full rounded bg-slate-100" />
            <div class="h-4 w-5/6 rounded bg-slate-100" />
          </div>
          <div class="h-[500px] rounded-2xl bg-slate-100" />
        </div>
      </div>
    </div>

    <!-- ── Error ─────────────────────────────────────────────────────── -->
    <div
      v-else-if="error"
      class="mx-auto max-w-6xl px-4 py-24 text-center sm:px-6"
    >
      <div class="mx-auto mb-6 flex size-20 items-center justify-center rounded-full bg-slate-100">
        <HomeModernIcon class="size-10 text-slate-400" />
      </div>
      <p class="text-xl font-semibold text-slate-700">{{ error }}</p>
      <p class="mt-2 text-sm text-slate-400">The listing may have been removed or the link is incorrect.</p>
      <RouterLink
        to="/properties"
        class="mt-6 inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 transition-colors"
      >
        <ArrowLeftIcon class="size-4" /> Back to Properties
      </RouterLink>
    </div>

    <!-- ── Property ──────────────────────────────────────────────────── -->
    <template v-else-if="property">

      <!-- ─ Gallery Hero ──────────────────────────────────────────────── -->
      <div class="relative bg-slate-900">
        <!-- Main + thumbnails grid -->
        <div class="mx-auto max-w-6xl px-4 pt-4 sm:px-6">
          <div class="grid gap-2 lg:grid-cols-[2fr_1fr]" style="height: 420px;">

            <!-- Primary image -->
            <div class="relative overflow-hidden rounded-2xl bg-slate-800">
              <img
                v-if="hasGallery"
                :src="images[selectedImage]"
                :alt="property.title"
                class="h-full w-full object-cover transition-all duration-500"
              />
              <div
                v-else
                class="flex h-full items-center justify-center bg-gradient-to-br from-slate-800 to-slate-900"
              >
                <HomeModernIcon class="size-24 text-slate-700" />
              </div>

              <!-- Back pill -->
              <RouterLink
                to="/properties"
                class="absolute left-3 top-3 flex items-center gap-1.5 rounded-full bg-black/50 px-3 py-1.5 text-xs font-medium text-white backdrop-blur-sm transition-colors hover:bg-black/70"
              >
                <ArrowLeftIcon class="size-3.5" />
                Properties
              </RouterLink>

              <!-- Listing badge -->
              <span
                class="absolute right-3 top-3 rounded-full px-3 py-1 text-xs font-bold shadow ring-1"
                :class="listingBadgeClass[property.listing_type] ?? 'bg-slate-100 text-slate-600 ring-slate-200'"
              >
                {{ listingLabel[property.listing_type] ?? property.listing_type }}
              </span>

              <!-- Photo count -->
              <button
                v-if="images.length > 1"
                class="absolute bottom-3 right-3 flex items-center gap-1.5 rounded-full bg-black/60 px-3 py-1.5 text-xs font-medium text-white backdrop-blur-sm transition-colors hover:bg-black/80"
                @click="showAllImages = !showAllImages"
              >
                📷 View all {{ images.length }} photos
              </button>
            </div>

            <!-- Thumbnail 2×2 grid -->
            <div
              v-if="thumbnails.length"
              class="hidden lg:grid grid-cols-2 gap-2"
            >
              <button
                v-for="(img, i) in thumbnails"
                :key="i"
                class="relative overflow-hidden rounded-xl bg-slate-800 ring-2 transition-all"
                :class="
                  selectedImage === i + 1
                    ? 'ring-emerald-400'
                    : 'ring-transparent hover:ring-white/30'
                "
                @click="selectedImage = i + 1"
              >
                <img
                  :src="img"
                  class="h-full w-full object-cover transition-transform duration-300 hover:scale-105"
                />
                <!-- Overlay for 4th thumb if more images -->
                <div
                  v-if="i === 3 && images.length > 5"
                  class="absolute inset-0 flex items-center justify-center bg-black/60 text-sm font-bold text-white"
                >
                  +{{ images.length - 5 }} more
                </div>
              </button>
              <!-- Pad with empty slots if fewer than 4 thumbnails -->
              <div
                v-for="n in Math.max(0, 4 - thumbnails.length)"
                :key="`pad-${n}`"
                class="rounded-xl bg-slate-800"
              />
            </div>
          </div>

          <!-- Thumbnail strip (mobile / overflow) -->
          <div
            v-if="images.length > 1"
            class="mt-2 flex gap-1.5 overflow-x-auto pb-1 lg:hidden"
          >
            <button
              v-for="(img, i) in images"
              :key="i"
              class="size-14 shrink-0 overflow-hidden rounded-lg border-2 transition-all"
              :class="
                selectedImage === i
                  ? 'border-emerald-400 opacity-100'
                  : 'border-transparent opacity-50 hover:opacity-75'
              "
              @click="selectedImage = i"
            >
              <img :src="img" class="h-full w-full object-cover" />
            </button>
          </div>
        </div>
      </div>

      <!-- ─ Breadcrumb ─────────────────────────────────────────────────── -->
      <div class="border-b border-slate-100 bg-white">
        <div class="mx-auto max-w-6xl px-4 sm:px-6">
          <nav class="flex items-center gap-1.5 py-3 text-xs text-slate-400" aria-label="Breadcrumb">
            <RouterLink to="/" class="transition-colors hover:text-emerald-600">Home</RouterLink>
            <ChevronRightIcon class="size-3" />
            <RouterLink to="/properties" class="transition-colors hover:text-emerald-600">Properties</RouterLink>
            <ChevronRightIcon class="size-3" />
            <span class="max-w-xs truncate text-slate-600">{{ property.title }}</span>
          </nav>
        </div>
      </div>

      <!-- ─ Main Layout ────────────────────────────────────────────────── -->
      <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6">
        <div class="grid gap-8 lg:grid-cols-[1fr_360px]">

          <!-- LEFT: Content ─────────────────────────────────────────── -->
          <div>
            <!-- Type chip + views -->
            <div class="mb-3 flex flex-wrap items-center justify-between gap-2">
              <div class="flex flex-wrap items-center gap-2">
                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                  {{ typeLabel[property.property_type] ?? property.property_type }}
                </span>
                <!-- Verified badge -->
                <span
                  v-if="property.store"
                  class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200"
                >
                  <ShieldCheckIcon class="size-3.5" />
                  Verified Agency
                </span>
              </div>
              <!-- View count -->
              <span
                v-if="property.views_count"
                class="flex items-center gap-1 text-xs text-slate-400"
              >
                <EyeIcon class="size-3.5" />
                {{ property.views_count.toLocaleString() }} views this week
              </span>
            </div>

            <!-- Title -->
            <h1 class="mb-3 text-2xl font-bold leading-snug text-slate-900 sm:text-3xl">
              {{ property.title }}
            </h1>

            <!-- Location -->
            <p v-if="fullAddress" class="mb-4 flex items-center gap-1.5 text-sm text-slate-500">
              <MapPinIcon class="size-4 shrink-0 text-slate-400" />
              {{ fullAddress }}
            </p>

            <!-- Price block -->
            <div class="mb-6 flex flex-wrap items-baseline gap-3">
              <p class="text-3xl font-extrabold tracking-tight text-brand-500">
                {{ formattedPrice }}
              </p>
              <span
                v-if="property.is_negotiable"
                class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-500"
              >
                Negotiable
              </span>
            </div>

            <!-- Pag-IBIG monthly estimate -->
            <div
              v-if="monthlyEstimate"
              class="mb-6 flex items-center gap-2 rounded-xl border border-slate-100 bg-white px-4 py-3 text-sm shadow-sm"
            >
              <span class="text-base">🏦</span>
              <span class="text-slate-600">
                Est. <strong class="text-slate-900">₱{{ monthlyEstimate }}/mo</strong> via Pag-IBIG
              </span>
              <span class="ml-auto text-xs text-slate-400">~20yr @ 6.5%</span>
            </div>

            <!-- Specs bar -->
            <div
              v-if="property.bedrooms != null || property.bathrooms != null || property.garage_spaces != null || property.floor_area || property.lot_area"
              class="mb-8 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5"
            >
              <div
                v-if="property.bedrooms != null"
                class="flex flex-col items-center gap-1 rounded-2xl border border-slate-100 bg-white px-3 py-4 text-center shadow-sm"
              >
                <span class="text-2xl">🛏</span>
                <span class="text-lg font-bold text-slate-900">{{ property.bedrooms }}</span>
                <span class="text-[11px] text-slate-500">Bedrooms</span>
              </div>
              <div
                v-if="property.bathrooms != null"
                class="flex flex-col items-center gap-1 rounded-2xl border border-slate-100 bg-white px-3 py-4 text-center shadow-sm"
              >
                <span class="text-2xl">🚿</span>
                <span class="text-lg font-bold text-slate-900">{{ property.bathrooms }}</span>
                <span class="text-[11px] text-slate-500">Bathrooms</span>
              </div>
              <div
                v-if="property.garage_spaces != null"
                class="flex flex-col items-center gap-1 rounded-2xl border border-slate-100 bg-white px-3 py-4 text-center shadow-sm"
              >
                <span class="text-2xl">🚗</span>
                <span class="text-lg font-bold text-slate-900">{{ property.garage_spaces }}</span>
                <span class="text-[11px] text-slate-500">Garage</span>
              </div>
              <div
                v-if="property.floor_area"
                class="flex flex-col items-center gap-1 rounded-2xl border border-slate-100 bg-white px-3 py-4 text-center shadow-sm"
              >
                <span class="text-2xl">📐</span>
                <span class="text-lg font-bold text-slate-900">{{ property.floor_area }}<span class="text-xs font-normal"> sqm</span></span>
                <span class="text-[11px] text-slate-500">Floor Area</span>
              </div>
              <div
                v-if="property.lot_area"
                class="flex flex-col items-center gap-1 rounded-2xl border border-slate-100 bg-white px-3 py-4 text-center shadow-sm"
              >
                <span class="text-2xl">🌿</span>
                <span class="text-lg font-bold text-slate-900">{{ property.lot_area }}<span class="text-xs font-normal"> sqm</span></span>
                <span class="text-[11px] text-slate-500">Lot Area</span>
              </div>
            </div>

            <hr class="mb-8 border-slate-100" />

            <!-- About -->
            <section v-if="property.description" class="mb-8">
              <h2 class="mb-3 text-lg font-bold text-slate-900">About this property</h2>
              <p class="whitespace-pre-line text-sm leading-relaxed text-slate-600">{{ property.description }}</p>
            </section>

            <!-- Features & Amenities -->
            <section v-if="property.features?.length" class="mb-8">
              <h2 class="mb-4 text-lg font-bold text-slate-900">Features & Amenities</h2>
              <div class="flex flex-wrap gap-2">
                <span
                  v-for="feature in property.features"
                  :key="feature"
                  class="rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200"
                >
                  {{ feature }}
                </span>
              </div>
            </section>

            <hr class="mb-8 border-slate-100" />

            <!-- Property details table -->
            <section class="mb-8">
              <h2 class="mb-4 text-lg font-bold text-slate-900">Property Details</h2>
              <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
                <table class="w-full text-sm">
                  <tbody class="divide-y divide-slate-50">
                    <tr v-if="property.property_type" class="bg-white">
                      <td class="w-1/3 px-4 py-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Type</td>
                      <td class="px-4 py-3 font-semibold text-slate-800">{{ typeLabel[property.property_type] ?? property.property_type }}</td>
                    </tr>
                    <tr v-if="property.listing_type" class="bg-slate-50/60">
                      <td class="px-4 py-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Listing</td>
                      <td class="px-4 py-3 font-semibold text-slate-800">{{ listingLabel[property.listing_type] ?? property.listing_type }}</td>
                    </tr>
                    <tr v-if="property.year_built" class="bg-white">
                      <td class="px-4 py-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Year Built</td>
                      <td class="px-4 py-3 font-semibold text-slate-800">{{ property.year_built }}</td>
                    </tr>
                    <tr v-if="property.floors" class="bg-slate-50/60">
                      <td class="px-4 py-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Floors</td>
                      <td class="px-4 py-3 font-semibold text-slate-800">{{ property.floors }}</td>
                    </tr>
                    <tr v-if="property.floor_area" class="bg-white">
                      <td class="px-4 py-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Floor Area</td>
                      <td class="px-4 py-3 font-semibold text-slate-800">{{ property.floor_area }} sqm</td>
                    </tr>
                    <tr v-if="property.lot_area" class="bg-slate-50/60">
                      <td class="px-4 py-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Lot Area</td>
                      <td class="px-4 py-3 font-semibold text-slate-800">{{ property.lot_area }} sqm</td>
                    </tr>
                    <tr v-if="property.zip_code" class="bg-white">
                      <td class="px-4 py-3 text-xs font-semibold uppercase tracking-wide text-slate-400">ZIP Code</td>
                      <td class="px-4 py-3 font-semibold text-slate-800">{{ property.zip_code }}</td>
                    </tr>
                    <tr v-if="fullAddress" class="bg-slate-50/60">
                      <td class="px-4 py-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Address</td>
                      <td class="px-4 py-3 font-semibold text-slate-800">{{ fullAddress }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </section>

            <!-- Video tour -->
            <section v-if="property.video_url" class="mb-8">
              <h2 class="mb-3 text-lg font-bold text-slate-900">Video Tour</h2>
              <a
                :href="property.video_url"
                target="_blank"
                rel="noopener"
                class="inline-flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-3 text-sm font-semibold text-emerald-700 transition-colors hover:bg-emerald-100"
              >
                ▶ Watch Video Tour
              </a>
            </section>

            <!-- Nearby places -->
            <section v-if="property.nearby_places?.length" class="mb-8">
              <h2 class="mb-4 text-lg font-bold text-slate-900">Nearby Places</h2>
              <ul class="grid grid-cols-2 gap-2 sm:grid-cols-3">
                <li
                  v-for="place in property.nearby_places"
                  :key="place.name ?? place"
                  class="flex items-center gap-2 rounded-xl bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm ring-1 ring-slate-100"
                >
                  <MapPinIcon class="size-4 shrink-0 text-emerald-500" />
                  {{ place.name ?? place }}
                </li>
              </ul>
            </section>

            <!-- Share row -->
            <div class="flex items-center gap-3 border-t border-slate-100 pt-6">
              <span class="text-xs font-semibold text-slate-400">Share this listing</span>
              <button
                class="flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-600 shadow-sm transition-colors hover:bg-slate-50"
                @click="copyLink"
              >
                <ShareIcon class="size-3.5" /> Copy link
              </button>
              <a
                :href="`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(route.fullPath)}`"
                target="_blank"
                rel="noopener"
                class="flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-600 shadow-sm transition-colors hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200"
              >
                📘 Facebook
              </a>
            </div>
          </div>

          <!-- RIGHT: Sticky sidebar ──────────────────────────────────── -->
          <div class="space-y-4 lg:sticky lg:top-24 self-start">

            <!-- Agency card -->
            <div
              v-if="property.store"
              class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-100"
            >
              <!-- Navy header -->
              <div style="background: #0F2044;" class="px-5 py-4">
                <p class="mb-0.5 text-[10px] font-semibold uppercase tracking-widest text-white/50">Listed by</p>
                <RouterLink
                  :to="`/stores/${property.store.slug}`"
                  class="block text-base font-bold text-white transition-opacity hover:opacity-80"
                >
                  {{ property.store.name }}
                </RouterLink>
                <div class="mt-2 flex items-center gap-1.5">
                  <span class="inline-flex items-center gap-1 rounded-full bg-emerald-500/20 px-2 py-0.5 text-[10px] font-semibold text-emerald-300 ring-1 ring-emerald-500/30">
                    <ShieldCheckIcon class="size-3" /> Verified Agency
                  </span>
                </div>
              </div>

              <!-- Agent info -->
              <div class="p-5">
                <div class="mb-4 flex items-center gap-3">
                  <img
                    v-if="property.store.agent_photo"
                    :src="property.store.agent_photo"
                    class="size-12 rounded-full object-cover ring-2 ring-emerald-100"
                  />
                  <UserCircleIcon v-else class="size-12 shrink-0 text-slate-300" />
                  <div>
                    <p v-if="property.store.agent_name" class="font-semibold text-slate-800">{{ property.store.agent_name }}</p>
                    <div class="mt-0.5 flex items-center gap-1">
                      <span class="text-xs text-amber-500">★★★★★</span>
                      <span class="text-xs text-slate-400">Verified agent</span>
                    </div>
                    <p v-if="property.store.agent_bio" class="mt-1 text-xs leading-relaxed text-slate-500 line-clamp-2">{{ property.store.agent_bio }}</p>
                  </div>
                </div>
                <a
                  v-if="property.store.phone"
                  :href="`tel:${property.store.phone}`"
                  class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 py-2.5 text-sm font-bold text-white shadow-sm transition-all hover:bg-emerald-700 hover:shadow-emerald-600/25 hover:shadow-md active:scale-[0.98]"
                >
                  <PhoneIcon class="size-4" />
                  {{ property.store.phone }}
                </a>
              </div>
            </div>

            <!-- Inquiry form card -->
            <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-100">
              <div class="border-b border-slate-100 px-5 py-4">
                <h3 class="font-bold text-slate-900">Send an Inquiry</h3>
                <p class="mt-0.5 text-xs text-slate-500">Get more details about this property</p>
              </div>

              <div class="p-5">
                <!-- Success -->
                <div
                  v-if="inquirySuccess"
                  class="flex flex-col items-center gap-2 rounded-2xl bg-emerald-50 px-4 py-8 text-center ring-1 ring-emerald-100"
                >
                  <div class="flex size-12 items-center justify-center rounded-full bg-emerald-100">
                    <CheckCircleIcon class="size-7 text-emerald-600" />
                  </div>
                  <p class="font-bold text-emerald-800">Inquiry sent!</p>
                  <p class="text-xs text-emerald-600">We'll be in touch with you shortly.</p>
                  <button
                    class="mt-1 text-xs font-medium text-emerald-700 underline transition-colors hover:text-emerald-900"
                    @click="inquirySuccess = false"
                  >
                    Send another inquiry
                  </button>
                </div>

                <!-- Form -->
                <form v-else class="space-y-3" @submit.prevent="submitInquiry">
                  <div>
                    <label class="mb-1 block text-xs font-semibold text-slate-600">Full Name *</label>
                    <input
                      v-model="inquiry.name"
                      required
                      type="text"
                      placeholder="Juan dela Cruz"
                      class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-800 placeholder-slate-400 outline-none transition-all focus:border-emerald-400 focus:bg-white focus:ring-2 focus:ring-emerald-100"
                    />
                  </div>
                  <div>
                    <label class="mb-1 block text-xs font-semibold text-slate-600">Email Address *</label>
                    <input
                      v-model="inquiry.email"
                      required
                      type="email"
                      placeholder="juan@example.com"
                      class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-800 placeholder-slate-400 outline-none transition-all focus:border-emerald-400 focus:bg-white focus:ring-2 focus:ring-emerald-100"
                    />
                  </div>
                  <div>
                    <label class="mb-1 block text-xs font-semibold text-slate-600">Phone Number</label>
                    <input
                      v-model="inquiry.phone"
                      type="tel"
                      placeholder="+63 9XX XXX XXXX"
                      class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-800 placeholder-slate-400 outline-none transition-all focus:border-emerald-400 focus:bg-white focus:ring-2 focus:ring-emerald-100"
                    />
                  </div>
                  <div>
                    <label class="mb-1 block text-xs font-semibold text-slate-600">Message</label>
                    <textarea
                      v-model="inquiry.message"
                      rows="3"
                      placeholder="I'm interested in this property. Could you send me more details?"
                      class="w-full resize-none rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-800 placeholder-slate-400 outline-none transition-all focus:border-emerald-400 focus:bg-white focus:ring-2 focus:ring-emerald-100"
                    />
                  </div>

                  <!-- Error -->
                  <div
                    v-if="inquiryError"
                    class="flex items-center gap-2 rounded-xl bg-red-50 px-3 py-2 text-xs text-red-600 ring-1 ring-red-100"
                  >
                    <ExclamationCircleIcon class="size-4 shrink-0" />
                    {{ inquiryError }}
                  </div>

                  <!-- CTA -->
                  <button
                    type="submit"
                    :disabled="inquirySubmitting"
                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 py-3 text-sm font-bold text-white shadow-sm transition-all hover:bg-emerald-700 hover:shadow-emerald-600/25 hover:shadow-md active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-60"
                  >
                    <span v-if="inquirySubmitting" class="flex items-center gap-2">
                      <svg class="size-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                      </svg>
                      Sending…
                    </span>
                    <span v-else>Send Inquiry</span>
                  </button>

                  <!-- Trust note -->
                  <p class="flex items-center justify-center gap-1.5 text-[11px] text-slate-400">
                    <LockClosedIcon class="size-3 shrink-0" />
                    Your data is protected and never shared
                  </p>
                </form>
              </div>
            </div>

            <!-- Share mini card -->
            <div class="rounded-2xl border border-slate-100 bg-white px-5 py-4 shadow-sm">
              <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-slate-400">Share this listing</p>
              <div class="flex gap-2">
                <button
                  class="flex flex-1 items-center justify-center gap-1.5 rounded-xl border border-slate-200 py-2 text-xs font-semibold text-slate-600 transition-colors hover:bg-slate-50"
                  @click="copyLink"
                >
                  🔗 Copy
                </button>
                <a
                  :href="`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(route.fullPath)}`"
                  target="_blank"
                  rel="noopener"
                  class="flex flex-1 items-center justify-center gap-1.5 rounded-xl border border-slate-200 py-2 text-xs font-semibold text-slate-600 transition-colors hover:bg-blue-50 hover:text-blue-600"
                >
                  📘 FB
                </a>
                <a
                  :href="`https://twitter.com/intent/tweet?url=${encodeURIComponent(route.fullPath)}&text=${encodeURIComponent(property.title)}`"
                  target="_blank"
                  rel="noopener"
                  class="flex flex-1 items-center justify-center gap-1.5 rounded-xl border border-slate-200 py-2 text-xs font-semibold text-slate-600 transition-colors hover:bg-sky-50 hover:text-sky-600"
                >
                  🐦 X
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>
