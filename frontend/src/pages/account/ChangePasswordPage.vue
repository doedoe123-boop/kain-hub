<script setup>
import { ref } from "vue";
import { authApi } from "@/api/auth";

const form = ref({
  current_password: "",
  password: "",
  password_confirmation: "",
});

const saving = ref(false);
const success = ref(false);
const errors = ref({});

async function submit() {
  saving.value = true;
  success.value = false;
  errors.value = {};

  try {
    await authApi.changePassword(form.value);
    success.value = true;
    form.value = {
      current_password: "",
      password: "",
      password_confirmation: "",
    };
    setTimeout(() => (success.value = false), 4000);
  } catch (err) {
    if (err.response?.status === 422) {
      errors.value = err.response.data.errors ?? {};
    } else {
      errors.value = {
        current_password: [
          err.response?.data?.message ?? "Something went wrong.",
        ],
      };
    }
  } finally {
    saving.value = false;
  }
}
</script>

<template>
  <div class="mx-auto max-w-xl px-4 py-8 sm:px-0">
    <h1 class="mb-6 text-2xl font-extrabold tracking-tight text-slate-900">
      Change Password
    </h1>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
      <form class="space-y-5" @submit.prevent="submit">
        <!-- Current password -->
        <div>
          <label
            for="current-password"
            class="mb-1.5 block text-sm font-medium text-slate-700"
            >Current Password</label
          >
          <input
            id="current-password"
            v-model="form.current_password"
            type="password"
            required
            autocomplete="current-password"
            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm text-slate-800 focus:border-brand-400 focus:ring-2 focus:ring-brand-100 focus:outline-none"
            :class="{ 'border-red-300': errors.current_password }"
          />
          <p v-if="errors.current_password" class="mt-1 text-xs text-red-600">
            {{ errors.current_password[0] }}
          </p>
        </div>

        <!-- New password -->
        <div>
          <label
            for="new-password"
            class="mb-1.5 block text-sm font-medium text-slate-700"
            >New Password</label
          >
          <input
            id="new-password"
            v-model="form.password"
            type="password"
            required
            minlength="8"
            autocomplete="new-password"
            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm text-slate-800 focus:border-brand-400 focus:ring-2 focus:ring-brand-100 focus:outline-none"
            :class="{ 'border-red-300': errors.password }"
          />
          <p v-if="errors.password" class="mt-1 text-xs text-red-600">
            {{ errors.password[0] }}
          </p>
        </div>

        <!-- Confirm new password -->
        <div>
          <label
            for="confirm-password"
            class="mb-1.5 block text-sm font-medium text-slate-700"
            >Confirm New Password</label
          >
          <input
            id="confirm-password"
            v-model="form.password_confirmation"
            type="password"
            required
            autocomplete="new-password"
            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm text-slate-800 focus:border-brand-400 focus:ring-2 focus:ring-brand-100 focus:outline-none"
          />
        </div>

        <!-- Feedback -->
        <p
          v-if="success"
          class="rounded-xl bg-green-50 px-4 py-2.5 text-sm font-medium text-green-700"
        >
          ✓ Password updated successfully.
        </p>

        <button
          type="submit"
          :disabled="saving"
          class="w-full rounded-xl bg-gradient-to-r from-brand-500 to-brand-600 px-6 py-2.5 text-sm font-bold text-white transition-all hover:from-brand-600 hover:to-brand-700 disabled:opacity-60"
        >
          {{ saving ? "Updating…" : "Update Password" }}
        </button>
      </form>
    </div>
  </div>
</template>
