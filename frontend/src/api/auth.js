import client, { initCsrf } from "./client";

export const authApi = {
  async register(payload) {
    await initCsrf();
    return client.post("/api/v1/register", payload);
  },

  async login(credentials) {
    await initCsrf();
    return client.post("/api/v1/login", credentials);
  },

  async logout() {
    return client.post("/api/v1/logout");
  },

  async me() {
    return client.get("/api/v1/user");
  },

  async forgotPassword(payload) {
    await initCsrf();
    return client.post("/api/v1/forgot-password", payload);
  },

  async resetPassword(payload) {
    await initCsrf();
    return client.post("/api/v1/reset-password", payload);
  },

  async updateProfile(payload) {
    return client.patch("/api/v1/user", payload);
  },

  async changePassword(payload) {
    return client.patch("/api/v1/user/password", payload);
  },

  async updateSettings(payload) {
    return client.patch("/api/v1/user/settings", payload);
  },

  async deleteAccount() {
    return client.delete("/api/v1/user");
  },
};
