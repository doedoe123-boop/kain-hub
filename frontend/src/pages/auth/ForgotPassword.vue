<script setup>
import { ref } from "vue";
import { RouterLink } from "vue-router";
import { useAuthStore } from "@/stores/auth";

const auth = useAuthStore();

const email = ref("");
const loading = ref(false);
const error = ref(null);
const success = ref(false);

async function submit() {
  loading.value = true;
  error.value = null;

  try {
    await auth.forgotPassword(email.value);
    success.value = true;
  } catch (err) {
    error.value =
      err?.response?.data?.message ??
      err?.response?.data?.errors?.email?.[0] ??
      "Something went wrong. Please try again.";
  } finally {
    loading.value = false;
  }
}
</script>

<template>
  <div class="w-full max-w-sm">
    <!-- Header -->
    <div class="mb-8 text-center">
      <h1 class="text-2xl font-bold tracking-tight text-slate-800">
        Forgot your password?
      </h1>
      <p class="mt-1 text-sm text-slate-500">
        Enter your email and we'll send you a reset link.
      </p>
    </div>

    <!-- Success state -->
    <template v-if="success">
      <div
        class="rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700"
      >
        <p class="font-medium">Check your inbox</p>
        <p class="mt-1 text-green-600">
          If <strong>{{ email }}</strong> is registered, we've sent a password
          reset link. Be sure to check your spam folder too.
        </p>
      </div>

      <p class="mt-6 text-center text-sm text-slate-500">
        <RouterLink
          to="/login"
          class="font-semibold text-brand-600 hover:text-brand-700 hover:underline"
        >
          Back to login
        </RouterLink>
      </p>
    </template>

    <!-- Form -->
    <form v-else novalidate @submit.prevent="submit">
      <!-- Error alert -->
      <div
        v-if="error"
        class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600"
      >
        {{ error }}
      </div>

      <!-- Email -->
      <div class="space-y-1">
        <label
          for="fp-email"
          class="text-xs font-semibold uppercase tracking-wide text-slate-500"
        >
          Email address
        </label>
        <input
          id="fp-email"
          v-model="email"
          type="email"
          autocomplete="email"
          required
          placeholder="you@example.com"
          class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 placeholder-slate-400 transition-colors focus:border-brand-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-200"
        />
      </div>

      <!-- Submit -->
      <button
        type="submit"
        :disabled="loading"
        class="mt-5 w-full rounded-xl bg-brand-500 py-3 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-brand-600 active:bg-brand-700 disabled:cursor-not-allowed disabled:opacity-50"
      >
        <span v-if="loading" class="flex items-center justify-center gap-2">
          <svg class="size-4 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle
              class="opacity-25"
              cx="12"
              cy="12"
              r="10"
              stroke="currentColor"
              stroke-width="4"
            />
            <path
              class="opacity-75"
              fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"
            />
          </svg>
          Sending…
        </span>
        <span v-else>Send Reset Link</span>
      </button>

      <!-- Back to login -->
      <p class="mt-6 text-center text-sm text-slate-500">
        Remember your password?
        <RouterLink
          to="/login"
          class="font-semibold text-brand-600 hover:text-brand-700 hover:underline"
        >
          Sign in
        </RouterLink>
      </p>
    </form>
  </div>
</template>
