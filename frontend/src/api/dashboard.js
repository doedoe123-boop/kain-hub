import client from "./client";

export const dashboardApi = {
  /** GET /api/v1/seller/dashboard — KPI summary */
  stats() {
    return client.get("/api/v1/seller/dashboard");
  },

  /** GET /api/v1/seller/orders — recent orders */
  orders(params = {}) {
    return client.get("/api/v1/seller/orders", { params });
  },

  /** GET /api/v1/seller/products — seller's products */
  products(params = {}) {
    return client.get("/api/v1/seller/products", { params });
  },

  /** GET /api/v1/seller/revenue — 7-day revenue series */
  revenue() {
    return client.get("/api/v1/seller/revenue");
  },
};
