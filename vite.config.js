import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import { fileURLToPath, URL } from "node:url";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            vue: "vue/dist/vue.esm-bundler.js",
            "@": fileURLToPath(new URL("./resources", import.meta.url)),
            "@pages": fileURLToPath(
                new URL("./resources/js/components/pages", import.meta.url)
            ),
            "@templates": fileURLToPath(
                new URL("./resources/js/components/templates", import.meta.url)
            ),
            "@organisms": fileURLToPath(
                new URL("./resources/js/components/organisms", import.meta.url)
            ),
            "@molecules": fileURLToPath(
                new URL("./resources/js/components/molecules", import.meta.url)
            ),
            "@atoms": fileURLToPath(
                new URL("./resources/js/components/atoms", import.meta.url)
            ),
            "@stores": fileURLToPath(
                new URL("./resources/js/stores", import.meta.url)
            ),
        },
    },
});
