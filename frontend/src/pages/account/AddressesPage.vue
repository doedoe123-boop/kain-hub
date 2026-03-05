<script setup>
import { ref, onMounted } from "vue";
import {
  MapPinIcon,
  PlusIcon,
  PencilIcon,
  TrashIcon,
} from "@heroicons/vue/24/outline";
import { addressesApi } from "@/api/addresses";

const addresses = ref([]);
const loading = ref(true);
const showModal = ref(false);
const saving = ref(false);
const deletingId = ref(null);
const errors = ref({});

const emptyForm = () => ({
  label: "",
  line1: "",
  line2: "",
  barangay: "",
  city: "",
  province: "",
  postal_code: "",
  is_default: false,
});

const form = ref(emptyForm());
const editingId = ref(null);

onMounted(fetchAddresses);

async function fetchAddresses() {
  loading.value = true;

  try {
    const { data } = await addressesApi.list();
    addresses.value = data.data ?? data;
  } finally {
    loading.value = false;
  }
}

function openAdd() {
  editingId.value = null;
  form.value = emptyForm();
  errors.value = {};
  showModal.value = true;
}

function openEdit(address) {
  editingId.value = address.id;
  form.value = {
    label: address.label ?? "",
    line1: address.line1 ?? "",
    line2: address.line2 ?? "",
    barangay: address.barangay ?? "",
    city: address.city ?? "",
    province: address.province ?? "",
    postal_code: address.postal_code ?? "",
    is_default: address.is_default ?? false,
  };
  errors.value = {};
  showModal.value = true;
}

async function save() {
  saving.value = true;
  errors.value = {};

  try {
    if (editingId.value) {
      await addressesApi.update(editingId.value, form.value);
    } else {
      await addressesApi.store(form.value);
    }
    showModal.value = false;
    await fetchAddresses();
  } catch (err) {
    if (err.response?.status === 422) {
      errors.value = err.response.data.errors ?? {};
    }
  } finally {
    saving.value = false;
  }
}

async function remove(id) {
  if (!confirm("Remove this address?")) {
    return;
  }

  deletingId.value = id;

  try {
    await addressesApi.destroy(id);
    addresses.value = addresses.value.filter((a) => a.id !== id);
  } finally {
    deletingId.value = null;
  }
}

async function setDefault(id) {
  await addressesApi.setDefault(id);
  await fetchAddresses();
}
</script>

