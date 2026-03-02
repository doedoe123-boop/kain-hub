import client from "./client";

export const propertiesApi = {
  /**
   * @param {{ search?: string, type?: string, listing_type?: string, min_price?: number, max_price?: number, bedrooms?: number, city?: string, featured?: boolean, per_page?: number, page?: number }} params
   */
  list(params = {}) {
    return client.get("/api/v1/properties", { params });
  },

  show(slug) {
    return client.get(`/api/v1/properties/${slug}`);
  },

  featured(limit = 4) {
    return client.get("/api/v1/properties", {
      params: { per_page: limit, featured: true },
    });
  },
};
