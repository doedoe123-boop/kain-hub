<script setup>
import { RouterLink, RouterView } from "vue-router"

const backendUrl = import.meta.env.VITE_API_BASE_URL ?? "http://localhost:8080";

const features = [
  "Browse 500+ local stores and properties",
  "Fast, same-day delivery in Metro Manila",
  "Secure checkout with PayMongo & Stripe",
  "One account for all your orders & inquiries",
];
</script>

<template>
  <div class="flex min-h-screen lg:flex-row">
    <!-- ─── Left branded panel (lg+) ──────────────────────────────────── -->
    <div
      class="relative hidden overflow-hidden lg:flex lg:w-[45%] lg:shrink-0 lg:flex-col lg:justify-between"
      style="
        background: linear-gradient(
          145deg,
          #0f172a 0%,
          #1e293b 50%,
          #0f2942 100%
        );
      "
    >
      <!-- Ambient glow decorations -->
      <div class="pointer-events-none absolute inset-0">
        <div
          class="absolute -top-32 -left-32 size-96 rounded-full opacity-20 blur-3xl"
          style="
            background: radial-gradient(circle, #3b82f6 0%, transparent 70%);
          "
        />
        <div
          class="absolute bottom-0 -right-24 size-80 rounded-full opacity-15 blur-3xl"
          style="
            background: radial-gradient(circle, #6366f1 0%, transparent 70%);
          "
        />
        <!-- Subtle grid overlay -->
        <svg
          class="absolute inset-0 size-full opacity-[0.04]"
          xmlns="http://www.w3.org/2000/svg"
        >
          <defs>
            <pattern
              id="auth-grid"
              width="40"
              height="40"
              patternUnits="userSpaceOnUse"
            >
              <path
                d="M 40 0 L 0 0 0 40"
                fill="none"
                stroke="white"
                stroke-width="1"
              />
            </pattern>
          </defs>
          <rect width="100%" height="100%" fill="url(#auth-grid)" />
        </svg>
      </div>

      <!-- Top: Logo + content -->
      <div class="relative z-10 flex flex-col p-12">
        <!-- Logo -->
        <div class="mb-14 flex items-center gap-3">
          <span
            class="flex size-10 items-center justify-center rounded-xl bg-brand-500 text-base font-bold text-white shadow-lg"
            >N</span
          >
          <RouterLink to="/" class="hidden text-xl font-bold text-white sm:block"
            > <span class="text-xl font-bold tracking-tight text-white"
            >NegosyoHub</span
          ></RouterLink>
        </div>

        <!-- Headline -->
        <h1 class="mb-4 text-4xl font-bold leading-tight text-white">
          Shop local.<br />
          <span
            class="bg-gradient-to-r from-brand-400 to-blue-400 bg-clip-text text-transparent"
          >
            Delivered.
          </span>
        </h1>
        <p class="mb-10 text-base leading-relaxed text-slate-400">
          Discover stores, real estate listings, and services across the
          Philippines — all in one place.
        </p>

        <!-- Feature list -->
        <ul class="space-y-4">
          <li
            v-for="feature in features"
            :key="feature"
            class="flex items-start gap-3"
          >
            <span
              class="mt-0.5 flex size-5 shrink-0 items-center justify-center rounded-full"
              style="background: rgba(59, 130, 246, 0.2)"
            >
              <svg
                class="size-3 text-brand-400"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M16.707 5.293a1 1 0 010 1.414L8.414 15 3.293 9.879a1 1 0 011.414-1.414L8.414 12.172l6.879-6.879a1 1 0 011.414 0z"
                  clip-rule="evenodd"
                />
              </svg>
            </span>
            <span class="text-sm text-slate-300">{{ feature }}</span>
          </li>
        </ul>
      </div>

      <!-- Bottom: Seller portal card -->
      <div class="relative z-10 p-12 pt-0">
        <div
          class="rounded-2xl border border-white/10 px-6 py-5 backdrop-blur-sm"
          style="background: rgba(255, 255, 255, 0.05)"
        >
          <p
            class="mb-0.5 text-xs font-semibold uppercase tracking-widest text-slate-500"
          >
            For Businesses
          </p>
          <p class="mb-3 text-sm text-slate-300">
            Register your store or list properties on the NegosyoHub platform.
          </p>
          <a
            :href="`${backendUrl}/register/sector`"
            target="_blank"
            class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-400 transition-colors hover:text-brand-300"
          >
            Seller &amp; Listing Portal
            <svg
              class="size-3.5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2.5"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"
              />
            </svg>
          </a>
        </div>
      </div>
    </div>

    <!-- ─── Right: form area ──────────────────────────────────────────── -->
    <div
      class="flex flex-1 flex-col items-center justify-center bg-white px-6 py-12 lg:px-16"
    >
      <!-- Mobile-only compact logo -->
      <div class="mb-8 flex items-center gap-2 lg:hidden">
        <span
          class="flex size-8 items-center justify-center rounded-lg bg-brand-500 text-sm font-bold text-white"
          >N</span
        >
        <span class="text-lg font-bold text-slate-900">NegosyoHub</span>
      </div>

      <div class="w-full max-w-sm">
        <RouterView />
      </div>
    </div>
  </div>
</template>
