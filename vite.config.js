import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/admin.css",
                "resources/css/home.css",
                "resources/css/login.css",
                "resources/css/register.css",
                "resources/js/app.js",
                "resources/js/admin.js",
            ],
            refresh: true,
        }),
    ],
    build: {
        manifest: true, // ⚠️ Laravel cần manifest.json để render
        outDir: "public/build",
        rollupOptions: {
            input: [
                "resources/css/admin.css",
                "resources/css/home.css",
                "resources/css/login.css",
                "resources/css/register.css",
                "resources/js/app.js",
                "resources/js/admin.js",
            ],
        },
    },
});
