import client from "./client";

export const paymentMethodsApi = {
  list() {
    return client.get("/api/v1/user/payment-methods");
  },

  store(payload) {
    return client.post("/api/v1/user/payment-methods", payload);
  },

  destroy(id) {
    return client.delete(`/api/v1/user/payment-methods/${id}`);
  },

  setDefault(id) {
    return client.patch(`/api/v1/user/payment-methods/${id}/default`);
  },
};
