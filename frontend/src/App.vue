<script setup>
import { RouterView } from "vue-router";
import { Analytics } from "@vercel/analytics/next"
import { SpeedInsights } from "@vercel/speed-insights/next"
</script>

<template>
  <Analytics />
  <SpeedInsights />
  <RouterView />
</template>
