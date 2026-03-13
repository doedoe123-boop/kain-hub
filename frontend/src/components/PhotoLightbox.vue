<script setup>
import { ref, computed, watch, onMounted, onBeforeUnmount } from "vue";
import {
  XMarkIcon,
  ChevronLeftIcon,
  ChevronRightIcon,
  MagnifyingGlassPlusIcon,
  MagnifyingGlassMinusIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
  images: { type: Array, required: true },
  startIndex: { type: Number, default: 0 },
  alt: { type: String, default: "Photo" },
});

const emit = defineEmits(["close"]);

const current = ref(props.startIndex);
const zoomLevel = ref(1);
const transitioning = ref(false);

// Pan state for zoomed images
const panX = ref(0);
const panY = ref(0);
const isPanning = ref(false);
const panStartX = ref(0);
const panStartY = ref(0);
const panOriginX = ref(0);
const panOriginY = ref(0);

// Touch / swipe state
const touchStartX = ref(0);
const touchStartY = ref(0);
const touchDeltaX = ref(0);
const isSwiping = ref(false);

const total = computed(() => props.images.length);
const hasPrev = computed(() => current.value > 0);
const hasNext = computed(() => current.value < total.value - 1);
const isZoomed = computed(() => zoomLevel.value > 1);

watch(
  () => props.startIndex,
  (val) => {
    current.value = val;
    resetZoom();
  },
);

function resetZoom() {
  zoomLevel.value = 1;
  panX.value = 0;
  panY.value = 0;
}

function prev() {
  if (!hasPrev.value || transitioning.value) return;
  resetZoom();
  transitioning.value = true;
  current.value--;
  setTimeout(() => (transitioning.value = false), 300);
}

function next() {
  if (!hasNext.value || transitioning.value) return;
  resetZoom();
  transitioning.value = true;
  current.value++;
  setTimeout(() => (transitioning.value = false), 300);
}

function cycleZoom() {
  if (zoomLevel.value === 1) {
    zoomLevel.value = 2;
  } else if (zoomLevel.value === 2) {
    zoomLevel.value = 3;
  } else {
    resetZoom();
  }
}

function zoomIn() {
  if (zoomLevel.value < 3) {
    zoomLevel.value = Math.min(3, zoomLevel.value + 1);
  }
}

function zoomOut() {
  if (zoomLevel.value > 1) {
    zoomLevel.value = Math.max(1, zoomLevel.value - 1);
    if (zoomLevel.value === 1) {
      panX.value = 0;
      panY.value = 0;
    }
  }
}

function close() {
  emit("close");
}

function onKeydown(e) {
  if (e.key === "Escape") close();
  if (e.key === "ArrowLeft") prev();
  if (e.key === "ArrowRight") next();
  if (e.key === "+" || e.key === "=") zoomIn();
  if (e.key === "-") zoomOut();
}

// Mouse pan for zoomed image
function onMouseDown(e) {
  if (!isZoomed.value) return;
  isPanning.value = true;
  panStartX.value = e.clientX;
  panStartY.value = e.clientY;
  panOriginX.value = panX.value;
  panOriginY.value = panY.value;
  e.preventDefault();
}

function onMouseMove(e) {
  if (!isPanning.value) return;
  panX.value = panOriginX.value + (e.clientX - panStartX.value);
  panY.value = panOriginY.value + (e.clientY - panStartY.value);
}

function onMouseUp() {
  isPanning.value = false;
}

// Mouse wheel zoom
function onWheel(e) {
  e.preventDefault();
  if (e.deltaY < 0) {
    zoomIn();
  } else {
    zoomOut();
  }
}

// Touch handlers for swipe (when not zoomed) and pan (when zoomed)
function onTouchStart(e) {
  const touch = e.touches[0];

  if (isZoomed.value) {
    // Pan mode
    isPanning.value = true;
    panStartX.value = touch.clientX;
    panStartY.value = touch.clientY;
    panOriginX.value = panX.value;
    panOriginY.value = panY.value;
    return;
  }

  touchStartX.value = touch.clientX;
  touchStartY.value = touch.clientY;
  touchDeltaX.value = 0;
  isSwiping.value = false;
}

function onTouchMove(e) {
  const touch = e.touches[0];

  if (isZoomed.value && isPanning.value) {
    panX.value = panOriginX.value + (touch.clientX - panStartX.value);
    panY.value = panOriginY.value + (touch.clientY - panStartY.value);
    e.preventDefault();
    return;
  }

  const dx = touch.clientX - touchStartX.value;
  const dy = touch.clientY - touchStartY.value;

  if (!isSwiping.value && Math.abs(dx) > Math.abs(dy) && Math.abs(dx) > 10) {
    isSwiping.value = true;
  }

  if (isSwiping.value) {
    e.preventDefault();
    touchDeltaX.value = dx;
  }
}

function onTouchEnd() {
  if (isZoomed.value) {
    isPanning.value = false;
    return;
  }

  const threshold = 60;
  if (touchDeltaX.value > threshold) {
    prev();
  } else if (touchDeltaX.value < -threshold) {
    next();
  }
  touchDeltaX.value = 0;
  isSwiping.value = false;
}

// Double-tap to zoom on mobile
let lastTap = 0;
function onDoubleTap() {
  const now = Date.now();
  if (now - lastTap < 300) {
    cycleZoom();
  }
  lastTap = now;
}

