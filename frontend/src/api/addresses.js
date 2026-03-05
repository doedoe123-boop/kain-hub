import client from "./client";

export const addressesApi = {
  list() {
    return client.get("/api/v1/user/addresses");
  },

  store(payload) {
    return client.post("/api/v1/user/addresses", payload);
  },

  update(id, payload) {
    return client.patch(`/api/v1/user/addresses/${id}`, payload);
  },

  destroy(id) {
    return client.delete(`/api/v1/user/addresses/${id}`);
  },

  setDefault(id) {
    return client.patch(`/api/v1/user/addresses/${id}/default`);
  },
};