<template>
  <div class="mx-auto max-w-2xl px-4 py-8 sm:px-0">
    <div class="mb-6 flex items-center justify-between">
      <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">
        Addresses
      </h1>
      <button
        class="flex items-center gap-2 rounded-xl bg-gradient-to-r from-brand-500 to-brand-600 px-4 py-2 text-sm font-bold text-white transition-all hover:from-brand-600 hover:to-brand-700"
        @click="openAdd"
      >
        <PlusIcon class="size-4" />
        Add New
      </button>
    </div>

    <!-- Skeleton -->
    <div v-if="loading" class="space-y-3">
      <div
        v-for="i in 2"
        :key="i"
        class="h-24 animate-pulse rounded-2xl bg-slate-100"
      />
    </div>

    <!-- Empty -->
    <div
      v-else-if="addresses.length === 0"
      class="rounded-2xl border border-dashed border-slate-200 bg-white py-14 text-center"
    >
      <MapPinIcon class="mx-auto mb-3 size-10 text-slate-300" />
      <p class="font-medium text-slate-500">No saved addresses</p>
      <p class="mt-1 text-sm text-slate-400">
        Add an address to speed up checkout.
      </p>
    </div>

    <!-- List -->
    <ul v-else class="space-y-3">
      <li
        v-for="addr in addresses"
        :key="addr.id"
        class="rounded-2xl border bg-white p-5 shadow-sm transition-colors"
        :class="addr.is_default ? 'border-brand-300' : 'border-slate-200'"
      >
        <div class="flex items-start justify-between gap-3">
          <div class="min-w-0 flex-1">
            <div class="mb-1 flex flex-wrap items-center gap-2">
              <span class="text-sm font-semibold text-slate-900">{{
                addr.label || "Address"
              }}</span>
              <span
                v-if="addr.is_default"
                class="rounded-full bg-brand-100 px-2 py-0.5 text-xs font-medium text-brand-700"
                >Default</span
              >
            </div>
            <p class="text-sm text-slate-600 leading-relaxed">
              {{ addr.line1
              }}<template v-if="addr.line2">, {{ addr.line2 }}</template>
              <br />
              <template v-if="addr.barangay">{{ addr.barangay }}, </template>
              {{ addr.city }}, {{ addr.province }} {{ addr.postal_code }}
            </p>
          </div>

          <!-- Actions -->
          <div class="flex shrink-0 items-center gap-1">
            <button
              v-if="!addr.is_default"
              class="rounded-lg px-3 py-1.5 text-xs font-medium text-slate-500 transition-colors hover:bg-slate-100 hover:text-slate-700"
              @click="setDefault(addr.id)"
            >
              Set default
            </button>
            <button
              class="rounded-lg p-1.5 text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-700"
              @click="openEdit(addr)"
            >
              <PencilIcon class="size-4" />
            </button>
            <button
              class="rounded-lg p-1.5 text-slate-400 transition-colors hover:bg-red-50 hover:text-red-500"
              :disabled="deletingId === addr.id"
              @click="remove(addr.id)"
            >
              <TrashIcon class="size-4" />
            </button>
          </div>
        </div>
      </li>
    </ul>

    <!-- Add/Edit Modal -->
    <Teleport to="body">
      <div
        v-if="showModal"
        class="fixed inset-0 z-50 flex items-end justify-center bg-black/40 p-4 sm:items-center"
        @click.self="showModal = false"
      >
        <div
          class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl"
          @click.stop
        >
          <h2 class="mb-5 text-lg font-bold text-slate-900">
            {{ editingId ? "Edit Address" : "New Address" }}
          </h2>

          <form class="space-y-4" @submit.prevent="save">
            <!-- Label -->
            <div>
              <label
                for="addr-label"
                class="mb-1 block text-xs font-medium text-slate-600"
                >Label (e.g. Home, Office)</label
              >
              <input
                id="addr-label"
                v-model="form.label"
                type="text"
                placeholder="Home"
                class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-brand-400 focus:ring-2 focus:ring-brand-100 focus:outline-none"
              />
            </div>

            <!-- Line 1 -->
            <div>
              <label
                for="addr-line1"
                class="mb-1 block text-xs font-medium text-slate-600"
                >Address Line 1 <span class="text-red-500">*</span></label
              >
              <input
                id="addr-line1"
                v-model="form.line1"
                type="text"
                required
                placeholder="House no., Street"
                class="w-full rounded-xl border px-3 py-2 text-sm focus:border-brand-400 focus:ring-2 focus:ring-brand-100 focus:outline-none"
                :class="errors.line1 ? 'border-red-300' : 'border-slate-200'"
              />
              <p v-if="errors.line1" class="mt-0.5 text-xs text-red-600">
                {{ errors.line1[0] }}
              </p>
            </div>

            <!-- Line 2 -->
            <div>
              <label
                for="addr-line2"
                class="mb-1 block text-xs font-medium text-slate-600"
                >Address Line 2 (optional)</label
              >
              <input
                id="addr-line2"
                v-model="form.line2"
                type="text"
                placeholder="Building, Floor, Unit"
                class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-brand-400 focus:ring-2 focus:ring-brand-100 focus:outline-none"
              />
            </div>

            <!-- Barangay / City / Province / Postal -->
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="mb-1 block text-xs font-medium text-slate-600"
                  >Barangay</label
                >
                <input
                  v-model="form.barangay"
                  type="text"
                  class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:border-brand-400 focus:ring-2 focus:ring-brand-100 focus:outline-none"
                />
              </div>
              <div>
                <label
                  for="addr-city"
                  class="mb-1 block text-xs font-medium text-slate-600"
                  >City / Municipality
                  <span class="text-red-500">*</span></label
                >
                <input
                  id="addr-city"
                  v-model="form.city"
                  type="text"
                  required
                  class="w-full rounded-xl border px-3 py-2 text-sm focus:border-brand-400 focus:ring-2 focus:ring-brand-100 focus:outline-none"
                  :class="errors.city ? 'border-red-300' : 'border-slate-200'"
                />
              </div>
              <div>
                <label
                  for="addr-province"
                  class="mb-1 block text-xs font-medium text-slate-600"
                  >Province <span class="text-red-500">*</span></label
                >
                <input
                  id="addr-province"
                  v-model="form.province"
                  type="text"
                  required
                  class="w-full rounded-xl border px-3 py-2 text-sm focus:border-brand-400 focus:ring-2 focus:ring-brand-100 focus:outline-none"
                  :class="
                    errors.province ? 'border-red-300' : 'border-slate-200'
                  "
                />
              </div>
              <div>
                <label
                  for="addr-postal"
                  class="mb-1 block text-xs font-medium text-slate-600"
                  >Postal Code <span class="text-red-500">*</span></label
                >
                <input
                  id="addr-postal"
                  v-model="form.postal_code"
                  type="text"
                  required
                  class="w-full rounded-xl border px-3 py-2 text-sm focus:border-brand-400 focus:ring-2 focus:ring-brand-100 focus:outline-none"
                  :class="
                    errors.postal_code ? 'border-red-300' : 'border-slate-200'
                  "
                />
              </div>
            </div>

            <!-- Default toggle -->
            <label class="flex cursor-pointer items-center gap-3">
              <input
                v-model="form.is_default"
                type="checkbox"
                class="size-4 rounded border-slate-300 accent-brand-600"
              />
              <span class="text-sm text-slate-700"
                >Set as default delivery address</span
              >
            </label>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pt-1">
              <button
                type="button"
                class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors"
                @click="showModal = false"
              >
                Cancel
              </button>
              <button
                type="submit"
                :disabled="saving"
                class="rounded-xl bg-gradient-to-r from-brand-500 to-brand-600 px-5 py-2 text-sm font-bold text-white transition-all hover:from-brand-600 hover:to-brand-700 disabled:opacity-60"
              >
                {{ saving ? "Saving…" : "Save Address" }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </Teleport>
  </div>
</template>
