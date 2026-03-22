import client from "./client";

export const emailVerificationApi = {
  resend() {
    return client.post("/api/v1/email/verification-notification");
  },
};
