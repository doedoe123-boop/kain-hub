<script setup>
import { ref } from "vue";
import { useAuthStore } from "@/stores/auth";
import { authApi } from "@/api/auth";

const auth = useAuthStore();

const form = ref({
  name: auth.user?.name ?? "",
  phone: auth.user?.phone ?? "",
});

const saving = ref(false);
const success = ref(false);
const error = ref("");

async function save() {
  saving.value = true;
  success.value = false;
  error.value = "";

  try {
    const { data } = await authApi.updateProfile(form.value);
    auth.user = data;
    success.value = true;
    setTimeout(() => (success.value = false), 3000);
  } catch (err) {
    error.value =
      err.response?.data?.message ?? "Failed to update profile. Try again.";
  } finally {
    saving.value = false;
  }
}
</script>

<template>
  <div class="mx-auto max-w-xl px-4 py-8 sm:px-0">
    <h1 class="mb-6 text-2xl font-extrabold tracking-tight text-slate-900">
      My Profile
    </h1>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
      <form class="space-y-5" @submit.prevent="save">
        <!-- Name -->
        <div>
          <label
            for="profile-name"
            class="mb-1.5 block text-sm font-medium text-slate-700"
            >Full Name</label
          >
          <input
            id="profile-name"
            v-model="form.name"
            type="text"
            required
            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-400 focus:ring-2 focus:ring-brand-100 focus:outline-none"
          />
        </div>

        <!-- Email (read-only) -->
        <div>
          <label
            for="profile-email"
            class="mb-1.5 block text-sm font-medium text-slate-700"
            >Email Address</label
          >
          <input
            id="profile-email"
            :value="auth.user?.email"
            type="email"
            disabled
            class="w-full rounded-xl border border-slate-100 bg-slate-50 px-4 py-2.5 text-sm text-slate-500 cursor-not-allowed"
          />
          <p class="mt-1 text-xs text-slate-400">
            Email cannot be changed here.
          </p>
        </div>

        <!-- Phone -->
        <div>
          <label
            for="profile-phone"
            class="mb-1.5 block text-sm font-medium text-slate-700"
            >Phone Number</label
          >
          <input
            id="profile-phone"
            v-model="form.phone"
            type="tel"
            placeholder="e.g. 09171234567"
            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:border-brand-400 focus:ring-2 focus:ring-brand-100 focus:outline-none"
          />
        </div>

        <!-- Success / error feedback -->
        <p
          v-if="success"
          class="rounded-xl bg-green-50 px-4 py-2.5 text-sm font-medium text-green-700"
        >
          ✓ Profile updated successfully.
        </p>
        <p
          v-if="error"
          class="rounded-xl bg-red-50 px-4 py-2.5 text-sm font-medium text-red-700"
        >
          {{ error }}
        </p>

        <button
          type="submit"
          :disabled="saving"
          class="w-full rounded-xl bg-gradient-to-r from-brand-500 to-brand-600 px-6 py-2.5 text-sm font-bold text-white transition-all hover:from-brand-600 hover:to-brand-700 disabled:opacity-60"
        >
          {{ saving ? "Saving…" : "Save Changes" }}
        </button>
      </form>
    </div>
  </div>
</template>
