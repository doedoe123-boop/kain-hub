import client from "./client";

export const searchApi = {
  /**
   * Global search across stores, products, and properties.
   *
   * @param {{ q: string, sector?: string, per_section?: number }} params
   * @returns {Promise<import('axios').AxiosResponse<{
   *   query: string,
   *   stores: Array<{ id: number, name: string, slug: string, logo_url: string|null, banner_url: string|null, sector: string|null, city: string|null, description: string|null }>,
   *   products: Array<{ id: number, name: string|null, thumbnail: string|null, price: number|null, currency: string|null, store_id: number|null }>,
   *   properties: Array<{ id: number, title: string, slug: string, city: string|null, province: string|null, listing_type: string|null, property_type: string|null, price: number|null, price_currency: string|null, price_period: string|null, bedrooms: number|null, floor_area: number|null, images: string[] }>
   * }>>}
   */
  global(params = {}) {
    return client.get("/api/v1/search", { params });
  },
};
