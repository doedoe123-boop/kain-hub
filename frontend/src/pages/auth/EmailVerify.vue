<script setup>
import { ref, onMounted } from "vue";
import { useRoute, useRouter, RouterLink } from "vue-router";
import { EnvelopeIcon, CheckCircleIcon } from "@heroicons/vue/24/outline";
import { useAuthStore } from "@/stores/auth";
import { emailVerificationApi } from "@/api/emailVerification";

const auth = useAuthStore();
const route = useRoute();
const router = useRouter();

const loading = ref(false);
const success = ref(false);
const error = ref(null);
const justVerified = ref(
  route.query.success === "1" || route.path === "/email/verified",
);

onMounted(() => {
  // If the user is already verified, redirect home
  if (auth.user?.email_verified_at) {
    router.replace({ name: "home" });
  }
});

async function resend() {
  loading.value = true;
  error.value = null;
  success.value = false;

  try {
    await emailVerificationApi.resend();
    success.value = true;
  } catch (err) {
    error.value =
      err?.response?.data?.message ?? "Something went wrong. Please try again.";
  } finally {
    loading.value = false;
  }
}
</script>

<template>
  <div class="w-full max-w-sm">
    <!-- Just verified via link -->
    <template v-if="justVerified">
      <div class="mb-8 text-center">
        <CheckCircleIcon class="mx-auto mb-4 size-14 text-emerald-500" />
        <h1 class="text-2xl font-bold tracking-tight text-slate-800">
          Email verified!
        </h1>
        <p class="mt-2 text-sm text-slate-500">
          Your email has been verified successfully.
        </p>
      </div>
      <RouterLink
        to="/"
        class="flex w-full items-center justify-center rounded-xl bg-brand-600 px-4 py-3 text-sm font-semibold text-white hover:bg-brand-700"
      >
        Go to homepage
      </RouterLink>
    </template>

    <!-- Awaiting verification -->
    <template v-else>
      <div class="mb-8 text-center">
        <EnvelopeIcon class="mx-auto mb-4 size-14 text-brand-500" />
        <h1 class="text-2xl font-bold tracking-tight text-slate-800">
          Verify your email
        </h1>
        <p class="mt-2 text-sm text-slate-500">
          We sent a verification link to
          <span v-if="auth.user?.email" class="font-medium text-slate-700">
            {{ auth.user.email }}
          </span>
          <span v-else>your email address</span>. Check your inbox and click the
          link to activate your account.
        </p>
      </div>

      <!-- Success alert -->
      <div
        v-if="success"
        class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700"
      >
        Verification email re-sent. Check your inbox (and spam folder).
      </div>

      <!-- Error alert -->
      <div
        v-if="error"
        class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
      >
        {{ error }}
      </div>

      <button
        :disabled="loading"
        class="flex w-full items-center justify-center rounded-xl bg-brand-600 px-4 py-3 text-sm font-semibold text-white hover:bg-brand-700 disabled:opacity-60"
        @click="resend"
      >
        <span v-if="loading">Sending…</span>
        <span v-else>Resend verification email</span>
      </button>

      <p class="mt-6 text-center text-sm text-slate-500">
        Wrong account?
        <button
          class="font-semibold text-brand-600 hover:underline"
          @click="
            auth.logout().then(() => $router.replace({ name: 'auth.login' }))
          "
        >
          Log out
        </button>
      </p>
    </template>
  </div>
</template>
