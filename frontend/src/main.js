import { createApp } from "vue";
import { createPinia } from "pinia";
import router from "./router";
import App from "./App.vue";
import "./style.css";

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);

// When a 401 fires mid-session (token expired), the API client emits this
// event. Clear auth state and redirect to login so the user isn't stuck
// on a protected page with broken requests.
window.addEventListener("auth:unauthenticated", async () => {
  const { useAuthStore } = await import("@/stores/auth");
  const auth = useAuthStore();
  auth.user = null;
  useCartStore().reset();
  router.push({ name: "auth.login" });
});

import { useCartStore } from "@/stores/cart";

app.mount("#app");
