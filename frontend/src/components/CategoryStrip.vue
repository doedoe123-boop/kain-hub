<script setup>
import { ref, computed, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import { categoriesApi } from "@/api/categories";

const router = useRouter();
const route = useRoute();
const active = ref(route.query.collection_id ?? "");

const FIXED_START = [{ id: "", name: "All", slug: "", icon: "🏪" }];
const FIXED_END = [
  { id: "properties", name: "Properties", slug: "properties", icon: "🏡" },
  { id: "movers", name: "Lipat Bahay", slug: "movers", icon: "🚚" },
];

const dynamicCategories = ref([]);
const loading = ref(true);

onMounted(async () => {
  try {
    const { data } = await categoriesApi.list();
    dynamicCategories.value = (data ?? []).map((c) => ({
      id: c.id,
      name: c.name,
      slug: c.slug ?? "",
      icon: c.icon ?? "🏷️",
    }));
  } catch {
    // silently fall back to empty dynamic list — fixed items still show
  } finally {
    loading.value = false;
  }
});

const categories = computed(() => [
  ...FIXED_START,
  ...dynamicCategories.value,
  ...FIXED_END,
]);

function select(cat) {
  if (cat.id === "properties") {
    active.value = "properties";
    router.push("/properties");
    return;
  }
  if (cat.id === "movers") {
    active.value = "movers";
    router.push("/movers");
    return;
  }
  active.value = cat.id;
  router.push({
    path: "/stores",
    query: cat.id ? { collection_id: cat.id } : {},
  });
}
</script>

<template>
  <div
    class="border-b border-slate-100 bg-white shadow-sm dark:bg-slate-900 dark:border-slate-800"
  >
    <div class="mx-auto max-w-7xl px-4 sm:px-6">
      <!-- Skeleton -->
      <div
        v-if="loading"
        class="flex items-center gap-1.5 overflow-x-auto py-2 scrollbar-none"
      >
        <div
          v-for="i in 8"
          :key="i"
          class="h-7 w-20 shrink-0 animate-pulse rounded-full bg-slate-100 dark:bg-slate-700"
        />
      </div>

      <!-- Category pills -->
      <div
        v-else
        class="flex items-center gap-1.5 overflow-x-auto py-2 scrollbar-none"
      >
        <button
          v-for="cat in categories"
          :key="cat.id"
          type="button"
          class="flex shrink-0 items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold whitespace-nowrap transition-all"
          :class="
            active === cat.id
              ? 'bg-navy-900 text-white shadow-sm'
              : 'border border-slate-200 bg-white text-slate-600 hover:border-emerald-300 hover:text-emerald-700 dark:bg-slate-800 dark:border-slate-700 dark:text-slate-300'
          "
          @click="select(cat)"
        >
          <span class="text-xs leading-none">{{ cat.icon }}</span>
          {{ cat.name }}
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.scrollbar-none::-webkit-scrollbar {
  display: none;
}
.scrollbar-none {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
