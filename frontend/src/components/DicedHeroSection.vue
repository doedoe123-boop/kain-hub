<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import ChronicleButton from "./ChronicleButton.vue";

const props = defineProps({
  topText: { type: String, required: true },
  mainText: { type: String, required: true },
  subMainText: { type: String, required: true },
  buttonText: { type: String, default: "Explore Now" },
  slides: {
    type: Array, // [{ title, image }]
    required: true,
    validator: (v) => v.length >= 4,
  },
  onMainButtonClick: { type: Function, default: null },
  onGridImageClick: { type: Function, default: null },
  separatorColor: { type: String, default: "var(--diced-hero-section-separator)" },
  backgroundColor: { type: String, default: "transparent" },
  mobileBreakpoint: { type: Number, default: 900 },
  fontFamily: { type: String, default: "inherit" },
});

// ── Responsive ────────────────────────────────────────────────
const containerRef = ref(null);
const isMobile = ref(false);
let ro = null;

onMounted(() => {
  ro = new ResizeObserver(([entry]) => {
    isMobile.value = entry.contentRect.width < props.mobileBreakpoint;
  });
  if (containerRef.value) ro.observe(containerRef.value);
});

onBeforeUnmount(() => ro?.disconnect());

// Positions for 2×2 grid (matching the original: [3,2,1,0] order)
// bottom-right | bottom-left | top-right | top-left
const gridClasses = [
  "warped-image warped-bottom-right",
  "warped-image warped-bottom-left",
  "warped-image warped-top-right",
  "warped-image warped-top-left",
];
const gridSlides = (slides) => [slides[3], slides[2], slides[1], slides[0]];
</script>

<template>
  <section
    ref="containerRef"
    class="diced-hero"
    :style="{
      backgroundColor,
      fontFamily,
      flexDirection: isMobile ? 'column' : 'row',
    }"
  >

    <!-- ── Left: Text panel ───────────────────────────────────── -->
    <div
      class="diced-hero__text"
      :style="{
        textAlign: isMobile ? 'center' : 'left',
        alignItems: isMobile ? 'center' : 'flex-start',
        paddingBottom: isMobile ? '2rem' : '0',
      }"
    >
      <!-- Overline label -->
      <span class="diced-hero__top-text">{{ topText }}</span>

      <!-- Main headline -->
      <h1 class="diced-hero__main-text">{{ mainText }}</h1>

      <!-- Animated separator -->
      <div
        class="diced-hero__separator"
        :style="{
          background: separatorColor,
          marginLeft: isMobile ? 'auto' : '0',
          marginRight: isMobile ? 'auto' : '0',
        }"
      />

      <!-- Sub-copy -->
      <p class="diced-hero__sub-text">{{ subMainText }}</p>

      <!-- CTA -->
      <div class="diced-hero__cta">
        <ChronicleButton
          :text="buttonText"
          :on-click="onMainButtonClick"
        />
      </div>
    </div>

    <!-- ── Right: Diced 2×2 image grid ───────────────────────── -->
    <div class="diced-hero__grid-wrap">
      <div class="diced-hero__grid">
        <div
          v-for="(slide, i) in gridSlides(slides)"
          :key="i"
          class="diced-hero__cell"
        >
          <img
            :src="slide.image"
            :alt="slide.title"
            :class="gridClasses[i]"
            class="diced-hero__img"
            @click="onGridImageClick && onGridImageClick(i)"
          />
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
/* ── Layout ──────────────────────────────────────────────────── */
.diced-hero {
  display: flex;
  align-items: stretch;
  justify-content: center;
  width: 100%;
  max-width: 1400px;
  margin: 0 auto;
  padding: 3rem 2rem;
  overflow: hidden;
  gap: 2.5rem;
}

/* ── Left panel ──────────────────────────────────────────────── */
.diced-hero__text {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
  max-width: 50%;
  z-index: 1;
}
@media (max-width: 900px) {
  .diced-hero__text { max-width: 100%; }
}

.diced-hero__top-text {
  display: block;
  font-size: 0.8rem;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: var(--diced-hero-section-top-text);
  margin-bottom: 0.6rem;
  animation: fadeUp 0.5s ease both;
}

.diced-hero__main-text {
  margin: 0;
  font-size: clamp(2.8rem, 5vw, 4.5rem);
  font-weight: 800;
  line-height: 1.1;
  letter-spacing: -0.02em;
  background-image: linear-gradient(
    45deg,
    var(--diced-hero-section-main-gradient-from),
    var(--diced-hero-section-main-gradient-to)
  );
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  animation: fadeUp 0.5s 0.1s ease both;
}

.diced-hero__separator {
  width: 0;
  height: 4px;
  border: none;
  border-radius: 9999px;
  margin: 1.25rem 0 1.75rem;
  animation: growSep 0.5s 0.2s ease forwards;
}
@keyframes growSep {
  to { width: 6rem; }
}

.diced-hero__sub-text {
  margin: 0;
  font-size: 0.95rem;
  line-height: 1.7;
  color: var(--diced-hero-section-sub-text);
  max-width: 38ch;
  animation: fadeUp 0.5s 0.3s ease both;
}

.diced-hero__cta {
  margin-top: 1.5rem;
  animation: fadeUp 0.5s 0.4s ease both;
}

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(18px); }
  to   { opacity: 1; transform: translateY(0);    }
}

/* ── Right grid ──────────────────────────────────────────────── */
.diced-hero__grid-wrap {
  flex: 1;
  display: flex;
  align-items: center;
}
.diced-hero__grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 16px;
  width: 100%;
  aspect-ratio: 1 / 1;
}
.diced-hero__cell {
  position: relative;
  width: 100%;
  padding-bottom: 100%;
  overflow: hidden;
  border-radius: 20px;
}
.diced-hero__img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  cursor: pointer;
  transition: transform 0.4s ease;
}
.diced-hero__img:hover {
  transform: scale(1.04);
}
</style>
