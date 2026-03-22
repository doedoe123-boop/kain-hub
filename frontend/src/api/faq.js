import client from "./client";

export const faqApi = {
  list() {
    return client.get("/api/v1/faqs");
  },
};
