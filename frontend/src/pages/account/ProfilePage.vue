<script setup>
import { RouterLink } from "vue-router";
import { useAuthStore } from "@/stores/auth";

const auth = useAuthStore();
</script>

<template>
  <div class="mx-auto max-w-lg px-4 py-10 sm:px-6">
    <!-- Breadcrumb -->
    <RouterLink
      to="/account"
      class="mb-5 inline-flex items-center gap-1.5 text-sm font-medium text-brand-600 hover:text-brand-700 transition-colors"
    >
      ← My Account
    </RouterLink>

    <h1 class="mb-6 text-2xl font-extrabold tracking-tight text-slate-900">
      My Profile
    </h1>
    <div class="rounded-2xl border border-slate-200 bg-white p-6">
      <dl class="space-y-4 text-sm">
        <div class="flex justify-between">
          <dt class="font-medium text-slate-600">Name</dt>
          <dd class="text-slate-900">{{ auth.user?.name }}</dd>
        </div>
        <div class="flex justify-between">
          <dt class="font-medium text-slate-600">Email</dt>
          <dd class="text-slate-900">{{ auth.user?.email }}</dd>
        </div>
        <div class="flex justify-between">
          <dt class="font-medium text-slate-600">Role</dt>
          <dd class="capitalize text-slate-900">
            {{ auth.user?.role?.replace("_", " ") }}
          </dd>
        </div>
      </dl>
    </div>
  </div>
</template>