onMounted(() => {
  document.addEventListener("keydown", onKeydown);
  document.addEventListener("mousemove", onMouseMove);
  document.addEventListener("mouseup", onMouseUp);
  document.body.style.overflow = "hidden";
});

onBeforeUnmount(() => {
  document.removeEventListener("keydown", onKeydown);
  document.removeEventListener("mousemove", onMouseMove);
  document.removeEventListener("mouseup", onMouseUp);
  document.body.style.overflow = "";
});
</script>

<template>
  <Teleport to="body">
    <div
      class="fixed inset-0 z-[100] flex flex-col bg-black/95 backdrop-blur-sm"
      @click.self="close"
    >
      <!-- Top bar -->
      <div class="flex items-center justify-between px-4 py-3 sm:px-6">
        <span class="text-sm font-medium text-white/70">
          {{ current + 1 }} / {{ total }}
        </span>

        <div class="flex items-center gap-1">
          <!-- Zoom out -->
          <button
            class="flex size-10 items-center justify-center rounded-full text-white/70 transition-colors hover:bg-white/10 hover:text-white disabled:opacity-30"
            title="Zoom out (−)"
            :disabled="zoomLevel <= 1"
            @click="zoomOut"
          >
            <MagnifyingGlassMinusIcon class="size-5" />
          </button>

          <!-- Zoom level indicator -->
          <span
            class="min-w-[40px] text-center text-xs font-semibold tabular-nums transition-colors"
            :class="isZoomed ? 'text-white' : 'text-white/40'"
          >
            {{ zoomLevel }}×
          </span>

          <!-- Zoom in -->
          <button
            class="flex size-10 items-center justify-center rounded-full text-white/70 transition-colors hover:bg-white/10 hover:text-white disabled:opacity-30"
            title="Zoom in (+)"
            :disabled="zoomLevel >= 3"
            @click="zoomIn"
          >
            <MagnifyingGlassPlusIcon class="size-5" />
          </button>

          <div class="mx-1 h-5 w-px bg-white/20" />

          <!-- Close -->
          <button
            class="flex size-10 items-center justify-center rounded-full text-white/70 transition-colors hover:bg-white/10 hover:text-white"
            title="Close (Esc)"
            @click="close"
          >
            <XMarkIcon class="size-6" />
          </button>
        </div>
      </div>

      <!-- Image area -->
      <div
        class="relative flex flex-1 items-center justify-center overflow-hidden px-4 sm:px-16"
        @touchstart.passive="onTouchStart"
        @touchmove="onTouchMove"
        @touchend.passive="onTouchEnd"
        @wheel.passive.prevent="onWheel"
      >
        <!-- Prev button (desktop) -->
        <button
          v-if="hasPrev"
          class="absolute left-2 top-1/2 z-10 hidden -translate-y-1/2 sm:flex size-12 items-center justify-center rounded-full bg-white/10 text-white transition-all hover:bg-white/20 hover:scale-110"
          @click.stop="prev"
        >
          <ChevronLeftIcon class="size-6" />
        </button>

        <!-- Image with swipe offset + zoom + pan -->
        <div
          class="flex h-full w-full items-center justify-center"
          :style="{
            transform:
              isSwiping && !isZoomed
                ? `translateX(${touchDeltaX}px)`
                : 'translateX(0)',
            transitionDuration: isSwiping ? '0ms' : '300ms',
          }"
          style="transition-property: transform; transition-timing-function: ease-out"
        >
          <img
            :src="images[current]"
            :alt="`${alt} ${current + 1}`"
            class="max-h-[calc(100vh-140px)] max-w-full select-none rounded-lg object-contain transition-transform duration-200"
            :class="isZoomed ? 'cursor-grab active:cursor-grabbing' : 'cursor-zoom-in'"
            :style="{
              transform: `scale(${zoomLevel}) translate(${panX / zoomLevel}px, ${panY / zoomLevel}px)`,
            }"
            draggable="false"
            @click.stop="isZoomed ? null : cycleZoom()"
            @mousedown="onMouseDown"
            @touchend="onDoubleTap"
          />
        </div>

        <!-- Next button (desktop) -->
        <button
          v-if="hasNext"
          class="absolute right-2 top-1/2 z-10 hidden -translate-y-1/2 sm:flex size-12 items-center justify-center rounded-full bg-white/10 text-white transition-all hover:bg-white/20 hover:scale-110"
          @click.stop="next"
        >
          <ChevronRightIcon class="size-6" />
        </button>
      </div>

      <!-- Zoom hint (fades in briefly) -->
      <p
        v-if="total > 0 && !isZoomed"
        class="pointer-events-none text-center text-[11px] text-white/30"
      >
        Click image or scroll to zoom · Arrow keys to navigate
      </p>

      <!-- Thumbnail strip -->
      <div
        v-if="total > 1"
        class="flex items-center justify-center gap-2 overflow-x-auto px-4 py-3 sm:py-4"
      >
        <button
          v-for="(img, i) in images"
          :key="i"
          class="size-14 shrink-0 overflow-hidden rounded-lg border-2 transition-all sm:size-16"
          :class="
            current === i
              ? 'border-white opacity-100 ring-1 ring-white/30'
              : 'border-transparent opacity-40 hover:opacity-70'
          "
          @click="current = i; resetZoom()"
        >
          <img
            :src="img"
            :alt="`Thumbnail ${i + 1}`"
            class="h-full w-full object-cover"
            draggable="false"
          />
        </button>
      </div>
    </div>
  </Teleport>
</template>
