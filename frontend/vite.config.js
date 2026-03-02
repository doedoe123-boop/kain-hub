import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import tailwindcss from "@tailwindcss/vite";
import { fileURLToPath, URL } from "node:url";

export default defineConfig({
  plugins: [vue(), tailwindcss()],
  resolve: {
    alias: {
      "@": fileURLToPath(new URL("./src", import.meta.url)),
    },
  },
  server: {
    port: 5173,
    proxy: {
      // Proxy /api and /sanctum calls to the Laravel nginx container.
      // Inside Docker, 'localhost' resolves to the node container itself —
      // use the nginx service hostname on the shared app-network instead.
      "/api": {
        target: "http://laravel_nginx:80",
        changeOrigin: true,
      },
      "/sanctum": {
        target: "http://laravel_nginx:80",
        changeOrigin: true,
      },
    },
  },
});
