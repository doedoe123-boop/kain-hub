<script setup>
const props = defineProps({
  text: { type: String, required: true },
  onClick: { type: Function, default: null },
  hoverColor: { type: String, default: "var(--diced-hero-section-button-hover-bg)" },
  hoverForeground: { type: String, default: "#fff" },
  borderRadius: { type: String, default: "2rem" },
  customBackground: { type: String, default: "var(--diced-hero-section-button-bg)" },
  customForeground: { type: String, default: "#fff" },
  width: { type: String, default: "auto" },
});
</script>

<template>
  <button
    class="chronicle-button"
    type="button"
    :style="{
      '--chronicle-button-background': customBackground,
      '--chronicle-button-foreground': customForeground,
      '--chronicle-button-hover-background': hoverColor,
      '--chronicle-button-hover-foreground': hoverForeground,
      borderRadius,
      width,
      minWidth: '140px',
    }"
    @click="onClick && onClick()"
  >
    <span><em>{{ text }}</em></span>
    <span><em>{{ text }}</em></span>
  </button>
</template>
