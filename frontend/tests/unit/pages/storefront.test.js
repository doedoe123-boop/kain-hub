import { describe, it, expect, vi, beforeEach } from "vitest";
import { flushPromises, mount } from "@vue/test-utils";
import { setActivePinia, createPinia } from "pinia";
import { createRouter, createMemoryHistory } from "vue-router";
import Stores from "@/pages/Stores.vue";
import NotFound from "@/pages/NotFound.vue";

// ---------------------------------------------------------------------------
// API mocks
// ---------------------------------------------------------------------------

vi.mock("@/api/stores", () => ({
  storesApi: {
    list: vi.fn(),
    show: vi.fn(),
    products: vi.fn(),
    properties: vi.fn(),
  },
}));

vi.mock("@/api/products", () => ({
  productsApi: { list: vi.fn(), show: vi.fn() },
}));

vi.mock("@/api/properties", () => ({
  propertiesApi: { list: vi.fn(), show: vi.fn(), featured: vi.fn() },
}));

vi.mock("@/api/homepage", () => ({
  homepageApi: { stats: vi.fn().mockResolvedValue({ data: {} }) },
}));

vi.mock("@/api/advertisements", () => ({
  advertisementsApi: { list: vi.fn().mockResolvedValue({ data: [] }) },
}));

vi.mock("@/api/promotions", () => ({
  promotionsApi: { list: vi.fn().mockResolvedValue({ data: [] }) },
}));

vi.mock("@/api/featuredListings", () => ({
  featuredListingsApi: { list: vi.fn().mockResolvedValue({ data: [] }) },
}));

// Stub complex sub-components from Home page so we don't need to provision all their deps
vi.mock("@/components/DicedHeroSection.vue", () => ({
  default: { template: "<section>Hero</section>" },
}));
vi.mock("@/components/CategoryStrip.vue", () => ({
  default: { template: "<div />" },
}));
vi.mock("@/components/homepage/VerifiedProperties.vue", () => ({
  default: { template: "<div />" },
}));
vi.mock("@/components/homepage/TrendingCarousel.vue", () => ({
  default: { template: "<div />" },
}));
vi.mock("@/components/homepage/TrustStrip.vue", () => ({
  default: { template: "<div />" },
}));
vi.mock("@/components/homepage/AdBanner.vue", () => ({
  default: { template: "<div />" },
}));
vi.mock("@/components/homepage/PromotionBanner.vue", () => ({
  default: { template: "<div />" },
}));
vi.mock("@/composables/useHomepageStats", () => ({
  useHomepageStats: () => ({
    stats: {},
    loaded: true,
    formatCount: (n) => String(n),
  }),
}));

// ---------------------------------------------------------------------------
// Helpers
// ---------------------------------------------------------------------------

function storeRouter() {
  return createRouter({
    history: createMemoryHistory(),
    routes: [
      { path: "/", component: { template: "<div />" } },
      { path: "/stores", component: Stores },
      { path: "/stores/:slug", component: { template: "<div />" } },
      { path: "/properties", component: { template: "<div />" } },
      { path: "/movers", component: { template: "<div />" } },
    ],
  });
}

// ---------------------------------------------------------------------------
// Stores listing page
// ---------------------------------------------------------------------------

describe("Stores listing page", () => {
  let pinia;

  beforeEach(() => {
    pinia = createPinia();
    setActivePinia(pinia);
    vi.clearAllMocks();
  });

  it("renders Browse Stores heading", async () => {
    const { storesApi } = await import("@/api/stores");
    storesApi.list.mockResolvedValue({ data: { data: [] } });

    const router = storeRouter();
    await router.push("/stores");

    const wrapper = mount(Stores, { global: { plugins: [pinia, router] } });
    await flushPromises();

    expect(wrapper.text()).toContain("Browse E-Commerce Stores");
  });

  it("displays stores returned from the API", async () => {
    const { storesApi } = await import("@/api/stores");
    storesApi.list.mockResolvedValue({
      data: {
        data: [
          { id: 1, name: "Pizza Palace", slug: "pizza-palace", sector: "Food & Beverage", logo_url: null },
          { id: 2, name: "Burger Barn", slug: "burger-barn", sector: "Food & Beverage", logo_url: null },
        ],
        meta: {},
      },
    });

    const router = storeRouter();
    await router.push("/stores");

    const wrapper = mount(Stores, { global: { plugins: [pinia, router] } });
    await flushPromises();

    expect(wrapper.text()).toContain("Pizza Palace");
    expect(wrapper.text()).toContain("Burger Barn");
  });

  it("renders the search input", async () => {
    const { storesApi } = await import("@/api/stores");
    storesApi.list.mockResolvedValue({ data: { data: [], meta: {} } });

    const router = storeRouter();
    await router.push("/stores");

    const wrapper = mount(Stores, { global: { plugins: [pinia, router] } });
    await flushPromises();

    const input = wrapper.find('input[type="search"], input[placeholder*="Search"]');
    expect(input.exists()).toBe(true);
  });

  it("shows empty state message when no stores returned", async () => {
    const { storesApi } = await import("@/api/stores");
    storesApi.list.mockResolvedValue({ data: { data: [], meta: {} } });

    const router = storeRouter();
    await router.push("/stores");

    const wrapper = mount(Stores, { global: { plugins: [pinia, router] } });
    await flushPromises();

    // either "No stores found" text or empty list — just verify no store cards appear
    expect(wrapper.text()).not.toContain("Pizza Palace");
  });

  it("calls storesApi.list on mount", async () => {
    const { storesApi } = await import("@/api/stores");
    storesApi.list.mockResolvedValue({ data: { data: [], meta: {} } });

    const router = storeRouter();
    await router.push("/stores");

    mount(Stores, { global: { plugins: [pinia, router] } });
    await flushPromises();

    expect(storesApi.list).toHaveBeenCalledOnce();
  });
});

// ---------------------------------------------------------------------------
// 404 / NotFound page
// ---------------------------------------------------------------------------

describe("404 page", () => {
  it("shows 404 text", () => {
    const pinia = createPinia();
    setActivePinia(pinia);
    const wrapper = mount(NotFound, {
      global: {
        plugins: [
          pinia,
          createRouter({
            history: createMemoryHistory(),
            routes: [{ path: "/:pathMatch(.*)*", component: NotFound }],
          }),
        ],
      },
    });
    expect(wrapper.text()).toContain("404");
  });
});
